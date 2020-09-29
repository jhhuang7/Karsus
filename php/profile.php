<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Profile</title>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Merriweather">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
        <style>
              body{
                background-color: #F0FFFF;
              }
              h1{
                  font-family: "Merriweather", serif;
                text-decoration: underline;
              }
        </style>

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

        $tsql = 'select * from Users where id = ' . $id;
        $getResults = sqlsrv_query($conn, $tsql);

        if ($getResults == FALSE) {
            // Query problem
            header("Location: home.php");
            exit();
        }

        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);

        $type = $row["type"];
    ?>
    <div class="navbar navbar-expand-md bg-dark navbar-dark">
        <div>
            <?php
                if ($type === 'S') {
                    echo '<a class="navbar-brand" href="home.php">';
                } else {
                    echo '<a class="navbar-brand" href="home2.php">';
                }
                echo '<img src="../images/karsus_logo.png" alt="Logo" style="width:55px"></a>';
            ?>
        </div>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item">
              <a class="nav-link" href="../index.html?status=loggedout" style="font-size:22px;"><i class="fas fa-sign-out-alt fa-md"></i>  Log Out</a>
            </li>
            </ul>
      </div>
      </head>
    <body>
      <br>
      <h1 class="w3-center w3-animate-top w3-animate-left">Edit Profile</h1>
        <div class="container">
            <form action="update.php" method="POST">
                <div class="form-group">
                    <label for="sid" onclick="lockedParam();">Student ID</label>
                    <input type="text" class="form-control" id="sid" value="<?php echo $row['id'] ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="first">First Name</label>
                    <input type="text" class="form-control" id="first" name="first" value="<?php echo $row['FirstName'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="last">Last Name</label>
                    <input type="text" class="form-control" id="last" name="last" value="<?php echo $row['LastName'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value="<?php echo $row['email'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="phone">Phone number</label>
                    <input type="number" class="form-control" id="phone" name="phone" value="<?php echo $row['phone'] ?>" required>
                </div>
                <div class="form-group">
                    <label for="pw">Password</label>
                    <input type="password" class="form-control" id="pw" name="pw" placeholder="Your Password" required>
                </div>
                <div class="form-group">
                    <label for="score" onclick="lockedParam();">Score</label>
                    <input type="text" class="form-control" id="score" value="<?php echo $row['score'] ?>" disabled>
                </div>
                <div class="form-group">
                    <label for="type" onclick="lockedParam();">Account Type</label>
                    <input type="text" class="form-control" id="type" name="type" value="<?php echo $row['type'] ?>" readonly>
                </div>
                <button type="submit" class="btn btn-success float-right">Update Details</button>
            </form>
            <?php
                if ($type === 'S') {
                    echo '<a class="btn btn-primary float-right" href="home.php" role="button">';
                } else {
                    echo '<a class="btn btn-primary float-right" href="home2.php" role="button">';
                }
                echo '<i class="fas fa-home"></i> Back to Home</a>';
            ?>
          </div>
            <script>
                function lockedParam() {
                    alert("You can't change this detail, as it is locked up!");
                }
            </script>
    </body>
  <br>
<br>
    <!-- End Page Content -->
    <footer class="page-footer font-small blue" style="background-color:#000000; color:#ffffff;">

        <div class="footer-copyright text-center py-3">Copyright © 2020 Karsus
            <p>All Rights Reserved by Team Karsus</p>
        </div>

    </footer>
</html>
