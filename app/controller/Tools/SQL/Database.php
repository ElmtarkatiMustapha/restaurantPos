<?php

namespace TOOL\SQL;

use PDO;

class Database
{

    /**
     * Server
     * 
     * @var ?PDO
     */
    private static ?PDO $server = NULL;

    /**
     * Conn
     * 
     * @var ?PDO
     */
    private static ?PDO $conn = NULL;


    /**
     * Server method
     * 
     * @return PDO
     */
    static function server()
    {

        // Check has setup
        if (self::$server) return self::$server;

        # Create connection
        self::$server = new PDO(
            "mysql:host=" . config('DATABASE_HOST'),
            config('DATABASE_USER'),
            config('DATABASE_PASS')
        );

        # Set the PDO attributes
        self::$server->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$server->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return self::$server;
    }

    /**
     * Conn method
     * 
     * @param bool $render
     * 
     * @return PDO
     */
    static function conn(bool $render = false)
    {

        // Check has setup
        if (self::$conn && !$render) return self::$conn;

        # Create connection
        self::$conn = new PDO(
            "mysql:host=" . config('DATABASE_HOST') . ";dbname=" . config('DATABASE_NAME'),
            config('DATABASE_USER'),
            config('DATABASE_PASS')
        );

        # Set the PDO attributes
        self::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        self::$conn->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);

        return self::$conn;
    }

    /**
     * Export method
     * 
     * @param string $saveDir
     * 
     * @param string $filename
     */
    static function export(string $saveDir, string $filename)
    {
        // Check is dir
        if (!is_dir($saveDir))
            throw new \Error("Not Found directory {$saveDir}");

        // Delete old
        unlink("{$saveDir}/{$filename}.sql.gz");

        $db = new PDO("mysql:host=" . config('DATABASE_HOST') . ";dbname=" . config('DATABASE_NAME') . "; charset=utf8", config('DATABASE_USER'), config('DATABASE_PASS'));
        $db->setAttribute(PDO::ATTR_ORACLE_NULLS, PDO::NULL_NATURAL);

        $do_compress = true;

        if ($do_compress) {
            $save_string = $saveDir . '/' . $filename . '.sql.gz';
            $zp = gzopen($save_string, "a9");
        } else {
            $save_string = $saveDir . '/' . $filename . '.sql';
            $handle = fopen($save_string, 'a+');
        }

        //array of all database field types which just take numbers
        $numtypes = array('tinyint', 'smallint', 'mediumint', 'int', 'bigint', 'float', 'double', 'decimal', 'real');

        $return = "";

        //get all tables
        $pstm1 = $db->query('SHOW TABLES');
        while ($row = $pstm1->fetch(PDO::FETCH_NUM)) {
            $tables[] = $row[0];
        }

        //cycle through the table(s)
        foreach ($tables as $table) {
            $result = $db->query("SELECT * FROM $table");
            $num_fields = $result->columnCount();
            $num_rows = $result->rowCount();

            //table structure
            $pstm2 = $db->query("SHOW CREATE TABLE $table");
            $row2 = $pstm2->fetch(PDO::FETCH_NUM);
            $ifnotexists = str_replace('CREATE TABLE', 'CREATE TABLE IF NOT EXISTS', $row2[1]);
            $return .= "\n\n" . $ifnotexists . ";\n\n";

            if ($do_compress) {
                gzwrite($zp, $return);
            } else {
                fwrite($handle, $return);
            }
            $return = "";

            //insert values
            if ($num_rows) {
                $return = 'INSERT INTO `' . $table . '` (';
                $pstm3 = $db->query("SHOW COLUMNS FROM $table");
                $count = 0;
                $type = array();

                while ($rows = $pstm3->fetch(PDO::FETCH_NUM)) {
                    if (stripos($rows[1], '(')) {
                        $type[$table][] = stristr($rows[1], '(', true);
                    } else {
                        $type[$table][] = $rows[1];
                    }

                    $return .= "`" . $rows[0] . "`";
                    $count++;
                    if ($count < ($pstm3->rowCount())) {
                        $return .= ", ";
                    }
                }

                $return .= ")" . ' VALUES';

                if ($do_compress) {
                    gzwrite($zp, $return);
                } else {
                    fwrite($handle, $return);
                }
                $return = "";
            }
            $counter = 0;
            while ($row = $result->fetch(PDO::FETCH_NUM)) {
                $return = "\n\t(";

                for ($j = 0; $j < $num_fields; $j++) {

                    if (isset($row[$j])) {

                        //if number, take away "". else leave as string
                        if ((in_array($type[$table][$j], $numtypes)) && (!empty($row[$j]))) {
                            $return .= $row[$j];
                        } else {
                            $return .= $db->quote($row[$j]);
                        }
                    } else {
                        $return .= 'NULL';
                    }
                    if ($j < ($num_fields - 1)) {
                        $return .= ',';
                    }
                }
                $counter++;
                if ($counter < ($result->rowCount())) {
                    $return .= "),";
                } else {
                    $return .= ");";
                }
                if ($do_compress) {
                    gzwrite($zp, $return);
                } else {
                    fwrite($handle, $return);
                }
                $return = "";
            }
            $return = "\n\n-- ------------------------------------------------ \n\n";
            if ($do_compress) {
                gzwrite($zp, $return);
            } else {
                fwrite($handle, $return);
            }
            $return = "";
        }

        $error1 = $pstm2->errorInfo();
        $error2 = $pstm3->errorInfo();
        $error3 = $result->errorInfo();
        echo $error1[2];
        echo $error2[2];
        echo $error3[2];

        if ($do_compress) {
            gzclose($zp);
        } else {
            fclose($handle);
        }
    }


    /**
     * Database __destruct
     * 
     */
    function __destruct()
    {

        self::$server = null;
        self::$conn = null;
    }
}
