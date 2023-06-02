<?php
    include('../lib/users.php');

    // Server returns JSON
    header("Content-Type: application/json");
    $userapi = new UserAPI();
    echo $userapi->handle_session_request();
?>