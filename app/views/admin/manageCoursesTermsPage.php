<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>manageCoursesTermsPage</title>
    <style>
        .div {
            height: auto;
            justify-content: space-evenly;
            width: 25%;
        }

        .div-father {
            display: flex;
        }
    </style>
</head>

<body>
    <div class="div-father">
        <div class="div" style="width: 50%;">
            <h2>classes management</h2>

            <table cellpadding="10">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>course name</th>
                        <th>term name</th>
                        <th>start time</th>
                        <th>end time</th>
                        <th>day of week</th>
                        <th>edit</th>
                        <th>delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['classes'] as $class) { ?>
                        <tr>
                            <td><?php echo $class['class_id']; ?></td>
                            <td><?php echo $class['course_name']; ?></td>
                            <td><?php echo $class['term_name']; ?></td>
                            <td><?php echo $class['start_time']; ?></td>
                            <td><?php echo $class['end_time']; ?></td>
                            <td><?php echo $class['day_of_week']; ?></td>
                            <td>
                                <a href="http://localhost/sina%20project/mvc/project/admin/editClass?classId=<?php echo $class['class_id'] ?>">
                                    <button id="editCourseBtn">edit</button>
                                </a>
                            </td>
                            <td>
                                <a href="http://localhost/sina%20project/mvc/project/admin/deleteClass?classId=<?php echo $class['class_id'] ?>">
                                    <button>delete</button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>


            <button onclick="toggleBtnForm('newClassBtn','newClassForm')" id="newClassBtn">ثبت کلاس درسی جدید</button>
            <form action="http://localhost/sina%20project/mvc/project/admin/newClass" style="display: none;" id="newClassForm" method="post">

                <input type="hidden" name="csrf-token" value="<?php echo $new_csrf->getCSRFToken(); ?>">

                <label for="course_id">course name : </label>
                <select name="course_id">
                    <?php foreach ($data['courses'] as $course) { ?>
                        <option value="<?php echo $course['id'] ?>"><?php echo $course['name'] ?></option>
                    <?php } ?>
                </select><br>

                <label for="term_id">term : </label>
                <select name="term_id">
                    <?php foreach ($data['terms'] as $term) { ?>
                        <option value="<?php echo $term['id'] ?>"><?php echo $term['name'] ?></option>
                    <?php } ?>
                </select><br>

                <label for="start_time">start time : </label>
                <input type="time" name="start_time"><br>

                <label for="end_time">end time : </label>
                <input type="time" name="end_time"><br>

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

                <input type="submit" value="ثبت" onclick="toggleBtnForm('newClassBtn','newClassForm')" />
            </form>

        </div>
        <div class="div">
            <h2>courses management</h2>

            <table cellpadding="10">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>unit</th>
                        <th>edit</th>
                        <th>delete</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['courses'] as $course) { ?>
                        <tr>
                            <td><?php echo $course['id']; ?></td>
                            <td><?php echo $course['name']; ?></td>
                            <td><?php echo $course['unit']; ?></td>
                            <td>
                                <a href="http://localhost/sina%20project/mvc/project/admin/showEditCourse?courseId=<?php echo $course['id'] ?>">
                                    <button id="editCourseBtn">edit</button>
                                </a>
                            </td>
                            <td>
                                <a href="http://localhost/sina%20project/mvc/project/admin/deleteCourse?courseId=<?php echo $course['id'] ?>">
                                    <button>delete</button>
                                </a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>


            <button onclick="toggleBtnForm('newCourseBtn','newCourseForm')" id="newCourseBtn">ثبت واحد درسی جدید</button>
            <form action="http://localhost/sina%20project/mvc/project/admin/newCourse" style="display: none;" id="newCourseForm" method="post">

                <input type="hidden" name="csrf-token" value="<?php echo $new_csrf->getCSRFToken(); ?>">

                <label for="name">name : </label>
                <input type="text" name="name" placeholder=" name ..."><br>

                <label for="">unit : </label>
                <input type="number" name="unit" placeholder="unit ..."><br>

                <input type="submit" value="ثبت" onclick="toggleBtnForm('newCourseBtn','newCourseForm')" />
            </form>
        </div>
        <div class="div">
            <h2>terms management</h2>

            <table cellpadding="10">
                <thead>
                    <tr>
                        <th>id</th>
                        <th>Name</th>
                        <th>start_date</th>
                        <th>end_date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($data['terms'] as $term) { ?>
                        <tr>
                            <td><?php echo $term['id']; ?></td>
                            <td><?php echo $term['name']; ?></td>
                            <td><?php echo $term['start_date']; ?></td>
                            <td><?php echo $term['end_date']; ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>


            <button onclick="toggleBtnForm('newTermBtn','newTermForm')" id="newTermBtn">ثبت ترم جدید</button>
            <form action="http://localhost/sina%20project/mvc/project/admin/newTerm" style="display: none;" id="newTermForm" method="post">

                <input type="hidden" name="csrf-token" value="<?php echo $new_csrf->getCSRFToken(); ?>">

                <label for="name">name:</label>
                <input type="text" name="name" placeholder="term name..."><br>

                <label for="">term start date:</label>
                <input type="date" name="term_start_date" placeholder="term name..."><br>

                <label for="">term end date:</label>
                <input type="date" name="term_end_date" placeholder="term name..."><br>

                <input type="submit" value="ثبت" onclick="toggleBtnForm('newTermBtn','newTermForm')" />
            </form>
        </div>
    </div>
    <script>
        function toggleBtnForm(BtnId, formId) {
            var btn = document.getElementById(BtnId);
            var form = document.getElementById(formId);

            if (btn.style.display === "block" && form.style.display === "none") {
                btn.style.display = "none";
                form.style.display = "block";
            } else {
                btn.style.display = "block";
                form.style.display = "none";
            }

        }
    </script>
</body>

</html>