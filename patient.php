<!DOCTYPE html>
<html>
  <head>
    <title> Patient Info </title>
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

    function createAddForm($r_drug, $r_doctor, $patient_id) {
        echo '<form action = "patient.php?id=' .  $patient_id . '" method = "post">';
            echo '<h3>Drug Name: ';
            echo '<select name="drug">';
                foreach($r_drug as $results) {
                    echo '<option value = ' . $results['name'] . '>' . $results['name'] . '</option>';
                }
            echo '</select></h3>';
            echo '<h3>Description: <input type = "text" name = "desc" size = "30" maxlength="100"></h3>';
            echo '<h3>Start Date: <input type = "date" name = "startDate" value = "2019-01-01"></h3>';
            echo '<h3>End Date: <input type = "date" name = "endDate" value = "2019-01-01"></h3>';
            echo '<h3>Dosage: <input type="text" name = "dosage" maxlength="25"></h3>';
            echo '<h3>Duration: <input type = "text" name = "duration" size = "25" maxlength="30"></h3>';
            echo '<h3>Size: <input type="number" name = "size" pattern="\d*" minLength="1" maxlength="5"></h3>';
            echo '<h3>Number of Refills: <input type="text" name = "refills" pattern="\d*" minLength="1" maxlength="5"></h3>';
            echo '<h3>Prescribed by: ';
            echo '<select name="doctor">';
                foreach($r_doctor as $results) {
                    echo '<option value = ' . $results['doctor_id'] . '>' . $results['firstName'] . ' ' . $results['lastName'] . '</option>';
                }
            echo '</select></h3>';

            echo '<h3><input id = "submit" type = "submit" name = "submit" value = "Add Prescription"></h3>';
        echo '</form>';
        echo '<a href="patient.php?id=' . $patient_id . '">Cancel</a>';
    }

    function createEditForm($row_patient, $r_doctor, $row_insurance, $primary_doc) {
        echo '<form action = "edit.php?id=' . $row_patient['patient_id'] . '" method = "post">';
            echo '<h3>First Name: <input type = "text" name = "fName" size = "15" maxlength="30" value="' . $row_patient['firstName'] . '"></h3>';
            echo '<h3>Last Name: <input type = "text" name = "lName" size = "15" maxlength="30" value="' . $row_patient['lastName'] . '"></h3>';
            echo '<h3>Address: <input type = "text" name = "address" size = "30" maxlength="50" value="' . $row_patient['address'] . '"></h3>';
            echo '<h3>Phone Number: <input type="numbernumber" name = "pNum" pattern="\d*" minLength="10" maxlength="10" value="' . $row_patient['phoneNumber'] . '"></h3>';
            echo '<h3>Email: <input type = "email" name = "email" size = "25" maxlength="30" value="' . $row_patient['email'] . '"></h3>';
            echo '<h3>Primary Doctor: ';
            echo '<select name="doctor">';
                foreach($r_doctor as $results) {
                    if ($primary_doc['doctor_id'] == $results['doctor_id']) {
                        echo '<option selected = "selected" value = ' . $results['doctor_id'] . '>' . $results['firstName'] . ' ' . $results['lastName'] . '</option>';
                    } else {
                        echo '<option value = ' . $results['doctor_id'] . '>' . $results['firstName'] . ' ' . $results['lastName'] . '</option>';
                    }
                }
            echo '</select></h3>';
            echo '<h3>Level of Coverage: ';
            echo '<select name = "coverage" value="' . $row_insurance['name'] . '">';
                if ($row_insurance['name'] == "Bronze") {
                   echo '<option value = "Bronze" selected="selected">Bronze</option>';
                } else {
                  echo '<option value = "Bronze">Bronze</option>';
                }
                if ($row_insurance['name'] == "Silver") {
                   echo '<option value = "Silver" selected="selected">Silver</option>';
                } else {
                  echo '<option value = "Silver">Silver</option>';
                }
                if ($row_insurance['name'] == "Gold") {
                   echo '<option value = "Gold" selected="selected">Gold</option>';
                } else {
                  echo '<option value = "Gold">Gold</option>';
                }
            echo '</select></h3>';
            echo '<a href="home.php"> <input type="submit" name="submit" value="Update Client" id="submit"></a><br><br>';
        echo '</form>';
        echo '<a href="patient.php?id=' . $row_patient['patient_id'] . '">Cancel</a>';
    }

    function createDeleteForm($patient) {
        echo '<form action = "delete.php?id=' .  $patient['patient_id'] . '" method = "post">';
            echo '<h3>Are you sure you want to delete client, ' . $patient['firstName'] . ' ' . $patient['lastName'] . '?</h3>';

            echo '<h3><input id = "submit" type = "submit" name = "submit" value = "Confirm"></h3>';
        echo '</form>';

        echo '<a href="patient.php?id=' . $patient['patient_id'] . '">Cancel</a>';
    }

    function createNewVisitForm($r_doctor, $patient_id) {
        echo '<form action = "addVisit.php?id=' .  $patient_id . '" method = "post">';
            echo '<h3>Date: <input type = "date" name = "visitDate" value = "2019-01-01"></h3>';

            echo '<h3>Type of Visit: ';
            echo '<select name="type">';
                echo '<option value = "New Issue">New Issue</option>';
                echo '<option value = "Follow-Up">Follow-Up</option>';
                echo '<option value = "Checkup">Checkup</option>';
            echo '</select></h3>';

            echo '<h3>Doctor: ';
            echo '<select name="doctor">';
                foreach($r_doctor as $results) {
                    echo '<option value = ' . $results['doctor_id'] . '>' . $results['firstName'] . ' ' . $results['lastName'] . '</option>';
                }
            echo '</select></h3>';

            echo '<h3>Status: <input type = "text" name = "status" size = "30" maxlength="50"></h3>';
            echo '<h3>Diagnosis: <input type="text" name = "diagnosis" size = 30; maxlength="75"></h3>';

            echo '<h3>Current Blood Pressure: <input type = "text" name = "bloodPressure" size = "10" maxlength="20"></h3>';
            echo '<h3>Height: <input type="text" name = "height" size = 10; maxlength="15"></h3>';
            echo '<h3>Weight: <input type="text" name = "weight" size = 10; maxlength="15"></h3>';

            echo '<h3><input id = "submit" type = "submit" name = "submit" value = "Add Visit"></h3>';
        echo '</form>';
        echo '<a href="patient.php?id=' . $patient_id . '">Cancel</a>';
    }

    # checks that there is an id and that it is a number
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {
        $id = $_GET['id'];
    }
    if (isset($_GET['add']) && is_numeric($_GET['add'])) {
        $addPrescription = true;
    } else {
        $addPrescription = false;
    }
    if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
        $editClient = true;
    } else {
        $editClient = false;
    }
    if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
        $deleteClient = true;
    } else {
        $deleteClient = false;
    }
    if (isset($_GET['new']) && is_numeric($_GET['new'])) {
        $newVisit = true;
    } else {
        $newVisit = false;
    }

    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    if ($addPrescription == true) {

        $q = "SELECT * FROM DRUG";
        $r_drug = @mysqli_query($dbc, $q);
        $q = "SELECT * FROM DOCTOR";
        $r_doc = @mysqli_query($dbc, $q);
        createAddForm($r_drug, $r_doc, $id);

    } else {

        // brings up edit client form
        if ($editClient == true) {

            // gets client information
            $q = "SELECT * FROM PATIENT WHERE patient_id = $id";
            $r_pat = @mysqli_query($dbc, $q);
            $row_patient = mysqli_fetch_array($r_pat, MYSQLI_ASSOC);

            // gets primary doctor id from client row
            $primary_doc_id = $row_patient['primaryDoctor'];
            // gets primary doctor first and last name
            $q = "SELECT * FROM DOCTOR WHERE doctor_id = $primary_doc_id";
            $r_primary_doc = @mysqli_query($dbc, $q);
            $primary_doc = mysqli_fetch_array($r_primary_doc, MYSQLI_ASSOC);

            // gets all doctors
            $q = "SELECT * FROM DOCTOR";
            $r_doc = @mysqli_query($dbc, $q);

            // sets coverage id to client id
            $coverage_id = $id;
            $q = "SELECT * FROM INSURANCE WHERE insurance_id = $coverage_id";
            $r_insur = @mysqli_query($dbc, $q);
            $row_insurance = mysqli_fetch_array($r_insur, MYSQLI_ASSOC);
            createEditForm($row_patient, $r_doc, $row_insurance, $primary_doc);

        } else {

            if ($deleteClient == true) {

              // gets client information
              $q = "SELECT * FROM PATIENT WHERE patient_id = $id";
              $r_pat = @mysqli_query($dbc, $q);
              $row_patient = mysqli_fetch_array($r_pat, MYSQLI_ASSOC);

              createDeleteForm($row_patient);

            } else {

                if ($newVisit == true) {

                    // gets all doctors
                    $q = "SELECT * FROM DOCTOR";
                    $r_doc = @mysqli_query($dbc, $q);

                    createNewVisitForm($r_doc, $id);

                } else {

                    // gets client information
                    $q = "SELECT * FROM PATIENT where patient_id = $id";
                    $r = mysqli_query($dbc,$q);
                    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);
                    $docID = $results['primaryDoctor'];

                    //echo '<div style = "">';
                    echo '<h2>' . $results['firstName'] . ' ' . $results['lastName'];
                    echo '<a href="patient.php?id=' . $id . '&edit=1"><span style="font-size:15px; padding-left: 20px;"">Edit</span></a>';
                    echo '<a href="patient.php?id=' . $id . '&delete=1"><span style="font-size:15px; padding-left: 10px;"">Delete</span></a></h2>';

                    echo '<p> Address: ' . $results['address'] . '</p>';
                    echo '<p> Phone Number: ' . $results['phoneNumber'] . '</p>';
                    echo '<p> Email: ' . $results['email'] . '</p>';

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

                    echo '<p> Prescription(s): </p>';echo '<ul>';
                    foreach($r as $row) {
                        echo '<li><strong>' . $row['name'] . '</strong> (<em>' . $row['description'] . '</em>)';
                          echo '<a href="editPrescription.php?id=' . $row['prescript_id'] . '&id_doc=' . $id . '&id_pat=' . $id . '"><span style="font-size:15px; padding-left: 20px;"">Edit</span></a>';
                          echo '<a href="deletePrescription.php?id=' . $row['prescript_id'] . '&id_doc=' . $id . '&id_pat=' . $id . '"><span style="font-size:15px; padding-left: 10px;"">Delete</span></a></h2>';
                          echo '<ul>';
                          echo '<li> Purpose - ' . $row['purpose'] . '</li>';
                          echo '<li> Possible Side Effects - ' . $row['sideEffects'] . '</li>';
                          echo '<li> Start Date: ' . $row['startDate'] . '</li>';
                          echo '<li> End Date: ' . $row['endDate'] . '</li>';
                          echo '<li> Dosage - ' . $row['dosage'] . '</li>';
                          echo '<li> Duration - ' . $row['duration'] . '</li>';
                          echo '<li> Size - ' . $row['size'] . '</li>';
                          echo '<li> Number of Refills - ' . $row['numRefill'] . '</li>';

                          $prescription_doctor = $row['doctor_id'];
                          $q = "SELECT DOCTOR.firstName, DOCTOR.lastName FROM DOCTOR where doctor_id = '$prescription_doctor'";
                          $r2 = mysqli_query($dbc,$q);
                          $results = mysqli_fetch_array($r2, MYSQLI_ASSOC);
                          echo '<li> Prescribed by - ' . $results['firstName'] . ' ' . $results['lastName'] . '</li>';
                        echo '</ul></li>';
                    }
                    echo '</ul>';
                    echo '<a href="patient.php?id=' . $id . '&add=1">Add New Prescription</a><br>';

                    $q = "SELECT * FROM VISIT INNER JOIN PATIENT ON VISIT.patient_id = PATIENT.patient_id WHERE VISIT.patient_id = $id";
                    $r = mysqli_query($dbc,$q);
                    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

                    echo '<p> Visit(s): </p>';
                    echo '<ul>';
                    foreach($r as $row) {
                        echo '<li><strong>' . $row['type'] . '</strong> (<em>' . $row['visitDate'] . '</em>)';
                          echo '<a href="editVisit.php?id=' . $row['visit_id'] . '&id_doc=' . $id . '&id_pat=' . $id . '"><span style="font-size:15px; padding-left: 20px;"">Edit</span></a>';
                          echo '<a href="deleteVisit.php?id=' . $row['visit_id'] . '&id_doc=' . $id . '&id_pat=' . $id . '"><span style="font-size:15px; padding-left: 10px;"">Delete</span></a></h2>';
                          echo '<ul>';
                          if ($row['diagnosis'] != '') {
                              echo '<li> Diagnosis - ' . $row['diagnosis'] . '</li>';
                          }
                          if ($row['status'] != '') {
                              echo '<li> Status - ' . $row['status'] . '</li>';
                          }
                          if ($row['bloodPressure'] != '') {
                              echo '<li> Blood Pressure - ' . $row['bloodPressure'] . '</li>';
                          }
                          if ($row['height'] != '') {
                              echo '<li> Height - ' . $row['height'] . '</li>';
                          }
                          if ($row['weight'] != '') {
                              echo '<li> Weight - ' . $row['weight'] . '</li>';
                          }
                          $doc = $row['doctor_id'];
                          $q = "SELECT * FROM DOCTOR WHERE doctor_id = $doc";
                          $r = mysqli_query($dbc,$q);
                          $results = mysqli_fetch_array($r, MYSQLI_ASSOC);
                          echo '<li> Doctor - ' . $results['firstName'] . ' ' . $results['lastName'] . '</li>';
                        echo '</ul></li>';
                    }
                    echo '</ul>';
                    echo '<a href="patient.php?id=' . $id . '&new=1">Add New Visit</a><br><br>';

                    echo "<a href='home.php'>Go Back</a><br><br>";

                }

            }

        }
    }

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

        if (isset($_GET['id'])) {
            $id_pat = $_GET['id'];
        }

        if (empty($errors)) {
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
                    // inserts the new patient
                    $q = "INSERT INTO PRESCRIPTION (patient_id, doctor_id, drug_id, description, startDate, endDate, dosage, duration, size, numRefill) VALUES ('$id_pat', '$id_doc', '$drugID', '$desc', '$start_date',  '$end_date', '$dosage', '$duration', '$size', '$refills')";
                    $r = @mysqli_query($dbc, $q);
                } else {
                    echo '<p> The following error(s) occured:<br>';
                    echo " - Prescription already exists.";
                }

            } else {
                  echo '<p> The following error(s) occured:<br>';
                  echo " - Drug does not exist.";
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

    }

    include("footer.html");
 ?>
