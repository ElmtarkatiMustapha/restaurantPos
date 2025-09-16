<?php
use APP\Settings;
use Mike42\Escpos\Printer;
use TOOL\Helper\Convert;
use TOOL\Other\Thermal;

$Settings = Settings::get();
$space = "                          ";

$Printer = Thermal::create($Settings->printers->cashier);

$Printer->setJustification(Printer::JUSTIFY_CENTER);
$Printer->setEmphasis(true);
$Printer->setTextSize(2, 2);
$Printer->text(lang('REPORT'));
$Printer->feed();

$Printer->setJustification(Printer::JUSTIFY_LEFT);
$Printer->setTextSize(1, 1);
$Printer->text(lang('From') . ' ' . date('d/m/Y H:i', strtotime($data->daily->create_at)) . ' ' . lang('To') . ' ' . ($data->daily->close_at ? date('d/m/Y H:i', strtotime($data->daily->close_at)) : date('d/m/Y H:i')));
$Printer->feed();

$Printer->text("-------------------------------------------");
$Printer->feed();
// $Printer->text(lang('Qnt') ."  ".lang('Product'). "           "."Prix.U" ."         ". lang('Total'));
$Printer->text(lang('Qnt') ."  ".lang('Product')."          ". lang('Total'));
$Printer->feed();
$Printer->text("-------------------------------------------");

$Printer->feed();
foreach ($data->items as $categoryName => $category) {
    $Printer->text($category->nbItems ."    " .Convert::textFixed($categoryName, 20)."    ". Convert::price($category->total));
    $Printer->feed();
    // foreach ($category->items as $item) {
        //     $Printer->text($item->qnt ." " .Convert::textFixed($item->title, 20)."  ". Convert::price($item->price) ."  ". Convert::price($item->total));
    //     $Printer->feed();
    // }
}
$Printer->text("-------------------------------------------");

$Printer->feed();
$Printer->setTextSize(1, 1);
$Printer->setJustification(Printer::JUSTIFY_CENTER);
$Printer->text(lang("Total orders") . ": " . $data->daily->totalOrders);
$Printer->feed();
$Printer->text(lang("table") . ": " . Convert::price($data->daily->totalTable));
$Printer->feed();
$Printer->text(lang("delivery") . ": " . Convert::price($data->daily->totalDelivery));
$Printer->feed();
$Printer->text(lang("import") . ": " . Convert::price($data->daily->totalImport));
$Printer->feed(2);
$Printer->text(lang("Total: ") . Convert::price($data->total));
$Printer->feed(2);
$Printer->text("-------------------------------------------");
$Printer->feed(2);

$Printer->setJustification(Printer::JUSTIFY_CENTER);
$Printer->setTextSize(2, 2);
$Printer->text(lang('USERS REPORT'));
$Printer->feed();

$Printer->setJustification(Printer::JUSTIFY_LEFT);
$Printer->setTextSize(1, 1);

$Printer->text("-------------------------------------------");
$Printer->feed();
// $Printer->text(lang('Waiter') ."              ".lang('Product'). "         ". lang('Total'));
// $Printer->feed();
// $Printer->text("-------------------------------------------");
// $Printer->feed();
// foreach ($data->users as $user) {
//     $Printer->text(Convert::textFixed($user->username, 20)."  ". $user->items ."     ". Convert::price($user->total));
//     $Printer->feed();
// }

foreach ($data->users as $user) {
    $Printer->text($user->infos->username."  :  ". Convert::price($user->infos->total));
    $Printer->feed();
    $Printer->text("-------------------------------------------");
    $Printer->feed();
    foreach ($user->details->data->items as $categoryName => $category) {
        $Printer->text($category->nbItems ."    " .Convert::textFixed($categoryName, 20)."    ". Convert::price($category->total));
        $Printer->feed();
        // foreach ($category->items as $item) {
        //     $Printer->text($item->qnt ." " .Convert::textFixed($item->title, 20)."  ". Convert::price($item->price) ."  ". Convert::price($item->total));
        //     $Printer->feed();
        // }
    }
    $Printer->text("-------------------------------------------");
    $Printer->feed();
}

$Printer->feed(4);
$Printer->cut();
$Printer->close();