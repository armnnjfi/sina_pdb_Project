<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>user request form</title>
</head>

<body>
    <form action="http://localhost/sina%20project/mvc/project/user/request/new" method="post">
        
        <input type="hidden" name="csrf-token" value="<?php echo $new_csrf->getCSRFToken(); ?>">

        <label for="">course name :</label>
        <select name="course_id">
            <?php foreach ($data['courses'] as $course) { ?>
                <option value="<?php echo $course['id'] ?>"><?php echo $course['name'] ?></option>
            <?php } ?>
        </select><br>

        <label for="">term name :</label>
        <select name="term_id">
            <?php foreach ($data['terms'] as $term) { ?>
                <option value="<?php echo $term['id'] ?>"><?php echo $term['name'] ?></option>
            <?php } ?>
        </select><br>
        <label for="">which days :</label><br>

        <input type="checkbox" name="weekDays[]" id="" value="پنجشنبه">
        <label for="">شنبه</label>
        <input type="checkbox" name="weekDays[]" id="" value="شنبه">
         <label for="">یک شنبه</label>
         <input type="checkbox" name="weekDays[]" id="" value="یکشنبه">
         <label for="">دوشنبه</label>
         <input type="checkbox" name="weekDays[]" id="" value="دوشنبه">
         <label for="">سه شنبه</label>
         <input type="checkbox" name="weekDays[]" id="" value="سه شنبه">
         <label for="">چهارشنبه</label>
         <input type="checkbox" name="weekDays[]" id="" value="چهارشنبه">
         <label for="">پنجشنبه</label>
        <br>
        
        <label for="">start time:</label>
        <input type="time" name="start_time" id="">
        <br>

        <label for="">end time:</label>
        <input type="time" name="end_time" id="">
        <br>

        <br>
        <label for="explain_input">explain:</label>
        <textarea name="explain" placeholder="توضیحات" id="explain_input"></textarea><br><br>

        <input type="submit" value="ثبت درخواست">
    </form>
</body>
 