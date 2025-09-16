<?php


use APP\Settings;
use Mike42\Escpos\Printer;
use TOOL\Other\Thermal;
session_start();
$items = array_filter($order->items, function ($item) {
    return $item->equips_in === 'bartender';
});

if (!$items) return true;

$Settings = Settings::get();


$Printer = Thermal::create($Settings->printers->bartender);

$Printer->setJustification(Printer::JUSTIFY_CENTER);
$Printer->setTextSize(2, 2);
$Printer->text(lang("Order No.") . " {$order->id}");
$Printer->feed(3);

$Printer->setJustification(Printer::JUSTIFY_LEFT);
$Printer->setTextSize(1, 1);
$Printer->setEmphasis(true);
$Printer->text(lang('Bartender'));
$Printer->feed();
$Printer->text(lang('Waiter'));
$Printer->text(" : " . $_SESSION["fullName"]);
$Printer->feed();
$Printer->text(lang("Date") . ": " . date("d/m/Y H:i",strtotime($order->create_at )));
$Printer->feed();
$Printer->text(lang("Type") . ": " . lang($order->type));
$Printer->feed();

if ($order->type === 'table'){
    $Printer->text(lang("Table") . ": {$order->table_area} - {$order->table_name}");
    $Printer->feed();
    $Printer->text(lang("The number of people") . ": " . $order->no_people);
    $Printer->feed();
}


$Printer->feed();
$Printer->setJustification(Printer::JUSTIFY_CENTER);
$Printer->text("-------------------------------------------");
$Printer->feed();
$Printer->text(lang('Title'));
$Printer->feed();
$Printer->text(lang('Qnt'));
$Printer->feed();
$Printer->text(lang('Note'));
$Printer->feed();
$Printer->text("-------------------------------------------");
$Printer->feed();

$Printer->setEmphasis(false);

foreach ($items as $item) {

    $Printer->text($item->title);
    $Printer->feed();
    $Printer->text($item->qnt);
    if ($item->note) {
        $Printer->feed();
        $Printer->text($item->note);
    }
    $Printer->feed();
    $Printer->text("-------------------------------------------");
    $Printer->feed();
}

Thermal::end($Printer);
