<?php

    $page_title = "Edit Hospital";
    include('header.php');

    # checks that there is an id and that it is a number
    if (isset($_GET['id']) && is_numeric($_GET['id'])) {  // from table.php
        $id = $_GET['id'];
    }
    if (isset($_GET['id_doc']) && is_numeric($_GET['id_doc'])) {  // from table.php
        $id_doc = $_GET['id_doc'];
    }
    if (isset($_GET['id_pat']) && is_numeric($_GET['id_pat'])) {  // from table.php
        $id_pat = $_GET['id_pat'];
    }

    // requires that we are able to connect to the database using are hidden php file
    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    // gets hospital information
    $q = "SELECT * FROM HOSPITAL WHERE hospital_id = $id";
    $r_hos = @mysqli_query($dbc, $q);
    $row_hospital = mysqli_fetch_array($r_hos, MYSQLI_ASSOC);

    echo '<form action = "editHospital.php?id=' . $id . '&id_doc=' . $id_doc . '&id_pat=' . $id_pat . '" method = "post">';
        echo '<h3>Name: <input type = "text" name = "name" size = "15" maxlength="30" value="' . $row_hospital['name'] . '"></h3>';
        echo '<h3>Location: <input type = "text" name = "location" size = "30" maxlength="50" value="' . $row_hospital['location'] . '"></h3>';
        echo '<h3>Phone Number: <input type="numbernumber" name = "phoneNumber" pattern="\d*" minLength="10" maxlength="10" value="' . $row_hospital['phoneNumber'] . '"></h3>';
        echo '<input type="submit" name="submit" value="Update Hospital" id="submit"><br><br>';
    echo '</form>';
    echo '<a href="hospital.php?id_hos=' . $id . '&id_doc=' . $id_doc . '&id_pat=' . $id_pat . '">Cancel</a>';

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // errors array
        $errors = [];

        // checks for a first name
        if (empty($_POST['name'])) {
            $errors[] = 'You forgot to enter the hospital\'s name.';
        } else {
            $name = mysqli_real_escape_string($dbc, trim($_POST['name']));
        }

        // checks for a last name
        if (empty($_POST['location'])) {
            $errors[] = 'You forgot to enter the hospital\'s location.';
        } else {
            $location = mysqli_real_escape_string($dbc, trim($_POST['location']));
        }

        // checks for an address
        if (empty($_POST['phoneNumber'])) {
            $errors[] = 'You forgot to enter the hospital\'s phone number.';
        } else {
            $phoneNum = mysqli_real_escape_string($dbc, trim($_POST['phoneNumber']));
        }

        if (empty($errors)) {

            // updates patient information
            $q = "UPDATE HOSPITAL SET name = '$name', location = '$location', phoneNumber = '$phoneNum' WHERE hospital_id = $id";
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
        $hospital_page = "http://shantim.smtchs.org/HealthOne_Medical/hospital.php?id_doc=" . $id_doc ."&id_hos=" . $id . "&id_pat=" . $id_pat;
        echo "<script type='text/javascript'>window.top.location='$hospital_page';</script>"; exit;

    }

    mysqli_close($dbc);
    include("footer.html");
?>
