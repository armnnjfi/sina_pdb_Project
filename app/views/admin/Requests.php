<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>requests list</title>
</head>

<body>
    <table cellpadding="10">
        <thead>
            <tr>
                <th>request id</th>
                <th>user id</th>
                <th>course name</th>
                <th>term name</th>
                <th>days of week</th>
                <th>start time</th>
                <th>end time</th>
                <th>explains</th>
                <th>approve</th>
                <th>reject</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['requests'] as $request) { ?>
                <tr>
                    <td><?php echo $request['request_id']; ?></td>
                    <td><?php echo $request['user_id']; ?></td>
                    <td><?php echo $request['course_name']; ?></td>
                    <td><?php echo $request['term_name']; ?></td>
                    <td><?php echo $request['day_of_week']; ?></td>
                    <td><?php echo $request['start_time']; ?></td>
                    <td><?php echo $request['end_time']; ?></td>
                    <td><?php echo $request['explains']; ?></td>
                    <td>
                        <form action="http://localhost/sina%20project/mvc/project/admin/requests/approve" method="post">
                            <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">
                            <input type="hidden" name="course_id" value="<?php echo $request['course_id']; ?>">
                            <input type="hidden" name="term_id" value="<?php echo $request['term_id']; ?>">
                            <input type="hidden" name="start_time" value="<?php echo $request['start_time']; ?>">
                            <input type="hidden" name="end_time" value="<?php echo $request['end_time']; ?>">
                            <input type="hidden" name="day_of_week" value="<?php echo $request['day_of_week']; ?>">
                            <input type="submit" value="approve">
                        </form>
                        
                    </td>

                    <td>
                        <form action="http://localhost/sina%20project/mvc/project/admin/requests/reject" method="post">
                            <input type="hidden" name="request_id" value="<?php echo $request['request_id']; ?>">

                            <input type="submit" value="reject">
                        </form>
                        
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</body>

</html>
