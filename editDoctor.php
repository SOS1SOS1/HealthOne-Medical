<!DOCTYPE html>
<html>
  <head>
    <title> Edit Doctor </title>
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
    if (isset($_GET['id_doc']) && is_numeric($_GET['id_doc'])) {
        $id_doc = $_GET['id_doc'];
    }
    if (isset($_GET['id_pat']) && is_numeric($_GET['id_pat'])) {
        $id_pat = $_GET['id_pat'];
    }

    // requires that we are able to connect to the database using are hidden php file
    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    // gets doctor information
    $q = "SELECT * FROM DOCTOR WHERE doctor_id = $id_doc";
    $r_doc = @mysqli_query($dbc, $q);
    $row_doctor = mysqli_fetch_array($r_doc, MYSQLI_ASSOC);

    // gets hospitals
    $q = "SELECT * FROM HOSPITAL";
    $r_hospital = @mysqli_query($dbc, $q);

    // gets doctor's affiliations
    $q = "SELECT hospital FROM AFFILIATION WHERE doctor = $id_doc";
    $r_affil = @mysqli_query($dbc, $q);

    echo '<form action = "editDoctor.php?id_doc=' . $id_doc . '&id_pat=' . $id_pat . '" method = "post">';
        echo '<h3>First Name: <input type="text" name="docFirst" value = ' . $row_doctor['firstName'] . '></h3>';
        echo '<h3>Last Name: <input type="text" name="docLast" value = ' . $row_doctor['lastName'] . '></h3>';
        echo '<h3>Specialty: <input type="text" name="docSpecialty" value = ' . $row_doctor['specialty'] . ' required></h3>';
        echo '<h3>Phone Number: <input type="numbernumber" name = "docPhoneNum" pattern="\d*" value = ' . $row_doctor['phoneNumber'] . ' minLength="10" maxlength="10" required></h3>';
        echo '<h3>Email: <input type="email" name="docEmail" size = "25" value = ' . $row_doctor['email'] . ' required></h3>';
        echo '<h3>Address: <input type = "text" name = "docAddress" size = "30" maxlength="50" value="' . $row_doctor['address'] . '"></h3>';
        foreach($r_hospital as $results){
            $affiliated = false;
            foreach($r_affil as $affiliation) {
                // if the doctor is affiliated with the hospital print it out with a checked checkbox
                if ($results['hospital_id'] == $affiliation['hospital']) {
                    $affiliated = true;
                    echo '<input type="checkbox" name="affiliation[]" checked = "checked" value=' . $results['hospital_id'] . '> ' . $results['name'] . ' <br>';
                }
            }
            if ($affiliated == false) {
                echo '<input type="checkbox" name="affiliation[]" value=' . $results['hospital_id'] . '> ' . $results['name'] . ' <br>';
            }
        }
        echo '<input type="hidden" name = "idPat" value=' . $id_pat . '>';
        echo '<input type="hidden" name = "idDoc" value=' . $id_doc . '>';
        echo '<input type="submit" name="submit" id="submit">';
    echo '</form>';
    echo '<a href="doctor.php?id_doc=' . $id_doc . '&id_pat=' . $id_pat . '">Cancel</a>';

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // errors array
        $errors = [];

        // checks for a first name
        if (empty($_POST['docFirst'])) {
            $errors[] = 'You forgot to enter the hospital\'s name.';
        } else {
            $first_name = mysqli_real_escape_string($dbc, trim($_POST['docFirst']));
        }

        // checks for a last name
        if (empty($_POST['docLast'])) {
            $errors[] = 'You forgot to enter the hospital\'s location.';
        } else {
            $last_name = mysqli_real_escape_string($dbc, trim($_POST['docLast']));
        }

        // checks for an specialty
        if (empty($_POST['docSpecialty'])) {
            $errors[] = 'You forgot to enter the hospital\'s phone number.';
        } else {
            $specialty = mysqli_real_escape_string($dbc, trim($_POST['docSpecialty']));
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

        // checks for the affiliations
        if (empty($_POST['affiliation'])) {
            $errors[] = 'You forgot to enter the doctor\'s affiliation(s).';
        } else {
            $affiliation[] = $_POST['affiliation'];
        }

        // checks for the doctor id
        if (empty($_POST['idDoc'])) {
            $errors[] = 'Couldn\'t find doctor\'s id.';
        } else {
            $idDoc = $_POST['idDoc'];
        }

        // checks for the patient id
        if (empty($_POST['idPat'])) {
            $errors[] = 'Couldn\'t find client\'s id.';
        } else {
            $idPat = $_POST['idPat'];
        }

        if (empty($errors)) {        

            // updates doctor information
            $q = "UPDATE DOCTOR SET firstName = '$first_name', lastName = '$last_name', specialty = '$specialty', address = '$address', phoneNumber = '$phone_number', email = '$email' WHERE doctor_id = $idDoc";
            $r = @mysqli_query($dbc, $q);

            // deletes all affiliations
            $q = "DELETE FROM AFFILIATION WHERE doctor = $id_doc";
            $r = @mysqli_query($dbc, $q);

            // creates new affiliations
            foreach ($_POST['affiliation'] as $hospital_id) {
                $q = "INSERT INTO AFFILIATION (doctor, hospital) VALUES ('$id_doc', '$hospital_id')";
                $r = @mysqli_query($dbc, $q);
            }

        } else {

            # reports the errors
            echo '<p> The following error(s) occured:<br>';
            foreach ($errors as $msg) {
                echo " - $msg<br>\n";
            }
            echo '</p><p> Please try again. </p>';

        }

        // redirects user back to client page
        $doctor_page = "http://shantim.smtchs.org/HealthOne_Medical/doctor.php?id_doc=" . $id_doc . "&id_pat=" . $id_pat;
        echo "<script type='text/javascript'>window.top.location='$doctor_page';</script>"; exit;

    }

    mysqli_close($dbc);
    include("footer.html");
?>
