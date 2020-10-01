<html lang="en">
    <head>
        <meta charset="UTF-8">
        <title>Add Task</title>
        <link rel="icon" type="image/x-icon" href="../images/karsus.ico">
        <link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">
        <script src="https://kit.fontawesome.com/776f279b3d.js" crossorigin="anonymous"></script>
        <script src="../bootstrap/js/bootstrap.min.js"></script>
    </head>

    <body>
        <div class="navbar navbar-expand-md bg-dark navbar-dark" style="background:beige;">
            <div>
                <a class="navbar-brand" href="home2.php">
                    <img src="../images/karsus_logo.png" alt="Logo" style="width:55px">
                </a>
            </div>

            <div class="col" style="color:white">
                <h2>Add Task</h2>
            </div>

            <div class="col text-right">
                <a href="profile.php">
                    <img src="../images/profile.png" alt="profile" width=40 height=40 />
                </a>
            </div>
        </div>

        <?php
            $course = $_GET["course"];
            // Will need to get the semester as well

            echo "<h2>Title</h2>";
            echo "<input />";

            echo "<h2>Due date</h2>";
            echo "<input />";

            echo "<h2>Description</h2>";
            echo "<input />";

            echo "<h2>Questions</h2>";
            echo "<textarea></textarea>";

            echo "<hr>";
            echo "<a href='class_info.php'><button>Submit</button></a>";
            echo "(Tries to add task then return to class_info.php with status.)";
        ?>
    </body>
</html>
