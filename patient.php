<!DOCTYPE html>
<html>
  <head>
    <title> Patient Info </title>
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

    $q = "SELECT * FROM PATIENT where patient_id = $id";
    $r = mysqli_query($dbc,$q);
    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

    echo '<h2>' . $results['lastName'] . ", " . $results['firstName'] . "</h2>";
    echo '<p> Address: ' . $results['address'] . '</p>';
    echo '<p> Phone Number: ' . $results['phoneNumber'] . '</p>';
    echo '<p> Email: ' . $results['email'] . '</p>';

    $q = "SELECT INSURANCE.name FROM INSURANCE INNER JOIN PATIENT ON patient_id = insurance_id WHERE patient_id = $id";
    $r = mysqli_query($dbc,$q);
    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

    echo '<p> Level of Coverage: ' . $results['name'] . '</p>';

    $q = "SELECT PRIMARY_DOCTOR.primary_id, PRIMARY_DOCTOR.firstName, PRIMARY_DOCTOR.lastName FROM PRIMARY_DOCTOR INNER JOIN PATIENT ON patient_id = primary_id WHERE patient_id = $id";
    $r = mysqli_query($dbc,$q);
    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

    echo '<p> Primary Care Doctor: ' . '<a href="doctor.php?id=' . $results['primary_id'] .'">' . $results['firstName'] . " " . $results['lastName'] . '</a></p>';

    echo "<a href='home.php'>Go back</a>";
 ?>
