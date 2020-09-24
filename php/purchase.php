<?php

session_start();
$id = $_SESSION["id"];
$item = $_GET["item"];

$SQL_GET_PURCHASE_PRICE = "SELECT cost FROM Inventory WHERE name = '" . $item . "'";

$SQL_GET_USER_GOLD = "SELECT  SUM(score)/COUNT(*) - SUM(cost)
                as [Balance]
                from Users
                inner join Purchase on Users.id = Purchase.student
                inner join Inventory on Purchase.item = Inventory.name
                where Users.id = " . $id;

$SQL_PURCHASE_ITEM = "INSERT into Purchase values(" . $id . ", '" . $item . "', 'N')";

$serverName = "tcp:karsus.database.windows.net,1433";
$connectionOptions = array(
    "UID" => "karsus", "PWD" => "K@rth0us",
    "Database" => "Karsus", "LoginTimeout" => 30,
    "Encrypt" => 1, "TrustServerCertificate" => 0
);

$conn = sqlsrv_connect($serverName, $connectionOptions);

$getResults = sqlsrv_query($conn, $SQL_GET_PURCHASE_PRICE);
$row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
$price = $row["cost"];

$getResults = sqlsrv_query($conn, $SQL_GET_USER_GOLD);
$row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
$gold = $row["Balance"];

if ($gold >= $price) {
    $stmt = sqlsrv_prepare($conn, $SQL_PURCHASE_ITEM);
    if (sqlsrv_execute($stmt)) {
        echo "" . $price; // send back price of item
    } else {
        echo "-1"; // Update failed
    }
} else {
    echo "-2";     // not enough gold
}

?>