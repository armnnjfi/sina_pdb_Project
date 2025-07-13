<?php

class HomeController extends controller
{
    public function index()
    {
        include 'app/models/classes.php';

        $classes_obj = new classes();

        // 1. دریافت اطلاعات کلاس‌ها از دیتابیس
        $classes = $classes_obj->showClassesWithDetails();

        // 2. ساخت یک آرایه خالی برای نگهداری برنامه هفتگی
        $schedule = [];

        // 3. تعریف بازه‌های زمانی مطابق با ستون‌های جدول
        $timeSlotsMap = [
            '08:00:00' => '8-10',
            '10:00:00' => '10-12',
            '12:00:00' => '12-14',
            '14:00:00' => '14-16',
            '16:00:00' => '16-18',
            '18:00:00' => '18-20',
        ];

        // 4. پردازش هر کلاس و قرار دادن آن در جای درست در آرایه schedule
        while ($class = $classes->fetch_assoc()) {

            $courseName = $class['course_name'];
            $startTime = $class['start_time'];

            // ممکن است یک کلاس در چند روز هفته برگزار شود، آن‌ها را جدا می‌کنیم
            $days = explode(',', $class['day_of_week']);

            // پیدا کردن کلید بازه زمانی (مثلا '8-10')
            $timeSlotKey = $timeSlotsMap[$startTime] ?? null;

            if ($timeSlotKey) {
                foreach ($days as $day) {
                    $day = trim($day); // حذف فاصله‌های اضافی
                    // ذخیره نام درس در روز و ساعت مشخص
                    $schedule[$day][$timeSlotKey] = $courseName;
                }
            }
        }

        // 5. ارسال آرایه پردازش شده به View
        $this->view('home', ['schedule' => $schedule]);
    }
}
