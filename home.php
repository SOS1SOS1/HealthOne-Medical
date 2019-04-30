<?php

    session_start();
    // checks if session variable user is set, if they logged in
    if (!isset($_SESSION['user'])) {
        header('Location: login.php');
        //exit();
    }
    echo '<br>';
    echo $_SESSION['user'];
    echo '<a href="logout.php"> Logout </a></br>';
?>

<!DOCTYPE html>
<html>
  <head>
    <title> Home Page </title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>
  <body>
    <h1>HealthOne Medical</h1>

    <form method = "post" action = home.php>
      <input type="submit" name="test" value="test">
    </form>
  </body>
</html>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    $q = "SELECT * FROM PATIENT";
    $r = mysqli_query($dbc,$q);
    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);


    echo '<table style="width:50%">';
    echo '<tr colspan=3><th>';
    echo $results['lastName'] . ", " . $results['firstName'] .'</th></tr>';
    foreach($r as $row){
      echo '<tr><td>';
      echo $row['address'] . '</td><td>' . $row['phoneNumber'] . '</td><td>' . $row['email'] . '</td></tr>';
    }
    echo'</table>';

  }
 ?>