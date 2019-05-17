<?php

    $page_title = "Delete Prescription";
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
    $q = "SELECT * FROM PRESCRIPTION WHERE prescript_id = $id";
    $r_pre = @mysqli_query($dbc, $q);
    $row_prescript = mysqli_fetch_array($r_pre, MYSQLI_ASSOC);

    // doctor and drug id
    $docID = $row_prescript['doctor_id'];
    $drugID = $row_prescript['drug_id'];

    // gets drug information
    $q = "SELECT * FROM DRUG WHERE drug_id = $drugID";
    $r_drug = @mysqli_query($dbc, $q);
    $row_drug = mysqli_fetch_array($r_drug, MYSQLI_ASSOC);

    echo '<form action = "deletePrescription.php?id=' . $id . '&id_pat=' . $id_pat . '" method = "post">';
        echo '<h3>Are you sure you want to delete the ' . $row_drug['name'] . ' prescription starting on ' . $row_prescript['startDate'] . ' and ending on ' . $row_prescript['endDate'] . '?</h3>';
        echo '<input type="submit" name="submit" value="Confirm" id="submit"><br><br>';
    echo '</form>';

    echo '<a href="patient.php?id=' . $id_pat . '">Cancel</a>';

    # checks that the form was submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {

        // deletes hospital information
        $q = "DELETE FROM PRESCRIPTION WHERE prescript_id = $id";
        $r = @mysqli_query($dbc, $q);

        mysqli_close($dbc);

        // redirects user back to patient page
        $patient_page = "http://shantim.smtchs.org/HealthOne_Medical/patient.php?id=" . $id_pat;
        echo "<script type='text/javascript'>window.top.location='$patient_page';</script>"; exit;

    }

    include("footer.html");
?>
