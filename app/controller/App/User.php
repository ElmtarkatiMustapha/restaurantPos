<?php

/**
 * |--------------
 * |    USER
 * |--------------
 */

namespace APP;

use TOOL\HTTP\RES;
use TOOL\HTTP\Filter;
use TOOL\Security\Token;
use TOOL\SQL\Curd\Extension as CurdExtension;
use TOOL\SQL\SQL;
use TOOL\Security\Auth;

class User extends CurdExtension
{
    

    /**
     * LOGIN_ERROR
     * 
     * @var string
     */
    private const LOGIN_ERROR = 'Password or username is incorrect';

    /**
     * Curd options
     * 
     * @var array
     */
    protected static array $curdOptions = [
        'table' => 'users',
        'tableKey' => 'id',
        'ACCESS_READ' => true,
        'ACCESS_CREATE' => true
    ];

    /**
     * Login method
     * 
     * @param object $req
     * 
     * @return
     */
    static function login(object $req)
    {
        session_start();

        // Validation
        $valid = (object) Filter::validate([
            ['username', $req->username, TRUE],
            ['password', $req->password, TRUE],
            ['remember', $req->remember, FALSE]
        ])->throw(lang(self::LOGIN_ERROR))->valid;

        // Get user
        $user = self::where("username = :username")->read(['username' => $valid->username])->data;

        if ($user->id && password_verify($valid->password, $user->password)) {

            // Generete token
            $_SESSION['fullName'] = $user->fullName;
            $userData = ['id' => $user->id];
            $token = Token::generate($userData, $valid->remember ? null : '+40 seconds');

            return RES::return(RES::SUCCESS, null, ['token' => $token,"fullName"=>$user->fullName , "userId"=> $user->id, "password"=> $valid->password, "userName"=> $valid->username]);
        } else {

            // Validation as invalid
            Filter::validate([
                ['username', null, TRUE],
                ['password', null, TRUE]
            ])->throw(lang(self::LOGIN_ERROR));
        }
    }
    static function loginCard(object $req)
    {
        session_start();
        // Validation
        // Get user
        $user = self::where("rfidCode = :rfidCode")->read(['rfidCode' => $req->rfidCode])->data;

        if ($user->id) {
            // Generete token
            $_SESSION['fullName'] = $user->fullName;
            $userData = ['id' => $user->id];
            $token = Token::generate($userData, $req->remember ? null : '+40 seconds');

            return RES::return(RES::SUCCESS, null, ['token' => $token,"fullName"=>$user->fullName , "idUser"=> $user->id, "password"=> $user->visiblepass, "userName"=> $user->username]);
        } else {

            // Validation as invalid
            Filter::validate([
                ['username', null, TRUE],
                ['password', null, TRUE]
            ])->throw(lang(self::LOGIN_ERROR));
        }
    }

