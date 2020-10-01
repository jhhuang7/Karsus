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

            $semester = "";
            while ($row1 = sqlsrv_fetch_array($getResults1,
                SQLSRV_FETCH_ASSOC)) {
                array_push($classes, $row1["code"]);
                $semester = $row1["sem"];
            }
            $_SESSION["sem"] = $semester;
        ?>

        <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;position:fixed;right:0;left:0;z-index:1030;">
            <div>
                <?php
                    echo '<a class="navbar-brand" href="home2.php">
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
                    echo '<span style="color:gold; font-size:25px">
                            <a href="profile.php">
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
                                <button class="btn btn-success float-left">
                                    Add Class
                                </button>
                            </a>
                        </div>
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
            } else if (params["status"] === "added") {
                alert("You have successfully added a new class!");
            }
        </script>
    </body>
</html>
