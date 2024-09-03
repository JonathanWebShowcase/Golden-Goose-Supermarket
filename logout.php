<?php
    session_start();
    // destroy the session
    session_destroy();
    // redict to home page
    header("Location: main.php");
?>