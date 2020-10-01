<?php
    session_start();
    $sem = $_SESSION["sem"];

    $course = $_POST["course"];
    $title = $_POST["title"];
    $due = $_POST["due"];
    $des = $_POST["des"];

    $qs = $_POST["qs"]; // Need to properly handle questions
    $questions = explode("|", $qs); // Questions could just be list of qs separated by '|'

    $serverName = "tcp:karsus.database.windows.net,1433";
    $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
        "Database" => "Karsus", "LoginTimeout" => 30,
        "Encrypt" => 1, "TrustServerCertificate" => 0);
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if ($conn == false) {
        // Connection problem
        header("Location: class_info.php?course=" . $course);
        exit();
    }

    // Get the students for this course
    $students = array();
    $tsql1 = "SELECT * FROM Enrollments WHERE class='" . $course . "' AND sem>=GETDATE();";
    $getResults1 = sqlsrv_query($conn, $tsql1);

    if ($getResults1 == false) {
        // Query problem
        header("Location: add_task.php?course=" . $course);
        exit();
    }

    while ($row1 = sqlsrv_fetch_array($getResults1,
            SQLSRV_FETCH_ASSOC)) {
        array_push($students, $row1["student"]);
    }

    $task = "good-task";

    // Add task to Tasks table
    $insert = "INSERT INTO Tasks(title, ccode, sem, info, due) 
        Values('" . $title . "', '" . $course . "', '" . $sem . "', '" .
        $des . "', '" . $due . "');";
    $stmt = sqlsrv_prepare($conn, $insert);
    if (!sqlsrv_execute($stmt)) {
        // Insert problem
        $task = "bad-task";
    }

    // Add questions into Question table for this task
    for ($j = 0; $j < count($questions); $j++) {
        $insert1 = "INSERT INTO Question(title, ccode, qid, sem, info) 
            VALUES('" . $title . "', '" . $course . "', " . $j . ", '" .
            $sem . "', '" . $questions[$j] . "');";
        $stmt1 = sqlsrv_prepare($conn, $insert1);
        if (!sqlsrv_execute($stmt1)) {
            // Insert problem
            $task = "bad-task";
        }
    }

    // Assign the new task for students taking this course
    if (count($students) >= 1) {
        for ($i = 0; $i < count($students); $i++) {
            $insert2 = "INSERT INTO Work(student, thing, ccode, sem, status) 
                    Values(" . $students[$i] . ", '" . $title . "', '" . $course .
                "', '" . $sem . "', 'I');";
            $stmt2 = sqlsrv_prepare($conn, $insert2);
            if (!sqlsrv_execute($stmt2)) {
                // Insert problem
                $task = "bad-task";
            }
        }
    }

    header("Location: class_info.php?course=" . $course . "&status=" . $task);
    exit();
