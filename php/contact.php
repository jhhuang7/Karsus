<?php
    $name = $_POST["Name"];
    $email = $_POST["Email"];
    $msg = $_POST["Message"];

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

    $insert = "INSERT INTO Contact(name, email, message) 
                            VALUES('" . $name . "', '" . $email . "', '"
        . $msg . "');";
    $stmt = sqlsrv_prepare($conn, $insert);

    if (!sqlsrv_execute($stmt)) {
        // Insert problem
        header("Location: ../index.html?status=badcontact#contact");
        exit();
    }

    header("Location: ../index.html?status=goodcontact#contact");
    exit();
