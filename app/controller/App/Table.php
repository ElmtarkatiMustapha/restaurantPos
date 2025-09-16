<?php

namespace APP;

use TOOL\HTTP\Filter;
use TOOL\SQL\Curd\Extension as CurdExtension;
use APP\Order;
use TOOL\HTTP\RES;

class Table extends CurdExtension
{

    /**
     * Curd options
     * 
     * @var array
     */
    protected static array $curdOptions = [
        'table' => 'tables',
        'tableKey' => 'id',
        'ACCESS_READ' => true,
        'ACCESS_CREATE' => true,
        'ACCESS_UPDATE' => true,
        'ACCESS_DELETE' => true
    ];

    /**
     * Create method
     * 
     * @param object $req
     * 
     * @return
     */
    static function create(object $req)
    {

        // Validation
        $valid = Filter::validate([
            ['area_id', $req->areaId, TRUE, Filter::IS_ID],
            ['area_id', $req->areaId, TRUE, function ($valid) {
                return Area::read($valid->area_id)->data->id;
            }, lang('Not found area')],
            ['name', $req->name, TRUE]
        ])->throw()->valid;

        return self::insert($valid);
    }

    /**
     * Custom update method
     * 
     * @param int $id
     * 
     * @param object $req
     * 
     * @return
     */
    static function customUpdate(int $id, object $req)
    {

        // Validation
        $valid = Filter::validate([
            ['name', $req->name, TRUE]
        ])->throw()->valid;

        return self::where($id)->update($valid);
    }

    /**
     * Record method
     * 
     * @param object $req
     * 
     * @return
     */
    static function record(object $req)
    {

        $Record = self::prepareRecord();

        $Record->setFilter(
            "AND area_id = :area",
            ['area' => $req->area],
            $req->area
        );

        $Record->setFilter(
            "AND name LIKE CONCAT('%', :keyword, '%')",
            ['keyword' => $req->keyword],
            $req->keyword
        );

        $Record->prepare(false);
        $data =  $Record->page($req->page)->get();
        $fullTables = self::fullTables();
        $newData = (object)[];
        if(count( $data->data->rows) > 0 ){
            $newData = $data;
            $newData->data->rows = array_map(function ($item) use ($fullTables) {
                if(in_array($item->id, $fullTables) ){
                    $item->isFull = 1;
                    return $item;
                }else{
                    $item->isFull = 0;
                    return $item;
                }
            }, $data->data->rows);
            $newData->data->fulltable = $fullTables;
        }
        return $newData;
    }
    /**
     * full table list
     */
    static function fullTables(){
        $Record = Order::prepareRecord([
            'record' => "SELECT table_id
            FROM orders
            WHERE paid = 0 "
        ]);

        // $Record->setOrder('id');
        $Record->prepare(false);
        return array_map(function ($item){
            return $item->table_id;
        },$Record->get()->data->rows);
    }
}
