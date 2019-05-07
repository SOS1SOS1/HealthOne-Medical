

<!DOCTYPE html>
<html>
  <head>

    <title> Home Page </title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
    <?php

        session_start();
        // checks if session variable user is set, if they logged in
        if (!isset($_SESSION['user'])) {
            header('Location: login.php');
            //exit();
        }

    ?>
  </head>
  <body>
    <nav class="navmain">
      <div class="homeLogout">
        <?php  echo $_SESSION['user']; ?><br>
        <a href="logout.php"> Logout</a><br>
        <a href="addClient.php"> New Client </a>
      </div>
      <a href="home.php"><h1>HealthOne Medical</h1></a>
      <a href="testingtingz.php">click for tests</a>
    </nav>

    <?php

        require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

        $q = "SELECT * FROM PATIENT";
        $r = mysqli_query($dbc,$q);
        $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

        echo '<table>';
        foreach($r as $row){
          echo '<tr><th colspan=3 style="text-align: left;">';
          echo '<a href="patient.php?id=' . $row['patient_id'] .'">' . $row['lastName'] . ", " . $row['firstName'] .'</a></th></tr>';
          echo '<tr><td>';
          echo $row['address'] . '</td><td >' . $row['phoneNumber'] . '</td><td>' . $row['email'] . '</td></tr>';
        }
        echo'</table>';

        include("footer.html");

     ?>

  </body>
</html>
