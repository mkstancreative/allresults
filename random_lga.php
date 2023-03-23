<?php
session_start();

require_once("./db/config.php");
require_once("./header.php");

// if (isset($_GET['party_abbreviation'])) {
//     $pdp = $_GET['party_abbreviation'];
// }





?>

<div class="container">
    <div>
        <h1>Select Polling Units By L.G.A </h1>
    </div>
    <div>
        <form action="process_lga.php" method="post">
            <select class="select_lga" name="selepoll" id="">
                <option hidden> Select Any L.G.A</option>
                <?php
                $query = "SELECT * FROM lga";
                $result =  mysqli_query($connect, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>
                        <option value="<?= $row['lga_id']  ?>"><?= $row['lga_name'] ?></option>

                <?php
                    }
                }
                ?>
            </select>
            <input type="submit" value="submit" name="submit" class="selec-btn">
        </form>
    </div>
</div>