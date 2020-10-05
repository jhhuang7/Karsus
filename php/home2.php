<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Home</title>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
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
                background-image: linear-gradient(to right, rgba(255, 0, 0, 0), rgba(116, 209, 76, 1));
            }
            </style>

        <?php
            session_start();
            $id = $_SESSION["id"];

            $serverName = "tcp:karsus.database.windows.net,1433";
            $connectionOptions = array("UID" => "karsus", "PWD" => "K@rth0us",
                "Database" => "Karsus", "LoginTimeout" => 30,
                "Encrypt" => 1, "TrustServerCertificate" => 0);

            $conn = sqlsrv_connect($serverName, $connectionOptions);
            if ($conn == false) {
                // Connection problem
                header("Location: ../index.html");
                exit();
            }

            // Get teacher's name
            $tsql = "SELECT FirstName FROM Users WHERE id =" . $id . ";";
            $getResults = sqlsrv_query($conn, $tsql);
            if ($getResults == false) {
                // Query problem
                header("Location: ../index.html");
                exit();
            }
            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
            $name = $row["FirstName"];

            $classes = array();
            $tsql1 = "SELECT * FROM Classes WHERE teacher=" . $id . " AND sem>=GETDATE();";
            $getResults1 = sqlsrv_query($conn, $tsql1);
            if ($getResults1 == false) {
                // Query problem
                header("Location: ../index.html");
                exit();
            }

            while ($row1 = sqlsrv_fetch_array($getResults1,
                SQLSRV_FETCH_ASSOC)) {
                array_push($classes, $row1['code']);
            }
        ?>
        <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;">
            <div>
                <a class="navbar-brand" href="home.php">
                    <img src="../images/karsus_logo.png" alt="Logo" style="width:55px">
                </a>

            </div>

            <div class="col" style="color:white">
                <h2><?php
                    echo '<h2>Welcome ' . $name . '!</h1>';
                ?></h2>
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
        <div class="w3-sidebar w3-bar-block w3-black " style="width:10%">
          <a href="home2.php" class="w3-bar-item w3-button">Dashboard</a>
          <div class="w3-dropdown-hover">
            <button class="w3-button w3-black">My Courses</button>
          <div class="w3-dropdown-content w3-bar-block w3-border">
            <?php
                for ($i = 0; $i < count($classes); $i++) {
                    echo '<p class="card-text">
                            <a
                                class="btn btn-link w-100"
                                href ="class_info.php?course=' . $classes[$i] . '">' . $classes[$i] .
                        '</a></p>';
                }
            ?>
          </div>
        </div>
          <a href="profile.php" class="w3-bar-item w3-button">Edit Profile</a>
          <a href="../index.html?status=loggedout" class="w3-bar-item w3-button w3-hover-red">Log Out</a>
        </div>
        </head>
        <body>
        <div style="margin-left:10%">
        <div class="w3-container " style="padding-top:20px" >
          <h2 style="font-weight:bold; font-family:Lato, sans-serif">Dashboard</h2>
            <div class="card-deck">
                <div class="card bg-light">
                  <div class="card-header" style="background-color:#248280;">
                  <h4 style="color:white; font-weight:bold;">My Courses</h4>
                  </div>
                    <div class="card-body">
                        <div class="container scroll">
                            <?php
                                for ($i = 0; $i < count($classes); $i++) {
                                    echo '<p class="card-text">
                                            <a
                                                class="btn btn-primary w-100"
                                                href ="class_info.php?course=' . $classes[$i] . '">' . $classes[$i] .
                                        '</a></p>';
                                }
                            ?>

                            <a href="add_class.php">
                                <button class="btn btn-danger float-right">
                                    Add Class
                                </button>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-deck">
                <div class="card bg-light">
                  <div class="card-header" style="background-color:#248280;">
                  <h4 style="color:white; font-weight:bold;">My Profile</h4>
                  </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
      </div>


        </body>
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
            } else if (params["status"] === "added") {
                alert("You have successfully added a new class!");
            }
        </script>
    </body>
</html>
