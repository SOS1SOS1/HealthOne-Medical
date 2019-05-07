<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title>anna ou!</title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>
  <body>
    <nav class="navmain">
      <div class="homeLogout">
        <?php  echo $_SESSION['user']; ?><br>
        <a href="logout.php"> Logout</a><br>
        <a href="addClient.php"> New Client </a>
      </div>
      <a href="home.php"><h1>HealthOne Medical</h1></a>


    </nav>

    <form action="testingtingz.php" method="post">
      <input type="submit" name="test" value="test" id="submit">
    </form>
  </body>
</html>

<?php
require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

# checks that the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  header('Location:http://shantim.smtchs.org/HealthOne_Medical/home.php');
  exit;

}

 ?>
