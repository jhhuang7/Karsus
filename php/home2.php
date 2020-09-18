<?php
    session_start();
    $id = $_SESSION["id"];

    echo "Home Page Dashboard for Teacher account of: " . $id;
    echo "<br>";

    $serverName = "tcp:karsus.database.windows.net,1433";
    $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
        "Database" => "Karsus", "LoginTimeout" => 30,
        "Encrypt" => 1, "TrustServerCertificate" => 0);

    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn == false) {
        die(print_r( sqlsrv_errors(), true));
    }

    $tsql = "SELECT * FROM Classes WHERE teacher=" . $id . " AND sem>=GETDATE();";
    $getResults = sqlsrv_query($conn, $tsql);

    if ($getResults == FALSE) {
        die(print_r(sqlsrv_errors(), true));
    }

    echo "Courses teaching for this sem: ";
    while ($row = sqlsrv_fetch_array($getResults,
        SQLSRV_FETCH_ASSOC)) {
        echo $row["code"] . "<br>";
}
