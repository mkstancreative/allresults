<?php
require_once("./db/config.php");
require_once("./header.php");
?>

<div class="poll-container">
    <div>
        <h1>List of All Polling Units</h1>
    </div>
    <div class="polling_units">

        <ul>
            <?php
            $query = "SELECT * FROM polling_unit ORDER BY polling_unit_id DESC";
            $result = mysqli_query($connect, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

            ?>
                    <li style="display: inline-block;" class="poll_unit_list">
                        <a href="polling_units_details.php?pollunitid=<?= $row["polling_unit_id"] ?>"><?= $row['polling_unit_name'] ?></a>

                    </li>

            <?php
                }
            }

            ?>

        </ul>

    </div>
</div>