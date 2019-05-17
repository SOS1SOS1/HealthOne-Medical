<!DOCTYPE html>
<html>
  <head>
    <title> Delete Doctor </title>
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

  </body>
</html>

<?php

    # checks that there is an id and that it is a number
    if (isset($_GET['id_doc']) && is_numeric($_GET['id_doc'])) {
        $id_doc = $_GET['id_doc'];
    }
    if (isset($_GET['id_pat']) && is_numeric($_GET['id_pat'])) {
        $id_pat = $_GET['id_pat'];
    }

    // requires that we are able to connect to the database using are hidden php file
    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    // gets doctor information
    $q = "SELECT * FROM DOCTOR WHERE doctor_id = $id_doc";
    $r_doc = @mysqli_query($dbc, $q);
    $row_doctor = mysqli_fetch_array($r_doc, MYSQLI_ASSOC);

    echo '<form action = "deleteDoctor.php?id_doc=' . $id_doc . '&id_pat=' . $id_pat . '" method = "post">';
        echo '<h3>Are you sure you want to delete the doctor, ' . $row_doctor['firstName'] . " " . $row_doctor['lastName'] . '?</h3>';
        echo '<input type="submit" name="submit" value="Confirm" id="submit"><br><br>';
    echo '</form>';

    echo '<a href="doctor.php?id_doc=' . $id_doc . '&id_pat=' . $id_pat . '">Cancel</a>';

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // deletes doctor information
        $q = "DELETE FROM DOCTOR WHERE doctor_id = $id_doc";
        $r = @mysqli_query($dbc, $q);

        // delete doctor's affiliations
        $q = "DELETE FROM AFFILIATION WHERE doctor = $id_doc";
        $r = @mysqli_query($dbc, $q);

        mysqli_close($dbc);

        // redirects user back to patient page
        $patient_page = "http://shantim.smtchs.org/HealthOne_Medical/patient.php?id=" . $id_pat;
        echo "<script type='text/javascript'>window.top.location='$patient_page';</script>"; exit;

    }

    include("footer.html");
?>
