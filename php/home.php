<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <style>
            .scroll {
                max-height: 300px;
                overflow-y: auto;
            }

            .card-deck {
                margin-bottom: 30px
            }
        </style>
    </head>

    <body>
        <?php
            class Task
            {
                public string $taskName = 'Default';
                public string $ccode = 'Default';

                public function getDisplayName()
                {
                    return $this->ccode . ': ' . $this->taskName;
                }
            }

            class Student
            {
                public string $name = 'Default';
                public string $score = 'Default';

                public string $imgsrc = '../images/Avatar_sml.png';
            }

            session_start();
            $id = $_SESSION["id"];

            $serverName = "tcp:karsus.database.windows.net,1433";
            $connectionOptions = array(
                "UID" => "karsus", "PWD" => "K@rth0us",
                "Database" => "Karsus", "LoginTimeout" => 30,
                "Encrypt" => 1, "TrustServerCertificate" => 0
            );

            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if ($conn == false) {
                // Connection problem
                header("Location: ../index.html");
                exit();
            }

            $tsql = "SELECT FirstName FROM Students WHERE id =" . $id . ";";
            $getResults = sqlsrv_query($conn, $tsql);

            if ($getResults == FALSE) {
                // Query problem
                header("Location: ../index.html");
                exit();
            }

            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
            $name = $row["FirstName"];

            $taskSql = "SELECT * from Works where student=" . $id . " and status='I'";
            $getResults = sqlsrv_query($conn, $taskSql);
            $tasks = array();


            if ($getResults == FALSE) {
                // Query problem
                header("Location: ../index.html");
                exit();
            }

            while ($row = sqlsrv_fetch_array(
                $getResults,
                SQLSRV_FETCH_ASSOC
            )) {
                if ($row["status"] == "I") {
                    $task = new Task;
                    $task->taskName = $row["thing"];
                    $task->ccode = $row["ccode"];
                    array_push($tasks, $task);
                }
            }

            $doneSql = "SELECT * from Works where student=" . $id . " and status='C'";
            $getResults2 = sqlsrv_query($conn, $doneSql);
            $done = array();


            if ($getResults2 == FALSE) {
                // Query problem
                header("Location: ../index.html");
                exit();
            }

            while ($row2 = sqlsrv_fetch_array(
                $getResults2,
                SQLSRV_FETCH_ASSOC
            )) {
                if ($row2["status"] == "C") {
                    $task2 = new Task;
                    $task2->taskName = $row2["thing"];
                    $task2->ccode = $row2["ccode"];
                    array_push($done, $task2);
                }
            }

            $classSql = "select class from Enrollment where student = " . $id;
            $getResults = sqlsrv_query($conn, $classSql);
            $classes = array();

            while ($row = sqlsrv_fetch_array(
                $getResults,
                SQLSRV_FETCH_ASSOC
            )) {
                array_push($classes, $row['class']);
            }

            $lbSql = "select top 50 FirstName, LastName, score from Students order by score desc";
            $getResults = sqlsrv_query($conn, $lbSql);
            $lboard = array();

            while ($row = sqlsrv_fetch_array(
                $getResults,
                SQLSRV_FETCH_ASSOC
            )) {
                $student = new Student;
                $student->name = $row['FirstName'] . ' ' . $row['LastName'];
                $student->score = $row['score'];
                array_push($lboard, $student);
            }

            // - SUM(cost)
            $goldSql = "select  SUM(score)/COUNT(*) 
                as [Balance]
                from Students
                inner join Purchase on Students.id = Purchase.student
                inner join Inventory on Purchase.item = Inventory.name
                where Students.id = " . $id;
            $getResults = sqlsrv_query($conn, $goldSql);
            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
            $gold = $row["Balance"];
        ?>

        <div class="row w-100">
            <div class="col">
                <?php
                    echo '<h2>Welcome ' . $name . '!</h1>';
                ?>
            </div>

            <div class="col text-right">
                <?php
                    echo '<span style="color:gold; font-size:25px;">' . $gold . 'g   ' .
                        '<a href="profile.php"><img src="../images/profile.png" alt="profile" width=40 height=40 /></a></span>';
                ?>
            </div>
        </div>
        <hr>
        <div class="container">
            <div class="card-deck">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title">Classes</h4>
                        <div class="container scroll">
                            <?php
                                for ($i = 0; $i < count($classes); $i++) {
                                    echo '<p class="card-text"><button type="button" class="btn btn-primary w-100">' . $classes[$i] . '</button></p>';
                                }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title"><a href="task.php">Tasks</a></h4>
                        <div class="container scroll">
                            <p class="card-text">
                                <button type="button" name="" id="" class="btn btn-secondary w-100 text-left">TODO Tasks</button>
                            </p>
                            <?php
                                for ($i = 0; $i < count($tasks); $i++) {
                                    echo '<p class="card-text"><button type="button" class="btn btn-info w-100 text-left">' . $tasks[$i]->getDisplayName() . '</button></p>';
                                }
                            ?>
                        </div>
                        <div class="container scroll" style="margin-top: 18px;">
                            <p class="card-text">
                                <button type="button" name="" id="" class="btn btn-secondary w-100 text-left">Completed Tasks</button>
                            </p>
                            <?php
                            for ($i = 0; $i < count($done); $i++) {
                                echo '<p class="card-text"><button type="button" class="btn btn-info w-100 text-left">' . $done[$i]->getDisplayName() . '</button></p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-deck">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title">Leader board</h4>
                        <div class="container scroll">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th scope="col">#</th>
                                        <th scope="col">Name</th>
                                        <th scope="col">Avatar</th>
                                        <th scope="col">Score</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                        for ($i = 0; $i < count($lboard); $i++) {
                                            echo '<tr>' .
                                                '<th scope="row">' . ($i + 1) . '</th>' .
                                                '<td>' . $lboard[$i]->name . '</td>' .
                                                '<td><img src="' . $lboard[$i]->imgsrc . '" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt=""></td>' .
                                                '<td>' . $lboard[$i]->score . '</td>' .
                                                '</tr>';
                                        }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title"><a href="customise.php">Customise</a></h4>
                        <img src="../images/Avatar.PNG" class="img-thumbnail w-50 mx-auto d-block" alt="Avatar">
                    </div>
                </div>
            </div>
        </div>

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

            if (params["status"] === "updated") {
                alert("Your details have been successfully updated!");
            }
        </script>
    </body>
</html>
