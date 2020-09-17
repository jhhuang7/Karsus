<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Task</title>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
        <script src="../js/jquery-3.5.1.js"></script>
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>

    <?php
        class Question {
            public string $questionNumber = '-1';
            public string $question = 'Default';
        }

        $title = urldecode($_GET['title']);
        $ccode = urldecode($_GET['ccode']);
        $info = urldecode($_GET['info']);
        $due = urldecode($_GET['due']);

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
            header("Location: home.php");
            exit();
        }

        $tsql = "select * from Questions where title = '" . $title .
            "' and ccode = '" . $ccode . "' and sem>=GETDATE() order by qid";
        $getResults = sqlsrv_query($conn, $tsql);

        $questions = array();
        while ($row = sqlsrv_fetch_array(
                $getResults, SQLSRV_FETCH_ASSOC)) {
            $question = new Question;
            $question->question = $row["info"];
            $question->questionNumber = $row["qid"];
            array_push($questions, $question);
        }

        if (count($questions) == 0) {
            $question = new Question;
            $question->question = "What do your think of this course?";
            array_push($questions, $question);
        }

        $people = array();
        $galaxy = "Select S.email from Students S, Works W 
                WHERE S.id=W.student AND W.ccode='" . $ccode . "' 
                AND W.thing='" . $title . "' AND W.status='C'
                AND W.sem>=GETDATE();";
        $brain = sqlsrv_query($conn, $galaxy);
        while ($row = sqlsrv_fetch_array(
                $brain, SQLSRV_FETCH_ASSOC)) {
            array_push($people, $row["email"]);
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
                <h2>Task</h2>
            </div>

            <div class="col text-right">
                <a href="profile.php">
                    <img src="../images/profile.png" alt="profile" width=40 height=40/>
                </a>
            </div>
        </div>

        <div class="container" style="margin-top: 50px; margin-bottom: 50px">
            <form action="answer.php" method="POST">
                <?php
                    echo '<p>' . $title . ': ' . $ccode . '<br>' .
                        "Description: " . $info .
                        '<br>Due date: ' . $due . '<br>';
                    echo "Who's completed this task: ";
                    echo implode(" ", $people);
                    if (count($people) == 0) {
                        echo "No one";
                    }
                    echo '</p>';

                    $count = count($questions);
                    for ($i = 0; $i < $count ; $i++) {
                        $num = $i + 1;
                        echo '<div class="form-group">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-auto">
                                            <h2>' . $num . '</h2>
                                        </div>
                                        <div class="col">
                                            <label for="q' . $num . '">
                                                ' . $questions[$i]->question . '
                                            </label>
                                            <textarea 
                                                name="'.$num.'" 
                                                class="form-control" 
                                                id="q' . $num . '" 
                                                rows="3" 
                                                required
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>';
                    }

                    echo "<input name='count' type='hidden' value='" . $count . "'/>";

                    $task = $ccode . "+" . $title;
                    echo "<input name='task' type='hidden' value='" . $task . "'/>";
                ?>

                <button class="btn btn-primary float-right" type="submit">
                    Submit Answers
                </button>
            </form>
        </div>
    </body>
</html>
