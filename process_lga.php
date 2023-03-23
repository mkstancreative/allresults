<?php
session_start();

require_once("./db/config.php");
require_once("header.php");

?>


<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $selepoll = $_POST['selepoll'];
    // $lga_name = $_POST['lganame'];

    // echo $lga_name;

    $query1 = "SELECT * FROM lga WHERE lga_id = '$selepoll'";
    $result1 = mysqli_query($connect, $query1);
    if (mysqli_num_rows($result1) > 0) {
        $row = mysqli_fetch_assoc($result1);
        $lga_name = $row['lga_name'];
    }


    // die();

    $query = "SELECT * FROM polling_unit WHERE lga_id = '$selepoll'";
    $result = mysqli_query($connect, $query);

    $polling_name = [];

    $pdp_score = 0;
    $cdc_score = 0;
    $jp_score = 0;
    $ppa_score = 0;
    $acn_score = 0;
    $dpp_score = 0;
    $labo_score = 0;
    $anpp_score = 0;
    $cpp_score = 0;

    $pdp = "";
    $cdc = "";
    $jp = "";
    $ppa = "";
    $acn = "";
    $dpp = "";
    $labo = "";
    $anpp = "";
    $cpp = "";

    // $Allresult = "";

    if (mysqli_num_rows($result) > 0) {
        while ($row = mysqli_fetch_assoc($result)) {
            array_push($polling_name, $row['polling_unit_id']);
            // echo $polling_name;
        }
    }


    foreach ($polling_name as $pu) {

        $query = "SELECT * FROM `announced_pu_results` WHERE `polling_unit_uniqueid` = '$pu'";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

                // echo $row['party_abbreviation'];

                switch ($row['party_abbreviation']) {
                    case 'PDP':
                        $pdp_score += $row['party_score'];
                        $pdp = $row['party_abbreviation'];
                        break;
                    case 'CDC':
                        $cdc_score += $row['party_score'];
                        $cdc =  $row['party_abbreviation'];
                        break;
                    case 'JP':
                        $jp_score += $row['party_score'];
                        $jp = $row['party_abbreviation'];
                        break;
                    case 'PPA':
                        $ppa_score += $row['party_score'];
                        $ppa = $row['party_abbreviation'];
                        break;
                    case 'ACN':
                        $acn_score += $row['party_score'];
                        $acn = $row['party_abbreviation'];
                        break;
                    case 'DPP':
                        $dpp_score += $row['party_score'];
                        $dpp = $row['party_abbreviation'];
                        break;
                    case 'LABO':
                        $labo_score += $row['party_score'];
                        $labo = $row['party_abbreviation'];
                        break;
                    case 'CPP':
                        $cpp_score += $row['party_score'];
                        $cpp = $row['party_abbreviation'];
                        break;
                    case 'ANPP':
                        $anpp_score += $row['party_score'];
                        $anpp = $row['party_abbreviation'];
                        break;
                    default:
                }
            }
        }
    };
}

?>

<div class="container">
    <h1>Total Result for All Polling Units in <?= $lga_name ?></h1>
    <table>
        <thead>
            <th>Party Abbreviation</th>
            <th>Total Result</th>
        </thead>
        <tbody>
            <?php

            if ($pdp == "PDP" || $cdc == "CDC" || $jp == "JP" || $ppa == "PPA" || $acn == "ACN" || $dpp == "DPP" || $labo == "LABO" || $anpp == "ANPP" || $cpp == "CPP") {

            ?>
                <tr>
                    <td><?= $pdp ? $pdp : "No Record Found for PDP" ?></td>
                    <td><?= $pdp_score ? $pdp_score : "No Record Found for PDP"  ?></td>

                </tr>
                <tr>
                    <td><?= $cdc ? $cdc  : "No Record Found for CDC" ?></td>
                    <td><?= $cdc_score ? $cdc_score  : "No Record Found for CDC"  ?></td>

                </tr>
                <tr>
                    <td><?= $jp ? $jp  : "No Record Found for JP" ?></td>
                    <td><?= $jp_score ? $jp_score  : "No Record Found for JP" ?></td>

                </tr>
                <tr>
                    <td><?= $ppa ? $ppa : "No Record Found for PPA" ?></td>
                    <td><?= $ppa_score ? $ppa_score : "No Record Found for PPA"  ?></td>

                </tr>
                <tr>
                    <td><?= $acn ? $acn  : "No Record Found for ACN" ?></td>
                    <td><?= $acn_score ? $acn_score  : "No Record Found for ACN"  ?></td>

                </tr>
                <tr>
                    <td> <?= $dpp ? $dpp  : "No Record Found for DPP" ?> </td>
                    <td><?= $dpp_score ? $dpp_score : "No Record Found for DPP" ?></td>

                </tr>
                <tr>
                    <td> <?= $labo ? $labo  : "No Record Found for LABO"  ?></td>
                    <td><?= $labo_score ? $labo_score  : "No Record Found for LABO"   ?></td>

                </tr>
                <tr>
                    <td> <?= $anpp ? $anpp  : "No Record Found for ANPP"  ?></td>
                    <td><?= $anpp_score  ? $anpp_score  : "No Record Found for ANPP"  ?></td>

                </tr>
                <tr>
                    <td><?= $cpp ? $cpp  : "No Record Found for CPP" ?></td>
                    <td><?= $cpp_score ? $cpp_score : "No Record Found for CPP" ?></td>

                </tr>

            <?php
            } else {
            ?>
                <tr>
                    <td colspan="6" style="text-align: center;"> No Records Found For <?= $lga_name ?> L.G.A</td>
                </tr>

            <?php
            }

            ?>
        </tbody>
    </table>
</div>