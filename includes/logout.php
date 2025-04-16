<?php
include("db-connect.php");
session_start();
session_unset();
session_destroy();
header('Location: ../pages/Account.php');
exit;
?>
