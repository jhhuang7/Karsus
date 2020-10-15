<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>TODO Tasks</title>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css"
        <link rel="stylesheet" href="../css/style1.css"/>
        <link rel="stylesheet" href="../css/style3.css"/>
        <link rel="stylesheet" href="../css/style4.css"/>
        <link href="https://fonts.googleapis.com/css2?family=Lato&display=swap" rel="stylesheet">
        <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@500&display=swap" rel="stylesheet">
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </head>

    <?php
        session_start();
        $id = $_SESSION["id"];

        class Task {
            public string $taskName = 'Default';
            public string $ccode = 'Default';
            public string $info = "Default";
            public string $dueDate = "Default";

            public function getDisplayName() {
                return $this->ccode . ': ' . $this->taskName;
            }
        }

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

        $taskSql = "SELECT thing, T.ccode, info, W.status, 
            FORMAT(due, 'dd/MM/yyyy') as date from Work W, Tasks T 
            where W.student=" . $id . " and W.status='I' and W.ccode=T.ccode 
            and W.thing=T.title and W.sem=T.sem and W.sem>=GETDATE() order by T.due";
        $getResults = sqlsrv_query($conn, $taskSql);
        $tasks = array();

        while ($row = sqlsrv_fetch_array($getResults,
                SQLSRV_FETCH_ASSOC)) {
            if ($row["status"] == "I") {
                $task = new Task;
                $task->taskName = $row["thing"];
                $task->ccode = $row["ccode"];
                $task->dueDate = $row["date"];
                $task->info = $row["info"];
                array_push($tasks, $task);
            }
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
                <h2>TODO Tasks</h2>
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

        <br>
        <div class="tasks">
            <div class="card-deck">
                <div class="card">
                    <div class="card-body">
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
                </div>
            </div>
        </div>
    </body>
</html>
