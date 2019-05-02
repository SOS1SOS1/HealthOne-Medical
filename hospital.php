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


require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

if (isset($_GET['id']) && is_numeric($_GET['id'])) {  // from table.php
    $id = $_GET['id'];
}

$q = "SELECT * FROM HOSPITAL WHERE hospital_id = $id";
$r = mysqli_query($dbc,$q);
$results = mysqli_fetch_array($r, MYSQLI_ASSOC);

echo '<h2>' . $results['name'] . "</h2>";
echo '<p> Location: ' . $results['location'] . '</p>';
echo '<p> Phone Number: ' . $results['phoneNumber'] . '</p>';


 ?>
