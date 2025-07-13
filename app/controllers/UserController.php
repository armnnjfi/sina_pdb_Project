<?php
class UserController extends controller
{
    public function dashboard()
    {
        if ($this->check_auth()) {
            $this->view("UserDashboard");
        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }

    public function showRequestForm()
    {
        if ($this->check_auth()) {

            include 'app/models/terms.php';
            include 'app/models/courses.php';
            include 'app/models/classes.php';

            $terms = new terms();
            $courses = new courses();
            $classes = new classes();

            $showTerms = $terms->showLast5Terms();
            $showCourses = $courses->showCourses();
            $showClasses = $classes->showClassesWithDetails();

            $this->view('UserRequestForm', ['terms' => $showTerms, 'courses' => $showCourses, 'classes' => $showClasses]);
        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }

    public function submitRequest()
    {
        if ($this->check_auth()) {
            if (isset($_POST['weekDays']) && isset($_POST['start_time']) && isset($_POST['end_time'])) {
                

                $csrf = $_POST ['csrf-token'];
                $new_csrf = new SecurityService();

                if (!$new_csrf->validate_token($csrf)) {
                    return var_dump('Error : CSRF Token invalid.');
                }
                
                $days_of_week = implode(', ', $_POST['weekDays']);
                $start_time = $_POST['start_time'];
                $end_time = $_POST['end_time'];


                include 'app/models/classes.php';

                $classes = new classes();

                $redirect_url = 'http://localhost/sina%20project/mvc/project/user/dashboard';

                if ($classes->isSlotCompletelyAvailable($days_of_week, $start_time, $end_time)) {
                    
                    $message = 'درخواست شما برای ادمین فرستاده شد';

                    include 'app/models/requests.php';
                    $request_obj = new requests();
                    $request_obj->insert($_SESSION['user_id'], $_POST['course_id'], $_POST['term_id'], $start_time, $end_time, $days_of_week, $_POST['explain']);
                } else {
                    $message = 'در تایم مشخص شده کلاس دیگری وجود دارد';
                }

                echo
                "<script>
                        alert(" . json_encode($message) . ");
                        window.location.href = '" . $redirect_url . "';
                    </script>";

                exit();
            } else {
                echo "<h1>تمام فیلد ها پر نشده</h1>";
                echo $_POST['term_id'];
                echo $_POST['course_id'];
            }
        } else {
            header('location: http://localhost/sina%20project/mvc/project/login');
            exit();
        }
    }
}
