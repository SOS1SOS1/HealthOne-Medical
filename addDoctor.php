<!DOCTYPE html>
<html>
  <head>
    <title> Add Client </title>
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

    // shows new doctor form
    function createDoctorForm($r_hospital, $row_doctor) {
        echo '<form action = "addDoctor.php" method = "post">';
            echo '<label>First Name</label><input type="text" name="firstname" value = ' . $row_doctor['firstName'] . '><br>';
            echo '<label>Last Name</label><input type="text" name="lastname" value = ' . $row_doctor['lastName'] . '><br>';
            echo '<label>Specialty</label><input type="text" name="specialty" required><br>';
            echo '<label>Phone Number</label><input type="numbernumber" name = "docPhoneNum" pattern="\d*" minLength="10" maxlength="10" required><br>';
            echo '<label>Email</label><input type="email" name="docEmail" required><br>';
            echo '<label>Address</label><input type="text" name="docAddress" required><br>';
            foreach($r_hospital as $results){
                echo '<input type="checkbox" name="affiliation[]" value=' . $results['hospital_id'] . '> ' . $results['name'] . ' <br>';
            }
            echo '<input type="submit" name="submit" id="submit">';
        echo '</form>';
    }

    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    }
    if (isset($_GET['id_pat']) && is_numeric($_GET['id_pat'])) {
        $id_pat = $_GET['id_pat'];
    }

    # requires that we are able to connect to the database using are hidden php file
    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    $q = "SELECT * FROM HOSPITAL";
    $r = @mysqli_query($dbc, $q);

    $q = "SELECT * FROM DOCTOR WHERE doctor_id = $id";
    $r_doc = @mysqli_query($dbc, $q);
    $row_doc = mysqli_fetch_array($r_doc, MYSQLI_ASSOC);

    createDoctorForm($r, $row_doc);

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // errors array
        $errors = [];

        // checks for a first name
        if (empty($_POST['firstname'])) {
            $errors[] = 'You forgot to enter the doctor\'s first name.';
        } else {
            $first_name = mysqli_real_escape_string($dbc, trim($_POST['fName']));
        }

        // checks for a last name
        if (empty($_POST['lastname'])) {
            $errors[] = 'You forgot to enter the doctor\'s last name.';
        } else {
            $last_name = mysqli_real_escape_string($dbc, trim($_POST['lName']));
        }

        // checks for an address
        if (empty($_POST['docAddress'])) {
            $errors[] = 'You forgot to enter the client\'s address.';
        } else {
            $address = mysqli_real_escape_string($dbc, trim($_POST['docAddress']));
        }

        // checks for a phone number
        if (empty($_POST['docPhoneNum'])) {
            $errors[] = 'You forgot to enter the doctor\'s phone number.';
        } else {
            $phone_number = mysqli_real_escape_string($dbc, trim($_POST['docPhoneNum']));
        }

        // checks for an email
        if (empty($_POST['docEmail'])) {
            $errors[] = 'You forgot to enter the doctor\'s email.';
        } else {
            $email = mysqli_real_escape_string($dbc, trim($_POST['docEmail']));
        }

        // checks for the specialty
        if (empty($_POST['specialty'])) {
            $errors[] = 'You forgot to enter the doctor\'s specialty.';
        } else {
            $specialty = mysqli_real_escape_string($dbc, trim($_POST['specialty']));
        }

        // checks for the affiliations
        if (empty($_POST['affiliation'])) {
            $errors[] = 'You forgot to enter the doctor\'s affiliation(s).';
        } else {
            $affiliation[] = $_POST['affiliation'];
        }

        // checks if there were no errors
        if (empty($errors)) {

          // NOTE: id is coming through to here

            // updates doctor with new information
            $q = "UPDATE DOCTOR SET firstName = '$first_name' and lastName = '$last_name' and address = '$address', phoneNumber = '$phone_number', email = '$email', specialty = '$specialty' WHERE doctor_id = $id";
            $r = @mysqli_query($dbc, $q);

            foreach ($_POST['affiliation'] as $hospital_id) {
                // adds affiliation
                $q = "INSERT INTO AFFILIATION (doctor, hospital) VALUES ('$id', '$hospital_id')";
                $r = @mysqli_query($dbc, $q);
            }

            // adds primary doctor to patient info
            $q = "UPDATE PATIENT SET primaryDoctor = '$id' WHERE doctor_id = $id_pat";
            $r = @mysqli_query($dbc, $q);

        } else {

            # reports the errors
            echo '<p> The following error(s) occured:<br>';
            foreach ($errors as $msg) {
                echo " - $msg<br>\n";
            }
            echo '</p><p> Please try again. </p>';

        }

    }

    echo "<a href='home.php'>Go Back</a>";

    mysqli_close($dbc);
    include("footer.html");
?>
