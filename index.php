<?php

if (!isset($_SESSION)) {
    session_start();
}

if (!isset($_SESSION['uid'])) {
    header('Location: ./auth/login.php');
} else {
    header('Location: ./pages/welcome.php');
}
