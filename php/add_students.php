<?php
    class Task {
        public string $title;
        public string $info;
        public string $dueDate;
        public string $sem;
    }

    session_start();
    $sem = $_SESSION["sem"];

    $course = $_GET["course"];

    $students = $_POST["students"];
    $ids = explode(",", $students);

    $serverName = "tcp:karsus.database.windows.net,1433";
    $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
        "Database" => "Karsus", "LoginTimeout" => 30,
        "Encrypt" => 1, "TrustServerCertificate" => 0);
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn == false) {
        // Connection problem
        header("Location: class_info.php");
        exit();
    }

    // Get the tasks for this course
    $tasks = array();
    $tsql1 = "SELECT * FROM Tasks WHERE ccode='" . $course . "' AND sem>=GETDATE();";
    $getResults1 = sqlsrv_query($conn, $tsql1);
    if ($getResults1 == false) {
        // Query problem
        header("Location: class_info.php");
        exit();
    }
    while ($row1 = sqlsrv_fetch_array($getResults1,
            SQLSRV_FETCH_ASSOC)) {
        $task = new Task;
        $task->title = $row1["title"];
        $task->info = $row1["info"];
        $task->dueDate = $row1["due"];
        $task->sem = $row1["sem"];
        array_push($tasks, $task);
    }

    $enroll = "good-enroll";

    // Do inserts
    for ($i = 0; $i < count($ids); $i++) {
        $id = $ids[$i];

        // Add students to Enrollments table
        $insert = "INSERT INTO Enrollments(class, student, sem)
            Values('" . $course . "', " . $id . ", '" . $sem . "');";
        $stmt = sqlsrv_prepare($conn, $insert);
        if (!sqlsrv_execute($stmt)) {
            // Insert problem
            $enroll = "bad-enroll";
        }

        // Assign students to tasks (add to Work table)
        if (count($tasks) >= 1) {
            for ($j = 0; $j < count($tasks); $j++) {
                $insert1 = "INSERT INTO Work(student, thing, ccode, sem, status) 
                    Values(" . $id . ", '" . $tasks[$j]->title . "', '" . $course .
                    "', '" . $tasks[$j]->sem . "', 'I');";
                $stmt1 = sqlsrv_prepare($conn, $insert1);
                if (!sqlsrv_execute($stmt1)) {
                    // Insert problem
                    $enroll = "bad-enroll";
                }
            }
        }
    }

    header("Location: home2.php?status=" . $enroll);
    exit();
