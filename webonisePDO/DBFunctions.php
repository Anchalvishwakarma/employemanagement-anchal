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





    public  function orderby($column,$type='DESC'){


        if(! is_null($column) ){
            $this->query .= " ORDER BY ".$column." ".$type;
        }

        return $this;
    }




    public function limit( $value=1 ){

        $this->query.= " LIMIT ".$value;
        //die($this->query);
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
                    $this->resultSet = $this->stmt->fetchAll( PDO::FETCH_ASSOC );
                }else {
                    $this->resultSet = $this->stmt->fetchAll( PDO::FETCH_OBJ );
                }
                }catch (Exception $e){

                   echo "catch block";
                }
          }
          else  //else block for insert /update/ delete query
          {
              try {

                  $this->stmt = $this->dbs->prepare($this->query);
                  $this->stmt->execute();
                  return $this->stmt->rowCount();
              }catch(Exception $e)
              {
                  echo "catch block".$e->getMessage();
              }
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
         //die($this->query);
        return $this;
    }




     public function insert($tbl_name,$data)
    {
          $this->query="INSERT INTO $tbl_name ( ";
          $value='VALUES ( ';

        if( is_array($data) )
        {
            foreach($data as $key => $val )
            {
                if (next($data) === false) { //check last loop

                    $this->query.= "".$key .")";
                    $value.="'".$val."')";
                }else{

                    $this->query.= "".$key .",";
                    $value.="'".$val."',";
                }

            }
            $this->query.=$value;
            return $this->run();
        }

    }

     public function update( $table , $data)
    {
        $this->query.="UPDATE $table SET ";

        if( is_array($data) )
        {
            foreach($data as $key => $val )
            {
                if (next($data) === false) { //check last loop

                    $this->query.=$key."='".$val."'";

                }else{

                    $this->query.=$key."='".$val."',";
                }

            }

        }
        return $this;

    }



    public function delete()
    {
        $this->query.="DELETE ";
        return $this;
    }


      public function getLastInsertedId()
     {
         return $this->dbs->lastInsertId();
     }


    public function passJoinQuery( $query )
    {
       if(! is_null($query) )
       {
           $this->stmt = $this->dbs->prepare($query );
           $this->stmt->execute();
           $this->resultSet = $this->stmt->fetchAll( PDO::FETCH_NUM );

       }

    }

    public function getEmployeeName( $id )
    {

        if( $id != 0 )
        {
            $where = array("id='" .$id. "'");
            $this->select(array('name'))->from('employees')->where($where)->run();
            $data = $this->resultSet;
            return $data[0]['name'];
        }

    }


    public function getDeptName( $id )
    {

        if( $id != 0 )
        {
            $where = array("id='" .$id. "'");
            $this->select(array('name'))->from('departments')->where($where)->run();
            $data = $this->resultSet;
            return $data[0]['name'];
        }

    }

    public function getJobTitleName( $id )
    {

        if( $id != 0 )
        {
            $where = array("id='" .$id. "'");
            $this->select(array('title'))->from('job_titles')->where($where)->run();
            $data = $this->resultSet;
            return $data[0]['title'];
        }

    }

}//end class

