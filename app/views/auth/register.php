<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>register</title>
</head>
<body>
    <form action="http://localhost/sina%20project/mvc/project/register" method="POST">
        <input type="hidden" name="csrf-token" value="<?php echo $new_csrf->getCSRFToken(); ?>">
        
        <label for="">Name:</label>
        <input type="text" name="Name" placeholder="Name...">
        <br>

        <label for="">password:</label>
        <input type="password" name="password" placeholder="password">
        <br>
        
        <label>Email : </label>
        <input type="email" name="email" placeholder="Email">
        <br>

        <button type="submit">Register</button>
    </form>
</body>
</html>