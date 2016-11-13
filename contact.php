<?php
/**
 * Created by PhpStorm.
 * User: agrze
 * Date: 22-Sep-16
 * Time: 6:43 PM
 */
include "resources/header.php";

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Atricity: Contact</title>
</head>
<body>
    <div id="success" class="row" style="display: none">
        <div class="col-sm-6">
            <h3>Thanks for your message.</h3>
        </div>
    </div>

    <form role="form" id="contactForm" style="display: inline">
        <div style="padding-left: 5em">
            <div class="row">
                <div class="form-group col-sm-2">
                    <h2>Contact Us</h2>
                </div>
            </div>
            <div class="form-group">
                <label for="reason">What is the reason for your inquiry?
                    <select name="reason"  id="reason" name="reason" class="form-control ">
                        <option value="complaint">Complaint</option>
                        <option value="question">Question</option>
                        <option value="suggestion">Suggestion</option>
                        <option value="praise">Praise</option>
                        <option value="other">Other</option>
                    </select>
                </label>
            </div>
            <br>
            <div class="row" id="error_name" style="display: none">
                <div class="col-sm-4">
                    <h4 style="color: red;">Please enter your first and last name.</h4>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-2">
                    <input type="text" class="form-control" id="fname" name="fname" placeholder="First Name">
                </div>
                <div class="form-group col-sm-2">
                    <input type="text" class="form-control" id="lname" name="lname" placeholder="Last Name">
                </div>
            </div>
            <div class="row" id="error_email" style="display: none">
                <div class="col-sm-4">
                    <h4 style="color: red;">Please enter a valid email.</h4>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <input type="email" class="form-control" id="input_email" name="input_email" placeholder="Email">
                </div>
            </div>
            <div class="row">
                <div class="row" id="error_subject" style="display: none">
                    <div class="col-sm-4">
                        <h4 style="color: red;">Please enter a subject for your message.</h4>
                    </div>
                </div>
                <div class="col-sm-4">
                    <input type="text" class="form-control" id="subject" name="subject" placeholder="Subhect:">
                </div>
            </div>
            <div class="row" id="error_message" style="display: none">
                <div class="col-sm-4">
                    <h4 style="color: red;">Please enter a message.</h4>
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-4">
                    <textarea class="form_control" id="message" name="message" rows="10" cols="45" placeholder="Message:"></textarea>
                </div>
                <div class="col-sm-8>">
                    <img src="images/mail_music.bmp">
                </div>
            </div>
            <div class="row">
                <button type="submit" class="btn btn-submit col-sm-4">Submit</button>
            </div>
            <div class="row" id="email_error" style="display: none">
                <div class="col-sm-6">
                    <h3 style="color: red;">There has been an error.  Try again later</h3>
                </div>
            </div>

        </div>
    </form>
<footer>
    <?php
    include "resources/footer.php"
    ?>
</footer>

<script>
    $(function () {
        $('#contactForm').on('submit', function (e) {
            e.preventDefault();
            var isGood = true;
            var fname = document.getElementById('fname').value;
            var lname = document.getElementById('lname').value;
            var email = document.getElementById('input_email').value;
            var subject = document.getElementById('subject').value;
            var message = document.getElementById('message').value;

            if(fname=="" || lname==""){
                document.getElementById('error_name').style.display='inline';
                isGood=false;
            }
            else
                document.getElementById('error_name').style.display='none';

            if(email==""){
                document.getElementById('error_email').style.display='inline';
                isGood=false;
            }
            else
                document.getElementById('error_email').style.display='none';

            if(subject==""){
                document.getElementById('error_subject').style.display='inline';
                isGood=false;
            }
            else
                document.getElementById('error_subject').style.display='none';

            if(message==""){
                document.getElementById('error_message').style.display='inline';
                isGood=false;
            }
            else
                document.getElementById('error_message').style.display='none';
            var success=false;
            if(isGood==true){
                document.getElementById('success').style.display='inline';
                $.ajax({
                    url: "lib/add.php?t=email",
                    type: "POST",
                    data: $("#contactForm").serialize(),
                    success: function(data){
                        if(data==='success'){
                            success=true;
                        }
                        else{
                            success=false;
                        }
                        window.alert(data);
                    }
                })
            }
            if(success=true && isGood==true) {
                document.getElementById('success').style.display = 'inline';
                document.getElementById('contactForm').style.display = 'none';
            }
            else if(success==false && isGood==true)
                document.getElementById('send_error').style.display='inline';
        })

    })
</script>
</body>
</html>