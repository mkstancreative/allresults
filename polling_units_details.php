<?php
require_once("./db/config.php");
require_once("./header.php");

if (isset($_GET["pollunitid"])) {
    $id = $_GET["pollunitid"];
}


?>

<div style="text-align: center;">
    <h1 style="margin-bottom: 1rem;">Results for Polling Units</h1>
</div>
<table>
    <thead>
        <th>Party Abbreviation</th>
        <th>Party Score</th>
        <th>Result Entered By</th>
    </thead>
    <tbody>
        <?php
        $query = "SELECT * FROM announced_pu_results WHERE polling_unit_uniqueid = '$id'";
        $result = mysqli_query($connect, $query);
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {

        ?>

                <tr>
                    <td><?= $row["party_abbreviation"] ?></td>
                    <td><?= $row["party_score"] ?></td>
                    <td><?php echo $row["entered_by_user"] ? $row["entered_by_user"] : "No Record" ?></td>
                </tr>

            <?php
            }
        } else {
            ?>
            <tr>
                <td colspan="6" style="text-align: center;"> No Records Found For This Polling Unit</td>
            </tr>

        <?php
        }
        ?>
    </tbody>
</table>