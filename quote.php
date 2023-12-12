<!-- Include Header -->
<?php include("./header.php"); ?>

<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px">

    <!-- Order Placement -->
    <div class="w3-container" id="order" style="margin-top:30px">
        <div class="d-flex">
            <h1 class="w3-xxlarge w3-text-red"><b>SEND QUOTE REQUEST</b></h1>
            <a href="myQuote.php" class="w3-button w3-red w3-margin-left">My Quotes</a>
        </div>

        <hr style="width:50px;border:5px solid red" class="w3-round">
        <!-- Order Form -->
        <form method="POST" enctype="multipart/form-data">
            <div class="w3-section">
                <label for="image"><b>Prescription Image:</b></label>
                <input id="image" class="w3-input w3-border" type="file" name="image" accept="image/*" required>
            </div>
            <div class="w3-section">
                <label for="delivery_type"><b>Delivery Type:</b></label>
                <select id="delivery_type" class="w3-select w3-border" name="delivery_type" required>
                    <option value="" disabled selected>Select delivery type</option>
                    <option value="normal">Normal</option>
                    <option value="overnight">Overnight</option>
                </select>
            </div>
            <div class="row d-flex">
                <div class="col-md-9">
                    <div class="w3-section">
                        <label for="delivery_address"><b>Delivery Address:</b></label>
                        <input id="delivery_address" class="w3-input w3-border" type="text" name="delivery_address"
                            required>
                    </div>

                </div>
                <div class="col-md-3">
                    <div class="w3-section">
                        <label for="zip_code"><b>Zip Code:</b></label>
                        <input id="zip_code" class="w3-input w3-border" type="text" name="zip_code" required>
                    </div>
                </div>
            </div>
            <div class="w3-section">
                <label for="other_service"><b>Other Service:</b></label>
                <input id="other_service" class="w3-input w3-border" type="text" name="other_service" required>
            </div>
            <div class="w3-row-padding">
                <div class="w3-half w3-section">
                    <label for="latitude"><b>Latitude:</b></label>
                    <input id="latitude" class="w3-input w3-border" type="text" name="latitude">
                </div>
                <div class="w3-half w3-section">
                    <label for="longitude"><b>Longitude:</b></label>
                    <input id="longitude" class="w3-input w3-border" type="text" name="longitude">
                </div>
            </div>

            <button type="submit" name="Request" class="w3-button w3-block w3-padding-large w3-red w3-margin-bottom">
                <b>Send Request</b>
            </button>
        </form>

    </div>


</div>
<!-- End page content -->

<!-- Include Footer -->
<?php include("./footer.php"); ?>


<!-- Backend Code for Quote -->
<?php
if (isset($_POST['Request'])) {
    // Fetch form data
    $delivery_type = $_POST['delivery_type'];
    $delivery_address = $_POST['delivery_address'];
    $zip_code = $_POST['zip_code'];
    $other_service = $_POST['other_service'];
    $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];
    $user_id = $_SESSION['user_id'];
    $name = $_SESSION['name'];
    $number = $_SESSION['number'];

    // Handle image upload
    $targetDir = "Upload/";
    $targetFile = $targetDir . basename($_FILES["image"]["name"]);

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
        // Assuming the connection variable is $conn
        $sql = "INSERT INTO quotes (delivery_type, delivery_address, zip_code, other_service, latitude, longitude, image, user_id, user_name, user_number)
                VALUES ('$delivery_type', '$delivery_address', '$zip_code', '$other_service', '$latitude', '$longitude', '$targetFile', '$user_id', '$name', '$number')";

        if (mysqli_query($connect, $sql)) {
            echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Request Sent!",
                    showConfirmButton: false,
                    timer: 1500
                })
                </script>';

                echo "<script> setTimeout(function(){ window.location.href = 'myQuote.php'; }, 1000); </script>";

        } else {
            echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error!",
                    text: "Failed to send request.",
                    showConfirmButton: false,
                    timer: 1500
                });
                </script>';

                echo "<script> setTimeout(function(){ window.location.href = 'myQuote.php'; }, 1000); </script>";
        }
    } else {
        echo '<script>
            Swal.fire({
                icon: "error",
                title: "Error!",
                text: "Failed to upload image.",
                showConfirmButton: false,
                timer: 1500
            });
            </script>';

            echo "<script> setTimeout(function(){ window.location.href = 'myQuote.php'; }, 1000); </script>";
    }
}
?>

<!-- Backend Code for Quote -->