<?php
/**
 * Created by PhpStorm.
 * User: anchal
 * Date: 30/4/15
 * Time: 12:27 PM
 */
include('DBConfig.php');

class DBConnect extends DBconfig{

    protected static $db;


         private function __construct()
        {

            $obj     = new DBconfig();
            $dbtype  = $obj->DBData['databaseType'];
            $host    = $obj->DBData['host'];
            $dbuser  = $obj->DBData['dbuser'];
            $dbpass  = $obj->DBData['dbpass'];
            $dbname  = $obj->DBData['dbname'];

            try {

                   self::$db = new PDO( "$dbtype:host=$host;dbname=$dbname", $dbuser, $dbpass );
                   self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
                }
                catch (PDOException $e) {
                echo "DataBase Connection Error";
          }

       }


    public static function getConnection() {


        if (!self::$db) {

            new DBConnect();
        }


        return self::$db;
    }

}