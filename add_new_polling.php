<?php

require_once("./db/config.php");
require_once("header.php");

if (isset($_GET["newpollid"])) {
    $newpollid = $_GET['newpollid'];
    // echo "LGA ID =".$newpollid;
    // echo "<br>"; 
}
$msg = null;
if (isset($_GET['msg'])) {
    $msg = $_GET['msg'];
}



$query = "SELECT * FROM ward WHERE lga_id = '$newpollid'";
$result = mysqli_query($connect, $query);
if (mysqli_num_rows($result) > 0) {
    $row = mysqli_fetch_assoc($result);
    $wardid = $row['ward_id'];
    $uniqueid = $row['uniqueid'];
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $uniqueid = $_POST['uniqueid'];
    $newpollid = isset($_POST['newpollid']);
    $wardid = isset($_POST['wardid']) ? trim($_POST['wardid']) : "";
    $polling_num = isset($_POST['polling_num']) ? trim($_POST['polling_num']) : "";
    $polling_name = isset($_POST['polling_name']) ? trim($_POST['polling_name']) : "";
    $polling_desc = isset($_POST['polling_desc']) ? trim($_POST['polling_desc']) : "";
    $enteredby = isset($_POST['enteredby']) ? trim($_POST['enteredby']) : "";


    $ip = $_SERVER['REMOTE_ADDR'];
    $datetime = date('Y-m-d H:i:s');




    $query1 = "INSERT INTO polling_unit(uniquewardid, lga_id, ward_id,polling_unit_number, polling_unit_name, polling_unit_description, entered_by_user, user_ip_address, date_entered) VALUES ('$uniqueid', '$newpollid', '$wardid', '$polling_num', '$polling_name', '$polling_desc', '$enteredby', '$ip', '$datetime')";

    // echo $query1;
    // die();

    $result1 = mysqli_query($connect, $query1);
    if ($result1) {
        $msg = "Polling Unit Created Successfully";
    } else {
        $msg = "Something Went Wrong";
    }
}




?>
<div class="add-polling-unit-cont">
    <div style="background-color: black;color:white;">
        <?php if ($msg != "") echo "<p> $msg </p>" ?>
    </div>

    <center>Register A New Polling Unit</center>
    <form action="" method="POST" class="addpoll-form">
        <input type="text" hidden readonly name="uniqueid" value="<?= $uniqueid ?>">
        <input type="text" hidden readonly name="newpollid" value="<?= $newpollid ?>">

        <div class="form-group">
            <label for=""> Ward</label>
            <select name="wardid">
                <option hidden> Select Your Ward</option>
                <?php
                $query = "SELECT * FROM ward WHERE lga_id = '$newpollid'";
                $result = mysqli_query($connect, $query);
                if (mysqli_num_rows($result) > 0) {
                    while ($row = mysqli_fetch_assoc($result)) {

                ?>
                        <option value="<?= $row["ward_id"] ?>"><?= $row["ward_name"] ?></option>

                <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="form-group">
            <label for="">Polling Unit Number</label>
            <input type="text" placeholder="Polling Unit Number" name="polling_num">
        </div>
        <div class="form-group">
            <label for="">Polling Unit Name</label>
            <input type="text" placeholder="Polling Unit Name" name="polling_name">
        </div>
        <div class="form-group">
            <label for="">Polling Unit Description</label>
            <input type="text" placeholder="Polling Unit Description" name="polling_desc">
        </div>
        <div class="form-group">
            <label for="">Entered By User</label>
            <input type="text" placeholder="Entered By" name="enteredby">
        </div>

        <div class="form-group">

        </div>
        <input type="submit" value="Submit">
    </form>
</div>