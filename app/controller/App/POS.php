<?php

namespace APP;

use Error;
use Throwable;
use TOOL\HTTP\Filter;
use TOOL\HTTP\RES;
use TOOL\HTTP\RESException;

class POS
{

    /**
     * Order method
     * 
     * @param object $req
     * 
     * @return
     * 
     */
    static function order(object $req)
    {

        // Step 1: Validation
        $valid = self::validation($req->items);

        // Step 2: Generate order
        if ($req->type === 'table')
            $order = Order::byTable($req->table, $req->noPeople,$req->userName);

        else if ($req->type === 'import')
            $order = Order::byImport($req->userName);

        else if ($req->type === 'delivery')
            $order = Order::byDelivery($req->customer, $req->userName);

        else
            throw new RESException('Not found type');

        // Step 3: Sale
        Sale::order(array_map(function ($item) use ($order) {
            return $item + ['order_id' => $order->data->id];
        }, $valid));


        // Step 4: Payment
        if ($req->payment)
            Order::fullPayment($order->data->id, $req->amountProvided);


        // Step 5: Print
        try{
            $listEquipedIn = EquipsIn::getAll();
            foreach($listEquipedIn as $key=>$item ){
                template('/thermal/custom.php', [
                    'order' => Order::get($order->data->id)->data,
                    'equipsIn'=>$item
                ]);
                // self::customPrint($order->data->id,$item);
            }
        }catch(Throwable $error){
            Settings::setError($error->getMessage());
            unset($error);
        }

        try {

            if ($req->cashier)
                self::cashierPrint($order->data->id);
        } catch (Throwable $error) {

            unset($error);
        }

        try {

            if ($req->payment)
                self::paymentPrint($order->data->id);
        } catch (Throwable $error) {

            unset($error);
        }

        return $order;
    }

    /**
     * Validation method
     * 
     * @param array $items
     * 
     * @return array
     */
    private static function validation(array $items)
    {

        // Step 1: Check items is found
        if (!$items)
            throw new RESException(lang('Not found items'));


        // Step 2: Validation
        $valid = Filter::multiValidate(function ($item) {

            // Define menu
            $menu = Menu::read($item->id)->data;

            // Define category
            $category = Category::read($menu->category_id)->data;

            // Define title
            $title = "{$menu->name}";

            return [
                ['menu_id', $menu->id, TRUE, FILTER_VALIDATE_INT, lang('Item not valid')],
                ['menu_id', $menu->id, TRUE, is_null($menu->quantity) || $menu->quantity >= $item->qnt, "{$menu->quantity} \"{$title}\" " . lang('left')],
                ['qnt', $item->qnt, TRUE, FILTER_VALIDATE_FLOAT, lang('Qnt not valid')],
                ['note', $item->note],
                ['category_name', $category->name],
                ['equips_in', $menu->equips_in],
                ['title', $title],
                ['price', $item->price],
                ['capital', $menu->capital],
                ['left', is_null($menu->quantity) ? null : $menu->quantity - $item->qnt]
            ];
        }, $items)->throw()->valid;

        return $valid;
    }

    /**
     * custom print function for other print
     * @param int $order
     */
    static function customPrint(int $order,object $equipsIn){
        
        template('/thermal/custom.php', [
            'order' => Order::get($order)->data,
            'equipsIn'=>$equipsIn,
        ]);
        
        return RES::return(RES::SUCCESS);
    }
    /**
     * Kitchen print method
     * 
     * @param int $order
     * 
     * @return
     */
    static function kitchenPrint(int $order)
    {

        template('/thermal/kitchen.php', [
            'order' => Order::get($order)->data
        ]);

        return RES::return(RES::SUCCESS);
    }

    /**
     * Bartender print method
     * 
     * @param int $order
     * 
     * @return
     */
    static function bartenderPrint(int $order)
    {

        template('/thermal/bartender.php', [
            'order' => Order::get($order)->data
        ]);

        return RES::return(RES::SUCCESS);
    }

    /**
     * Cashier print method
     * 
     * @param int $order
     * 
     * @return
     */
    static function cashierPrint(int $order)
    {

        template('/thermal/cashier.php', [
            'order' => Order::get($order)->data
        ]);

        return RES::return(RES::SUCCESS);
    }

    /**
     * Cashier payment method
     * 
     * @param int $order
     * 
     * @return
     */
    static function paymentPrint(int $order)
    {

        // Check has paid
        // if (!Order::hasPaid($order))
        //     throw new RESException(lang('Not paid yet'));

        template('/thermal/payment.php', [
            'order' => Order::get($order)->data
        ]);

        return RES::return(RES::SUCCESS);
    }

    /**
     * Add items
     * 
     * @param int $id
     * 
     * @param object $req
     * 
     * @return
     */
    static function addItems(int $id, object $req)
    {

        // Check has paid
        if (Order::hasPaid($id))
            throw new RESException(lang('This order has paid'));

        // Step 1: Validation
        $valid = self::validation($req->items);

        // Old items
        $oldItems = array_column(Order::get($id)->data->items, 'id');

        // Step 3: Sale
        Sale::order(array_map(function ($item) use ($id) {
            return $item + ['order_id' => $id];
        }, $valid));

        // Step 4: Print
        try{
            //map other printer
            $listEquipedIn = EquipsIn::getAll();
            foreach($listEquipedIn as $key=>$item ){
                template('/thermal/custom.php', [
                    'order' => Order::get($id, $oldItems)->data,
                    'equipsIn'=>$item
                ]);
            }
        }catch(Throwable $error){
            Settings::setError($error->getMessage());
            unset($error);
        }
        
        return RES::return(RES::SUCCESS);
    }
}
