<?php
class AdminController extends controller
{
    public function dashboard()
    {
        if ($this->is_admin()) {
            $this->view("AdminDashboard");
        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }

    public function showUsersList()
    {
        if ($this->check_auth() && $this->is_admin()) {
            include 'app/models/users.php';
            $showAllUsers = new users();
            $showUser = $showAllUsers->showAllUsers();
            $this->view('UsersList', ['user' => $showUser]);
        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }


    public function userPromoteToAdmin()
    {
        include 'app/models/users.php';
        $new_admin = new users();
        $new_admin->userPromoteToAdmin($_GET['userId']);
        header("location: http://localhost/sina%20project/mvc/project/admin/userList");
    }

    public function adminToUser()
    {
        include 'app/models/users.php';
        $adminToUser = new users();
        $adminToUser->adminToUser($_GET['userId']);
        header("location: http://localhost/sina%20project/mvc/project/admin/userList");
    }

    public function showManageCorsesTermsPage()
    {
        if ($this->check_auth() && $this->is_admin()) {

            include 'app/models/terms.php';
            include 'app/models/courses.php';
            include 'app/models/classes.php';


            $terms = new terms();
            $courses = new courses();
            $classes = new classes();

            $showTerms = $terms->showLast5Terms();
            $showCourses = $courses->showCourses();
            $showClasses = $classes->showClassesWithDetails();

            $csrf_obj = new SecurityService();
            $csrf = $csrf_obj->getCSRFToken();

            $this->view('manageCoursesTermsPage', ['terms' => $showTerms, 'courses' => $showCourses, 'classes' => $showClasses,'csrf_token'=>$csrf]);
        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }

    public function addNewTerm()
    {

        $csrf = $_POST['csrf_token'];
        $new_csrf = new SecurityService();

        if (!$new_csrf->validate_token($csrf)) {
            return var_dump('Error : CSRF Token invalid.');
        }
        $name = $_POST['name'];
        $start_date = $_POST['term_start_date'];
        $end_date = $_POST['term_end_date'];

        include 'app/models/terms.php';
        $new_term = new terms();
        $new_term->insert($name, $start_date, $end_date);

        header('location: http://localhost/sina%20project/mvc/project/admin/manageClasses');
    }

    public function addNewCourse()
    {

        $csrf = $_POST['csrf_token'];
        $new_csrf = new SecurityService();

        if (!$new_csrf->validate_token($csrf)) {
            return var_dump('Error : CSRF Token invalid.');
        }

        $name = $_POST['name'];
        $unit = $_POST['unit'];

        include 'app/models/courses.php';
        $new_course = new courses();
        $new_course->insert($name, $unit);

        header('location: http://localhost/sina%20project/mvc/project/admin/manageClasses');
    }

    public function deleteCourse()
    {
        $courseId = $_GET['courseId'];
        include 'app/models/courses.php';
        $delete_course = new courses();
        $delete_course->delete($courseId);

        header('location: http://localhost/sina%20project/mvc/project/admin/manageClasses');
    }

    public function showEditCourse()
    {
        if ($this->check_auth() && $this->is_admin()) {
            $csrf_obj = new SecurityService();
            $csrf = $csrf_obj->getCSRFToken();
            $this->view('editCoursesForm',['csrf_token'=> $csrf]);
        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }

    public function editCourse()
    {

        $csrf = $_POST['csrf_token'];
        $new_csrf = new SecurityService();

        if (!$new_csrf->validate_token($csrf)) {
            return var_dump('Error : CSRF Token invalid.');
        }

        $id = $_POST['id_edit'];
        $name = $_POST['name_edit'];
        $unit = $_POST['unit_edit'];

        include 'app/models/courses.php';
        $edit_course = new courses();
        echo $edit_course->edit($id, $name, $unit);

        header('location: http://localhost/sina%20project/mvc/project/admin/manageClasses');
    }

    public function newClass()
    {
        $csrf = $_POST['csrf_token'];
        $new_csrf = new SecurityService();

        if (!$new_csrf->validate_token($csrf)) {
            return var_dump('Error : CSRF Token invalid.');
        }

        $course_id = $_POST['course_id'];
        $term_id = $_POST['term_id'];
        $start_time = $_POST['start_time'];
        $end_time = $_POST['end_time'];

        $day_of_week = $_POST['weekDays'];
        $day_of_week = implode(', ', $day_of_week);

        include 'app/models/classes.php';
        $new_class = new classes();
        $new_class->insertNewClass($course_id, $term_id, $start_time, $end_time, $day_of_week);

        header('location: http://localhost/sina%20project/mvc/project/admin/manageClasses');
    }
    public function deleteClass()
    {
        $classId = $_GET['classId'];
        include 'app/models/classes.php';
        $delete_class = new classes();
        $delete_class->delete($classId);

        header('location: http://localhost/sina%20project/mvc/project/admin/manageClasses');
    }

    public function editClass()
    {
        if ($this->check_auth() && $this->is_admin()) {
            $this->view('editClassesForm');
        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }

    public function manageRequests()
    {
        if ($this->check_auth() && $this->is_admin()) {
            include 'app/models/requests.php';
            $requests_obj = new requests();

            $showRequests = $requests_obj->showWaitingRequests();
            $this->view('Requests', ['requests' => $showRequests]);
        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }

    public function approveRequest()
    {
        if ($this->check_auth() && $this->is_admin()) {
            // $csrf = $_SESSION['csrf-token'];
            // $new_csrf = new SecurityService();

            // if (!$new_csrf->validate_token($csrf)) {
            //     return var_dump('Error : CSRF Token invalid.');
            // }

            include 'app/models/requests.php';
            $requests_obj = new requests();
            $approveReq = $requests_obj->approveRequest($_POST['request_id']);

            if ($approveReq) {

                $course_id = $_POST['course_id'];
                $term_id = $_POST['term_id'];
                $start_time = $_POST['start_time'];
                $end_time = $_POST['end_time'];
                $day_of_week = $_POST['day_of_week'];

                include 'app/models/classes.php';
                $new_class = new classes();
                $new_class->insertNewClass($course_id, $term_id, $start_time, $end_time, $day_of_week);
                header('location: http://localhost/sina%20project/mvc/project/admin/requests');
            }else {
                echo "کلاس اضافه نشد!";
            }


        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }

    public function rejectRequest()
    {
        if ($this->check_auth() && $this->is_admin()) {
            include 'app/models/requests.php';
            $requests_obj = new requests();
            $requests_obj->rejectRequest($_POST['request_id']);
            header('location: http://localhost/sina%20project/mvc/project/login');  
        } else {
            header('location: http://localhost/sina%20project/mvc/project/admin/requests');
            exit();
        }
    }
}
