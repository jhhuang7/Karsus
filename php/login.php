<html lang="en">
    <head>
        <title>Log in</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>

    <body>
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

            $tsql = "SELECT pw FROM Students WHERE id = " . $id . ";";
            $getResults = sqlsrv_query($conn, $tsql);

            if ($getResults == FALSE) {
                // Query problem
                header("Location: ../index.html");
                exit();
            }

            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
            $hash = $row["pw"];
            
            if (password_verify($pw, $hash)) {
                session_start();
                $_SESSION["id"] = $id;
                header("Location: home.php");
                exit();
            } else {
                header("Location: ../index.html?status=badlogin#login");
                exit();
            }
        ?>
    </body>
</html>
