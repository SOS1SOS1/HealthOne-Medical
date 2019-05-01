<!DOCTYPE html>
<html>
  <head>
    <title> Doctor Info </title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>
  <body>
    <h1>HealthOne Medical</h1>
  </body>
</html>

<?php

  # checks that there is an id and that it is a number
  if (isset($_GET['id']) && is_numeric($_GET['id'])) {  // from table.php
      $id = $_GET['id'];
  }

  require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

  $q = "SELECT * FROM DOCTOR where doctor_id = $id";
  $r = mysqli_query($dbc,$q);
  $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

  echo '<h2>' . $results['lastName'] . ", " . $results['firstName'] . "</h2>";
  echo '<p> Address: ' . $results['address'] . '</p>';
  echo '<p> Phone Number: ' . $results['phoneNumber'] . '</p>';
  echo '<p> Email: ' . $results['email'] . '</p>';

  $q = "SELECT HOSPITAL.name FROM HOSPITAL, DOCTOR INNER JOIN AFFILIATION ON DOCTOR.doctor_id = doctor WHERE doctor_id = $id and hospital_id = hospital";
  $r = mysqli_query($dbc,$q);
  $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

  foreach($results as $row) {
    echo '<p> Hospital affiliations: ' . $row['name'] . '</p>';
  }

  echo "<a href='home.php'>Go back</a>";

 ?>
