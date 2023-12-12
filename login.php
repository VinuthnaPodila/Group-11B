<!-- Include Header -->
<?php include("./header.php"); ?>


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px">

    <!-- Login Section -->
    <div class="w3-container" style="margin-top:50px" id="login">
        <h1 class="w3-xxxlarge w3-text-red"><b>Login</b></h1>
        <hr style="width:50px;border:5px solid red" class="w3-round">
        <p>Log in to your account.</p>
        <form method="POST">
            <div class="w3-section">
                <label><b>Email</b></label>
                <input class="w3-input w3-border mb-5" type="email" name="email" required>
            </div>
            <div class="w3-section">
                <label><b>Password</b></label>
                <input class="w3-input w3-border mb-5" type="password" name="password" required>
            </div>

            <button type="submit" class="w3-button w3-block w3-padding-large w3-red w3-margin-bottom"
                name="Login"><b>LOGIN</b></button>
        </form>
    </div>

</div>
<!-- End page content -->

<!-- Include Footer -->
<?php include("./footer.php"); ?>


<!-- Backend code for login -->
<?php
// session start
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the Login form has been submitted
if (isset($_POST['Login'])) {

    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user details from the database
    $query = mysqli_query($connect, "SELECT * FROM users WHERE `email` = '$email' AND `password` = '$password' AND `status` = 'Active' ");

    if ($query) {
        $data = mysqli_fetch_object($query);

        // Set session variables if user exists
        if ($data) {
            $_SESSION['start'] = true;
            $_SESSION['user_id'] = $data->user_id;
            $_SESSION['name'] = $data->name;
            $_SESSION['number'] = $data->number;
            $_SESSION['email'] = $data->email;
            $_SESSION['password'] = $data->password;

            if ($data->user_type === 'Admin') {
                echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Welcome Admin!",
                            showConfirmButton: false,
                            timer: 1500
                        })
                      </script>';
                echo "<script> setTimeout(function(){ window.location.href = 'admin/index.php'; }, 1000); </script>";
            } else if ($data->user_type === 'Company') {
                echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Welcome Company!",
                            showConfirmButton: false,
                            timer: 1500
                        })
                      </script>';
                echo "<script> setTimeout(function(){ window.location.href = 'company/index.php'; }, 1000); </script>";
            } else {
                echo '<script>
                        Swal.fire({
                            icon: "success",
                            title: "Login Successful!",
                            showConfirmButton: false,
                            timer: 1500
                        })
                      </script>';
                echo "<script> setTimeout(function(){ window.location.href = 'index.php'; }, 1000); </script>";
            }
            
        } else {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Invalid email or password.",
                    });
                </script>';

            echo "<script> setTimeout(function(){ window.location.href = 'login.php'; }, 1000); </script>";
        }
    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error fetching user details.",
                });
            </script>';

        echo "<script> setTimeout(function(){ window.location.href = 'login.php'; }, 1000); </script>";
    }
}
?>
<!-- Backend code for login -->