<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>edit course form</title>
</head>

<body>
    <form action="http://localhost/sina%20project/mvc/project/admin/editCourse" id="editCourseForm" method="post">

        <input type="hidden" name="csrf_token" value="<?php echo $data['csrf_token']; ?>">

        <label>id : </label>
        <input type="text" name="id_edit" readonly value="<?php echo $_GET['courseId']; ?>"><br>

        <label for="name">name : </label>
        <input type="text" name="name_edit" placeholder=" name ..."><br>

        <label for="">unit : </label>
        <input type="number" name="unit_edit" placeholder="unit ..."><br>

        <input type="submit" value="ثبت" />
    </form>
</body>

</html>