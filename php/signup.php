<html lang="en">
    <head>
        <title>Sign Up</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php
            $id = $_POST["id2"];
            $pw = $_POST["pw2"];
            $first = $_POST["first"];
            $last = $_POST["last"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];

            $hashed_password = password_hash($pw, PASSWORD_DEFAULT);


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

            $tsql = "SELECT COUNT(*) as num FROM Students
                WHERE id =" . $id . ";";
            $getResults = sqlsrv_query($conn, $tsql);
            if ($getResults == FALSE) {
                // Query problem
                header("Location: ../index.html");
                exit();
            }

            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
            if ($row["num"] != 0) {
                header("Location: ../index.html?error=badsignup");
                exit();
            } else {
                $insert = "INSERT INTO 
                    Students(id, FirstName, LastName, email, phone, pw, score) 
                    VALUES(" . $id . ", '" . $first . "', '" . $last . "', '" .
                    $email . "', '" . $phone . "', '" . $hashed_password . "', 0);";
                $stmt = sqlsrv_prepare($conn, $insert);
                if (!sqlsrv_execute($stmt)) {
                    // Insert problem
                    header("Location: ../index.html");
                    exit();
                }

                session_start();
                $_SESSION["id"] = $id;
                header("Location: home.php");
                exit();
            }
        ?>
    </body>
</html>