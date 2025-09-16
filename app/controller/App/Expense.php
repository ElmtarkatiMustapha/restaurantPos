<?php

namespace APP;

use Dompdf\Dompdf;
use Throwable;
use TOOL\HTTP\RES;
use TOOL\Network\Mailer;
use \TOOL\SQL\Curd\Extension as CurdExtension;
use TOOL\SQL\SQL;
class Expense extends CurdExtension
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
        'table' => 'expense_daily',
        'tableKey' => 'id',
        'ACCESS_READ' => true,
        'ACCESS_CREATE' => true,
        'ACCESS_UPDATE' => true
    ];

    static function record(object $req)
    {
        //$sql = "SELECT SUM(expenses.amount) as amount, COUNT(expenses.id) AS countExpense  From expense_daily, expenses where expense_daily.id == expenses.daily_id" ;
        $Record = self::prepareRecord([
            'record' => "SELECT expense_daily.id as id, expense_daily.create_at as create_at, expense_daily.close_at as close_at ,COUNT(expenses.id) AS countExpense , SUM(expenses.amount) as amount from expense_daily LEFT JOIN expenses on expense_daily.id = expenses.daily_id GROUP by expenses.daily_id ORDER BY create_at desc",
            'results' => "SUM(amount) AS amounts,
            SUM(countExpense) AS countExpenses"
        ]);

        // $Record->setOrder('id', $req->orders->id);
        // $Record->setOrder('income', $req->orders->income);
        // $Record->setOrder('profit', $req->orders->profit);

        $Record->setFilter("AND DATE(create_at) >= :from", ['from' => $req->from], $req->from);
        $Record->setFilter("AND DATE(create_at) <= :to", ['to' => $req->to], $req->to);

        return $Record->get();
    }
    static function create(object $req){
        $title = $req->title;
        $amount = $req->amount;
        $description = "" ;
        if($req->description){
            $description = $req->description ;
        }
        
        $daily_id = "";
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

        $sqlDaily =  "SELECT * FROM expense_daily where close_at is NULL limit 1";
        $resDaily = mysqli_query($conn, $sqlDaily);
        if ($resDaily->num_rows > 0) {
            $daily_id =  mysqli_fetch_assoc($resDaily)["id"];
        }else{
            $sqlDaily = "INSERT INTO `expense_daily` ( `close_at`) VALUES (null)";
            mysqli_query($conn, $sqlDaily);
            $daily_id = mysqli_insert_id($conn);
        }

        $sql = "INSERT INTO `expenses`( `title`, `amount`, `description`, `daily_id`) VALUES ('$title','$amount','$description','$daily_id')";
        $res = mysqli_query($conn, $sql);
        return RES::return(RES::SUCCESS, null, ["message"=> $res]);
    }
    static function renewal(){
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
        $currentDateTime = date('Y-m-d H:i:s');
        $sqlUpdate = "UPDATE `expense_daily` SET `close_at`='$currentDateTime' WHERE close_at is NULL";
        mysqli_query($conn, $sqlUpdate);
        return RES::return(RES::SUCCESS, null, ["message" =>"cloture with success"]);
    }
    
    static function expense(int $id, object $req){
        $Record = self::prepareRecord([
            'record' => "SELECT id, title, amount, description
            FROM expenses
            WHERE daily_id = :id",
            'results' => "SUM(amount) as totalAmount, COUNT(id) as CountExpense"
        ]);
        return $Record->get(['id' => $id]);
    }
    static function remove(int $id, object $req ){
        $servername = config('DATABASE_HOST');
        $username = config('DATABASE_USER');
        $password = config('DATABASE_PASS');
        $dbname = config('DATABASE_NAME');
        // Create connection
        try {
            $conn = mysqli_connect($servername, $username, $password, $dbname);
            // Check connection
            if (!$conn) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $sqlDelete = "DELETE FROM expenses WHERE id = $id";
            mysqli_query($conn, $sqlDelete);
            return RES::return(RES::SUCCESS, null, ["message" => "removed with success"]);
        } catch (Throwable $error) {
            return RES::return(RES::ERROR, null, ["message" => "removed with success"]);
        }
        
    }
     /**
     * export data
     */
    static function export(Object $req){
        
        $Record = self::prepareRecord([
            'record' => " SELECT 
                    id ,
                    title,
                    create_at,
                    description,
                    amount as total, 
                    DATE(create_at) AS costs_date,
                    daily_id
                FROM expenses
                ORDER BY create_at DESC
                " 
        ]);
        $Record->setFilter("AND DATE(create_at) >= :from", ['from' => $req->from], $req->from);
        $Record->setFilter("AND DATE(create_at) <= :to", ['to' => $req->to], $req->to);
        // return $Record->get();
        $data = $Record->get()->data->rows ?? [];

        

        // Ouverture du flux de sortie
        $output = fopen('php://output', 'w');

        // Écrire l'en-tête CSV
        fputcsv($output, ['ID ligne', 'Title', 'Date Complet', 'Date', 'Total', 'ID depence', 'description'],";");

        // Écrire les lignes de données
        foreach ($data as $row) {
            fputcsv($output, [
                $row->id ?? 'null',
                $row->title ?? 'null',
                $row->create_at ?? 'null',
                $row->costs_date ?? 'null',
                $row->total ?? 'null',
                $row->daily_id ?? 'null',
                empty($row->description)?'null':$row->description
            ],";");
        }

        fclose($output);
        exit;
    }
    static function report(?int $id)
    {
        $total = 0;
        $Record = self::prepareRecord([
            'record' => " SELECT 
                id ,
                title,
                create_at,
                description,
                amount as total, 
                DATE(create_at) AS costs_date,
                daily_id
                FROM expenses
                ORDER BY create_at DESC
                " 
        ]);
        $Record->setFilter("AND daily_id = :id", ['id' => $id], $id);
        $data = $Record->get()->data->rows ?? [];
        foreach ($data as $row) {
            $total += $row->total;
        }
        $Record2 = self::prepareRecord([
            'record' => "SELECT *
            FROM expense_daily
            WHERE id = :id"
        ]);
        $dataExpense = $Record2->get(['id' => $id])->data->rows;
        try {
            self::sendEmail((object)["items"=>$data,"total"=>$total,"infos"=>$dataExpense[0]]);
        } catch (Throwable $error) {
            
            unset($error);
        }
        return RES::return(RES::SUCCESS , "response" , ["items"=>$data,"total"=>$total,"infos"=>$dataExpense[0]]);

    }
    private static function sendEmail($data)
    {
        // Generate pdf file
        $dompdf = new Dompdf();
        $dompdf->loadHtml(template('/email/reportExpense.php', ['data' => $data]));
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Generate new report
        file_put_contents($file = BASESTORAGE . '/cache/R-' . date('Y-m-d H-i-s') . '.pdf', $dompdf->output());

        // Send report to mail
        Mailer::file($file);

        // Detele old report
        unlink($file);
    }
}