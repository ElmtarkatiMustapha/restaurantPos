<?php

namespace APP;

use Dompdf\Dompdf;
use Throwable;
use TOOL\HTTP\RES;
use TOOL\Network\Mailer;
use \TOOL\SQL\Curd\Extension as CurdExtension;
use TOOL\SQL\SQL;

class Daily extends CurdExtension
{

    /**
     * LAST_DAY_CONDITION
     * 
     * @var string
     */
    private const LAST_DAY_CONDITION = "close_at IS NULL ORDER BY id DESC LIMIT 1";


    /**
     * Curd options
     * 
     * @var array
     */
    protected static array $curdOptions = [
        'table' => 'daily',
        'tableKey' => 'id',
        'ACCESS_READ' => true,
        'ACCESS_CREATE' => true,
        'ACCESS_UPDATE' => true
    ];


    /**
     * Generate method
     * 
     * @return
     */
    static function generate()
    {
        // return self::insert(['id' => 'id']);
        return self::insert(['create_at' => date('Y-m-d H:i:s'),]);
    }

    /**
     * Use day method
     * 
     * @return
     */
    static function useDay()
    {
        // Define day
        $day = self::where(self::LAST_DAY_CONDITION)->read();

        if ($day->data->id)
            return $day;

        // Generate as new
        self::generate();

        return self::where(self::LAST_DAY_CONDITION)->read();
    }

    /**
     * Send email method
     * 
     * @param $data
     */
    private static function sendEmail($data)
    {
        // Generate pdf file
        $dompdf = new Dompdf();
        $dompdf->loadHtml(template('/email/report.php', ['data' => $data]));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Generate new report
        file_put_contents($file = BASESTORAGE . '/cache/R-' . date('Y-m-d H-i-s') . '.pdf', $dompdf->output());

        // Send report to mail
        Mailer::file($file);

        // Detele old report
        unlink($file);
    }

    /**
     * Send Report
     * 
     * @param ?int $id
     * 
     * @return
     */
    static function report(?int $id)
    {

        // Define id
        $id = $id ?? self::useDay()->data->id;

        // Define total
        $total = 0;

        // Get daily
        $daily = SQL::set("SELECT
            id,
            create_at,
            close_at,
            IFNULL(totalOrders, 0) AS totalOrders,
            IFNULL(byTable, 0) AS byTable,
            IFNULL(byDelivery, 0) AS byDelivery,
            IFNULL(byImport, 0) AS byImport,
            byTable,
            byDelivery,
            byImport,
            totalTable,
            totalDelivery,
            totalImport
            FROM daily
            LEFT JOIN (
                SELECT
                daily_id,
                COUNT(id) AS totalOrders,

                SUM(
                    CASE
                        WHEN orders.type = 'table' THEN 1
                        ELSE 0
                    END
                ) AS byTable,
                SUM(
                    CASE
                        WHEN orders.type = 'delivery' THEN 1
                        ELSE 0
                    END
                ) AS byDelivery,
                SUM(
                    CASE
                        WHEN orders.type = 'import' THEN 1
                        ELSE 0
                    END
                ) AS byImport,

                SUM(
                    CASE
                        WHEN orders.type = 'table' THEN subTotal
                        ELSE 0
                    END
                ) AS totalTable,
                SUM(
                    CASE
                        WHEN orders.type = 'delivery' THEN subTotal
                        ELSE 0
                    END
                ) AS totalDelivery,
                SUM(
                    CASE
                        WHEN orders.type = 'import' THEN subTotal
                        ELSE 0
                    END
                ) AS totalImport

                FROM orders
                LEFT JOIN (
                    SELECT
                    order_id,
                    SUM(qnt * price) AS subTotal
                    FROM sales
                    GROUP BY order_id
                ) AS sales ON sales.order_id = orders.id
                GROUP BY daily_id
            ) AS orders ON orders.daily_id = daily.id
            WHERE daily.id = :dailyId
        ")->ferch([
            'dailyId' => $id
        ])->data;

