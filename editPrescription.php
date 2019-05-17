<?php

    $page_title = "Edit Prescription";
    include('header.php');

    # checks that there is an id and that it is a number
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    }
    if (isset($_GET['id_doc']) && is_numeric($_GET['id_doc'])) {
        $id_doc = $_GET['id_doc'];
    }
    if (isset($_GET['id_pat']) && is_numeric($_GET['id_pat'])) {
        $id_pat = $_GET['id_pat'];
    }

    // requires that we are able to connect to the database using are hidden php file
    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    // gets drug information
    $q = "SELECT * FROM PRESCRIPTION WHERE prescript_id = $id";
    $r_pre = @mysqli_query($dbc, $q);
    $row_prescript = mysqli_fetch_array($r_pre, MYSQLI_ASSOC);
    $docID = $row_prescript['doctor_id'];
    $drugID = $row_prescript['drug_id'];

    // gets doctors
    $q = "SELECT * FROM DOCTOR";
    $r_doc = @mysqli_query($dbc, $q);
    $row_doctor = mysqli_fetch_array($r_doc, MYSQLI_ASSOC);

    // gets drugs
    $q = "SELECT * FROM DRUG";
    $r_drug = @mysqli_query($dbc, $q);

    echo '<form action = "editPrescription.php?id=' .  $id . '&id_pat=' . $id_pat . '" method = "post">';
        echo '<h3>Drug Name: ';
        echo '<select name="drug">';
            foreach($r_drug as $results) {
                if ($drugID == $results['drug_id']) {
                    echo '<option selected = "selected" value = ' . $results['drug_id'] . '>' . $results['name'] . '</option>';
                } else {
                    echo '<option value = ' . $results['drug_id'] . '>' . $results['name'] . '</option>';
                }
            }
        echo '</select></h3>';
        echo '<h3>Description: <input type = "text" name = "desc" value = "' . $row_prescript['description'] . '" size = "30" maxlength="100"></h3>';
        echo '<h3>Start Date: <input type = "date" name = "startDate" value = "' . $row_prescript['startDate'] . '" value = "2019-01-01"></h3>';
        echo '<h3>End Date: <input type = "date" name = "endDate" value = "' . $row_prescript['endDate'] . '" value = "2019-01-01"></h3>';
        echo '<h3>Dosage: <input type="text" name = "dosage" value = "' . $row_prescript['dosage'] . '" maxlength="25"></h3>';
        echo '<h3>Duration: <input type = "text" name = "duration" value = "' . $row_prescript['duration'] . '" size = "25" maxlength="30"></h3>';
        echo '<h3>Size: <input type="number" name = "size" value = "' . $row_prescript['size'] . '" pattern="\d*" minLength="1" maxlength="5"></h3>';
        echo '<h3>Number of Refills: <input type="text" name = "refills" value = "' . $row_prescript['numRefill'] . '" pattern="\d*" minLength="1" maxlength="5"></h3>';
        echo '<h3>Prescribed by: ';
        echo '<select name="doctor">';
            foreach($r_doc as $results) {
                if ($docID == $results['doctor_id']) {
                    echo '<option selected = "selected" value = ' . $results['doctor_id'] . '>' . $results['firstName'] . ' ' . $results['lastName'] . '</option>';
                } else {
                    echo '<option value = ' . $results['doctor_id'] . '>' . $results['firstName'] . ' ' . $results['lastName'] . '</option>';
                }
            }
        echo '</select></h3>';

        echo '<h3><input id = "submit" type = "submit" name = "submit" value = "Edit Prescription"></h3>';
    echo '</form>';
    echo '<a href="patient.php?id=' . $id_pat . '">Cancel</a><br><br>';

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

        // checks for a doctor name
        if (empty($_POST['doctor'])) {
            $errors[] = 'You forgot to enter the name of the doctor who prescribed the drug.';
        } else {
            $id_doc = mysqli_real_escape_string($dbc, trim($_POST['doctor']));
        }

        if (empty($errors)) {

            // updates prescription information
            $q = "UPDATE PRESCRIPTION SET doctor_id = '$id_doc', drug_id = '$drug', description = '$desc', startDate = '$start_date', endDate = '$end_date', dosage = '$dosage', duration = '$duration', size = '$size', numRefill = '$refills' WHERE prescript_id = $id";
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
        $patient_page = "http://shantim.smtchs.org/HealthOne_Medical/patient.php?id=" . $id_pat;
        echo "<script type='text/javascript'>window.top.location='$patient_page';</script>"; exit;

    }

    mysqli_close($dbc);
    include("footer.html");
?>
