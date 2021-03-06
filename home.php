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
        <title> Home Page </title>
        <link rel="stylesheet" href="main.css">
        <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
    </head>
    <body>
        <nav class="navmain">
            <div class="homeLogout">
                <div class="searchBar">
                    <form action = "home.php?s=1" method = "post">
                        <input type = "text" size = "20" name = "clientFirst" placeholder = "First Name">
                        <input type = "text" size = "20" name = "clientLast" placeholder = "Last Name">
                        <input type = "submit" name = "search" value = "Search" id ="submit" style = "padding: 10px;">
                    </form>
                </div>
                <div class="logout">
                    <?php  echo $_SESSION['user']; ?><br>
                    <a href="logout.php"> Logout</a><br>
                    <?php
                    if ($_SESSION['user'] == "admin") {
                        echo '<a href="settings.php"> Settings </a>';
                    } else {
                        echo '<p></p>';
                    }
                    ?>
                </div>
            </div>
          <a href="home.php"><h1>HealthOne Medical</h1></a>
        </nav>
    </body>
</html>

<?php

    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    //Pagination tingz
    $display = 13;

    if(isset($_GET['p']) && is_numeric($_GET['p'])){
      $pages = $_GET['p'];
    } else{
      $q = "SELECT COUNT(patient_id) FROM PATIENT";
      $r = @mysqli_query($dbc, $q);
      $row = @mysqli_fetch_array($r, MYSQLI_NUM);
      $records = $row[0];

      if($records > $display){
        $pages = ceil($records/$display);
      } else {
        $pages = 1;
      }

    }
    //end pagination tingz

    if (isset($_GET['s']) && is_numeric($_GET['s'])) {
        $start = $_GET['s'];
        $search = true;
    } else {
        $start = 0;
        $search = false;
    }

    if ($search == true) {

        // gets the search
        if (empty($_POST['clientFirst']) && empty($_POST['clientLast'])) {
          $error = true;
        } else {
          $error = false;

          $first_name = mysqli_real_escape_string($dbc, trim($_POST['clientFirst']));
          $last_name = mysqli_real_escape_string($dbc, trim($_POST['clientLast']));
        }

        if ($error == false) {

            // bring up items related to search
            if ($first_name == "") {
                $q = "SELECT * FROM PATIENT WHERE lastName LIKE '%$last_name%' ORDER BY lastName ASC LIMIT  $display";
            } else if ($last_name == "") {
                $q = "SELECT * FROM PATIENT WHERE firstName LIKE '%$first_name%'  ORDER BY lastName ASC LIMIT  $display ";
            } else {
                $q = "SELECT * FROM PATIENT WHERE firstName LIKE '%$first_name%' OR lastName LIKE '%$last_name%'  ORDER BY lastName ASC LIMIT $display";
            }
            $r = mysqli_query($dbc,$q);

            echo '<table>';
            foreach($r as $row){
              echo '<tr><th colspan=3 style="text-align: left;">';
              echo '<a href="patient.php?id=' . $row['patient_id'] .'">' . $row['lastName'] . ", " . $row['firstName'] .'</a></th></tr>';
              echo '<tr><td>';
              echo $row['address'] . '</td><td >' . $row['phoneNumber'] . '</td><td>' . $row['email'] . '</td></tr>';
            }
            echo'</table>';

        } else {

            // if it errors, then it brings up all clients
            $q = "SELECT * FROM PATIENT  ORDER BY lastName ASC LIMIT $start, $display";
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

        }

    } else {

        // brings up all clients
        $q = "SELECT * FROM PATIENT ORDER BY lastName ASC LIMIT $start, $display";
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

    }

    //pagination tingz pt 2

    if($search == true && $error == false){
        echo '<br><p class="pages"><a href="home.php">Go Back</a></p>';
    } else{
    if($pages > 1){
      echo '<br><p class="pages">';

      $current_page = ($start/ $display) +1;


      if($current_page != 1){
        echo '<a href="home.php? s=' . ($start - $display) . '&p='. $pages .'"> Previous </a>';
      }

      for($i=1;$i<=$pages;$i++){
        if($i != $current_page){
          echo '<a href="home.php?s='. (($display * ($i -1)))  . '&p=' . $pages . '">'. $i .'</a>';
        } else {
          echo '   ';
          echo $i .' ';
        }
      }

      if($current_page != $pages){
        echo '<a href="home.php?s=' . ($start + $display) .'&p=' . $pages .'"> Next </a>';
      }
    }
    }

  //end pagination

  include("footer.html");

?>