        // Get items
        $items = SQL::set("SELECT
            category_name,
            price,
            title,
            SUM(qnt) AS qnt,
            SUM(qnt * price) AS total
            FROM sales

            RIGHT JOIN (
                SELECT
                id AS orderId,
                daily_id
                FROM orders
            ) AS orders ON orders.orderId = sales.order_id

            WHERE orders.daily_id = :dailyId
            GROUP BY sales.menu_id
        ")->ferchAll([
            'dailyId' => $id
        ])->data;

        // GROUP
        $RecordByUsers = self::prepareRecord([
            'record' => "SELECT SUM(total)as total, create_by as username, SUM(items) as items
            FROM orders
            LEFT JOIN (
                SELECT order_id,
                SUM(price * qnt) AS total,
                SUM((price - capital) * qnt) AS profit,
                COUNT(id) AS items 
                FROM sales
                GROUP BY order_id
            ) AS sales ON sales.order_id = orders.id
            WHERE daily_id = :id
            group By create_by"
        ]);
        $dataByUser = $RecordByUsers->get(['id' => $id]);
        //get items of each user
        $allUserItems = [];
        foreach($dataByUser->data->rows as $user){
            $arr1 = (object) ["username"=>$user->username, "items"=>$user->items, "total"=>$user->total];
            //query to get record by user
            $arr2 =  (object) User::getUserReport($user->username,$id);

            array_push($allUserItems,(object)["infos"=>$arr1,"details"=>$arr2]);
        }

        // Define new items
        $newItems = [];

        // Start group
        foreach ($items as $key => $item) {

            // Check if category exists in $newItems
            if (!isset($newItems[$item->category_name])) {
                // If not, initialize it
                $newItems[$item->category_name] = (object)[
                    'items' => [],
                    'total' => 0,
                    'nbItems'=>0,
                ];
            }

            // Append to parent category
            $newItems[$item->category_name]->items[$key] = $item;

            // Sum category total
            $newItems[$item->category_name]->total += $item->total;
            $newItems[$item->category_name]->nbItems += $item->qnt;

            // Sum total
            $total += $item->total;
        }

        // Sort
        ksort($newItems, SORT_NUMERIC);

        // Return to items
        $items = $newItems;

        // END GROUP
 
        $data = (object) [
            'daily' => $daily,
            'items' => $items,
            'total' => $total,
            'users' => $allUserItems
        ];
        
        
        try {

            template('/thermal/report.php', ['data' => $data]);
        } catch (Throwable $error) {
            
            unset($error);
        }
        
        try {

            self::sendEmail($data);
        } catch (Throwable $error) {
            
            unset($error);
        }
        return RES::return(RES::SUCCESS , "response" , $data);

    }

    /**
     * Renewal method
     * 
     * @return
     */
    static function renewal()
    {
        // Define use day
        $useDay = self::useDay()->data->id;
        
        //get record in wait
        $record = SQL::set("SELECT *
            FROM orders
            LEFT JOIN (
                SELECT
                order_id,
                SUM(qnt * price) AS total
                FROM sales
                GROUP BY order_id
            ) AS sales ON sales.order_id = orders.id
            WHERE paid = 0")->ferchAll()->data;
        //check if not empty
        if(!empty($record)){
            //return error
            return RES::return(RES::ERROR,"Commandes pas encore payées");
        }

        // Close this day
        self::where(self::LAST_DAY_CONDITION)->update(['close_at' => date('Y-m-d H:i:s')]);

        // Generate new day
        $generate = self::generate();

        self::report($useDay);

        return $generate;
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
            'record' => "SELECT *
            FROM daily
            LEFT JOIN (
                SELECT daily_id,
                SUM(income) AS income,
                SUM(profit) AS profit,
                COUNT(id) AS countOrder
                FROM orders
                LEFT JOIN (
                    SELECT order_id,
                    SUM(price * qnt) AS income,
                    SUM((price - capital) * qnt) AS profit
                    FROM sales
                    GROUP BY order_id
                ) AS sales ON sales.order_id = orders.id
                GROUP BY daily_id
            ) AS orders ON orders.daily_id = daily.id",
            'results' => "SUM(income) AS incomes,
            SUM(profit) AS profits,
            SUM(countOrder) AS countOrders"
        ]); 

        $Record->setOrder('id', $req->orders->id);
        $Record->setOrder('income', $req->orders->income);
        $Record->setOrder('profit', $req->orders->profit);

        $Record->setFilter("AND DATE(create_at) >= :from", ['from' => $req->from], $req->from);
        $Record->setFilter("AND DATE(create_at) <= :to", ['to' => $req->to], $req->to);

        return $Record->get();
    }

    /**
     * Orders method
     * 
     * @param int $id
     * 
     * @param object $req
     * 
     * @return
     */
    static function orders(int $id, object $req)
    {
        $Record = self::prepareRecord([
            'record' => "SELECT *
            FROM orders
            LEFT JOIN (
                SELECT order_id,
                SUM(price * qnt) AS total,
                SUM((price - capital) * qnt) AS profit,
                COUNT(id) AS items 
                FROM sales
                GROUP BY order_id
            ) AS sales ON sales.order_id = orders.id
            WHERE daily_id = :id",
            'results' => "SUM(total) AS totals,
            SUM(profit) AS profits" 
        ]);

        $Record->setOrder('id', $req->orders->id);
        $Record->setOrder('items', $req->orders->items);
        $Record->setOrder('total', $req->orders->total);
        $Record->setOrder('profit', $req->orders->profit);
        if($req->userName !="" && $req->userName !="false" ){
            $Record->setFilter("AND create_by = :user", ['user' => $req->userName], $req->userName);
        }

        return $Record->get(['id' => $id]);
    }
    /**
     * export data
     */
    static function export(Object $req){
        
        $Record = self::prepareRecord([
            'record' => " SELECT 
                    m.id AS product_id,
                    m.name AS product_name,
                    s.create_at as create_at,
                    o.create_by as create_by,
                    (s.price * s.qnt) as total, 
                    DATE(s.create_at) AS order_date,
                    HOUR(s.create_at) AS order_time,
                    s.qnt AS quantity,
                    c.id AS category_id,
                    c.name AS category_name
                FROM sales s
                LEFT JOIN menu m ON s.menu_id = m.id
                LEFT JOIN categories c ON m.category_id = c.id
                LEFT JOIN orders o ON s.order_id = o.id
                ORDER BY o.create_at DESC
                " 
        ]);
        $Record->setFilter("AND DATE(create_at) >= :from", ['from' => $req->from], $req->from);
        $Record->setFilter("AND DATE(create_at) <= :to", ['to' => $req->to], $req->to);
        // return $Record->get();
        $data = $Record->get()->data->rows ?? [];

        

        // Ouverture du flux de sortie
        $output = fopen('php://output', 'w');

        // Écrire l'en-tête CSV
        fputcsv($output, ['ID Produit', 'Nom Produit', 'Date Complet', 'Date', 'Heure', 'Quantite', 'Total', 'ID Categorie', 'Nom Categorie','Creer par'],";");

        // Écrire les lignes de données
        foreach ($data as $row) {
            fputcsv($output, [
                $row->product_id ?? '',
                $row->product_name ?? '',
                $row->create_at ?? '',
                $row->order_date ?? '',
                $row->order_time ?? '',
                $row->quantity ?? '',
                $row->total ?? '',
                $row->category_id ?? '',
                $row->category_name ?? '',
                $row->create_by ?? ''
            ],";");
        }

        fclose($output);
        exit;
    }
}
