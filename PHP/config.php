<?php
   define('SERVER', 'YOUR_SERVER');
   define('USERNAME', 'YOUR USERNAME');
   define('PASSWORD', 'YOUR PASSWORD');
   define('TABLE', 'YOUR TABLE NAME');
   $database = new mysqli(SERVER,USERNAME,PASSWORD,TABLE);
if ($database->connect_errno) {
    die("Connection failed." . mysqli_connect_error());
}
?>
