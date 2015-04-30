<?php
/**
 * Created by PhpStorm.
 * User: webonise
 * Date: 30/4/15
 * Time: 2:45 PM
 */
include('DBConnect.php');

class DBFunctions extends DBConnect{

    public $dbs;
    function __construct()
    {
       $dbs = DBConnect::getConnection();
    }
}