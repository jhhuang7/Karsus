<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Class</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>

    <body>
        <h1>
            Class
        </h1>

        <?php
            $course = $_POST["course"];

            $serverName = "tcp:karsus.database.windows.net,1433";
            $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
                "Database" => "Karsus", "LoginTimeout" => 30,
                "Encrypt" => 1, "TrustServerCertificate" => 0);

            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if ($conn == false) {
                // Connection problem
                header("Location: home.php");
                exit();
            }

            $q1 = "SELECT * FROM Class WHERE code ='" . $course . "';";
            $results1 = sqlsrv_query($conn, $q1);

            $q2 = "SELECT COUNT(*) as num FROM Enrollment 
                WHERE class ='" . $course . "';";
            $results2 = sqlsrv_query($conn, $q2);

            $q3 = "SELECT title, info, FORMAT(due, 'dd/MM/yyyy') as date 
                FROM Task WHERE ccode ='" . $course . "' ORDER BY date ASC;";
            $results3 = sqlsrv_query($conn, $q3);

            if ($results1 == false or $results2 == false
                    or $results3 == false) {
                // Query problem
                header("Location: home.php");
                exit();
            }

            $row1 = sqlsrv_fetch_array($results1, SQLSRV_FETCH_ASSOC);
            $row2 = sqlsrv_fetch_array($results2, SQLSRV_FETCH_ASSOC);

            echo "Course Code: " . $row1["code"];
            echo "<br>";

            echo "Course Description: " . $row1["info"];
            echo "<br>";

            echo "Number of People: " . $row2["num"];
            echo "<br>";

            echo "Tasks: <br><ol>";
            while ($row3 = sqlsrv_fetch_array($results3,
                SQLSRV_FETCH_ASSOC)) {
                echo "<li>Task: " . $row3["title"] .
                    "; Information: " . $row3["info"] .
                    "; Due date: " . $row3["date"] .
                    ".</li>";
            }
            echo "</ol>";
        ?>

        <form action="home.php">
            <button>Back to Home</button>
        </form>
    </body>
</html>
