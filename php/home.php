<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <style>
            .scroll {
                max-height: 300px;
                overflow-y: auto;
            }

            .card-deck {
                margin-bottom: 30px
            }

            body {
                background-image: linear-gradient(to right, rgba(255, 0, 0, 0), rgba(255, 255, 76, 1));
            }
        </style>
    </head>

    <body>
        <?php
            class Task {
                public string $taskName = 'Default';
                public string $ccode = 'Default';
                public string $info = "Default";
                public string $dueDate = "Default";

                public function getDisplayName() {
                    return $this->ccode . ': ' . $this->taskName;
                }
            }

            class Student {
                public string $name = 'Default';
                public string $score = 'Default';
                public int $id = 40000000;
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

            $tsql = "SELECT FirstName FROM Users WHERE id =" . $id . ";";
            $getResults = sqlsrv_query($conn, $tsql);

            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
            $name = $row["FirstName"];

            $taskSql = "SELECT top 3 thing, T.ccode, info, W.status, FORMAT(due, 'dd/MM/yyyy') as date 
                from Work W, Tasks T where W.student=" .
                $id . " and W.status='I' and W.ccode=T.ccode and W.thing=T.title
                and W.sem=T.sem and W.sem>=GETDATE() order by T.due";
            $getResults = sqlsrv_query($conn, $taskSql);
            $tasks = array();

            while ($row = sqlsrv_fetch_array(
                $getResults,
                SQLSRV_FETCH_ASSOC
            )) {
                if ($row["status"] == "I") {
                    $task = new Task;
                    $task->taskName = $row["thing"];
                    $task->ccode = $row["ccode"];
                    $task->dueDate = $row["date"];
                    $task->info = $row["info"];
                    array_push($tasks, $task);
                }
            }

            $doneSql = "SELECT top 3 * from Work W, Tasks T where W.student=" .
                $id . " and W.status='C' and W.ccode=T.ccode and W.thing=T.title
                and W.sem=T.sem and W.sem>=GETDATE() order by T.due";
            $getResults2 = sqlsrv_query($conn, $doneSql);
            $done = array();

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

            $classSql = "select class from Enrollments
                where sem>=GETDATE() and student = " . $id;
            $getResults = sqlsrv_query($conn, $classSql);
            $classes = array();

            while ($row = sqlsrv_fetch_array(
                $getResults,
                SQLSRV_FETCH_ASSOC
            )) {
                array_push($classes, $row['class']);
            }

            $lbSql = "";
            $filter = "";

            if (isset($_GET["filter"])) {
                $filter = $_GET["filter"];
            }

            if ($filter == "" or $filter == "Global") {
                $lbSql = "select top 50 id, FirstName, LastName, score
                        from Users where type='S' order by score desc, LastName, FirstName";
            } else {
                $lbSql = "select S.id, S.FirstName, S.LastName, S.score
                        from Users S, Enrollments E
                        where S.id=E.student
                        and S.type='S'
                        and E.class='" . $filter . "'
                        and E.sem>=GETDATE()
                        order by S.score desc, LastName, FirstName;";
            }

            $getResults = sqlsrv_query($conn, $lbSql);
            $lboard = array();

            while ($row = sqlsrv_fetch_array(
                $getResults,
                SQLSRV_FETCH_ASSOC
            )) {
                $student = new Student;
                $student->name = $row['FirstName'] . ' ' . $row['LastName'];
                $student->score = $row['score'];
                $student->id = $row['id'];
                array_push($lboard, $student);
            }

            $goldSql = "select  SUM(score)/COUNT(*) - SUM(cost)
                        as [Balance]
                        from Users
                        inner join Purchase on Users.id = Purchase.student
                        inner join Inventory on Purchase.item = Inventory.name
                        where Users.id = " . $id;
            $getResults = sqlsrv_query($conn, $goldSql);
            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
            $gold = $row["Balance"];
        ?>

        <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;position:fixed;right:0;left:0;z-index:1030;">
            <div>
                <?php
                echo '<a class="navbar-brand" href="home.php">
                <img src="../images/karsus_logo.png" alt="Logo" style="width:55px">
                </a>'
                ?>
            </div>

            <div class="col" style="color:white">
                <?php
                echo '<h2>Welcome ' . $name . '!</h1>';
                ?>
            </div>

            <div class="col text-right">
                <?php
                echo '<span style="color:gold; font-size:25px">' .
                    $gold . ' <img
                                src="../images/Karsus_coin.png"
                                alt="profile" width=40 height=40
                            />' .

                    '<a href="profile.php">
                            <img
                                src="../images/profile.png"
                                alt="profile" width=40 height=40
                            />
                            </a></span>';
                ?>
            </div>
        </div>

        <div class="container" style="padding-top:100px">
            <div class="card-deck">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title">
                            Classes
                        </h4>
                        <div class="container scroll">
                            <?php
                            for ($i = 0; $i < count($classes); $i++) {
                                echo '<p class="card-text">
                                            <a
                                                class="btn btn-primary w-100"
                                                href ="class.php?course=' . $classes[$i] . '">' . $classes[$i] .
                                    '</a></p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title">Tasks</h4>
                        <div class="container scroll">
                            <p class="card-text">
                                <a href="todo.php">
                                    <button type="button" name="" id="" class="btn btn-secondary w-100 text-left">
                                        <i class="fas fa-clipboard-list"></i> TODO Tasks
                                    </button>
                                </a>
                            </p>
                            <?php
                            for ($i = 0; $i < count($tasks); $i++) {
                                echo '<p class="card-text">
                                            <a
                                                class="btn btn-info w-100 text-left"
                                                href ="task.php?title=' . $tasks[$i]->taskName . '&ccode=' . $tasks[$i]->ccode . '&info=' . $tasks[$i]->info . '&due=' . $tasks[$i]->dueDate . '">' .
                                    $tasks[$i]->getDisplayName() . '
                                            </a></p>';
                            }
                            ?>
                        </div>
                        <div class="container scroll" style="margin-top: 18px;">
                            <p class="card-text">
                                <a href="completed.php">
                                    <button type="button" name="" id="" class="btn btn-secondary w-100 text-left">Completed Tasks</button>
                                </a>
                            </p>
                            <?php
                            for ($i = 0; $i < count($done); $i++) {
                                echo '<p class="card-text">
                                    <button type="button"
                                        class="btn btn-info w-100 text-left"
                                        style="background-color: forestgreen;"
                                    >' . $done[$i]->getDisplayName() . '
                                    </button></p>';
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-deck">
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title">Leaderboard</h4>
                            <?php
                                echo "<select id='filter' onchange='filter();'> 
                                    <option value='Global'>Global</option>";
                                for ($i = 0; $i < count($classes); $i++) {
                                    if ($filter === $classes[$i]) {
                                        echo "<option selected='selected' value='$classes[$i]'>$classes[$i]</option>";
                                    } else {
                                        echo "<option value='$classes[$i]'>$classes[$i]</option>";
                                    }
                                }
                                echo "</select>"
                            ?>

                        <div class="container scroll" id="leaderboard">
                            <table class="table">
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Name</th>
                                    <th scope="col">Avatar</th>
                                    <th scope="col">Score</th>
                                </tr>

                                <?php
                                    for ($i = 0; $i < count($lboard); $i++) {
                                        if ($id == $lboard[$i]->id) {
                                            echo '<tr style="background:yellow">';
                                        } else {
                                            '<tr>';
                                        }
                                        echo  '<th scope="row">' . ($i + 1) . '</th>';
                                        echo '<td>' . $lboard[$i]->name . '</td>';
                                        echo '<td><img src="' . $lboard[$i]->imgsrc . '" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt=""></td>' .
                                            '<td>' . $lboard[$i]->score . '</td>' .
                                            '</tr>';
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="card bg-light">
                    <div class="card-body">
                        <h4 class="card-title">Customise</h4>
                        <a href="customise_new.php">
                            <img src="../images/Avatar.PNG" class="img-thumbnail w-50 mx-auto d-block" alt="Avatar">
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <script>
            function filter() {
                const val = document.getElementById("filter").value;
                location.replace("home.php?filter=" + val + "#leaderboard");
            }

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
            } else if (params["status"] === "answered") {
                alert("You have just completed a task!");
            }
        </script>
    </body>

    <!-- End Page Content -->
    <footer class="page-footer font-small blue" style="background-color:#000000; color:#ffffff;">

        <div class="footer-copyright text-center py-3">Copyright © 2020 Karsus
            <p>All Rights Reserved by Team Karsus</p>
        </div>

    </footer>
</html>
