<?php
require_once("./db/config.php");
require_once("./header.php");

?>

<div class="lga-container">
    <div>
        <h1>Select Your L.G.A </h1>
    </div>
    <div>
        <ul class="lga_wrapper">
            <?php
            $query = "SELECT * FROM lga";
            $result =  mysqli_query($connect, $query);
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {

            ?>
                    <li class="lga-items">
                        <a href="add_new_polling.php?newpollid=<?= $row['lga_id'] ?>" class="lga-link">
                            <?= $row['lga_name'] ?>
                        </a>
                    </li>

            <?php
                }
            }
            ?>
        </ul>
    </div>
</div>