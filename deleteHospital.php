<?php

    $page_title = "Delete Hospital";
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

    echo '<form action = "deleteHospital.php?id=' . $id . '&id_doc=' . $id_doc . '&id_pat=' . $id_pat . '" method = "post">';
        echo '<h3>Are you sure you want to delete the hospital, ' . $row_hospital['name'] . '?</h3>';
        echo '<input type="submit" name="submit" value="Confirm" id="submit"><br><br>';
    echo '</form>';

    echo '<a href="hospital.php?id_hos=' . $id . '&id_doc=' . $id_doc . '&id_pat=' . $id_pat . '">Cancel</a>';

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // deletes hospital information
        $q = "DELETE FROM HOSPITAL WHERE hospital_id = $id";
        $r = @mysqli_query($dbc, $q);

        // delete hospital's affiliations
        $q = "DELETE FROM HOSPITAL WHERE hospital = $id";
        $r = @mysqli_query($dbc, $q);

        mysqli_close($dbc);

        // redirects user back to hospital page
        $hospital_page = "http://shantim.smtchs.org/HealthOne_Medical/hospital.php?id_doc=" . $id_doc ."&id_hos=" . $id . "&id_pat=" . $id_pat;
        echo "<script type='text/javascript'>window.top.location='$hospital_page';</script>"; exit;

    }

    include("footer.html");
?>
