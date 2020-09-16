<?php
    session_start();
    $id = $_SESSION["id"];

    echo "Home Page Dashboard for Teacher account of : " . $id;
