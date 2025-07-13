<?php 

class model{
    public $connection;
    public function __construct(){
        $this->connect();
    }
    public function connect(){
        try{
            $this->connection = new mysqli("localhost","root","","universitycalender");
        } catch(Exception $e){
            var_dump($e->getMessage());
        }
    }
}
?>