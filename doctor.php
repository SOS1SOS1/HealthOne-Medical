<?php

  $page_title = "Doctor Information";
  include('header.php');

  # checks that there is an id and that it is a number
  if (isset($_GET['id_doc']) && is_numeric($_GET['id_doc'])) {  // from table.php
      $id = $_GET['id_doc'];
  }
  if (isset($_GET['id_pat']) && is_numeric($_GET['id_pat'])) {  // from table.php
      $id_patient = $_GET['id_pat'];
  }

  require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

  $q = "SELECT * FROM DOCTOR where doctor_id = $id";
  $r = mysqli_query($dbc,$q);
  $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

  echo '<h2>' . $results['lastName'] . ", " . $results['firstName'];
  if ($_SESSION['user'] == "admin") {
      echo '<a href="editDoctor.php?id_doc=' . $id . '&id_pat=' . $id_patient . '"><span style="font-size:15px; padding-left: 20px;"">Edit</span></a>';
      echo '<a href="deleteDoctor.php?id_doc=' . $id . '&id_pat=' . $id_patient . '"><span style="font-size:15px; padding-left: 10px;"">Delete</span></a>';
  }
  echo '</h2>';
  echo '<p> Address: ' . $results['address'] . '</p>';
  echo '<p> Phone Number: ' . $results['phoneNumber'] . '</p>';
  echo '<p> Email: ' . $results['email'] . '</p>';
  echo '<p> Specialty: ' . $results['specialty'] . '</p>';

  $q = "SELECT HOSPITAL.hospital_id, HOSPITAL.name FROM HOSPITAL, DOCTOR INNER JOIN AFFILIATION ON DOCTOR.doctor_id = doctor WHERE doctor_id = $id and hospital_id = hospital";
  $r = @mysqli_query($dbc,$q);
  $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

  echo '<p> Hospital Affiliation(s): </p>';
  echo '<ul>';
  foreach($r as $row) {
      echo '<li><a href="hospital.php?id_doc=' . $id . '&id_hos=' . $row['hospital_id'] . '&id_pat=' . $id_patient .'">' . $row['name'] . '</a></li>';
  }
  echo '</ul>';

  echo '<a href="patient.php?id='. $id_patient .'">Go back</a>';

include("footer.html");
 ?>
