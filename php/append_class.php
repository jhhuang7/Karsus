<?php
    $code = $_POST["code"];
    $sem = $_POST["sem"];
    $title = $_POST["title"];

    session_start();
    $id = $_SESSION["id"];

    $serverName = "tcp:karsus.database.windows.net,1433";
    $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
        "Database" => "Karsus", "LoginTimeout" => 30,
        "Encrypt" => 1, "TrustServerCertificate" => 0);

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn == false) {
        // Connection problem
        header("Location: add_class.php");
        exit();
    }


    $insert = "INSERT INTO Classes(code, sem, info, teacher)
        Values('$code". "', '". $sem ."', '" . $title . "', $id)";
    $stmt = sqlsrv_prepare($conn, $insert);

    if (!sqlsrv_execute($stmt)) {
        // Insert problem
        header("Location: add_class.php?status=badadd");
    } else {
        header("Location: home2.php?status=added");
    }
    exit();
