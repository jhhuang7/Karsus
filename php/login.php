<?php
    $id = $_POST["id"];
    $pw = $_POST["pw"];

    $serverName = "tcp:karsus.database.windows.net,1433";
    $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
        "Database" => "Karsus", "LoginTimeout" => 30,
        "Encrypt" => 1, "TrustServerCertificate" => 0);

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn == false) {
        // Connection problem
        header("Location: ../index.html");
        exit();
    }

    $tsql = "SELECT pw, type FROM Users WHERE id = " . $id . ";";
    $getResults = sqlsrv_query($conn, $tsql);

    if ($getResults == FALSE) {
        // Query problem
        header("Location: ../index.html");
        exit();
    }

    $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
    $hash = $row["pw"];
    $type = $row["type"];

    if (password_verify($pw, $hash)) {
        session_start();
        $_SESSION["id"] = $id;
        if ($type === "S") {
            header("Location: home.php");
        } else {
            header("Location: home2.php");
        }
        exit();
    } else {
        header("Location: ../index.html?status=badlogin#login");
        exit();
    }
