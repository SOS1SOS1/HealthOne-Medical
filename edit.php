<!DOCTYPE html>
<html>
  <head>
      <title> Edit Client </title>
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

    # checks that there is an id and that it is a number
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {  // from table.php
        $id = $_GET['id'];
    } elseif (isset($_POST['id']) && is_numeric($_POST['id'])) {  // from form submission
        $id = $_POST['id'];
    } else {  // no valid id, kill the script
        echo '<p> This page has been accessed in error. </p>';
        exit();
    }

    # requires that we are able to connect to the database using are hidden php file
    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // errors array
        $errors = [];

        // checks for a first name
        if (empty($_POST['fName'])) {
            $errors[] = 'You forgot to enter the client\'s first name.';
        } else {
            $first_name = mysqli_real_escape_string($dbc, trim($_POST['fName']));
        }

        // checks for a last name
        if (empty($_POST['lName'])) {
            $errors[] = 'You forgot to enter the client\'s last name.';
        } else {
            $last_name = mysqli_real_escape_string($dbc, trim($_POST['lName']));
        }

        // checks for an address
        if (empty($_POST['address'])) {
            $errors[] = 'You forgot to enter the client\'s address.';
        } else {
            $address = mysqli_real_escape_string($dbc, trim($_POST['address']));
        }

        // checks for a phone number
        if (empty($_POST['pNum'])) {
            $errors[] = 'You forgot to enter the client\'s phone number.';
        } else {
            $phone_number = mysqli_real_escape_string($dbc, trim($_POST['pNum']));
        }

        // checks for an email
        if (empty($_POST['email'])) {
            $errors[] = 'You forgot to enter the client\'s email.';
        } else {
            $email = mysqli_real_escape_string($dbc, trim($_POST['email']));
        }

        // checks for a primary care doctor
        if (empty($_POST['doctor'])) {
            $errors[] = 'You forgot to enter the client\'s level of insurance coverage.';
        } else {
            $docID = mysqli_real_escape_string($dbc, trim($_POST['doctor']));
        }

        // checks for the level of coverage
        if (empty($_POST['coverage'])) {
            $errors[] = 'You forgot to enter the client\'s level of insurance coverage.';
        } else {
            $coverage = mysqli_real_escape_string($dbc, trim($_POST['coverage']));
        }

        if (empty($errors)) {

            // updates patient information
            $q = "UPDATE PATIENT SET firstName = '$first_name', lastName = '$last_name', address = '$address', phoneNumber = '$phone_number', email = '$email', primaryDoctor = '$docID' WHERE patient_id = $id";
            $r = @mysqli_query($dbc, $q);

            // updates patient's insurance plan
            $q = "UPDATE INSURANCE SET name = '$coverage' WHERE insurance_id = $id";
            $r = @mysqli_query($dbc, $q);

        } else {

            # reports the errors
            echo '<p> The following error(s) occured:<br>';
            foreach ($errors as $msg) {
                echo " - $msg<br>\n";
            }
            echo '</p><p> Please try again. </p>';

        }

        // redirects user back to client page
        $patient_page = "http://shantim.smtchs.org/HealthOne_Medical/patient.php?id=" . $id;
        echo "<script type='text/javascript'>window.top.location='$patient_page';</script>"; exit;

    }

    mysqli_close($dbc);
    include("footer.html");
?>
