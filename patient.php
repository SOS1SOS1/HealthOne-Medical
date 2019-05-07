<!DOCTYPE html>
<html>
  <head>
    <title> Patient Info </title>
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

    $docID = $results['primaryDoctor'];

    $q = "SELECT INSURANCE.name FROM INSURANCE INNER JOIN PATIENT ON patient_id = insurance_id WHERE patient_id = $id";
    $r = mysqli_query($dbc,$q);
    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

    echo '<p> Level of Coverage: ' . $results['name'] . '</p>';

    $q = "SELECT DOCTOR.firstName, DOCTOR.lastName FROM DOCTOR where doctor_id = $docID";
    $r = mysqli_query($dbc,$q);
    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

    echo '<p> Primary Care Doctor: ' . '<a href="doctor.php?id_pat=' . $id . '&id_doc=' . $docID .'">' . $results['firstName'] . " " . $results['lastName'] . '</a></p>';

    $q = "SELECT * FROM DRUG INNER JOIN PRESCRIPTION ON PRESCRIPTION.drug_id = DRUG.drug_id WHERE patient_id = $id";
    $r = mysqli_query($dbc,$q);
    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

    // TODO: also show start and end date for prescription
    echo '<p> Prescription(s): </p>';
    echo '<ul>';
    foreach($r as $row) {
        echo '<li>' . $row['name'] . '<ul>';
          echo '<li> Purpose - ' . $row['purpose'] . '</li>';
          echo '<li> Possible Side Effects - ' . $row['sideEffects'] . '</li>';
        echo '</ul></li>';
    }
    echo '</ul>';

    echo '<a href="addDrug.php?id_doc=' . $docID . '&id_pat=' . $id . '">Add New Prescription</a><br><br>';

    echo "<a href='home.php'>Go Back</a>";
    include("footer.html");
 ?>
