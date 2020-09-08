<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Class</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
    <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
    <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
    <script src="../js/jquery-3.5.1.js"></script>
</head>

<?php

class Student
{
    public string $firstName;
    public string $lastName;
}

class Task
{
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

$q1 = "SELECT * FROM Class WHERE code ='" . $course . "';";
$results1 = sqlsrv_query($conn, $q1);

$q3 = "SELECT S.FirstName, S.LastName FROM Students S, Enrollment E 
                WHERE E.class ='" . $course . "' AND E.student=S.id 
                ORDER BY S.score DESC, S.LastName;";
$results3 = sqlsrv_query($conn, $q3);

$q4 = "SELECT title, info, FORMAT(due, 'dd/MM/yyyy') as date 
                FROM Task WHERE ccode ='" . $course . "' ORDER BY due;";
$results4 = sqlsrv_query($conn, $q4);

if (
    $results1 == false
    or $results3 == false or $results4 == false
) {
    // Query problem
    header("Location: home.php");
    exit();
}

$row1 = sqlsrv_fetch_array($results1, SQLSRV_FETCH_ASSOC);
$courseInfo = $row1["info"];

$students = array();
while ($row3 = sqlsrv_fetch_array(
    $results3,
    SQLSRV_FETCH_ASSOC
)) {
    $student = new Student;
    $student->firstName = $row3["FirstName"];
    $student->lastName = $row3["LastName"];
    array_push($students, $student);
}

$tasks = array();
while ($row4 = sqlsrv_fetch_array(
    $results4,
    SQLSRV_FETCH_ASSOC
)) {
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
            <h2>Class</h2>
        </div>

        <div class="col text-right">

            <a href="profile.php">
                <img src="../images/profile.png" alt="profile" width=40 height=40 />
            </a>';

        </div>
    </div>

    <div class="container" style="margin-top: 50px;">
        <p class="h1">
            <?php echo $course ?>
        </p>
        <p class="h2">Class Description</p>
        <p><?php echo $courseInfo ?></p>
        <p class="h3">
            Members
            <ul>
                <?php
                for ($i = 0; $i < count($students); $i++) {
                    echo '<li>' . $students[$i]->firstName . ' ' . $students[$i]->lastName . '</li>';
                }
                ?>
            </ul>
        </p>
        <p class="h3">Tasks</p>
        <div class="list-group">
            <?php
            for ($i = 0; $i < count($tasks); $i++) {
                echo '<a href="task.php?title=' . $tasks[$i]->title . '&ccode=' . $course . '&info=' . $tasks[$i]->info . '&due=' . $tasks[$i]->dueDate . '"
                             class="list-group-item list-group-item-action flex-column align-items-start">
                    <div class="d-flex w-100 justify-content-between">
                        <h5 class="mb-1">' . $tasks[$i]->title . '</h5>
                        <small>' . $tasks[$i]->dueDate . '</small>
                    </div>
                    <p class="mb-1">' . $tasks[$i]->info . '</p>
                    </a>';
            }
            ?>

        </div>
    </div>


</body>

</html>