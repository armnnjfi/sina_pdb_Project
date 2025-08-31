<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
</head>

<body>
    <form action="http://localhost/sina%20project/mvc/project/login" method="POST">
        <!-- todo -->
        <input type="hidden" name="csrf_token" value="<?= $data['csrf_token']; ?>">

        <label for="">Name:</label>
        <input type="text" name="Name" placeholder="usertName...">
        <br>
        <label for="">password:</label>
        <input type="password" name="password" placeholder="password">
        <br>
        <input type="submit" name="submit" value="login" />
    </form>
</body>

</html>