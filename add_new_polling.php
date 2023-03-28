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
    $polling_name = isset($_POST['polling_name']) ? trim($_POST['polling_name']) : "";
    $polling_desc = isset($_POST['polling_desc']) ? trim($_POST['polling_desc']) : "";
    $enteredby = isset($_POST['enteredby']) ? trim($_POST['enteredby']) : "";


    // Getting the user Latitude, Longitude and IP Address 
    $loc = curl_init();
    curl_setopt($loc, CURLOPT_URL, "http://ip-api.com/json");
    curl_setopt($loc, CURLOPT_RETURNTRANSFER, 1);
    $result = curl_exec($loc);
    $result = json_decode($result);

    if ($result->status == "success") {
        $lon = $result->lon;
        $lat = $result->lat;
        $ip = $result->query;
    }

    // Generating Polling Unit id 
    $pollid = "12345678901234567890";
    $pollid = str_shuffle($pollid);
    $pollid = substr($pollid, 0, 2);
    


    // Generating Polling Unit Number 
    $rndConst = "DT";
    $rndNum = "87446644748756474611130098987575646338373222";
    $rndNum = str_shuffle($rndNum);
    $rndNum = substr($rndNum, 0, 7);
    $polling_num = $rndConst . $rndNum;

    // Getting the Date and Time  
    $datetime = date('Y-m-d H:i:s');



    $query1 = "INSERT INTO polling_unit(`uniquewardid`, `polling_unit_id`, `lga_id`, `ward_id`, `polling_unit_number`, `polling_unit_name`, `polling_unit_description`, `entered_by_user`, `lat`, `long`, `date_entered`, `user_ip_address`)VALUES('$uniqueid', '$pollid', '$newpollid', '$wardid', '$polling_num', '$polling_name', '$polling_desc', '$enteredby', '$lat', '$lon', '$datetime', '$ip')";

    // echo "<br>";
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