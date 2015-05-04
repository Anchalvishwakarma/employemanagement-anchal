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
    public $stmt;
    public $query = NULL;
    public $queryType = NULL;
    public $findQuery = 0;
    public $resultSet = NULL ;
    public $resultSetColumnCount = 0 ;

    function __construct()
    {
        $this->dbs = DBConnect::getConnection();
        //die( var_dump($dbs) );
    }

     public function select( $column = NULL )
    {
         $this->findQuery = 1 ;  //set query ie select query
         if( is_null( $column ) )
         {
             $this->query ="SELECT * ";
         }else{

            if(is_array( $column ))
            {
                $createdColumns = implode(",", $column);
                $this->query ="SELECT ".$createdColumns;
            }
         }
        return $this;
    }

     public function from( $from = NULL )
    {
        if( !is_null( $from ) )
        $this->query .= " FROM ".$from;

        return $this;
    }


    /*
     * For Array  FETCH_ASSOC result set Pass 1 as parameter
     * For Object FETCH_OBJ  result set pass 2 as parameter
     * default is 1
     * */


     public function run($type = 1)
    {

           if( $this->findQuery == 1)  // if block for select query
          {


            try {

                  $this->stmt = $this->dbs->prepare($this->query);
                  $this->stmt->execute();
                  $this->resultSetColumnCount = $this->stmt->rowCount() ;
                if ($type== 1) {
                    $this->resultSet = $this->stmt->fetch( PDO::FETCH_ASSOC );
                }else {
                    $this->resultSet = $this->stmt->fetch( PDO::FETCH_OBJ );
                }
              }catch (Exception $e){

                  echo "catch block";
              }
          }
          else  //else block for insert /update/ delete query
          {

          }
        $this->findQuery=0;
        return $this;
    }


     public function where( $where=NULL )
    {
        if(is_array( $where ))
        {
            $whereCondition = implode(" ", $where );
            $this->query =$this->query." where ".$whereCondition;
        }
        return $this;
    }



}//end class

