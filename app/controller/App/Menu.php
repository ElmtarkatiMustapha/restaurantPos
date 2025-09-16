<?php

namespace APP;

use TOOL\HTTP\Filter;
use TOOL\SQL\Curd\Extension as CurdExtension;

class Menu extends CurdExtension
{

    /**
     * Curd options
     * 
     * @var array
     */
    protected static array $curdOptions = [
        'table' => 'menu',
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
            ['category_id', $req->categoryId, TRUE, Filter::IS_ID],
            ['category_id', $req->categoryId, TRUE, function ($valid) {
                return Category::read($valid->category_id)->data->id;
            }, lang('Not Found Category')],
            ['name', $req->name, TRUE],
            ['capital', $req->capital ? $req->capital : 0, TRUE, Filter::IS_POSITIVE_NUMBER],
            ['price', $req->price, TRUE, Filter::IS_POSITIVE_NUMBER],
            ['quantity', $req->quantity, FALSE, FILTER_VALIDATE_FLOAT],
            ['equips_in', $req->equipsIn, TRUE],
            ['image', $req->image, FALSE]
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
            ['name', $req->name, TRUE],
            ['capital', $req->capital ? $req->capital : 0, TRUE, Filter::IS_POSITIVE_NUMBER],
            ['price', $req->price, TRUE, Filter::IS_POSITIVE_NUMBER],
            ['quantity', $req->quantity, FALSE, FILTER_VALIDATE_FLOAT],
            ['equips_in', $req->equipsIn, TRUE],
            ['image', $req->image, FALSE]
        ])->throw()->valid;

        return self::where($id)->update($valid);
    }

    /**
     * Category method
     * 
     * @param object $req
     * 
     * @return
     */
    static function category(object $req)
    {

        $Record = self::prepareRecord([
            'record' => "SELECT *,
                 name AS title
                FROM menu",
            'columns' => 'id, name, title, price, image, quantity AS available'
        ]);

        $Record->setFilter(
            "AND category_id = :categoryId",
            [
                'categoryId' => $req->categoryId
            ],
            $req->categoryId
        );

        $Record->prepare(false);

        return $Record->page($req->page)->get();
    }
}
