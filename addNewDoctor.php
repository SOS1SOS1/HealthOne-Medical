<?php

    $page_title = "Add Doctor";
    include('header.php');

    // shows new doctor form
    function createDoctorForm($r_hospital) {
        echo '<form action = "addNewDoctor.php" method = "post">';
            echo '<label>First Name</label><input type="text" name="docFirst"><br>';
            echo '<label>Last Name</label><input type="text" name="docLast"><br>';
            echo '<label>Specialty</label><input type="text" name="docSpecialty" required><br>';
            echo '<label>Phone Number</label><input type="numbernumber" name = "docPhoneNum" pattern="\d*" minLength="10" maxlength="10" required><br>';
            echo '<label>Email</label><input type="email" name="docEmail" required><br>';
            echo '<label>Address</label><input type="text" name="docAddress" required><br>';
            foreach($r_hospital as $results){
                echo '<input type="checkbox" name="affiliation[]" value=' . $results['hospital_id'] . '> ' . $results['name'] . ' <br>';
            }
            echo '<input type="submit" name="submit" id="submit">';
        echo '</form>';
    }

    # requires that we are able to connect to the database using are hidden php file
    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    $q = "SELECT * FROM HOSPITAL";
    $r = @mysqli_query($dbc, $q);

    createDoctorForm($r);
    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // errors array
        $errors = [];
        // checks for a first name
        if (empty($_POST['docFirst'])) {
            $errors[] = 'You forgot to enter the doctor\'s first name.';
        } else {
            $first_name = mysqli_real_escape_string($dbc, trim($_POST['docFirst']));
        }
        // checks for a last name
        if (empty($_POST['docLast'])) {
            $errors[] = 'You forgot to enter the doctor\'s last name.';
        } else {
            $last_name = mysqli_real_escape_string($dbc, trim($_POST['docLast']));
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
        if (empty($_POST['docSpecialty'])) {
            $errors[] = 'You forgot to enter the doctor\'s specialty.';
        } else {
            $specialty = mysqli_real_escape_string($dbc, trim($_POST['docSpecialty']));
        }
        // checks for the affiliations
        if (empty($_POST['affiliation'])) {
            $errors[] = 'You forgot to enter the doctor\'s affiliation(s).';
        } else {
            $affiliation[] = $_POST['affiliation'];
        }

        $q = "SELECT COUNT(doctor_id) FROM DOCTOR where firstName = '$first_name' and lastName = '$last_name' and address = '$address' and phoneNumber = '$phone_number'";
        $r = @mysqli_query($dbc, $q);
        $row = mysqli_fetch_array($r, MYSQLI_NUM);
        $doctors = $row[0];

        // checks if the doctor already exists
        if ($doctors == 0) {

            // checks if there were no errors
            if (empty($errors)) {
                // updates doctor with new information
                $q = "INSERT INTO DOCTOR (firstName, lastName, address, phoneNumber, email, specialty) VALUES ('$first_name', '$last_name', '$address', '$phone_number', '$email', '$specialty')";
                $r = mysqli_query($dbc,$q);
                $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

                $q = "SELECT doctor_id FROM DOCTOR WHERE firstName = '$first_name' and lastName = '$last_name' and address = '$address' and email = '$email' and specialty = '$specialty' and phoneNumber = '$phone_number'";
                $r = mysqli_query($dbc,$q);
                $results = mysqli_fetch_array($r, MYSQLI_ASSOC);
                $idDoc = $results['doctor_id'];

                // adds doctor's affiliations
                foreach ($_POST['affiliation'] as $hospital_id) {
                    // adds affiliation
                    $q = "INSERT INTO AFFILIATION (doctor, hospital) VALUES ('$idDoc', '$hospital_id')";
                    $r = @mysqli_query($dbc, $q);
                }

                // redirects user to settings page
                $settings_page = "http://shantim.smtchs.org/HealthOne_Medical/settings.php";
                echo "<script type='text/javascript'>window.top.location='$settings_page';</script>"; exit;
            } else {
                # reports the errors
                echo '<p> The following error(s) occured:<br>';
                foreach ($errors as $msg) {
                    echo " - $msg<br>\n";
                }
                echo '</p><p> Please try again. </p>';
            }

        } else {

            echo '<p> The following error(s) occured:<br>';
            echo " - Doctor already exists.";

        }
    }
    echo "<br><a href='settings.php'>Go Back</a>";
    mysqli_close($dbc);
    include("footer.html");
?>
