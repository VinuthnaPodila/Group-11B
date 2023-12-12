<?php
// Include the header
include("./header.php");

session_start();

// Check if the user is logged in
if (!isset($_SESSION['start']) || $_SESSION['start'] !== true) {
    // Redirect to the login page if not logged in
    header("Location: ../login.php");
    exit();
}

// Sample user data (replace this with your logic to fetch user data)
$user_id = $_SESSION['user_id'];

$query = mysqli_query($connect, "SELECT * FROM users WHERE user_id = '$user_id' ");

$data = mysqli_fetch_object($query);

?>

<!-- Profile Page Content -->
<div class="w3-main" style="margin-left:300px;margin-right:40px">
    <!-- Profile Section -->
    <div class="w3-container" style="margin-top:50px" id="profile">
        <h1 class="w3-xxxlarge w3-text-blue"><b>Welcome, <?php echo $data->name; ?></b></h1>

        <!-- Profile Table -->
        <div class="profile-table">
            <table class="w3-table w3-bordered">
                <tr>
                    <th>User ID</th>
                    <td><?php echo $user_id; ?></td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td><?php echo $data->name; ?></td>
                </tr>
                <tr>
                    <th>Number</th>
                    <td><?php echo $data->number; ?></td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td><?php echo $data->email; ?></td>
                </tr>
                <tr>
                    <th>Password</th>
                    <td><?php echo $data->password; ?></td> <!-- For security purposes, show asterisks -->
                </tr>
            </table>
        </div>

        <h1 class="w3-xlarge w3-text-blue pt-5"><b>Update Profile</b></h1>
        <!-- Update Profile Form -->
        <div class="update-profile-form mt-4">
            <form method="POST">
                <input type="hidden" name="user_id" value="<?=$data->user_id?>">
                <div class="d-flex">
                    <div class="col-md-5 m-auto">
                        <div class="mb-3">
                            <label for="new_name" class="form-label"><b>Name:</b></label>
                            <input type="text" id="new_name" name="name" value="<?=$data->name?>" class="form-control"
                                required>
                        </div>
                    </div>
                    <div class="col-md-5 m-auto">
                        <div class="mb-3">
                            <label for="new_number" class="form-label"><b>Number:</b></label>
                            <input type="text" id="new_number" name="number" value="<?=$data->number?>"
                                class="form-control" required>
                        </div>
                    </div>
                </div>
                <div class="d-flex">
                    <div class="col-md-5 m-auto">
                        <div class="mb-3">
                            <label for="new_email" class="form-label"><b>Email:</b></label>
                            <input type="email" id="new_email" name="email" value="<?=$data->email?>"
                                class="form-control" readonly required>
                        </div>
                    </div>
                    <div class="col-md-5 m-auto">
                        <div class="mb-3">
                            <label for="new_password" class="form-label"><b>Password:</b></label>
                            <input type="text" id="new_password" name="password" value="<?=$data->password?>"
                                class="form-control" required>
                        </div>
                    </div>
                </div>

                <div class="text-center">
                    <button type="submit" name="Update" style="width:80%;margin-top:20px"
                        class="btn btn-primary"><b>Update
                            Details</b></button>
                </div>

            </form>
        </div>

    </div>
</div>
<!-- End profile content -->

<!-- Include the footer -->
<?php include("./footer.php"); ?>

<!-- Backend code for update profile -->
<?php
// Check if the update form has been submitted
if (isset($_POST['Update'])) {

    $user_id = $_POST['user_id'];
    $name = $_POST['name'];
    $number = $_POST['number'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Fetch user details from the database
    $query = mysqli_query($connect, "UPDATE users SET name='$name', number='$number', `password`='$password' WHERE user_id='$user_id' ");

    if ($query) {

            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "Update Successful!",
                        showConfirmButton: false,
                        timer: 1500
                    })
                </script>';

            echo "<script> setTimeout(function(){ window.location.href = 'profile.php'; }, 1000); </script>";
    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Error updating user details.",
                });
            </script>';

        echo "<script> setTimeout(function(){ window.location.href = 'profile.php'; }, 1000); </script>";
    }
}
?>
<!-- Backend code for update profile -->