    /**
     * Register method
     * 
     * @param object $req
     * 
     * @return RES
     */
    static function register(object $req)
    {

        // Validation
        $valid = (object) Filter::validate([
            // ['firstName', $req->firstName, TRUE],
            ['username', $req->userName, TRUE, Filter::IS_USERNAME],
            ['username', $req->userName, TRUE, function ($valid) {
                return !self::where("username = :username")->read(['username' => $valid->username])->data->id;
            }, 'username arrady exist'],
            // ['email', $req->email, TRUE, Filter::IS_EMAIL],
            ['type', $req->type, TRUE],
            ['password', $req->password, TRUE],
            // ['confirmPassword', $req->confirmPassword, TRUE, $req->confirmPassword === $req->password],
        ])->throw()->valid;

        // Create account
        return self::insert([
            'fullName'=>$req->fullName,
            'type' => $req->type,
            'username' => $valid->username,
            'rfidCode' => $req->rfidCode,
            'password' => password_hash($valid->password, PASSWORD_DEFAULT),
            'visiblepass' => $valid->password
        ]);
    }
    static function updateInfo(object $req){
        $servername = config('DATABASE_HOST');
        $username = config('DATABASE_USER');
        $password = config('DATABASE_PASS');
        $dbname = config('DATABASE_NAME');

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        // Check connection
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $escapedValue = mysqli_real_escape_string($conn, $req->rfidCode);
        $sql = "UPDATE users SET fullName='" . $req->fullName . "', rfidCode='" . $escapedValue . "', password='". password_hash($req->password, PASSWORD_DEFAULT)."' WHERE username='".$req->userName. "'";
        // $sql = "UPDATE users SET fullName='mustapha', password='". password_hash("admin", PASSWORD_DEFAULT)."' WHERE username='admin'";

        if (mysqli_query($conn, $sql)) {
            return RES::return(RES::SUCCESS, null, ['message' =>"good job"]);
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
        // self::update([
        //     'password' => password_hash($req->password, PASSWORD_DEFAULT),
        //     "fullName" => $req->fullName
        // ]);
    }
    static function get_all(){
        $servername = config('DATABASE_HOST');
        $username = config('DATABASE_USER');
        $password = config('DATABASE_PASS');
        $dbname = config('DATABASE_NAME');

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        $sql = "SELECT * FROM users";
        // $sql = "UPDATE users SET fullName='mustapha', password='". password_hash("admin", PASSWORD_DEFAULT)."' WHERE username='admin'";
        $res = mysqli_query($conn, $sql);
        if ($res->num_rows > 0) {
            $data = array();
            while ($row = mysqli_fetch_assoc($res)) {
                $data[] = $row;
            }
            // Send the data as a JSON response
            // header("Content-Type: application/json");
            // echo json_encode($data);
            return RES::return(RES::SUCCESS, null, $data);
        } else {
            echo "Error updating record: " . mysqli_error($conn);
        }
    }
    static function setSession(object $req){
        session_start();
        $_SESSION["fullName"] = $req->fullName;
        return RES::return(RES::SUCCESS, null, ["message"=> $_SESSION["fullName"]]);
    }
    static function deleteOne(object $req){
        $servername = config('DATABASE_HOST');
        $username = config('DATABASE_USER');
        $password = config('DATABASE_PASS');
        $dbname = config('DATABASE_NAME');

        // Create connection
        $conn = mysqli_connect($servername, $username, $password, $dbname);
        if (!$conn) {
            die("Connection failed: " . mysqli_connect_error());
        }
        if(Auth::loggedIn()->id != $req->userID){
            $sql = "DELETE FROM `users` WHERE id=".$req->userID;
            mysqli_query($conn, $sql);
            return RES::return(RES::SUCCESS, null, ["message" => "good job"]);
        }else{
            return RES::return(RES::ERROR, null, ["message" => "No autorise "]);
        }
    }
    /**
     * get statistic infos
     */
    static function get_statistics($user){
        $currentDaily = Daily::useDay()->data->id;
        $Record1 = Order::prepareRecord([
            'record' => "SELECT *
            FROM orders
            WHERE paid = 0  and create_by= '$user'"
        ]);
        $Record2 = Order::prepareRecord([
            'record' => "SELECT *
            FROM orders
            WHERE paid = 1  and create_by= '$user' and daily_id = '$currentDaily' "
        ]);
        $Record3 = Daily::prepareRecord([
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
        // $Record->setOrder('id');
        $Record1->prepare(false);
        $Record2->prepare(false);
        $Record3->setFilter("AND create_by = :user", ['user' => $user], $user);

        $pendingOrders = count($Record1->get()->data->rows);
        $payedOrders = count($Record2->get()->data->rows);
        $total = $Record3->get(['id' => $currentDaily])->data->results->totals;

        return RES::return(RES::SUCCESS, null, [
            "pendingOrders" => $pendingOrders,
            "payedOrders" => $payedOrders,
            "total" => $total
        ]);
    }
    
    //print rapport user
    static function raport($user, object $req){
        //get daily id
        // Define id
        $id = $req->daily ?? Daily::useDay()->data->id;

        $userData = self::getUserReport($user,$id);
        template('/thermal/userRaport.php', $userData);
        return RES::return(RES::SUCCESS, null, [$userData]);

    }
    static function getUserReport($user, $dailyId){
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
                where create_by = :user
                GROUP BY daily_id
            ) AS orders ON orders.daily_id = daily.id
            WHERE daily.id = :dailyId
        ")->ferch([
            'dailyId' => $dailyId,
            "user" => $user
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
                where create_by = :user
            ) AS orders ON orders.orderId = sales.order_id

            WHERE orders.daily_id = :dailyId
            GROUP BY sales.menu_id
        ")->ferchAll([
            'dailyId' => $dailyId,
            'user' => $user
        ])->data;

        // GROUP

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
            'total' => $total
        ];
        return [
            'data' => $data,
            "user" =>$user
        ];
    }
}

