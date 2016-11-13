<?php
/**
 * Created by PhpStorm.
 * User: agrze
 * Date: 03-Oct-16
 * Time: 6:53 PM
 */

include "resources/header.php";
include "lib/dbconn.php";
$db->query("USE ajg379;");

$sql = "SELECT u.first_name, ";
$sql .= "u.last_name, ";
$sql .= "u.id AS user_id, ";
$sql .= "i.id AS inst_id, ";
$sql .= "i.inst_name, ";
$sql .= "f.id AS entry_id, ";
$sql .= "f.post_date, ";
$sql .= "f.post_time, ";
$sql .= "f.comments, ";
$sql .= "f.type_post, ";
$sql .= "f.talent ";
$sql .= "FROM forumEntry f ";
$sql .= "LEFT JOIN user u ON u.id = f.user_id ";
$sql .= "LEFT JOIN instrument i ON i.id = f.inst_id ";
$sql .= "ORDER BY f.post_date, f.post_time";

$result=$db->query($sql);
while($row=$result->fetch_array(MYSQLI_ASSOC)){
    $forumEntries[]=$row;
}

$sql = "SELECT inst_name, id AS inst_id FROM instrument ORDER BY inst_name";
$result = $db->query($sql);
while($row=$result->fetch_array(MYSQLI_ASSOC)){
    $all_instruments[]=$row;
}
if(isset($_SESSION['user_id'])){
    $sql = "SELECT i.inst_name, ";
    $sql .= "i.id as inst_id ";
    $sql .= "FROM instrument i ";
    $sql .= "LEFT JOIN instrument_user iu ON i.id = iu.inst_id WHERE iu.user_id=".$_SESSION['user_id'].";";
    $result = $db->query($sql);
    while($row=$result->fetch_array(MYSQLI_ASSOC)){
        $user_instruments[]=$row;
    }
}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Atricity: Waiting Room</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <style>

    </style>
</head>

<body>
<!--Get Discovered Modal-->
<div class="modal fade" id="discoverModal" tabindex="-1" aria-hidden="true" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Find someone to jam with.</h4>
            </div>
            <form role="form" id="formDiscover" name="formDiscover" method="post">
                <div class="modal-body">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <!--Instrument selector goes here-->
                                <label for="instruments">Select one or more instruments:</label>
                                <div id="error_instruments" style="display: none"><h4 style="color: red;">Please select at least one instrument.</h4> </div>
                                <select multiple class="form-control" id="instruments[]" name="instruments[]">
                                    <?php
                                        foreach ($all_instruments as $instrument){
                                            echo('<option value=' . $instrument['inst_id'] . ">");
                                            echo($instrument['inst_name']);
                                            echo('</option>');
                                        }
                                    ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="skillLevel">Select the skill level you wish to play with:
                                    <select name="skillLevel" id="skillLevel" class="form-control">
                                        <option value="0">Doesn't Matter</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </label>
                            </div>
                        </div>
                        <div id="error_noUser" style="display: none;">
                            <h3 style="color: red;">Please login before posting in the Waiting Room.</h3>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="submit" id="submitDiscover" name="submitDiscover" class="btn btn-primary">Find Players...</button>
            </div>
        </div>
    </div>
