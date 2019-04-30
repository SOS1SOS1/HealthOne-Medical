<?php

    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        # requires that we are able to connect to the database using are hidden php file
        require_once('/moredata/shantim/etc/mysqli_connect.php');

        function check_login($dbc, $user = '', $pass = '') {
            $errors = [];
            if (empty($user)) {
                $errors[] = "You forgot to enter your username!";
            } else {
                $u = mysqli_real_escape_string($dbc, trim($user));
            }

            if (empty($pass)) {
                $errors[] = "You forgot to enter your password!";
            } else {
                $p = mysqli_real_escape_string($dbc, trim($pass));
            }

            if (empty($errors)) {

                // checks if that username and password exist in users table
                $q = "SELECT username FROM USERS WHERE username = '$u' AND password = SHA2('$p', 512)";

                // runs the query
                $r = @mysqli_query($dbc, $q);

                if (mysqli_num_rows($r) == 1) {
                    // get that record
                    $row = mysqli_fetch_array($r, MYSQLI_ASSOC);  // assoc lets me use column name to identify indexes of the array

                    session_start();
                    $_SESSION['user'] = $row['username'];
                    //echo 'working';
                    // redirects user to table page
                    header('Location: table.php');
                    exit();

                } else {
                    $errors[] = "The username and password do match any of those on file.";
                }

            }

            foreach ($errors as $msg) {
                echo "$msg<br>\n";
            }

        } // end of check login function

        check_login($dbc, $_POST['user'], $_POST['pass']);
    }

    $page_title = "Login";
    include('includes/header.html');
    include('includes/loginPage.html');
?>
