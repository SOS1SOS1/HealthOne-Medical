

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
            <a href="addClient.php"> New Client </a>
        </div>
      </div>
      <a href="home.php"><h1>HealthOne Medical</h1></a>

    </nav>

    <?php

        require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

        //Pagination tingz

        //end pagination tingz




        if (isset($_GET['s']) && is_numeric($_GET['s'])) {
            $search = true;
        } else {
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
                    $q = "SELECT * FROM PATIENT WHERE lastName LIKE '%$last_name%'";
                } else if ($last_name == "") {
                    $q = "SELECT * FROM PATIENT WHERE firstName LIKE '%$first_name%'";
                } else {
                    $q = "SELECT * FROM PATIENT WHERE firstName LIKE '%$first_name%' OR lastName LIKE '%$last_name%'  ";
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
                $q = "SELECT * FROM PATIENT LIMIT $start, $display";
                $r = mysqli_query($dbc,$q);
                $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

                echo '<table>';
                foreach($r as $row){
                  echo '<tr><th colspan=3 style="text-align: left;">';
                  echo '<a href="patient.php?id=' . $row['patient_id'] .'">' . $row['lastName'] . ", " . $row['firstName'] .'</a></th></tr>';
                  echo '<tr><td>';
                  echo $row['address'] . '</td><td >' . $row['phoneNumber'] . '</td><td>' . $row['email'] . '</td></tr>';
                }
                echo '<tr><td colspan = "6" class = "links">';
                createLinks();
                echo '</td></tr>';
                echo'</table>';

            }

        } else {

            // brings up all clients
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

        }

        //pagination tingz pt 2

        //end pagination

        include("footer.html");

     ?>

  </body>
</html>
