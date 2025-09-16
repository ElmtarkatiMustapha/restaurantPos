<?php

namespace APP;

use TOOL\HTTP\Filter;
use TOOL\HTTP\RESException;
use TOOL\SQL\Curd\Extension as CurdExtension;

class Sale extends CurdExtension
{

    /**
     * Curd options
     * 
     * @var array
     */
    protected static array $curdOptions = [
        'table' => 'sales',
        'tableKey' => 'id',
        'ACCESS_READ' => true,
        'ACCESS_CREATE' => true,
        'ACCESS_UPDATE' => true,
        'ACCESS_DELETE' => true
    ];


    /**
     * Order method
     * 
     * @param array $items
     * 
     * @return
     */
    static function order(array $items)
    {
        // Update stock
        foreach ($items as $item) {

            if (!is_null($item['left']))
                Menu::where($item['menu_id'])->update(['quantity' => $item['left']]);
        }

        // Sale
        return self::prepareInsert(
            ['order_id', 'menu_id', 'category_name', 'equips_in', 'title', 'price', 'capital', 'qnt', 'note']
        )->save($items);
    }

    /**
     * Update qnt method
     * 
     * @param int $id
     * 
     * @param object $req
     * 
     * @return
     */
    static function updateQnt(int $id, object $req)
    {

        // Check has paid
        if (Order::hasPaid($id))
            throw new RESException(lang('This order has paid'));

        // Validation
        $valid = (object) Filter::validate([
            ['qnt', $req->qnt, TRUE, is_int($req->qnt) && $req->qnt >= 1, lang('Qnt not valid')]
        ])->throw()->valid;

        // Define item
        $item = self::read($id)->data;

        // Check has paid
        if (Order::hasPaid($item->order_id))
            throw new RESException(lang('This order has paid'));

        // Define menu
        $menu = Menu::read($item->menu_id)->data;

        // Check is avaliable stock
        if ($menu->quantity !== null && $menu->quantity < $valid->qnt - $item->qnt)
            throw new RESException('out of stock');

        // Update qnt
        if ($menu->quantity !== null)
            Menu::where($menu->id)->update(['quantity' => $menu->quantity - ($valid->qnt - $item->qnt)]);

        return self::where($id)->update(['qnt' => $valid->qnt]);
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
        // Define item
        $item = self::read($id)->data;

        // Check has paid
        if (Order::hasPaid($item->order_id))
            throw new RESException(lang('This order has paid'));

        // Define menu
        $menu = Menu::read($item->menu_id)->data;

        // Update qnt
        if ($menu->quantity !== null)
            Menu::where($menu->id)->update(['quantity' => $menu->quantity + $item->qnt]);

        return self::delete($id);
    }
}
