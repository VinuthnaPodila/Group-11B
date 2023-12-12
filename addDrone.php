<!-- Include Header -->
<?php
session_start(); 
include("./header.php"); 
?>


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px">

    <!-- Registration Section -->
    <div class="w3-container" style="margin-top:50px" id="registration">
        <h1 class="w3-xxxlarge w3-text-blue"><b>Add Drone</b></h1>
        <hr style="width:50px;border:5px solid blue" class="w3-round">
        <p>Fill out the form below to add new drone.</p>
        <form method="POST">

            <div class="w3-row">
                <div class="w3-half ">
                    <label><b>Drone Name</b></label>
                    <input class="w3-input w3-border" style="width:99%" type="text" name="drone_name" required
                        value="<?php echo isset($_POST['drone_name']) ? htmlspecialchars($_POST['drone_name']) : ''; ?>">
                </div>
                <div class="w3-half">
                    <label><b>Drone Model</b></label>
                    <input class="w3-input w3-border" style="width:99%" type="text" name="drone_model" required
                        value="<?php echo isset($_POST['drone_model']) ? htmlspecialchars($_POST['drone_model']) : ''; ?>">
                </div>
            </div>
            <div class="w3-row">
                <div class="w3-half w3-section">
                    <label><b>Weight</b></label>
                    <input class="w3-input w3-border" style="width:99%" type="text" name="weight" required
                        value="<?php echo isset($_POST['weight']) ? htmlspecialchars($_POST['weight']) : ''; ?>">
                </div>
                <div class="w3-half w3-section">
                    <label><b>Max Payload</b></label>
                    <input class="w3-input w3-border" style="width:99%" type="text" name="max_payload" required
                        value="<?php echo isset($_POST['max_payload']) ? htmlspecialchars($_POST['max_payload']) : ''; ?>">
                </div>
            </div>

            <div class="w3-section">
                <label><b>Registration Number</b></label>
                <input class="w3-input w3-border" type="text" name="registration_number" required
                    value="<?php echo isset($_POST['registration_number']) ? htmlspecialchars($_POST['registration_number']) : ''; ?>">
            </div>
            <div class="w3-section">
                <label><b>Battery Life</b></label>
                <input class="w3-input w3-border" type="text" name="battery_life" required
                    value="<?php echo isset($_POST['battery_life']) ? htmlspecialchars($_POST['battery_life']) : ''; ?>">
            </div>
            <div class="w3-section">
                <label><b>Flight Logs</b></label>
                <input class="w3-input w3-border" type="text" name="flight_logs" required
                    value="<?php echo isset($_POST['flight_logs']) ? htmlspecialchars($_POST['flight_logs']) : ''; ?>">
            </div>
            <!-- Additional fields based on your requirements -->
            <!-- User Type, Date, etc. -->

            <button type="submit" class="w3-button w3-block w3-padding-large w3-blue w3-margin-bottom"
                name="AddDrone"><b>Add Drone</b></button>
        </form>

    </div>

</div>
<!-- End page content -->

<!-- Include Footer -->
<?php include("./footer.php"); ?>


<!-- Backend cod for register -->
<?php
if (isset($_POST['AddDrone'])) {

    $company_id = $_SESSION['user_id'];
    $drone_name = $_POST['drone_name'];
    $drone_model = $_POST['drone_model'];
    $weight = $_POST['weight'];
    $max_payload = $_POST['max_payload'];
    $registration_number = $_POST['registration_number'];
    $battery_life = $_POST['battery_life'];
    $flight_logs = $_POST['flight_logs'];
    // Add other drone fields as required

    // Assuming you have established a database connection ($connect)
    $user_id = $_SESSION['user_id']; // Fetch user ID from the session

    $query_drone = mysqli_query($connect, "INSERT INTO drones (drone_name, drone_model, `weight`, max_payload, registration_number, battery_life, flight_logs, company_id) 
    VALUES ('$drone_name', '$drone_model', '$weight', '$max_payload', '$registration_number', '$battery_life', '$flight_logs', '$company_id')");

    if ($query_drone) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Drone Added Successfully!",
                    showConfirmButton: false,
                    timer: 1500
                }).then(() => {
                    window.location.href = "adminCompany.php";
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'companyDrone.php'; }, 1000); </script>";

    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Failed to add drone.",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'companyDrone.php'; }, 1000); </script>";

    }
}
?>