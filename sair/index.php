<?php
    session_start();
    ob_start();
    if (isset($_SESSION['user'])) {
        $_SESSION['user'] = null;
        header('Location: ../');
    }
?>
