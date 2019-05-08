<!DOCTYPE html>
<html>
  <head>
    <title> Add Prescription </title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>
  <body>
    <nav class="navmain">
      <div class="homeLogout">
        <?php  echo $_SESSION['user']; ?>
        <a href="logout.php"> Logout</a>
        <a href="addClient.php"> New Client </a>
      </div>
      <h1>HealthOne Medical</h1>
    </nav>

    <?php

        # requires that we are able to connect to the database using are hidden php file
        require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

        # checks that the form was submitted
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            // errors array
            $errors = [];

            // checks for a drug name
            if (empty($_POST['drug'])) {
                $errors[] = 'You forgot to enter the name of the drug.';
            } else {
                $drug = mysqli_real_escape_string($dbc, trim($_POST['drug']));
            }

            // checks for a description
            if (empty($_POST['desc'])) {
                $errors[] = 'You forgot to enter the description of the prescription.';
            } else {
                $desc = mysqli_real_escape_string($dbc, trim($_POST['desc']));
            }

            // checks for a start date
            if (empty($_POST['startDate'])) {
                $errors[] = 'You forgot to enter the start date of the prescription.';
            } else {
                $start_date = mysqli_real_escape_string($dbc, trim($_POST['startDate']));
            }

            // checks for an end date
            if (empty($_POST['endDate'])) {
                $errors[] = 'You forgot to enter the end date of the prescription.';
            } else {
                $end_date = mysqli_real_escape_string($dbc, trim($_POST['endDate']));
            }

            // checks for a dosage
            if (empty($_POST['dosage'])) {
                $errors[] = 'You forgot to enter the dosage of the prescription.';
            } else {
                $dosage = mysqli_real_escape_string($dbc, trim($_POST['dosage']));
            }

            // checks for a duration
            if (empty($_POST['duration'])) {
                $errors[] = 'You forgot to enter the duration of the prescription.';
            } else {
                $duration = mysqli_real_escape_string($dbc, trim($_POST['duration']));
            }

            // checks for a size
            if (empty($_POST['size'])) {
                $errors[] = 'You forgot to enter the size of the prescription.';
            } else {
                $size = mysqli_real_escape_string($dbc, trim($_POST['size']));
            }

            // checks for number of refills
            if (empty($_POST['refills'])) {
                $errors[] = 'You forgot to enter the number of refills for the prescription.';
            } else {
                $refills = mysqli_real_escape_string($dbc, trim($_POST['refills']));
            }

            // checks for patient's id
            if (empty($_POST['docID'])) {
                $errors[] = 'Couldn\'t find doctor\'s id.';
            } else {
                $id_doc = mysqli_real_escape_string($dbc, trim($_POST['docID']));
            }

            // checks for doctor's id
            if (empty($_POST['patID'])) {
                $errors[] = 'Couldn\'t find patient\'s id.';
            } else {
                $id_pat = mysqli_real_escape_string($dbc, trim($_POST['patID']));
            }

            $q = "SELECT drug_id FROM DRUG where DRUG.name = '$drug'";
            $r = mysqli_query($dbc,$q);
            $row = mysqli_fetch_array($r, MYSQLI_ASSOC);
            $drugID = $row['drug_id'];
            // if the drug exists
            if (mysqli_num_rows($r) == 1) {
                // then it checks if the prescription already exists
                $q = "SELECT COUNT(patient_id) FROM PRESCRIPTION where drug_id = $drugID and doctor_id = $id_doc and startDate = '$start_date' and endDate = '$end_date' and patient_id = $id_pat";
                $r = @mysqli_query($dbc, $q);
                $row = mysqli_fetch_array($r, MYSQLI_NUM);
                $drugs = $row[0];

                // checks if there were no errors
                if ($drugs == 0) {
                    if (empty($errors)) {
                        // inserts the new patient
                        $q = "INSERT INTO PRESCRIPTION (patient_id, doctor_id, drug_id, description, startDate, endDate, dosage, duration, size, numRefill) VALUES ('$id_pat', '$id_doc', '$drugID', '$desc', '$start_date',  '$end_date', '$dosage', '$duration', '$size', '$refills')";
                        $r = @mysqli_query($dbc, $q);
                    } else {
                        # reports the errors
                        echo '<p> The following error(s) occured:<br>';
                        foreach ($errors as $msg) {
                            echo " - $msg<br>\n";
                        }
                        echo '</p><p> Please try again. </p>';
                        // end of errors if statement
                    }
                } else {
                    echo '<p> The following error(s) occured:<br>';
                    echo " - Prescription already exists.";
                }

            } else {
                  echo '<p> The following error(s) occured:<br>';
                  echo " - Drug does not exist.";
            }

        }

        echo '<a href="patient.php?id='. $pat_id .'">Go back</a>';

        mysqli_close($dbc);
        include("footer.html");
    ?>

  </body>
</html>
