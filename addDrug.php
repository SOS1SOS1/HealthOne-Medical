<!DOCTYPE html>
<html>
  <head>
    <title> Add Prescription </title>
    <link rel="stylesheet" href="main.css">
    <link href="https://fonts.googleapis.com/css?family=Nunito+Sans" rel="stylesheet">
  </head>
  <body>
    <h1>HealthOne Medical</h1>

    <form action = "addClient.php" method = "post">
        <h3>Description: <input type = "text" name = "desc" size = "15" maxlength="30"></h3>
        <h3>Start Date: <input type = "date" name = "startDate" value = "2019-01-01"></h3>
        <h3>End Date: <input type = "date" name = "endDate" value = "2019-01-01"></h3>
        <h3>Dosage: <input type="number" name = "dosage" pattern="\d*" minLength="1" maxlength="4"></h3>
        <h3>Duration: <input type = "text" name = "duration" size = "25" maxlength="30"></h3>
        <h3>Size: <input type="number" name = "size" pattern="\d*" minLength="1" maxlength="5"></h3>
        <h3>Number of Refills: <input type="number" name = "refills" pattern="\d*" minLength="1" maxlength="5"></h3>
        <h3><input class = "submit" type = "submit" name = "submit" value = "Add Drug"></h3>
    </form>

  </body>
</html>

<?php
    # requires that we are able to connect to the database using are hidden php file
    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // errors array
        $errors = [];

        // checks for a description
        if (empty($_POST['desc'])) {
            $errors[] = 'You forgot to enter the description of the prescription.';
        } else {
            $desc = mysqli_real_escape_string($dbc, trim($_POST['desc']));
        }

        // checks for a last name
        if (empty($_POST['startDate'])) {
            $errors[] = 'You forgot to enter the start date of the prescription.';
        } else {
            $start_date = mysqli_real_escape_string($dbc, trim($_POST['startDate']));
        }

        // checks for an address
        if (empty($_POST['endDate'])) {
            $errors[] = 'You forgot to enter the end date of the prescription.';
        } else {
            $end_date = mysqli_real_escape_string($dbc, trim($_POST['endDate']));
        }

        // checks for a phone number
        if (empty($_POST['dosage'])) {
            $errors[] = 'You forgot to enter the dosage of the prescription.';
        } else {
            $phone_number = mysqli_real_escape_string($dbc, trim($_POST['dosage']));
        }

        // checks for an email
        if (empty($_POST['email'])) {
            $errors[] = 'You forgot to enter the client\'s email.';
        } else {
            $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        }

        // checks for a primary care doctor first name
        if (empty($_POST['dFirstName'])) {
            $errors[] = 'You forgot to enter the client\'s primary care doctor\'s first name.';
        } else {
            $dFirst = mysqli_real_escape_string($dbc, trim($_POST['dFirstName']));
        }

        // checks for a primary care doctor first name
        if (empty($_POST['dLastName'])) {
            $errors[] = 'You forgot to enter the client\'s primary care doctor\'s last name.';
        } else {
            $dLast = mysqli_real_escape_string($dbc, trim($_POST['dLastName']));
        }

        // checks for the level of coverage
        if (empty($_POST['coverage'])) {
            $errors[] = 'You forgot to enter the client\'s level of insurance coverage.';
        } else {
            $coverage = mysqli_real_escape_string($dbc, trim($_POST['coverage']));
        }

        $q = "SELECT COUNT(patient_id) FROM PATIENT where firstName = '$first_name' and lastName = '$last_name' and address = '$address'";
        $r = @mysqli_query($dbc, $q);
        $row = mysqli_fetch_array($r, MYSQLI_NUM);
        $patients = $row[0];

        // checks if there were no errors
        if ($patients == 0) {
          if (empty($errors)) {

              // gets the primary care doctors id
              $q = "SELECT doctor_id FROM DOCTOR where firstName = '$dFirst' and lastName = '$dLast'";
              $r = @mysqli_query($dbc, $q);
              $row = mysqli_fetch_array($r, MYSQLI_ASSOC);

              // checks if that doctor exists
              if (mysqli_num_rows($r) == 1) {
                $doc = $row['doctor_id'];

                // inserts the new patient
                $q = "INSERT INTO PATIENT (firstName, lastName, address, phoneNumber, email, primaryDoctor) VALUES ('$first_name', '$last_name', '$address', '$phone_number', '$email',  $doc)";
                $r = @mysqli_query($dbc, $q);

                // inserts patient's insurance plan
                $q = "INSERT INTO INSURANCE (name) VALUES ('$coverage')";
                $r = @mysqli_query($dbc, $q);

                // go back to home page
                header('Location: home.php');

              } else {
                echo '<p> The following error(s) occured:<br>';
                echo " - Doctor entered doesn't exist in table.";
                echo '<p> Please enter the doctor\'s information </p>';

                // go to doctor form
              }

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
            echo " - Patient already exists.";
        }

    } else {
      echo 'refresh';
    }

    mysqli_close($dbc);
    include("footer.html");
?>
