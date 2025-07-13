<?php
include 'core/model.php';
class users extends model {

    public function insert($name,$password,$email,$role="user") {
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(openssl_random_pseudo_bytes(32));
        $query = "INSERT INTO users (name, email, password, role, token) VALUES (?,?,?,?,?)";
        $result = $this->connection->prepare($query);
        $result->bind_param("sssss",$name,$email, $pass_hash, $role, $token);
        $result->execute();

        return 'ok';
    }
    
    public function find_user($name,$password)
    {
        $query = "SELECT * FROM users WHERE name = ?" ;
        $result = $this->connection->prepare($query);
        $result->bind_param("s",$name);
        $result->execute();
        $user = $result->get_result()->fetch_assoc();

        if (password_verify($password, $user['password'])) 
        {
            echo "yes";
            return ['response'=>200, 'message'=>$user];
        }
        return ['response'=>403, 'message'=>'Error! Invalid username or password.'];
    }

    public function showAllUsers()
    {
        $query = "SELECT id,name,role,email FROM users" ;
        $result = $this->connection->prepare($query);
        $result->execute();
        
        return $result->get_result();
    }

    public function userPromoteToAdmin($userId)
    {
        $query = "UPDATE users SET  role ='admin' WHERE id = '".$userId."'";
        $this->connection->query($query);
    }

    public function adminToUser($userId)
    {
        $query = "UPDATE users SET  role ='user' WHERE id = '".$userId."'";
        $this->connection->query($query);
    }
}
?>