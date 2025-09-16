<?php

namespace TOOL\Other;

use Mike42\Escpos\Printer;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;

class Thermal
{

    /**
     * Create method
     * 
     * @param string $printName
     * 
     * @return Printer
     */
    static function create(string $printName)
    {
        
        // New connection print connection with windows
        $connector = new WindowsPrintConnector($printName);

        return new Printer($connector);
    }


    /**
     * End method
     * 
     * @param Printer $Printer
     */
    static function end(Printer $printer)
    {

        $printer->feed(4);
        $printer->pulse();
        $printer->cut();
        $printer->close();
    }
}
