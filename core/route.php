<?php

//url هارو از چت جی پی تی بپرس 
// هر دو فایل route که به فنا نریم
class route
{
    public function __construct()
    {
        $url = $_GET['path'];
        $urls_arr = [
            // مسیر صفحه اصلی (نمایش تقویم عمومی)
            //unCompleted
            // [
            //     'url' => '//',
            //     'controller' => 'HomeController',
            //     'action' => 'index',
            //     'method' => 'GET'
            // ],
            [
                'url' => '/^home$/',
                'controller' => 'HomeController',
                'action' => 'index',
                'method' => 'GET'
            ],
             // مسیرهای ثبت نام
            [
                'url' => '/^register$/',
                'controller' => 'AuthController',
                'action' => 'register',
                'method' => 'POST'
            ],
            [
                'url' => '/^register$/',
                'controller' => 'AuthController',
                'action' => 'showRegisterForm',
                'method' => 'GET'
            ],
            // مسیرهای ورود
            [
                'url' => '/^login$/',
                'controller' => 'AuthController',
                'action' => 'showLoginForm',
                'method' => 'GET'
            ],
            [
                'url' => '/^login$/',
                'controller' => 'AuthController',
                'action' => 'login',
                'method' => 'POST'
            ],
            // مسیر خروج
            [
                'url' => '/^logout$/',
                'controller' => 'AuthController',
                'action' => 'logout',
                'method' => 'POST'
            ],
            // داشبورد ادمین
            [
                'url' => '#^admin/dashboard$#',
                'controller' => 'AdminController',
                'action' => 'dashboard',
                'method' => 'GET'
            ],
            //مدیریت ترم و درس های کلاس 
            [
                'url' => '#^admin/manageClasses$#',
                'controller' => 'AdminController',
                'action' => 'showManageCorsesTermsPage',
                'method' => 'GET'
            ],
            // ثبت ترم جدید
            [
                'url' => '#^admin/newTerm$#',
                'controller' => 'AdminController',
                'action' => 'addNewTerm',
                'method' => 'POST'
            ],

            // ثبت واحد درسی جدید
            [
                'url' => '#^admin/newCourse$#',
                'controller' => 'AdminController',
                'action' => 'addNewCourse',
                'method' => 'POST'
            ],
            //نمایش فرم ویرایش واحد درسی
            [
                'url' => '#^admin/showEditCourse$#',
                'controller' => 'AdminController',
                'action' => 'showEditCourse',
                'method' => 'GET'
            ],
            //ثبت ویرایش  واحد درسی
            [
                'url' => '#^admin/editCourse$#',
                'controller' => 'AdminController',
                'action' => 'editCourse',
                'method' => 'POST'
            ],

            //ثبت کلاس جدید
            [
                'url' => '#^admin/newClass$#',
                'controller' => 'AdminController',
                'action' => 'newClass',
                'method' => 'POST'
            ],

            //حذف کلاس 
            [
                'url' => '#^admin/deleteClass$#',
                'controller' => 'AdminController',
                'action' => 'deleteClass',
                'method' => 'GET'
            ],

            //نمایش فرم ویرایش کلاس درسی
            [
                'url' => '#^admin/editClass$#',
                'controller' => 'AdminController',
                'action' => 'editClass',
                'method' => 'GET'
            ],

            //لیست کاربر ها 
            [
                'url' => '#^admin/userList$#',
                'controller' => 'AdminController',
                'action' => 'showUsersList',
                'method' => 'GET'
            ],
            // مدیریت درخواست‌ها توسط ادمین
            //uncompleted
            [
                'url' => '#^admin/requests$#',
                'controller' => 'AdminController',
                'action' => 'manageRequests',
                'method' => 'GET'
            ],
            //ارتقا یوزر به ادمین
            [
                'url' => '#^admin/userPromote$#',
                'controller' => 'AdminController',
                'action' => 'userPromoteToAdmin',
                'method' => 'GET'
            ],
            // ادمین به یوزر معمولی
            [
                'url' => '#^admin/adminToUser$#',
                'controller' => 'AdminController',
                'action' => 'adminToUser',
                'method' => 'GET'
            ],
            //تایید ریکوئست
            [
                'url' => '#^admin/requests/approve$#',
                'controller' => 'AdminController',
                'action' => 'approveRequest', // این متد ID را به عنوان ورودی می‌گیرد
                'method' => 'POST'
            ],
            //رد ریکوئست
            [
                'url' => '#^admin/requests/reject$#',
                'controller' => 'AdminController',
                'action' => 'rejectRequest', 
                'method' => 'POST'
            ],
            // داشبورد کاربر
            [
                'url' => '#^user/dashboard$#',
                'controller' => 'UserController',
                'action' => 'dashboard',
                'method' => 'GET'
            ],
            // فرم ثبت درخواست جدید توسط کاربر
            [
                'url' => '#^user/request/new$#',
                'controller' => 'UserController',
                'action' => 'showRequestForm',
                'method' => 'GET'
            ],
            // ارسال فرم درخواست جدید
            [
                'url' => '#^user/request/new$#',
                'controller' => 'UserController',
                'action' => 'submitRequest',
                'method' => 'POST'
            ],
        ];
        $routing_fail = true;
        foreach ($urls_arr as $url_arr) {
            if (
                preg_match($url_arr['url'], $url, $matches) &&
                $url_arr['method'] == $_SERVER['REQUEST_METHOD']
            ) {
               $routing_fail = false;

                unset($matches[0]);
                include 'app/controllers/' . $url_arr['controller'] . '.php';
                $new_obj = new $url_arr['controller'];

                call_user_func_array([$new_obj, $url_arr['action']], array_values($matches));
            }
        }
        if ($routing_fail) {
            echo "(404) Page not found";
        }
    }
}
?>