</div>
<!--Be Discovered Modal-->
<div class="modal fade" id="beDiscoveredModal" tabindex="-1" aria-hidden="true" role="dialog" >
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Find someone to jam with.</h4>
            </div>
            <form role="form" id="formBeDiscovered" name="formBeDiscovered" method="post">
                <div class="modal-body">
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <div class="form-group">
                                <!--Instrument selector goes here-->
                                <label for="instruments">Select one or more instruments:</label>
                                <div id="error_user_instruments" style="display:none;"><h4 style="color: red;">Please select at least one instrument.</h4> </div>
                                <select multiple class="form-control" id="user_instruments[]" name="user_instruments[]">
                                    <?php
                                    foreach ($user_instruments as $instrument){
                                        echo('<option value=' . $instrument['inst_id'] . ">");
                                        echo($instrument['inst_name']);
                                        echo('</option>');
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div id="error_BeDiscoveredNoUser" style="display: none;">
                            <h3 style="color: red;">Please login before posting in the Waiting Room.</h3>
                        </div>
                    </div>
                </div>
            </form>
            <div class="modal-footer">
                <button type="submit" id="submitBeDiscovered" name="submitBeDiscovered" class="btn btn-primary">Find Players...</button>
            </div>
        </div>
    </div>
</div>

<div class="container">
    <div class="col-lg-3 col-lg-offset-9">
        <div class="row">
            <h3 class="ready-to-play">Ready to play?</h3>
        </div>
        <div class="row">
            <a href="#discoverModal" role="button" class="btn" data-toggle="modal">Discover</a>
        </div>
        <div class="row">
            <a href="#beDiscoveredModal" role="button" class="btn" data-toggle="modal">Be Discovered</a>
        </div>
    </div>
    <table class="table table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Instrument</th>
                <th>Skill Level</th>
                <th>Date and Time</th>
                <th>Live Studio</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        if(isset($forumEntries)){
            foreach ($forumEntries as $forumEntry){
                echo('<tr>');
                echo('<td>' . $forumEntry['first_name'].'</td>');
                echo('<td>' . $forumEntry['inst_name'].'</td>');
                echo('<td>' . $forumEntry['talent'].'</td>');
                echo('<td>' . $forumEntry['post_date']." ".$forumEntry['post_time'].'</td>');
                echo('<td>' . $forumEntry['type_post'].'</td>');
                if(isset($_SESSION['user_id'])&& $_SESSION['user_id']==$forumEntry['user_id']){
                    echo("<button class='btn' id=''> ");
                }
                else{
                    echo('<td></td>');
                }

                echo('</tr>');
            }
        }
        ?>
        </tbody>
    </table>
    <h2>Todo:</h2>
    <ul>
        <li>Delete entry option</li>
        <li>Make date more friendly</li>
        <li>Filter options</li>
        <li>Delete entries after a certain amount of time</li>
        <li>Clicking an entry asks the poster to start a Studio session---deletes the post if yes</li>

    </ul>
</div>
<script>
    $(function () {
        $('#submitDiscover').on('click', function (e) {
            e.preventDefault();
            var instruments=document.getElementById('instruments[]').value;
            var isGood=true;
            if(instruments.length==0){
                isGood=false;
                document.getElementById('error_instruments').style.display='inline'
            }
            else {
                document.getElementById('error_instruments').style.display = 'none';
                var isGood = true;
            }
            var success=false;
            if(isGood==true) {
                $.ajax({
                    url: "lib/add.php?t=discover",
                    type: "POST",
                    data: $("#formDiscover").serialize(),
                    success: function (data) {
                        if (data == "success") {
                            //window.alert("success");
                            success = true;
                            window.location.reload();
                        }
                        else if (data == "not_signed_in") {
                            //window.alert("data=false");
                            success = false;
                        }

                    }
                });
            }
            if (success == false && isGood==true) {
                //window.alert('false');
                document.getElementById('error_noUser').style.display = 'inline';
            }
        });
    });

    $(function () {
        $('#submitBeDiscovered').on('click', function (e) {
            e.preventDefault();
            var instruments=document.getElementById('user_instruments[]').value;
            var isGood=true;
            if(instruments.length==0){
                isGood=false;
                document.getElementById('error_user_instruments').style.display='inline'
            }
            else {
                document.getElementById('error_user_instruments').style.display = 'none';
                var isGood = true;
            }
            var success=false;
            if(isGood==true) {
                $.ajax({
                    url: "lib/add.php?t=BeDiscover",
                    type: "POST",
                    data: $("#formBeDiscovered").serialize(),
                    success: function (data) {
                        if (data == "success") {
                            //window.alert("success");
                            success = true;
                            window.location.reload();
                        }
                        else if (data == "not_signed_in") {
                            //window.alert("data=false");
                            success = false;
                        }
                        else
                            window.alert("failed")

                    }
                });
            }
            if (success == false && isGood==true) {
                //window.alert('false');
                document.getElementById('error_BeDiscoveredNoUser').style.display = 'inline';
            }
        });
    });
</script>
</body>
<br>
<footer>
    <?php
    include "resources/footer.php"
    ?>
</footer>


</html>