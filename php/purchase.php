<?php

session_start();
$id = $_SESSION["id"];
$item = $_GET["item"];

$SQL_PURCHASE_ITEM = "insert into Purchase values(" . $id . ", " . $item . ", N)";

$serverName = "tcp:karsus.database.windows.net,1433";
$connectionOptions = array(
    "UID" => "karsus", "PWD" => "K@rth0us",
    "Database" => "Karsus", "LoginTimeout" => 30,
    "Encrypt" => 1, "TrustServerCertificate" => 0
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

$stmt = sqlsrv_prepare($conn, $SQL_PURCHASE_ITEM);
sqlsrv_execute($stmt);

header("Location: customise_new.php")

?>