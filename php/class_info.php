<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Class Info</title>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>
    <style>
    body {
        background-color: #B5D6A7;
    }
    </style>
    <body>
        <?php
            class Task {
                public $title;
                public $info;
                public $dueDate;
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
                header("Location: home2.php");
                exit();
            }

            $q1 = "SELECT * FROM Classes
                WHERE code ='" . $course . "'
                AND sem>=GETDATE();";
            $results1 = sqlsrv_query($conn, $q1);
            if ($results1 == false) {
                // Query problem
                header("Location: home2.php");
                exit();
            }
            $row1 = sqlsrv_fetch_array($results1, SQLSRV_FETCH_ASSOC);
            $title = $row1["info"];

            $q2 = "SELECT * FROM Enrollments E, Users U
                    WHERE E.student=U.id AND E.class ='" . $course . "'
                    AND E.sem>=GETDATE()
                    ORDER BY U.score desc, U.LastName, U.FirstName, U.id;";
            $results2 = sqlsrv_query($conn, $q2);
            if ($results2 == false) {
                // Query problem
                header("Location: home2.php");
                exit();
            }
            $students = array();
            while ($row2 = sqlsrv_fetch_array(
                    $results2, SQLSRV_FETCH_ASSOC)) {
                $student = $row2["FirstName"] . " " . $row2["LastName"] .
                    " (" . "<a href='mailto:" . $row2["email"] . "'>" . $row2["id"] . "</a>)";
                array_push($students, $student);
            }

            $q3 = "SELECT title, info, FORMAT(due, 'dd/MM/yyyy') as date
                            FROM Tasks T WHERE ccode ='" . $course . "'
                            and sem>=GETDATE() ORDER BY due;";
            $results3 = sqlsrv_query($conn, $q3);
            if ($results3 == false) {
                // Query problem
                header("Location: home2.php");
                exit();
            }
            $tasks = array();
            while ($row3 = sqlsrv_fetch_array(
                    $results3, SQLSRV_FETCH_ASSOC)) {
                $task = new Task;
                $task->title = $row3["title"];
                $task->info = $row3["info"];
                $task->dueDate = $row3["date"];
                array_push($tasks, $task);
            }
        ?>

        <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;">
            <div>
                <a class="navbar-brand" href="home2.php">
                    <img src="../images/karsus_logo.png" alt="Logo" width=40 height=40>
                </a>
            </div>

            <div class="col" style="color:white">
                <h2><?php echo $course . " - " . $title; ?></h2>
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
            <h3>
                <b>Class Members</b>
            </h3>
            <?php echo '<form action="add_students.php?course=' . $course . '" method="POST">'; ?>
                <label>
                    <input name="students" class="form-control" placeholder="Student IDs (CSV)" required />
                </label>
                <button  class="btn btn-success">Add +</button>
            <?php echo "</form>"; ?>
            <h4>List of members:</h4>
            <div class="container">
            <ul class="list-group ">
            <?php
                if (count($students) == 0) {
                    echo "No members in this class yet, please add some.";
                    echo "<br>";
                } else {

                    for ($i = 0; $i < count($students); $i++) {
                        echo "<li class='list-group-item '><i class='glyphicon glyphicon-education'>&nbsp</i>".
                            $students[$i] . "<br>" .
                        "</li>";
                    }

                }
            ?>
          </ul>
          </div>
            <hr>

            <h3>
                <b>Tasks</b>
            </h3>
            <form action="add_task.php">
                <button class="btn btn-success">Create Task &#8680;</button>
                <?php
                    echo "<input name='course' value='$course' hidden />";
                ?>
            </form>
            <h4>List of tasks:</h4>
            <?php
                if (count($tasks) == 0) {
                    echo "No tasks in this class yet, please add some.";
                    echo "<br>";
                } else {
                    for ($i = 0; $i < count($tasks); $i++) {
                        echo '<a class="list-group-item list-group-item-action flex-column align-items-start">
                                    <div class="d-flex w-100 justify-content-between">
                                        <h5 class="mb-1">' . $tasks[$i]->title . '</h5>
                                        <small>' . $tasks[$i]->dueDate . '</small>
                                    </div>
                                    <p class="mb-1">' . $tasks[$i]->info . '</p>
                                    </a>';
                    }
                }
            ?>
        </div>
        <br>
        <br>

        <script>
            let params = {};

            window.location.search
                .slice(1)
                .split("&")
                .forEach((elm) => {
                    if (elm === "") return;
                    let spl = elm.split("=");
                    const d = decodeURIComponent;
                    params[d(spl[0])] = spl.length >= 2 ? d(spl[1]) : true;
                });

            if (params["status"] === "good-enroll") {
                alert("You have successfully added students to this class.");
            } else if (params["status"] === "bad-enroll") {
                alert("There was an issue when adding students, please check and try again.");
            } else if (params["status"] === "good-task") {
                alert("You have successfully added a task to this class.");
            } else if (params["status"] === "bad-task") {
                alert("There was an issue when adding a task, please check and try again.");
            }
        </script>
    </body>
</html>
