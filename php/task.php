<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Task</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</head>

<?php

class Question
{
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

$tsql = "select * from Questions where title = '" . $title . "' and ccode = '" . $ccode . "' order by qid";
$getResults = sqlsrv_query($conn, $tsql);

$questions = array();
while ($row = sqlsrv_fetch_array(
    $getResults,
    SQLSRV_FETCH_ASSOC
)) {

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

?>

<body>
    <div class="container" style="margin-top: 50px; margin-bottom: 50px">
        <form>
            <p class="h1">Task</p>

            <p>
                Task info:
                title, course, description, due date,
                who's completed this task.
            </p>

            <?php

            echo '<p>' . $title . ': ' . $ccode . '<br>' . $info . '<br>Due date: ' . $due . '</p>';

            for ($i = 0; $i < count($questions); $i++) {
                $num = $i + 1;
                echo '<div class="form-group">
                        <div class="container">
                            <div class="row">
                                <div class="col-md-auto">
                                    <h2>' . $num . '</h2>
                                </div>
                                <div class="col">
                                    <label for="q' . $num . '">' . $questions[$i]->question . '</label>
                                    <textarea class="form-control" id="q' . $num . '" rows="3"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>';
            }
            ?>

            <!--                Actual questions will be pulled from DB!-->
            <!-- <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-md-auto">
                            <h2>1</h2>
                        </div>
                        <div class="col">
                            <label for="q1">Would you like vanilla ice cream?</label>
                            <textarea class="form-control" id="q1" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-md-auto">
                            <h2>2</h2>
                        </div>
                        <div class="col">
                            <label for="q2">Have you ever met Joe before?</label>
                            <textarea class="form-control" id="q2" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-md-auto">
                            <h2>3</h2>
                        </div>
                        <div class="col">
                            <label for="q3">Where did you go to college?</label>
                            <textarea class="form-control" id="q3" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-md-auto">
                            <h2>4</h2>
                        </div>
                        <div class="col">
                            <label for="q4">What is your best quality?</label>
                            <textarea class="form-control" id="q4" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="container">
                    <div class="row">
                        <div class="col-md-auto">
                            <h2>5</h2>
                        </div>
                        <div class="col">
                            <label for="q5">Do you have a pet?</label>
                            <textarea class="form-control" id="q5" rows="3"></textarea>
                        </div>
                    </div>
                </div>
            </div> -->
            <button type="submit" class="btn btn-primary float-right" onclick="alert('Score based on length of answers.');">
                Submit Answers
            </button>
        </form>
    </div>

    <form action="home.php">
        <button>Back to Home</button>
    </form>
</body>

</html>