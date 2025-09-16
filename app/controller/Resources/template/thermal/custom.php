<?php

use APP\EquipsIn;
use APP\Settings;
use Mike42\Escpos\Printer;
use TOOL\Other\Thermal;
session_start();
// throw new Error($equipsIn->id);
$items = array_filter($order->items, function ($item) use ($equipsIn) {
    return $item->equips_in == $equipsIn->id;
});
// $items = array_filter($order->items, function ($item) {
//     return $item->equips_in == $equipsIn->id;
// });
if (!$items) return true;
$Settings = Settings::get();


$Printer = Thermal::create($equipsIn->printer_name);

$Printer->setJustification(Printer::JUSTIFY_CENTER);
$Printer->setEmphasis(true);
$Printer->setTextSize(1, 1);
$Printer->text(lang("Order No.") . " {$order->id}");
$Printer->feed();

$Printer->setJustification(Printer::JUSTIFY_LEFT);
$Printer->text($equipsIn->name);
$Printer->feed();
$Printer->text(lang('Waiter'));
$Printer->text(" : " . $order->create_by);
$Printer->feed();
$Printer->text(lang("Date") . ": " . date("d/m/Y H:i"));
$Printer->feed();
$Printer->text(lang("Type") . ": " . lang($order->type) . " / ");
if ($order->type === 'table'){
    $Printer->text(" {$order->table_area} - {$order->table_name}");
}

$Printer->feed();
$Printer->text("-------------------------------------------");
$Printer->feed();
$Printer->text(lang('Qnt') ." ". lang('Title'));
$Printer->feed();

$Printer->text("-------------------------------------------");


foreach ($items as $item) {

    $Printer->feed();
    $Printer->text($item->qnt." ".$item->title);
    if ($item->note) {
        $Printer->feed();
        $Printer->setReverseColors(true);
        $Printer->text($item->note);
	$Printer->setReverseColors(false);
    }
    $Printer->feed();
    $Printer->text("-------------------------------------------");
}

$Printer->feed(4);
$Printer->cut();
$Printer->close();