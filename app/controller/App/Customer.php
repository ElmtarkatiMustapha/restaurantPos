<?php

namespace APP;

use TOOL\HTTP\Filter;
use TOOL\SQL\Curd\Extension as CurdExtension;

class Customer extends CurdExtension
{

    /**
     * Curd options
     * 
     * @var array
     */
    protected static array $curdOptions = [
        'table' => 'customers',
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
            ['name', $req->name, TRUE],
            ['name', $req->name, TRUE, function ($valid) {
                return !self::where('name = :name')->read(['name' => $valid->name])->data->id;
            }, lang('Customer already exists')],
            ['address', $req->address, FALSE],
            ['phone', $req->phone, FALSE]
        ])->throw()->valid;

        return self::insert($valid);
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
            "AND name LIKE CONCAT('%', :keyword, '%')",
            ['keyword' => $req->keyword],
            $req->keyword
        );

        $Record->prepare(false);

        return $Record->page($req->page)->get();
    }
}
