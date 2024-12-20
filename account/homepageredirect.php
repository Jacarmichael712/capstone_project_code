<?php
    session_start();
    header("Location: http://team05sif.cpsc4911.com/S24-Team05/account/".$_SESSION['account_type']."homepage.php");
    exit();
?>