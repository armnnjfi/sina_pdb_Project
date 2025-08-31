<?php
class AuthController extends controller
{
    public function showRegisterForm()
    {
        if ($this->check_auth() && $this->is_admin()) {
            header('location: ' . $this->redirect_url_admin);
            exit();
        } else if ($this->check_auth() && !$this->is_admin()) {
            header('location: ' . $this->redirect_url_user);
            exit();
        } else {
            $this->view('register');
        }
    }

    public function showLoginForm()
    {
        if ($this->check_auth()) {
            if ($this->is_admin()) {
                header('location: ' . $this->redirect_url_admin);
                exit();
            } else {
                header('location: ' . $this->redirect_url_user);
                exit();
            }
        } else {
            $csrf = new SecurityService();
            $csrf->setCSRFToken();
            $token = $csrf->getCSRFToken();

            $this->view('login', ['csrf_token' => $token]);
        }
    }

    public function logout()
    {
        session_destroy();
        header('location: http://localhost/sina%20project/mvc/project/login');
        exit();
    }

    public function register()
    {
        $name = $_POST['Name'];
        $password = $_POST['password'];
        $email = $_POST['email'];
        $csrf = $_POST['csrf-token'];

        $new_csrf = new SecurityService();
        if (!$new_csrf->validate_token($csrf)) {
            return var_dump('Error : CSRF Token invalid.');
        }

        include 'app/models/users.php';
        $new_user = new users();
        echo $new_user->insert($name, $password, $email);

        header('location: http://localhost/sina%20project/mvc/project/login');
    }
    public function login()
    {
        $csrf = new SecurityService();
        $csrf_token = $_POST['csrf_token'] ?? '';

        if (!$csrf->validate_token($csrf_token)) {
            die("Error: CSRF token invalid.");
        }

        $username = $_POST['Name'] ?? '';
        $password = $_POST['password'] ?? '';

        include 'app/models/users.php';
        $user = new users();
        $res = $user->find_user($username, $password);

        if ($res['response'] == 200) {
            $_SESSION['user_id'] = $res['message']['id'];
            $_SESSION['Name'] = $res['message']['name'];
            $_SESSION['role'] = $res['message']['role'];
            $_SESSION['is_auth'] = 1;

            if ($this->is_admin()) {
                header('location: ' . $this->redirect_url_admin);
                exit();
            } else {
                header('location: ' . $this->redirect_url_user);
                exit();
            }
        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }
}
