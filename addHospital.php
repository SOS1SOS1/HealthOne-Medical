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
      <div class="otherLogout">
        <div class="logoutdiff">
            <?php  echo $_SESSION['user']; ?><br>
            <a href="logout.php"> Logout</a><br>
            <a href="addClient.php"> New Client </a>
        </div>
      </div>
      <a href="home.php"><h1>HealthOne Medical</h1></a>

    </nav>

    <form action="addHospital.php" method="post">
      <h3> Name<input type="text" name="hosname" required></h3>
      <h3> Location<input type="text" name="location" required></h3>
      <h3>Phone Number: <input type="numbernumber" name = "hosNum" pattern="\d*" minLength="10" maxlength="10"></h3>
      <input type="submit" name="test" value="Add Hospital" id="submit"><br><br>
      <a href='settings.php'>Cancel</a>
    </form>
  </body>
</html>

<?php
require_once('/moredata/shantim/etc/mysqli_connect_medical.php');


if ($_SERVER['REQUEST_METHOD'] == 'POST') {

  if(isset($_POST['hosname']) && isset($_POST['location']) && isset($_POST['hosNum'])){
    $hosname = $_POST['hosname'];
    $location = $_POST['location'];
    $phone = $_POST['hosNum'];


    $q = "INSERT INTO HOSPITAL (name, location, phoneNumber) VALUES ('$hosname', '$location', '$phone')";
    $r = $r = @mysqli_query($dbc, $q);
  }

}
 ?>
