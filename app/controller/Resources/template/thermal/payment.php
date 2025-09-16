<?php

use APP\Settings;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\Printer;
use TOOL\Helper\Convert;
use TOOL\Other\Thermal;
use TOOL\Security\Auth;
session_start();
$Settings = Settings::get();
$space = "            ";

$Printer = Thermal::create($Settings->printers->cashier);

$Printer->setJustification(Printer::JUSTIFY_CENTER);

if ($Settings->company->logo) {
    $Logo = EscposImage::load(BASEUPLOAD . '/' . $Settings->company->logo);
    $Printer->bitImage($Logo);
    $Printer->feed(1);
}
// $Printer->setJustification(Printer::JUSTIFY_LEFT);
if ($Settings->company->name) {
    $Printer->setTextSize(1, 1);
    $Printer->text($Settings->company->name);
    $Printer->feed();
}
if ($Settings->company->phone) {
    $Printer->setTextSize(1, 1);
    $Printer->text($Settings->company->phone);
    $Printer->feed();
}
if ($Settings->company->address) {
    $Printer->setTextSize(1, 1);
    $Printer->text($Settings->company->address);
    $Printer->feed();
}
$Printer->text("-------------------------------------------");
$Printer->feed();
$Printer->setJustification(Printer::JUSTIFY_LEFT);
$Printer->setTextSize(1, 1);
$Printer->setEmphasis(true);
$Printer->text(lang('Payment'));
$Printer->feed();
$Printer->text(lang('Waiter'));
$Printer->text(" : " . $order->create_by);
$Printer->feed();
$Printer->text(lang("Order No.") . " {$order->id} Le ");
$Printer->text( date("d/m/Y H:i:s",strtotime($order->create_at )));
$Printer->feed();
$Printer->text(lang($order->type) . " / ");
if ($order->type === 'table'){
    $Printer->text(" {$order->table_area} - {$order->table_name}");
}
$Printer->feed();

if ($order->type === 'delivery') {
    $Printer->feed();
    $Printer->text(lang("Customer") . ": {$order->customer_name}");
    $Printer->feed();
    $Printer->text(lang("Phone") . ": {$order->customer_phone}");
    $Printer->feed();
    $Printer->text(lang("Address") . ": {$order->customer_address}");
}

$Printer->setJustification(Printer::JUSTIFY_LEFT);
$Printer->text("-------------------------------------------");
$Printer->feed();
$Printer->text(lang('Qnt') ."  ".lang('Product'). "           "."Prix.U" ."         ". lang('Total'));
$Printer->feed();
$Printer->text("-------------------------------------------");
$Printer->feed();

$Printer->setEmphasis(false);
$qnt =0;
foreach ($order->items as $item) {
    $qnt += $item->qnt;
    $Printer->text( $item->qnt." ".Convert::textFixed($item->title,20). "   " . Convert::price($item->price) . "  " . Convert::price($item->price * $item->qnt));
    $Printer->feed();
} 
$Printer->text("-------------------------------------------");
$Printer->feed();
$Printer->text("Nbr.Art: ". $qnt. "      ");
$Printer->setTextSize(1, 2);
$Printer->setEmphasis(true);
$Printer->text(lang("TOTAL: ") . Convert::price(
    array_reduce($order->items, function ($total, $item) {
        return $total + floatval($item->price * $item->qnt);
    })
)."     ");

$Printer->feed(2);
$Printer->setTextSize(1, 1);
$Printer->setJustification(Printer::JUSTIFY_CENTER);
$Printer->text("---------------------------");
$Printer->feed();

if ($Settings->ticket->footer)
    $Printer->text($Settings->ticket->footer);


Thermal::end($Printer);
