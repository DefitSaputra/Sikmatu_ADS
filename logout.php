<?php
session_start();
session_destroy();
header("Location: sikmatuLog.php");
exit();
?>
