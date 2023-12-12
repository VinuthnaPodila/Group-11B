<?php include("../DB/connection.php"); ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Drone Delivery Management</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Poppins">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
    body,
    h1,
    h2,
    h3,
    h4,
    h5 {
        font-family: "Poppins", sans-serif
    }

    body {
        font-size: 16px;
    }

    .w3-half img {
        margin-bottom: -6px;
        margin-top: 16px;
        opacity: 0.8;
        cursor: pointer
    }

    .w3-half img:hover {
        opacity: 1
    }
    </style>
</head>

<body>

    <!-- Sidebar/menu -->
    <nav class="w3-sidebar w3-blue w3-collapse w3-top w3-large w3-padding"
        style="z-index:3;width:260px;font-weight:bold;" id="mySidebar"><br>
        <a href="javascript:void(0)" onclick="w3_close()" class="w3-button w3-hide-large w3-display-topleft"
            style="width:100%;font-size:25px">Close Menu</a>

        <div class="w3-container text-center">
            <img src="../IMG/drone2.png" style="max-width:100px" class="img-fluid" alt="Description of the image">
            <h3 class="pb-3"><b>Company<br>Dashboard</b></h3>
        </div>
        <div class="w3-bar-block">
            <a href="index.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white mb-2"><i
                    class="fas fa-home"></i>
                Dashboard</a>
            <a href="companyDrone.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white mb-2"><i
                    class="fas fa-plane"></i> Drones</a>
            <a href="companyDelivery.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white mb-2"><i
                    class="fas fa-shipping-fast"></i> Deliveries</a>
            <a href="./profile.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white mb-2"><i
                    class="fas fa-user"></i> Profile</a>
            <a href="../logout.php" onclick="w3_close()" class="w3-bar-item w3-button w3-hover-white mb-2"><i
                    class="fas fa-sign-out-alt"></i> Logout</a>

        </div>
    </nav>

    <!-- Top menu on small screens -->
    <header class="w3-container w3-top w3-hide-large w3-blue w3-xlarge w3-padding">
        <a href="javascript:void(0)" class="w3-button w3-blue w3-margin-right" onclick="w3_open()">☰</a>
        <span>Drone Delivery Management</span>
    </header>

    <!-- Overlay effect when opening sidebar on small screens -->
    <div class="w3-overlay w3-hide-large" onclick="w3_close()" style="cursor:pointer" title="close side menu"
        id="myOverlay"></div>