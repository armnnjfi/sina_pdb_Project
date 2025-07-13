<?php
require_once 'core/model.php';
class classes extends model
{
    public function insertNewClass($course_id, $term_id, $start_time, $end_time, $day_of_week)
    {
        $query = "INSERT INTO classes (`course_id`, `term_id`, `start_time`, `end_time`, `day_of_week`) VALUES (?,?,?,?,?)";
        $result = $this->connection->prepare($query);
        $result->bind_param("iisss", $course_id, $term_id, $start_time, $end_time, $day_of_week);
        $result->execute();
    }

    public function delete($classId)
    {
        $query = "DELETE FROM classes WHERE id = ?";
        $result = $this->connection->prepare($query);
        $result->bind_param("i", $classId);
        $result->execute();
    }

    // public function edit($classId, $className, $classUnit)
    // {
    //     $query = "UPDATE classes SET name = '".$className."', unit = '".$classUnit."' WHERE id = '".$classId."'";
    //     $this->connection->query($query);
    // }

    public function showClassesWithDetails()
    {
        $query =
            "SELECT
                classes.id AS class_id,
                classes.start_time,
                classes.end_time,
                classes.day_of_week,
                courses.id AS course_id,
                courses.name AS course_name,
                terms.id AS term_id,
                terms.name AS term_name
            FROM
                classes
            INNER JOIN
                courses ON classes.course_id = courses.id
            INNER JOIN
                terms ON classes.term_id = terms.id;
                ";

        $result = $this->connection->prepare($query);
        $result->execute();

        return $result->get_result();
    }


    function isSlotCompletelyAvailable(string $days_of_week, string $startTime, string $endTime): bool
    {
        // ۱. تبدیل رشته روزها به آرایه
        $days = explode(',', $days_of_week);
        
        // ۲. ساخت بخش داینامیک کوئری برای روزهای هفته
        $dayClauses = array_fill(0, count($days), 'day_of_week LIKE ?');
        $daySqlPart = '(' . implode(' OR ', $dayClauses) . ')';

        // ۳. ساخت کوئری کامل
        $sql = "SELECT 1 FROM classes WHERE start_time < ? AND end_time > ? AND {$daySqlPart} LIMIT 1";

        // ۴. آماده‌سازی پارامترها برای bind_param
        $types = 'ss' . str_repeat('s', count($days));
        $params = [$endTime, $startTime];
        foreach ($days as $day) {
            $params[] = "%" . trim($day) . "%";
        }

        // ۵. اجرا و بررسی نتیجه
        $stmt = $this->connection->prepare($sql);
        $stmt->bind_param($types, ...$params);
        $stmt->execute();
        $result = $stmt->get_result();
        $stmt->close();

        // اگر تعداد سطرهای نتیجه بزرگتر از صفر باشد، یعنی تداخل پیدا شده است
        if ($result->num_rows === 0) {
            return true;
        } else {
            return false;
        }
        
    }
}




// حتماً، بیا خط‌به‌خط و تابع‌به‌تابع دقیقاً توضیح بدم این دو خط چی کار می‌کنن:

// ---

// ### 🟦 خط 1:

// ```php
// $dayClauses = array_fill(0, count($days), 'day_of_week LIKE ?');
// ```

// #### 📌 تابع `array_fill($start_index, $count, $value)`

// * یک آرایه می‌سازه که از ایندکس `$start_index` شروع می‌شه،
// * به تعداد `$count` عنصر داره،
// * و همه‌ی مقدارها برابر با `$value` هستن.

// #### ✅ اینجا چه اتفاقی می‌افته؟

// * `$days` مثلاً برابر باشه با: `['شنبه', 'یکشنبه']`
// * پس `count($days)` = 2
// * یعنی می‌خوای دو شرط LIKE داشته باشی، یکی برای شنبه و یکی برای یکشنبه.

// نتیجه:

// ```php
// $dayClauses = ['day_of_week LIKE ?', 'day_of_week LIKE ?'];
// ```

// یعنی داری برای هر روزی که انتخاب شده یک شرط `LIKE ?` آماده می‌کنی.

// ---

// ### 🟦 خط 2:

// ```php
// $daySqlPart = '(' . implode(' OR ', $dayClauses) . ')';
// ```

// #### 📌 تابع `implode($separator, $array)`

