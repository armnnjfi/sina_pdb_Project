<?php
require_once 'core/model.php';
class courses extends model {
public function insert($name,$unit) {
        $query = "INSERT INTO courses (name, unit) VALUES (?,?)";
        $result = $this->connection->prepare($query);
        $result->bind_param("ss",$name,$unit);
        $result->execute();
    }

    public function showCourses()
    {
        $query = "SELECT id,name,unit FROM courses ORDER BY 'id' DESC" ;
        $result = $this->connection->prepare($query);
        $result->execute();
        
        return $result->get_result();
    } 
    
    public function delete($courseId)
    {
        $query = "DELETE FROM courses WHERE id = ?"; ;
        $result = $this->connection->prepare($query);
        $result->bind_param("s",$courseId);
        $result->execute();
    } 
    
    public function edit($courseId,$courseName,$courseUnit)
    {
        $query = "UPDATE courses SET  name ='".$courseName."' , unit='".$courseUnit."' WHERE id = '".$courseId."'";
        $this->connection->query($query);
    }
}