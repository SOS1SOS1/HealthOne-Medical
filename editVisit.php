<?php

    $page_title = "Edit Visit";
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

    // gets visit information
    $q = "SELECT * FROM VISIT WHERE visit_id = $id";
    $r_vis = @mysqli_query($dbc, $q);
    $row_visit = mysqli_fetch_array($r_vis, MYSQLI_ASSOC);
    $docID = $row_visit['doctor_id'];

    // gets doctors
    $q = "SELECT * FROM DOCTOR";
    $r_doc = @mysqli_query($dbc, $q);
    $row_doctor = mysqli_fetch_array($r_doc, MYSQLI_ASSOC);

    echo '<form action = "editVisit.php?id=' . $id .  '&id_pat=' .  $id_pat . '" method = "post">';
        echo '<h3>Date: <input type = "date" name = "visitDate" value = ' . $row_visit['visitDate'] . '></h3>';

        echo '<h3>Type of Visit: ';
        echo '<select name="type">';
            if ($row_visit['type'] == "New Issue") {
               echo '<option value = "New Issue" selected="selected">New Issue</option>';
            } else {
              echo '<option value = "New Issue">New Issue</option>';
            }
            if ($row_visit['type'] == "Follow-Up") {
               echo '<option value = "Follow-Up" selected="selected">Follow-Up</option>';
            } else {
              echo '<option value = "Follow-Up">Follow-Up</option>';
            }
            if ($row_visit['type'] == "Checkup") {
               echo '<option value = "Checkup" selected="selected">Checkup</option>';
            } else {
              echo '<option value = "Checkup">Checkup</option>';
            }
        echo '</select></h3>';

        echo '<h3>Doctor: ';
        echo '<select name="doctor">';
            foreach($r_doc as $results) {
                if ($row_visit['doctor_id'] == $results['doctor_id']) {
                    echo '<option selected = "selected" value = ' . $results['doctor_id'] . '>' . $results['firstName'] . ' ' . $results['lastName'] . '</option>';
                } else {
                    echo '<option value = ' . $results['doctor_id'] . '>' . $results['firstName'] . ' ' . $results['lastName'] . '</option>';
                }
            }
        echo '</select></h3>';

        echo '<h3>Status: <input type = "text" name = "status" size = "30" maxlength="50" value = "' . $row_visit['status'] . '"></h3>';
        echo '<h3>Diagnosis: <input type="text" name = "diagnosis" value = "' . $row_visit['diagnosis'] . '" size = 30; maxlength="75"></h3>';

        if (!(empty($row_visit['bloodPressure']))) {
            echo '<h3>Current Blood Pressure: <input type="text" name = "bloodPressure" value = "' . $row_visit['bloodPressure'] . '" size = 10; maxlength="15"></h3>';
        } else {
            echo '<h3>Current Blood Pressure: <input type="text" name = "bloodPressure" size = 10; maxlength="15"></h3>';
        }
        if (!(empty($row_visit['height']))) {
            echo '<h3>Height: <input type="text" name = "height" value = "' . $row_visit['height'] . '" size = 10; maxlength="15"></h3>';
        } else {
            echo '<h3>Height: <input type="text" name = "height" size = 10; maxlength="15"></h3>';
        }
        if (!(empty($row_visit['weight']))) {
            echo '<h3>Weight: <input type="text" name = "weight" value = "' . $row_visit['weight'] . '" size = 10; maxlength="15"></h3>';
        } else {
            echo '<h3>Weight: <input type="text" name = "weight" size = 10; maxlength="15"></h3>';
        }

        echo '<h3><input id = "submit" type = "submit" name = "submit" value = "Update Visit"></h3>';
    echo '</form>';
    echo '<a href="patient.php?id=' . $id_pat . '">Cancel</a>';

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // errors array
        $errors = [];

        // checks for a the date of the visit
        if (empty($_POST['visitDate'])) {
            $errors[] = 'You forgot to enter the date of the visit.';
        } else {
            $date = mysqli_real_escape_string($dbc, trim($_POST['visitDate']));
        }

        // checks for the doctor
        if (empty($_POST['doctor'])) {
            $errors[] = 'You forgot to enter the doctor the visit was with.';
        } else {
            $doc = mysqli_real_escape_string($dbc, trim($_POST['doctor']));
        }

        // checks for the type of the visit
        if (empty($_POST['type'])) {
            $errors[] = 'You forgot to enter the type of the visit.';
        } else {
            $type = mysqli_real_escape_string($dbc, trim($_POST['type']));

            // checks the type of visit to see what other information should have been included
            if ($type == "New Issue") {

                // checks for a initial diagnosis
                if (empty($_POST['diagnosis'])) {
                    $errors[] = 'You forgot to enter the initial diagnosis of the prescription.';
                } else {
                    $diagnosis = mysqli_real_escape_string($dbc, trim($_POST['diagnosis']));
                }

            } else if ($type == "Follow-Up") {

                // checks for a status
                if (empty($_POST['diagnosis'])) {
                    $errors[] = 'You forgot to enter the status at this visit.';
                } else {
                    $status = mysqli_real_escape_string($dbc, trim($_POST['status']));
                }

                // checks for a diagnosis
                if (empty($_POST['diagnosis'])) {
                    $errors[] = 'You forgot to enter the initial diagnosis at the visit.';
                } else {
                    $diagnosis = mysqli_real_escape_string($dbc, trim($_POST['diagnosis']));
                }

            } else if ($type == "Checkup") {

                // checks for the current blood pressure
                if (empty($_POST['bloodPressure'])) {
                    $errors[] = 'You forgot to enter the client\'s blood pressure at the visit.';
                } else {
                    $pressure = mysqli_real_escape_string($dbc, trim($_POST['bloodPressure']));
                }

                // checks for a height
                if (empty($_POST['height'])) {
                    $errors[] = 'You forgot to enter the client\'s height at the visit.';
                } else {
                    $height = mysqli_real_escape_string($dbc, trim($_POST['height']));
                }

                // checks for a weight
                if (empty($_POST['weight'])) {
                    $errors[] = 'You forgot to enter the client\'s weight at the visit.';
                } else {
                    $weight = mysqli_real_escape_string($dbc, trim($_POST['weight']));
                }

            }
        }

        if (empty($errors)) {

            // updates visit information
            $q = "UPDATE VISIT SET doctor_id = '$doc', visitDate = '$date', type = '$type', diagnosis = '$diagnosis', status = '$status', bloodPressure = '$pressure', height = '$height', weight = '$weight' WHERE visit_id = $id";
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
