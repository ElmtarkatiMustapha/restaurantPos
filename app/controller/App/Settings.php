<?php

namespace APP;

use TOOL\HTTP\Filter;
use TOOL\HTTP\RES;
use TOOL\System\JSON;

class Settings
{

    /**
     * SETTINGS
     * 
     * @var string
     */
    private const SETTINGS = BASESTORAGE . '/settings.json';


    /**
     * Open method
     * 
     * @return JSON
     */
    public static function open()
    {
        return JSON::open(self::SETTINGS);
    }

    /**
     * Get method
     * 
     * @return object
     */
    static function get()
    {
        return self::open()->read();
    }

    /**
     * Get printers method
     * 
     * @return
     */
    static function getPrinters()
    {
        return RES::return(RES::SUCCESS, null, self::open()->go('/printers')->read());
    }
    static function getCaissier()
    {
        // return RES::return(RES::SUCCESS, null, );
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

        $sql = "SELECT * FROM users ";
        // $sql = "UPDATE users SET fullName='mustapha', password='". password_hash("admin", PASSWORD_DEFAULT)."' WHERE username='admin'";
        $res = mysqli_query($conn, $sql);
        if ($res->num_rows > 0) {
            $data = array();
            while ($row = mysqli_fetch_assoc($res)
            ) {
                $data[] = $row;
            }
            // Send the data as a JSON response
            // header("Content-Type: application/json");
            // echo json_encode($data);
            return RES::return(RES::SUCCESS,null,$data);
        } else {
            return RES::return(RES::SUCCESS,null,[]);
        }
        // return RES::return(RES::SUCCESS, null, self::open()->go('/printers')->read());
    }

    /**
     * Set printers method
     * 
     * @param object $req
     * 
     * @return
     */
    static function setPrinters(object $req)
    {
        // Validation
        $valid = Filter::validate([
            ['kitchen', $req->kitchen],
            ['bartender', $req->bartender],
            ['cashier', $req->cashier]
        ])->throw()->valid;

        self::open()->go('/printers')->set($valid)->save();

        return RES::return(RES::SUCCESS);
    }

    /**
     * Get company method
     * 
     * @return
     */
    static function getCompany()
    {
        return RES::return(RES::SUCCESS, null, self::open()->go('/company')->read());
    }

    /**
     * Set company method
     * 
     * @param object $req
     * 
     * @return
     */
    static function setCompany(object $req)
    {

        // Validation
        $valid = Filter::validate([
            ['name', $req->name],
            ['phone', $req->phone],
            ['address', $req->address],
            ['logo', $req->logo, FALSE, pathinfo($req->logo, PATHINFO_EXTENSION) === 'jpg', 'Enable just jpg'],
            ['logo', $req->logo, FALSE, function ($valid) {
                return is_readable(BASEUPLOAD . "/{$valid->logo}");
            }, 'Not found logo']
        ])->throw()->valid;

        self::open()->go('/company')->set($valid)->save();

        return RES::return(RES::SUCCESS);
    }

    /**
     * Get ticket method
     * 
     * @return
     */
    static function getTicket()
    {
        return RES::return(RES::SUCCESS, null, self::open()->go('/ticket')->read());
    }

    /**
     * Set ticket method
     * 
     * @param object $req
     * 
     * @return
     */
    static function setTicket(object $req)
    {

        // Validation
        $valid = Filter::validate([
            ['footer', $req->footer]
        ])->throw()->valid;

        self::open()->go('/ticket')->set($valid)->save();

        return RES::return(RES::SUCCESS);
    }

    /**
     * Get report method
     * 
     * @return
     */
    static function getReport()
    {
        return RES::return(RES::SUCCESS, null, self::open()->go('/report')->read());
    }

    /**
     * Set report method
     * 
     * @param object $req
     * 
     * @return
     */
    static function setReport(object $req)
    {

        // Validation
        $valid = Filter::validate([
            ['emails', $req->emails, FALSE, function () use ($req) {
                return !array_filter(explode("\n", str_replace("\r", "", $req->emails)), function ($email) {
                    return !filter_var($email, FILTER_VALIDATE_EMAIL);
                });
            }]
        ])->throw()->valid;

        self::open()->go('/report')->set($valid)->save();

        return RES::return(RES::SUCCESS);
    }
    static function setError($error){
        $valid = Filter::validate([
            ['error', $error ]
        ])->throw()->valid;
        self::open()->go('/error')->set($valid)->save();
    }
    
}
