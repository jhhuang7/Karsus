<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Update Profile</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>

    <body>
        <?php
            session_start();
            $id = $_SESSION["id"];

            $pw = $_POST["pw"];
            $first = $_POST["first"];
            $last = $_POST["last"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $type = $_POST["type"];

            $hashed_password = password_hash($pw, PASSWORD_DEFAULT);

            $serverName = "tcp:karsus.database.windows.net,1433";
            $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
                "Database" => "Karsus", "LoginTimeout" => 30,
                "Encrypt" => 1, "TrustServerCertificate" => 0);

            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if ($conn == false) {
                // Connection problem
                header("Location: profile.php");
                exit();
            }

            $update = "UPDATE Users SET FirstName='" . $first .
                "', LastName='" . $last . "', email='" . $email .
                "', phone='" . $phone . "', " . "pw='" . $hashed_password .
                "' WHERE id=" . $id . ";";

            $stmt = sqlsrv_prepare($conn, $update);
            if (!sqlsrv_execute($stmt)) {
                // Insert problem
                header("Location: profile.php?status=badupdate");
                exit();
            }

            if ($type === 'S') {
                header("Location: home.php?status=updated");
            } else {
                header("Location: home2.php?status=updated");
            }
            exit();
        ?>
    </body>
</html>
