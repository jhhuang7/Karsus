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

//            $q2 = "SELECT COUNT(*) as num FROM Enrollment
//                WHERE class ='" . $course . "';";
//            $results2 = sqlsrv_query($conn, $q2);

            $q3 = "SELECT S.FirstName, S.LastName FROM Students S, Enrollment E 
                WHERE E.class ='" . $course . "' AND E.student=S.id 
                ORDER BY S.score DESC, S.LastName;";
            $results3 = sqlsrv_query($conn, $q3);

            $q4 = "SELECT title, info, FORMAT(due, 'dd/MM/yyyy') as date 
                FROM Task WHERE ccode ='" . $course . "' ORDER BY due;";
            $results4 = sqlsrv_query($conn, $q4);

            if ($results1 == false
                    or $results3 == false or $results4 == false) {
                // Query problem
                header("Location: home.php");
                exit();
            }

            $row1 = sqlsrv_fetch_array($results1, SQLSRV_FETCH_ASSOC);
            echo "Course Code: " . $row1["code"];
            echo "<br>";

            echo "Course Description: " . $row1["info"];
            echo "<br>";

//            $row2 = sqlsrv_fetch_array($results2, SQLSRV_FETCH_ASSOC);
//            echo "Number of People: " . $row2["num"];
//            echo "<br>";

            echo "Class List: <br><ul>";
            while ($row3 = sqlsrv_fetch_array($results3,
                SQLSRV_FETCH_ASSOC)) {
                echo "<li>" . $row3["FirstName"] .
                    " " . $row3["LastName"] . "</li>";
            }
            echo "</ul>";

            echo "Tasks: <br><ol>";
            while ($row4 = sqlsrv_fetch_array($results4,
                SQLSRV_FETCH_ASSOC)) {
                echo "<li>Task: " . $row4["title"] .
                    "; Information: " . $row4["info"] .
                    "; Due date: " . $row4["date"] .
                    ".</li>";
            }
            echo "</ol>";
        ?>

        <form action="home.php">
            <button>Back to Home</button>
        </form>
    </body>
</html>
