<!DOCTYPE html>
<html>
  <head>
    <title> Patient Info </title>
  </head>
  <body>

  </body>
</html>

<?php

    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    $q = "SELECT * FROM PATIENT";
    $r = mysqli_query($dbc,$q);
    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);



 ?>
