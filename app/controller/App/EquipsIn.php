<?php

namespace APP;

use TOOL\HTTP\Filter;
use TOOL\HTTP\RES;
use TOOL\HTTP\RESException;
use TOOL\SQL\Curd\Extension as CurdExtension;
use APP\Settings;
class EquipsIn extends CurdExtension
{

    /**
     * Curd options
     * 
     * @var array 
     */
    protected static array $curdOptions = [
        'table' => 'equips_in',
        'tableKey' => 'id',
        'ACCESS_READ' => true,
        'ACCESS_CREATE' => true,
        'ACCESS_UPDATE' => true,
        'ACCESS_DELETE' => true
    ];
    /**
     * add new equips
     */
    static function addEquipsIn(object $req){
        EquipsIn::insert([
            "name"=>$req->name,
            "printer_name"=> $req->printerName
        ]);
        
        $record = EquipsIn::prepareRecord([
            'record' => "SELECT *
                FROM equips_in where name != 'cachier'"
        ]);
        $record->prepare(false);
        $data = $record->get();
        return RES::return(RES::SUCCESS,"Success",$data->data->rows);
    }

    //get list of equips in 
    static function getEquipsIn(){
        $record = EquipsIn::prepareRecord([
            'record' => "SELECT *
                FROM equips_in where name != 'cachier'"
        ]);
        $record->prepare(false);
        $data = $record->get();
        return RES::return(RES::SUCCESS,"",$data->data->rows);
    }
    static function getAll(){
        $record = EquipsIn::prepareRecord([
            'record' => "SELECT *
                FROM equips_in where name != 'cachier'"
        ]);
        $record->prepare(false);
        $data = $record->get();
        return $data->data->rows;
    }
    //remove equips in
    static function remove(object $req){
        EquipsIn::where("id = ".$req->id)->delete();
        $record = EquipsIn::prepareRecord([
            'record' => "SELECT *
                FROM equips_in where name != 'cachier'"
        ]);
        $record->prepare(false);
        $data = $record->get();
        return RES::return(RES::SUCCESS,"Success",$data->data->rows);
    }
    
    //get printers
    static function getPrinters(){
        $record = EquipsIn::prepareRecord([
            'record' => "SELECT *
                FROM equips_in"
        ]);
        $record->prepare(false);
        $data = $record->get();
        return RES::return(RES::SUCCESS,"",$data->data->rows);
    }

    //change printer name for each equips in 
    static function setPrinters(object $req){
        $cashier="";
        foreach($req as $key=>$item ){
            $id = $item->id;
            $printerName = $item->printer_name;
            EquipsIn::where($id)->update([
                "printer_name"=> $printerName
            ]);
            if($item->name =="cachier"){
                $cashier = $item->printer_name;
            }
        }
        //set in filter 
        $valid = Filter::validate([
            ['cashier', $cashier]
        ])->throw()->valid;
        Settings::open()->go('/printers')->set($valid)->save();
        
        $record = EquipsIn::prepareRecord([
            'record' => "SELECT *
                FROM equips_in"
        ]);
        $record->prepare(false);
        $data = $record->get();
        return RES::return(RES::SUCCESS,"Success",$data->data->rows);
    }
}