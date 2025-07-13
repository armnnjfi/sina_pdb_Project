<?php
    session_start();
    include "app/services/SecurityService.php";
    include "core/route.php";
    include "core/controller.php";
    
    $csrf_token = new SecurityService();
    $csrf_token->setCSRFToken();

    new route();

?>

<head>
    <title>sina project</title>
</head>
