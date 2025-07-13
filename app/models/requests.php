<?php

require_once 'core/model.php';
class requests extends model {
    public function insert($user_id,$course_id,$term_id,$startTime, $endTime, $dayOfWeek, $explain="") {
        $status = "waiting";
        $query = "INSERT INTO requests (user_id,course_id,term_id,start_time,end_time,day_of_week,explains,`status`) VALUES (?,?,?,?,?,?,?,?)";
        $result = $this->connection->prepare($query);
        $result->bind_param("iiisssss",$user_id,$course_id,$term_id, $startTime, $endTime, $dayOfWeek, $explain,$status);
        $result->execute();

        return 'ok';
    }


    public function showWaitingRequests()
    {
        $query = 
            "SELECT 
                requests.request_id,
                requests.course_id,
                requests.term_id,
                requests.user_id,
                requests.explains,
                requests.status,
                requests.day_of_week,
                requests.start_time,
                requests.end_time,   
                terms.name AS term_name,
                courses.name AS course_name 
            FROM requests
            INNER JOIN courses ON requests.course_id = courses.id
            INNER JOIN terms ON requests.term_id = terms.id
            WHERE requests.status = 'waiting';
";


        $result = $this->connection->prepare($query);
        $result->execute();
        
        return $result->get_result();
    }


    public function approveRequest($request_id)
    {
        $query = "UPDATE `requests` SET status ='approved' WHERE request_id = ". $request_id;
        $this->connection->query($query);

        return true;
    }

    public function rejectRequest($request_id)
    {
        $query = "UPDATE `requests` SET status ='rejected' WHERE request_id = ". $request_id;
        $this->connection->query($query);

        return true;
    }
}