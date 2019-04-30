<?php

    session_start();
    // checks if they are logged in, before they can log out (prevents people from accessing pages w/o being logged in)
    if(!isset($_SESSION['user'])) {
        header('Location: login.php');
    } else {
        // cleans it out
        $_SESSION = [];
        // destroys the session itself
        session_destroy();
        header('Location: login.php');
    }

?>
