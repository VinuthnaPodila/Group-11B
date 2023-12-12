<!-- Include Header -->
<?php include("./header.php"); ?>


<?php
// execute queries
$query1 = mysqli_query($connect, "SELECT * from users WHERE user_type = 'User' ");
$query2 = mysqli_query($connect, "SELECT * from users WHERE user_type = 'Company' ");
$query3 = mysqli_query($connect, "SELECT * from deliveries ");
$query4 = mysqli_query($connect, "SELECT * from quotes ");
// store totals
$count1 = mysqli_num_rows($query1);
$count2 = mysqli_num_rows($query2);
$count3 = mysqli_num_rows($query3);
$count4 = mysqli_num_rows($query4);

?>


<style>
.card {
    width: 300px;
    height: 200px;
    transition: transform 0.3s;
    cursor: pointer;
}

.card:hover {
    transform: translateY(-10px);
    box-shadow: 0px 10px 20px rgba(0, 0, 0, 0.1);
}

.card .content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;
    height: 100%;
    text-align: center;

}

.card .content h5 {
    font-size: 24px;
    margin-bottom: 10px;
}

.card .content p {
    font-size: 36px;
    font-weight: bold;
    margin: 0;
}
</style>


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px;min-height:70vh">

    <!-- Header -->
    <div class="w3-container" style="margin-top:50px" id="showcase">
        <h1 class="w3-jumbo"><b>Drone Delivery Management</b></h1>
        <h1 class="w3-xxxlarge w3-text-blue"><b>Company Management</b></h1>
        <hr style="width:50px;border:5px solid blue" class="w3-round">
    </div>

    <div class="w3-row-padding mt-5">
        <div class="d-flex">
            <div class="card w3-hover-shadow" onclick="onClick(this)">
                <div class="content w3-green">
                    <h5><b>Total Users</b></h5>
                    <p><?php echo $count1; ?></p>
                </div>
            </div>
            <div class="card w3-hover-shadow" onclick="onClick(this)">
                <div class="content w3-red">
                    <h5><b>Total Company</b></h5>
                    <p><?php echo $count2; ?></p>
                </div>
            </div>
            <div class="card w3-hover-shadow" onclick="onClick(this)">
                <div class="content w3-blue">
                    <h5><b>Total Deliveries</b></h5>
                    <p><?php echo $count3; ?></p>
                </div>
            </div>
            <div class="card w3-hover-shadow" onclick="onClick(this)">
                <div class="content w3-yellow">
                    <h5><b>Total Quotes</b></h5>
                    <p><?php echo $count4; ?></p>
                </div>
            </div>
        </div>
    </div>




</div>
<!-- End page content -->


<!-- Include Footer -->
<?php include("./footer.php"); ?>