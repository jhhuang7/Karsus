<html lang="en">
    <head>
        <title>Answer</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>

    <?php
        function determine_score($answer) {
            // At the moment score of an answer is based on its length
            return strlen($answer);
        }
    ?>

    <body>
        <?php
            session_start();
            $id = $_SESSION["id"];

            $task = $_POST["task"];
            $taskarr = explode("+", $task);
            $ccode = $taskarr[0];
            $title = $taskarr[1];

            $score = 0;
            $count = $_POST["count"];
            for ($i = 0; $i < $count; $i++) {
                $name = $i + 1;
                $answer = $_POST["$name"];

                // Total score is question num * 5 * len of answer
                $score += $name * 5 * determine_score($answer);
            }

            $serverName = "tcp:karsus.database.windows.net,1433";
            $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
                "Database" => "Karsus", "LoginTimeout" => 30,
                "Encrypt" => 1, "TrustServerCertificate" => 0);

            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if ($conn == false) {
                // Connection problem
                header("Location: task.php");
                exit();
            }

            // Set the task for the student to be Completed
            $update = "UPDATE Works SET status='C' WHERE student=" . $id .
                " AND ccode='" . $ccode . "' AND thing='" . $title . "';";
            $stmt = sqlsrv_prepare($conn, $update);
            if (!sqlsrv_execute($stmt)) {
                // Update problem
                header("Location: task.php");
                exit();
            }

            // Update student's new score
            $update2 = "UPDATE Students SET score=score+$score 
                WHERE id=" . $id . ";";
            $stmt2 = sqlsrv_prepare($conn, $update2);
            if (!sqlsrv_execute($stmt2)) {
                // Update problem
                header("Location: task.php");
                exit();
            }

            // Return home once everything is done ok
            header("Location: home.php?status=answered");
            exit();
        ?>
    </body>
</html>