<?php
/**
 * Created by PhpStorm.
 * User: agrze
 * Date: 02-Oct-16
 * Time: 5:17 PM
 */
session_start();
session_unset();
session_destroy();
header('Location: ../home.php');
?>