<!DOCTYPE html>
<html>
  <head>
    <title> Doctor Info </title>
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

    if (isset($_GET['id_doc']) && is_numeric($_GET['id_doc'])) {
        $id_doctor = $_GET['id_doc'];
    }
    if (isset($_GET['id_hos']) && is_numeric($_GET['id_hos'])) {
        $id = $_GET['id_hos'];
    }
    if (isset($_GET['id_pat']) && is_numeric($_GET['id_pat'])) {
        $id_patient = $_GET['id_pat'];
    }

    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    $q = "SELECT * FROM HOSPITAL WHERE hospital_id = $id";
    $r = mysqli_query($dbc,$q);
    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

    echo '<h2>' . $results['name'];
    echo '<a href="editHospital.php?id=' . $id . '&id_doc=' . $id_doctor . '&id_pat=' . $id_patient . '"><span style="font-size:15px; padding-left: 20px;"">Edit</span></a>';
    echo '<a href="deleteHospital.php?id=' . $id . '&id_doc=' . $id_doctor . '&id_pat=' . $id_patient . '"><span style="font-size:15px; padding-left: 10px;"">Delete</span></a></h2>';
    echo '<p> Location: ' . $results['location'] . '</p>';
    echo '<p> Phone Number: ' . $results['phoneNumber'] . '</p>';

    echo '<a href="doctor.php?id_doc=' . $id_doctor . '&id_pat=' . $id_patient . '">Go back</a>';

    include("footer.html");

 ?>
