<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Class</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
        <script src="../js/jquery-3.5.1.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>

    <?php
        class Student {
            public string $firstName;
            public string $lastName;
        }

        class Task {
            public string $title;
            public string $info;
            public string $dueDate;
        }

        $course = $_GET["course"];

        $serverName = "tcp:karsus.database.windows.net,1433";
        $connectionOptions = array(
            "UID" => "karsus", "PWD" => "K@rth0us",
            "Database" => "Karsus", "LoginTimeout" => 30,
            "Encrypt" => 1, "TrustServerCertificate" => 0
        );

        $conn = sqlsrv_connect($serverName, $connectionOptions);
        if ($conn == false) {
            // Connection problem
            header("Location: home.php");
            exit();
        }

        $q1 = "SELECT * FROM Classes C, Users S
            WHERE C.teacher=S.id and C.code ='" . $course . "'
            AND C.sem>=GETDATE();";
        $results1 = sqlsrv_query($conn, $q1);

        $q3 = "SELECT S.FirstName, S.LastName FROM Users S, Enrollments E
                        WHERE E.class ='" . $course . "' AND E.student=S.id
                        AND E.sem>=GETDATE()
                        ORDER BY S.score DESC, S.LastName;";
        $results3 = sqlsrv_query($conn, $q3);

        $q4 = "SELECT title, info, FORMAT(due, 'dd/MM/yyyy') as date
                        FROM Tasks T WHERE ccode ='" . $course . "'
                        and sem>=GETDATE() ORDER BY due;";
        $results4 = sqlsrv_query($conn, $q4);

        if ($results1 == false
            or $results3 == false or $results4 == false) {
            // Query problem
            header("Location: home.php");
            exit();
        }

        $row1 = sqlsrv_fetch_array($results1, SQLSRV_FETCH_ASSOC);
        $courseInfo = $row1["info"];
        $teacher = $row1["FirstName"] . " " . $row1["LastName"] .
            " (" . $row1["email"] . ")";

        $students = array();
        while ($row3 = sqlsrv_fetch_array(
                $results3, SQLSRV_FETCH_ASSOC)) {
            $student = new Student;
            $student->firstName = $row3["FirstName"];
            $student->lastName = $row3["LastName"];
            array_push($students, $student);
        }

        $tasks = array();
        while ($row4 = sqlsrv_fetch_array(
                $results4, SQLSRV_FETCH_ASSOC)) {
            $task = new Task;
            $task->title = $row4["title"];
            $task->info = $row4["info"];
            $task->dueDate = $row4["date"];
            array_push($tasks, $task);

        }
    ?>

    <body>
      <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;">
          <div>
              <a class="navbar-brand" href="home.php">
                  <img src="../images/karsus_logo.png" alt="Logo" style="width:55px">
              </a>

          </div>

          <div class="col" style="color:white">
              <h2><?php echo $course ?></h2>
          </div>
          <div class="dropdown">
            <button type="button" class="btn btn-secondary dropdown-toggle" data-toggle="dropdown">
            <img src="../images/profile.png" alt="profile" width=30 height=30 />
            </button>
            <div class="dropdown-menu dropdown-menu-right">
              <a class="dropdown-item" href="profile.php">Edit Profile</a>
              <a class="dropdown-item" href="../index.html?status=loggedout">Log Out</a>
          </div>
        </div>
      </div>

        <div class="container" style="margin-top: 50px;">
            <p class="h2">Class Description</p>
            <p><?php echo $courseInfo ?></p>

            <p class="h2">Course Coordinator</p>
            <p><?php echo $teacher ?></p>

            <p class="h3">
                Members (<?php echo count($students) ?>)
                <ul>
                    <?php
                        for ($i = 0; $i < count($students); $i++) {
                            echo '<li>' . $students[$i]->firstName . ' ' . $students[$i]->lastName . '</li>';
                        }
                    ?>
                </ul>

                <p class="h3">List of Tasks(<?php echo count($tasks) ?>)</p>
                <div class="list-group">
                    <?php
                    echo "<table class='table table-hover table-bordered'>
                    <thead>
                    <tr>
                    <th>Assessment Task</th>
                    <th style='text-align:center;'>Due Date</th>
                    </tr>
                    </thead>
                    <tbody>";
                        for ($i = 0; $i < count($tasks); $i++) {
                            // Not sure if tasks should link to their page as tasks couple be completed
                            // href="task.php?title=' . $tasks[$i]->title . '&ccode=' . $course . '&info=' . $tasks[$i]->info . '&due=' . $tasks[$i]->dueDate . '"
                            echo '
                            <tr>
                            <td><h6 style="color:blue;">'. $tasks[$i]->title . '</h6><p>' . $tasks[$i]->info . '</p></td>
                            <td><h6 style="color:red; text-align:center;">' . $tasks[$i]->dueDate . '</h6></td>
                            </tr>
                            ';
                          }
                          echo '
                          </tbody>
                          </table>
                          ';
                    ?>
                </div>

        </div>
    </body>
</html>
