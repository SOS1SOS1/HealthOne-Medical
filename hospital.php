<?php

    $page_title = "Hospital Information";
    include('header.php');

    if (isset($_GET['id_doc']) && is_numeric($_GET['id_doc'])) {
        $id_doctor = $_GET['id_doc'];
    }
    if (isset($_GET['id_hos']) && is_numeric($_GET['id_hos'])) {
        $id = $_GET['id_hos'];
    }
    if (isset($_GET['id_pat']) && is_numeric($_GET['id_pat'])) {
        $id_patient = $_GET['id_pat'];
    }

    require_once('/moredata/shantim/etc/mysqli_connect_medical.php');

    $q = "SELECT * FROM HOSPITAL WHERE hospital_id = $id";
    $r = mysqli_query($dbc,$q);
    $results = mysqli_fetch_array($r, MYSQLI_ASSOC);

    echo '<h2>' . $results['name'];
    if ($_SESSION['user'] == "admin") {
        echo '<a href="editHospital.php?id=' . $id . '&id_doc=' . $id_doctor . '&id_pat=' . $id_patient . '"><span style="font-size:15px; padding-left: 20px;"">Edit</span></a>';
        echo '<a href="deleteHospital.php?id=' . $id . '&id_doc=' . $id_doctor . '&id_pat=' . $id_patient . '"><span style="font-size:15px; padding-left: 10px;"">Delete</span></a>';
    }
    echo '</h2>';
    echo '<p> Location: ' . $results['location'] . '</p>';
    echo '<p> Phone Number: ' . $results['phoneNumber'] . '</p>';

    echo '<a href="doctor.php?id_doc=' . $id_doctor . '&id_pat=' . $id_patient . '">Go back</a>';

    include("footer.html");

 ?>
