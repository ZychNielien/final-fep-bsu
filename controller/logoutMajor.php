<?php
session_start();

header('location: ../index.php?alert=major');

session_destroy();
?>