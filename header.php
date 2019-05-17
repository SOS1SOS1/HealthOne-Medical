<?php
    session_start();
    // checks if session variable user is set, if they are logged in
    if (!isset($_SESSION['user'])) {
        // redirects user back to login page
        $login_page = "http://shantim.smtchs.org/HealthOne_Medical/login.php";
        echo "<script type='text/javascript'>window.top.location='$login_page';</script>"; exit;
        exit();
    }
?>

<!DOCTYPE html>
<html>

    <head>
        <title> <?php echo $page_title; ?> </title>
        <link rel="stylesheet" href="main.css">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
    </head>
    <body>
        <nav class="navmain">
          <div class="otherLogout">
            <div class="logoutdiff">
                <?php  echo $_SESSION['user']; ?><br>
                <a href="logout.php"> Logout</a><br>
                <?php
                if ($_SESSION['user'] == "admin") {
                    echo '<a href="settings.php"> Settings </a>';
                }
                ?>
            </div>
          </div>
          <a href="home.php"><h1>HealthOne Medical</h1></a>
        </nav>
    </body>

</html>
