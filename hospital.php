<!DOCTYPE html>
<html>
  <head>
    <title> Doctor Info </title>
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
  </body>
</html>

<?php


require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

if (isset($_GET['id_doc']) && is_numeric($_GET['id_doc'])) {  // from table.php
    $id_doctor = $_GET['id_doc'];
}
if (isset($_GET['id_hos']) && is_numeric($_GET['id_hos'])) {  // from table.php
    $id = $_GET['id_hos'];
}
if (isset($_GET['id_pat']) && is_numeric($_GET['id_pat'])) {  // from table.php
    $id_patient = $_GET['id_pat'];
}

$q = "SELECT * FROM HOSPITAL WHERE hospital_id = $id";
$r = mysqli_query($dbc,$q);
$results = mysqli_fetch_array($r, MYSQLI_ASSOC);

echo '<h2>' . $results['name'] . "</h2>";
echo '<p> Location: ' . $results['location'] . '</p>';
echo '<p> Phone Number: ' . $results['phoneNumber'] . '</p>';

echo '<a href="doctor.php?id_doc=' . $id_doctor . '&id_pat=' . $id_patient . '">Go back</a>';

include("footer.html");
 ?>
