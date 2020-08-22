<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
    </head>

    <body>
        <?php
            session_start();
            $id = $_SESSION["id"];

            $serverName = "tcp:karsus.database.windows.net,1433";
            $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
                "Database" => "Karsus", "LoginTimeout" => 30,
                "Encrypt" => 1, "TrustServerCertificate" => 0);

            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if ($conn == false) {
                // Connection problem
                header("Location: index.html");
                exit();
            }

            $tsql = "SELECT FirstName FROM Students WHERE id =" . $id . ";";
            $getResults = sqlsrv_query($conn, $tsql);

            if ($getResults == FALSE) {
                // Query problem
                header("Location: index.html");
                exit();
            }

            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
            $name = $row["FirstName"];
            echo "<a>Welcome $name!</a> <hr>";
        ?>

        <button>Classes</button>
        <button>Tasks</button>
        <button>Leaderboard</button>
        <button>Customisation</button>
    </body>
</html>
