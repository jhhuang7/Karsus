<?php
    session_start();
    $id = $_SESSION['id'];

    $equippedStr = "";

    if (isset($_GET["equipped"])) {
        $equippedStr = urldecode($_GET["equipped"]);
    }

    if ($equippedStr != "") {

        $equipped = explode(',', $equippedStr);
        for ($i = 0; $i < count($equipped); $i++) {
            $equipped[$i] = "item='" . $equipped[$i] . "'";
        }
        $conditions = join(" or ", $equipped);

        $SQL_CLEAR_EQUIPPED = "update Purchase set wearing='N' where student=" . $id;
        $SQL_SET_EQUIPPED = "update Purchase set wearing='Y' where student=".$id." and (" . $conditions . ")";

        $serverName = "tcp:karsus.database.windows.net,1433";
        $connectionOptions = array(
            "UID" => "karsus", "PWD" => "K@rth0us",
            "Database" => "Karsus", "LoginTimeout" => 30,
            "Encrypt" => 1, "TrustServerCertificate" => 0
        );

        $conn = sqlsrv_connect($serverName, $connectionOptions);

        $stmt = sqlsrv_prepare($conn, $SQL_CLEAR_EQUIPPED);
        sqlsrv_execute($stmt);

        $stmt = sqlsrv_prepare($conn, $SQL_SET_EQUIPPED);
        sqlsrv_execute($stmt);

        echo "1"; // Succeeded

    } else {
        echo "0"; // failed
    }
