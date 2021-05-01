<?php
   define('SERVER', 'dijkstra.ug.bcc.bilkent.edu.tr');
   define('USERNAME', 'ali.altunsoy');
   define('PASSWORD', 'WkhYQAxv');
   define('TABLE', 'ali_altunsoy');
   $database = new mysqli(SERVER,USERNAME,PASSWORD,TABLE);
if ($database->connect_errno) {
    die("Connection failed." . mysqli_connect_error());
}
?>