// * آرایه‌ای از رشته‌ها رو با جداکننده‌ای که مشخص می‌کنی، به یک رشته تبدیل می‌کنه.

// #### ✅ اینجا چه اتفاقی می‌افته؟

// * آرایه‌ات اینه: `['day_of_week LIKE ?', 'day_of_week LIKE ?']`
// * می‌خوای اینها رو با `OR` بهم وصل کنی:

// نتیجه:

// ```php
// $daySqlPart = '(day_of_week LIKE ? OR day_of_week LIKE ?)';
// ```

// ---

// ### 🎯 هدف نهایی این دو خط

// تهیه‌ی بخش شرط روزهای هفته در SQL، مثل:

// ```sql
// ... AND (day_of_week LIKE ? OR day_of_week LIKE ?)
// ```

// که بعدش این `?` ها با `%شنبه%` و `%یکشنبه%` پر می‌شن تا بررسی کنه کلاسی در اون روزها هست یا نه.

// ---

// اگه بخوای همین بخش رو با یک [مثال عددی کامل با مقدار ورودی و خروجی نهایی SQL](f) ببینی، می‌تونم برات آماده کنم.




// حتماً، اینم یک مثال عددی کامل از کل فرآیند با مقادیر واقعی، تا دقیقاً ببینی چه ورودی‌هایی به چه کوئری‌ای منجر می‌شن:

// ---

// ## ✅ ورودی تابع:

// ```php
// $days_of_week = "شنبه,یکشنبه";
// $startTime = "10:00";
// $endTime = "12:00";
// ```

// ---

// ## ✅ مرحله 1: تبدیل روزها به آرایه

// ```php
// $days = explode(',', $days_of_week);
// // خروجی:
// $days = ['شنبه', 'یکشنبه'];
// ```

// ---

// ## ✅ مرحله 2: ساخت شرط‌های LIKE

// ```php
// $dayClauses = array_fill(0, count($days), 'day_of_week LIKE ?');
// // خروجی:
// $dayClauses = ['day_of_week LIKE ?', 'day_of_week LIKE ?'];
// ```

// ---

// ## ✅ مرحله 3: تبدیل به شرط SQL

// ```php
// $daySqlPart = '(' . implode(' OR ', $dayClauses) . ')';
// // خروجی:
// $daySqlPart = '(day_of_week LIKE ? OR day_of_week LIKE ?)';
// ```

// ---

// ## ✅ مرحله 4: کوئری نهایی

// ```php
// $sql = "SELECT 1 FROM classes WHERE start_time < ? AND end_time > ? AND {$daySqlPart} LIMIT 1";
// // جایگزینی کامل:
// $sql = "SELECT 1 FROM classes WHERE start_time < ? AND end_time > ? AND (day_of_week LIKE ? OR day_of_week LIKE ?) LIMIT 1";
// ```

// ---

// ## ✅ مرحله 5: آماده‌سازی پارامترها

// ```php
// $types = 'ssss';  // چون 4 پارامتر داریم
// $params = ['12:00', '10:00', '%شنبه%', '%یکشنبه%'];
// ```

// ---

// ## ✅ در نهایت چه کوئری‌ای اجرا می‌شه؟

// اگر بخوای **شبیه‌سازی کنی که کوئری نهایی به شکل دستی چه شکلی هست** (برای درک بهتر):

// ```sql
// SELECT 1
// FROM classes
// WHERE start_time < '12:00'
//   AND end_time > '10:00'
//   AND (
//     day_of_week LIKE '%شنبه%' OR day_of_week LIKE '%یکشنبه%'
//   )
// LIMIT 1;
// ```

// ---

// ## ✅ هدف این کوئری؟

// بررسی می‌کنه:

// * آیا کلاسی وجود داره که قبل از ساعت 12 شروع بشه
// * و بعد از 10 تموم بشه (یعنی با بازه 10 تا 12 تداخل داشته باشه)
// * و در یکی از روزهای "شنبه" یا "یکشنبه" برگزار بشه؟

// اگر وجود داشته باشه، یعنی اون بازه زمانی **آزاد نیست**.

// ---

// اگر خواستی، می‌تونم همین منطق رو برات به یک [کلاس PHP تستی یا فرم کاربری](f) هم تبدیل کنم تا کاملاً اجرایی ببینی.
