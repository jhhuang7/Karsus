<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Profile</title>
    <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
    <script src="../bootstrap/js/bootstrap.min.js"></script>
</head>

<?php
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

$tsql = 'select * from Students where id = ' . $id;
$getResults = sqlsrv_query($conn, $tsql);

if ($getResults == FALSE) {
    // Query problem
    header("Location: home.php");
    exit();
}

$row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
?>

<body>

    <div class="container" style="margin-top: 50px; margin-bottom: 50px">
        <form action="update.php" method="POST">
            <p class="h1">Profile</p>
            <a class="btn btn-primary" href="../index.html?status=loggedout" role="button">Log out</a>
            <a class="btn btn-primary" href="home.php" role="button">Back to Home</a>
            <div class="form-group">
                <label for="sid">Student ID</label>
                <input type="text" class="form-control" id="sid" value="<?php echo $row['id'] ?>" disabled>
            </div>
            <div class="form-group">
                <label for="first">First Name</label>
                <input type="text" class="form-control" id="first" name="first" value="<?php echo $row['FirstName'] ?>">
            </div>
            <div class="form-group">
                <label for="last">Last Name</label>
                <input type="text" class="form-control" id="last" name="last" value="<?php echo $row['LastName'] ?>">
            </div>
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email'] ?>">
            </div>
            <div class="form-group">
                <label for="phone">Phone number</label>
                <input type="number" class="form-control" id="phone" name="phone" value="<?php echo $row['phone'] ?>">
            </div>
            <div class="form-group">
                <label for="pw">Password</label>
                <input type="password" class="form-control" id="pw" name="pw">
            </div>
            <div class="form-group">
                <label for="score">Score</label>
                <input type="text" class="form-control" id="score" value="<?php echo $row['score'] ?>" disabled>
            </div>
            <button type="submit" class="btn btn-primary float-right">Update Details</button>
        </form>

        <script>
            function lockedParam() {
                alert("You can't change this detail, as it is locked up!");
            }
        </script>
</body>

</html>