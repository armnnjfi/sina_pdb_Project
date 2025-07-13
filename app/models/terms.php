<?php
include 'core/model.php';
class terms extends model {
    public function insert($name,$start_date,$end_date) {
        $query = "INSERT INTO terms (name, start_date, end_date) VALUES (?,?,?)";
        $result = $this->connection->prepare($query);
        $result->bind_param("sss",$name,$start_date, $end_date);
        $result->execute();
    }

    public function showLast5Terms()
    {
        $query = "SELECT id,name,start_date,end_date FROM terms ORDER BY 'id' DESC LIMIT 5" ;
        $result = $this->connection->prepare($query);
        $result->execute();
        
        return $result->get_result();
    }
}