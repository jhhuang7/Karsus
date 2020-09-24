<?php
    $course = $_GET["course"];
    // Will need to get the semester as well

    echo "<h1>Add Task</h1>";

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
