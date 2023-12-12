<?php

$connect = mysqli_connect("localhost", "root", "", "drone_delivery");

if($connect)
{
    // echo "Connection Done!";
}
else
{
    echo "Connection Failed!";
}

?>