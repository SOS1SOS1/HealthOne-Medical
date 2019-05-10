<!DOCTYPE html>
<html>
  <head>
    <title> Edit Client </title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>
  <body>
    <nav class="navmain">
      <div class="homeLogout">
        <?php  echo $_SESSION['user']; ?><br>
        <a href="logout.php"> Logout</a><br>
        <a href="addClient.php"> Edit Client </a>
      </div>
      <a href="home.php"><h1>HealthOne Medical</h1></a>
    </nav>

  </body>
</html>

<?php

    # checks that there is an id and that it is a number
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {  // from table.php
        $id = $_GET['id'];
    } elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {  // from form submission
        $id = $_POST['id'];
    } else {  // no valid id, kill the script
        echo '<p> This page has been accessed in error. </p>';
        exit();
    }

    # requires that we are able to connect to the database using are hidden php file
    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // updates patient information
        $q = "DELETE FROM PATIENT WHERE patient_id = $id";
        $r = @mysqli_query($dbc, $q);

        // updates patient's insurance plan
        $q = "UPDATE INSURANCE SET name = '$coverage' WHERE insurance_id = $id";
        $r = @mysqli_query($dbc, $q);
        
        mysqli_close($dbc);

        // redirects user back to client page
        $patient_page = "http://shantim.smtchs.org/HealthOne_Medical/home.php?";
        echo "<script type='text/javascript'>window.top.location='$patient_page';</script>"; exit;

    }
    
?>
