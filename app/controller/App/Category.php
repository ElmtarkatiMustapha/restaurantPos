<?php

namespace APP;

use TOOL\HTTP\Filter;
use TOOL\SQL\Curd\Extension as CurdExtension;

class Category extends CurdExtension
{

    /**
     * Curd options
     * 
     * @var array
     */
    protected static array $curdOptions = [
        'table' => 'categories',
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
            }, lang('Category already exists')],
            ['image', $req->image, FALSE]
        ])->throw()->valid;

        return self::insert($valid);
    }

    /**
     * Menu record method
     * 
     * @param object $req
     * 
     * @return
     */
    static function menuRecord(object $req)
    {

        $Record = self::prepareRecord([
            'record' => "SELECT *
                FROM categories
                LEFT JOIN (
                    SELECT
                    category_id,
                    CONCAT(
                        '[',
                        GROUP_CONCAT(JSON_OBJECT(
                            'id', id,
                            'name', name,
                            'quantity', quantity,
                            'price', price,
                            'image', image
                        ))
                        ,']'
                    ) AS items,
                    GROUP_CONCAT(name) AS names,
                    COUNT(id) AS countItems
                    FROM menu
                    WHERE name LIKE CONCAT('%', :item, '%')
                    GROUP BY category_id
                ) AS menu ON categories.id = menu.category_id",
            'maxRows' => 50
        ]);

        $Record->setFilter(
            "AND names LIKE CONCAT('%', :keyword, '%')",
            [
                'keyword' => $req->keyword
            ],
            $req->type === 'items' && $req->keyword
        );

        $Record->setFilter(
            "AND name LIKE CONCAT('%', :keyword, '%')",
            [
                'keyword' => $req->keyword
            ],
            $req->type === 'categories' && $req->keyword
        );

        $Record->setOrder('id', 'desc');

        $Record->prepare($req->options->results);
        $reuslts = $Record->page($req->page)->get(
            [
                'item' => $req->type === 'items' ? $req->keyword : '',
            ]
        );
        $reuslts->data->rows = array_map(function ($row) {
            $row->items = (!empty($row->items) && is_string($row->items))
                ? json_decode($row->items, true)
                : [];
            return $row;
        }, (array) $reuslts->data->rows);
        return $reuslts;
    }

    /**
     * Custom delete method
     * 
     * @param int $id
     * 
     * @return
     */
    static function customDelete(int $id)
    {

        // Delete items
        Menu::where("category_id = :id")->delete(['id' => $id]);

        // Delete category
        return self::delete($id);
    }

    /**
     * Custom update method
     * 
     * @param int $id
     * @param object $req
     * 
     * @return
     */
    static function customUpdate(int $id, object $req)
    {

        // Validation
        $valid = Filter::validate([
            ['name', $req->name, TRUE],
            ['name', $req->name, TRUE, function ($valid) use ($id) {
                return !Category::where('name = :name AND id != :id')->read(['name' => $valid->name, 'id' => $id])->data->id;
            }, lang('Category already exists')],
            ['image', $req->image, FALSE]
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

        $Record = self::prepareRecord([
            'columns' => 'id, name, image'
        ]);

        $Record->prepare($req->options->results);

        return $Record->page($req->page)->get();
    }
}
