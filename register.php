<!-- Include Header -->
<?php include("./header.php"); ?>


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px">

    <!-- Registration Section -->
    <div class="w3-container" style="margin-top:50px" id="registration">
        <h1 class="w3-xxxlarge w3-text-red"><b>Register Now</b></h1>
        <hr style="width:50px;border:5px solid red" class="w3-round">
        <p>Join us today! Fill out the form below to create your account.</p>
        <form method="POST">
            <div class="w3-section">
                <label><b>Name</b></label>
                <input class="w3-input w3-border" type="text" name="name" required
                    value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            </div>
            <div class="w3-section">
                <label><b>Number</b></label>
                <input class="w3-input w3-border" type="number" name="number" required
                    value="<?php echo isset($_POST['number']) ? htmlspecialchars($_POST['number']) : ''; ?>">
            </div>
            <div class="w3-section">
                <label><b>Email</b></label>
                <input class="w3-input w3-border" type="email" name="email" required
                    value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>
            <div class="w3-section">
                <label><b>Password</b></label>
                <input class="w3-input w3-border" type="password" name="password" required>
            </div>
            <div class="w3-section">
                <label><b>Confirm Password</b></label>
                <input class="w3-input w3-border" type="password" name="cpassword" required>
            </div>
            <!-- Additional fields based on your requirements -->
            <!-- User Type, Date, etc. -->

            <button type="submit" class="w3-button w3-block w3-padding-large w3-red w3-margin-bottom"
                name="Register"><b>REGISTER</b></button>
        </form>
    </div>

</div>
<!-- End page content -->

<!-- Include Footer -->
<?php include("./footer.php"); ?>


<!-- Backend cod for register -->
<?php
if (isset($_POST['Register'])) {


    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $cpassword = $_POST['cpassword']; 
    
    // Check if email already exists
    $check_email = mysqli_query($connect, "SELECT * FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Email already exists!",
                });
             </script>';
    } elseif ($password != $cpassword) { 
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Passwords do not match!",
                });
             </script>';
    } else {
        // Insert user data into the database
        $query = mysqli_query($connect, "INSERT INTO users (name, number, email, password) 
        VALUES ('$name', '$number', '$email', '$password')");

        if ($query) {
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Registration Successful!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                 </script>';

                 echo "<script> setTimeout(function(){ window.location.href = 'login.php'; }, 1000); </script>";

        } else {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Failed to register user.",
                        showConfirmButton: false,
                        timer: 1500
                    });
                 </script>';

                 echo "<script> setTimeout(function(){ window.location.href = 'login.php'; }, 1000); </script>";

        }
    }
}
?>