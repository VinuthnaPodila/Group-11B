<!-- Include Header -->
<?php
session_start(); 
include("./header.php"); 
?>


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px; min-height:70vh">
    <!-- My Quotes Table -->
    <div class="w3-container" id="myQuotes" style="margin-top: 40px">
        <h1 class="w3-xxlarge w3-text-blue"><b>ALL DRONES</b></h1>
        <a href="addDrone.php" class="btn btn-primary"><b>Add Drone</b></a>
        <hr style="width: 50px; border: 5px solid blue" class="w3-round">

        <!-- Display Quotes in a Table -->
        <div class="table-responsive">
            <table class="w3-table-all">
                <thead>
                    <thead>
                        <tr class="w3-blue">
                            <th>S.N.</th>
                            <th>Name</th>
                            <th>Model</th>
                            <th>Weight</th>
                            <th>Max Payload</th>
                            <th>RST Number</th>
                            <th>Battery Life</th>
                            <th>Flight Logs</th>
                            <th>Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>

                </thead>
                <tbody>
                    <?php 
                $company_id = $_SESSION['user_id'];
                $count = 1;
                // Query to fetch all drones for the logged-in company 
                $query = "SELECT * FROM drones WHERE company_id = '$company_id' ORDER BY drone_id DESC";
                $result = mysqli_query($connect, $query);

                while ($dron = mysqli_fetch_assoc($result)) {
                ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=$dron['drone_name']?></td>
                        <td><?=$dron['drone_model']?></td>
                        <td><?=$dron['weight']?></td>
                        <td><?=$dron['max_payload']?></td>
                        <td><?=$dron['registration_number']?></td>
                        <td><?=$dron['battery_life']?></td>
                        <td><?=$dron['flight_logs']?></td>
                        <td><?=$dron['date']?></td>
                        <td>
                            <a href="?id=<?=$dron['drone_id']?>&action=delete">
                                <button class="btn btn-danger"><b>Delete</b></button>
                            </a>
                        </td>
                    </tr>
                    <?php
    }
    ?>
                </tbody>

            </table>
        </div>
    </div>
</div>



<!-- Include Footer -->
<?php include("./footer.php"); ?>


<!-- Backend code for removing order -->
<?php
if (isset($_GET['action']) && $_GET['action'] == 'delete') {
    
    $drone_id = $_GET['id']; 
    
    // Execute query to delete the order
    $delete_query = "DELETE FROM drones WHERE drone_id = '$drone_id'";
    $delete_result = mysqli_query($connect, $delete_query);

    if ($delete_result) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Great, Drone Deleted Successfully!",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

        echo "<script> setTimeout(function(){ window.location.href = 'companyDrone.php'; }, 1000); </script>";

    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Sorry, Failed to delete drone.",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'companyDrone.php'; }, 1000); </script>";

    }
}
?>
<!-- Backend code for removing order -->