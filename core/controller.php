<?php
// include "../app/policies/userPolicy.php";
class controller
{
    // use userPolicy;

    public $redirect_url_user = 'http://localhost/sina%20project/mvc/project/user/dashboard';
    public $redirect_url_admin = 'http://localhost/sina%20project/mvc/project/admin/dashboard';
    public function whichFolder($file_name)
    {

        switch ($file_name) {
            case 'login':
                return "auth";
            case 'register':
                return "auth";
            case 'AdminDashboard':
                return "admin";
            case 'UsersList':
                return "admin";
            case "manageCoursesTermsPage":
                return "admin";
            case "editCoursesForm":
                return "admin";
            case "editClassesForm":
                return "admin";
            case "Requests":
                return "admin";
            case 'UserDashboard':
                return "user";
            case 'UserRequestForm':
                return "user";
            case "home":
                return "public";
        }
    }
    public function view($file_name, $data = '')
    {
        $folderName = $this->whichFolder($file_name);

        $this->nav('header');
        $new_csrf = new SecurityService();

        if ($folderName == 'admin') {
            $this->nav('sidebar');
        }

        include "app/views/" . $folderName . "/" . $file_name . '.php';

    }

    public function nav($file_name)
    {
        include "app/views/Layouts/" . $file_name . '.php';
    }


    public function check_auth()
    {
        if (isset($_SESSION['is_auth']) && $_SESSION['is_auth'] == 1) {
            return true;
        } else {
            return false;
        }
    }

    public function is_admin()
    {
        if (isset($_SESSION['is_auth']) && $_SESSION['is_auth'] == 1 && $_SESSION['role'] == 'admin') {
            return true;
        }
        return false;
    }
}
