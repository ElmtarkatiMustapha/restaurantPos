<?php

namespace APP;

use TOOL\HTTP\Filter;
use TOOL\HTTP\RES;
use TOOL\HTTP\RESException;
use TOOL\SQL\Curd\Extension as CurdExtension;

class Order extends CurdExtension
{

    /**
     * Curd options
     * 
     * @var array
     */
    protected static array $curdOptions = [
        'table' => 'orders',
        'tableKey' => 'id',
        'ACCESS_READ' => true,
        'ACCESS_CREATE' => true,
        'ACCESS_UPDATE' => true,
        'ACCESS_DELETE' => true
    ];


    /**
     * By table method
     * 
     * @param int $id
     * 
     * @param int $noPeople
     * 
     * @return
     */
    static function byTable(int $id, int $noPeople, $userName)
    {

        // Define table
        $table = Table::read($id)->data;

        if (!$table->id)
            throw new RESException(lang('Not found table'));

        // Define area
        $area = Area::read($table->area_id)->data;

        return Order::insert([
            'type' => 'table',
            'table_id' => $table->id,
            'table_area' => $area->name,
            'table_name' => $table->name,
            'no_people' => $noPeople,
            'create_by'=> $userName,
        ]);
    }

    /**
     * By import method
     * 
     * @return
     */
    static function byImport( $userName)
    {
        return Order::insert([
            'type' => 'import',
            'create_by' => $userName,
        ]);
    }

    /**
     * By delivery method
     * 
     * @param int $id
     * 
     * @return
     */
    static function byDelivery(int $id,  $userName)
    {

        // Define customer
        $customer = Customer::read($id)->data;

        if (!$customer->id)
            throw new RESException(lang('Not found customer'));

        return Order::insert([
            'type' => 'delivery',
            'customer_id' => $customer->id,
            'customer_name' => $customer->name,
            'customer_address' => $customer->address,
            'customer_phone' => $customer->phone,
            'create_by' => $userName,
        ]);
    }

    /**
     * Full payment method
     * 
     * @param int $id
     * 
     * @return
     */
    static function fullPayment(int $id,float $amountProvided)
    {

        // Check has paid
        if (self::hasPaid($id))
            throw new RESException(lang('This order has paid'));

        return self::where($id)->update([
            'paid' => true,
            'paid_at' => date('Y-m-d H:i:s'),
            'daily_id' => Daily::useDay()->data->id,
            'amountProvided'=> $amountProvided
        ]);
    }

    /**
     * Get method
     * 
     * @param int $id
     * 
     * @param ?array $skip
     * 
     * @return
     */
    static function get(int $id, ?array $skip = null)
    {

        $order = (array) self::read($id)->data;
        if ($skip) {

            $skipItems = implode(',', array_map('intval', $skip));

            $items = Sale::where("order_id = :id AND id NOT IN ({$skipItems})")->select('*, NULL AS capital')->readAll(['id' => $id])->data;
        } else
            $items = Sale::where('order_id = :id')->select('*, NULL AS capital')->readAll(['id' => $id])->data;

        return RES::return(
            RES::SUCCESS,
            null,
            (object) ($order + ['items' => $items])
        );
    }

    /**
     * Record method
     * 
     * @param object $req
     * 
     * @return
     */
    static function record(object $req , $create_by)
    {
        $Record = "";
        if($create_by != "admin"){
            $Record = self::prepareRecord([
                'record' => "SELECT *
                FROM orders
                LEFT JOIN (
                    SELECT
                    order_id,
                    SUM(qnt * price) AS total
                    FROM sales
                    GROUP BY order_id
                ) AS sales ON sales.order_id = orders.id
                WHERE paid = 0 and create_by = '$create_by'"
            ]);
        }else{
            $Record = self::prepareRecord([
                'record' => "SELECT *
                FROM orders
                LEFT JOIN (
                    SELECT
                    order_id,
                    SUM(qnt * price) AS total
                    FROM sales
                    GROUP BY order_id
                ) AS sales ON sales.order_id = orders.id
                WHERE paid = 0"
            ]);
        }
        

        if(isset($req->orders->id)){
            $Record->setOrder('id', $req->orders->id);
        }else if(isset($req->orders->table)){
            $Record->setOrder('table_name', $req->orders->table);
        }else if(isset($req->orders->create_by)){
            $Record->setOrder('create_by', $req->orders->create_by);
        }else if(isset($req->orders->total)){
            $Record->setOrder('total', $req->orders->total);
        }

        $Record->prepare(false);

        return $Record->page($req->page)->get();
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

        // Check has paid
        if (self::hasPaid($id))
            throw new RESException(lang('This order has paid'));

        // Delete items
        Sale::where("order_id = :id")->delete(['id' => $id]);

        // Delete category
        return self::delete($id);
    }

    /**
     * Update table method
     * 
     * @param int $id
     * 
     * @param object $req
     * 
     * @return
     */
    static function updateTable(int $id, object $req)
    {

        // Check has paid
        if (self::hasPaid($id))
            throw new RESException(lang('This order has paid'));

        // Validation
        $params = (object) Filter::validate([
            ['table', $req->table, TRUE, Filter::IS_ID, lang('Table not valid')],
            ['noPeople', $req->noPeople, TRUE, Filter::IS_ID, lang('No people not valid')]
        ])->throw()->valid;

        // Define table
        $table = Table::read($params->table)->data;

        if (!$table->id)
            throw new RESException(lang('Not found table'));

        // Define area
        $area = Area::read($table->area_id)->data;

        return Order::where($id)->update([
            'table_id' => $table->id,
            'table_area' => $area->name,
            'table_name' => $table->name,
            'no_people' => $params->noPeople
        ]);
    }

    /**
     * Has paid method
     * 
     * @param int $id
     * 
     * @return bool
     */
    static function hasPaid(int $id)
    {

        return self::read($id)->data->paid === 1;
    }
    
}
