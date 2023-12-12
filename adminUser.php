<!-- Include Header -->
<?php include("./header.php"); ?>


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px; min-height:70vh">
    <!-- My Quotes Table -->
    <div class="w3-container" id="myQuotes" style="margin-top: 40px">
        <h1 class="w3-xxlarge w3-text-green"><b>ALL USERS</b></h1>
        <hr style="width: 50px; border: 5px solid green" class="w3-round">

        <!-- Display Quotes in a Table -->
        <div class="table-responsive">
            <table class="w3-table-all">
                <thead>
                    <tr class="w3-green">
                        <th>S.N.</th>
                        <th>Name</th>
                        <th>number</th>
                        <th>Email</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                $count = 1;
                // query to fetch all queries for the logged in user
                $query = "SELECT * from users WHERE user_type = 'User' ORDER BY user_id DESC;
                ";
                $result = mysqli_query($connect, $query);

                while ($user = mysqli_fetch_object($result))
                {
                ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=$user->name?></td>
                        <td><?=$user->number?></td>
                        <td><?=$user->email?></td>
                        <td><?=$user->date?></td>
                        <td><?=$user->status?></td>

                        <td><a href="?id=<?=$user->user_id?>&action=update"><button class="btn btn-warning"><b>Update
                                        Status</b></button></a>
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


<!-- Backend code for updating status -->
<?php
if (isset($_GET['action']) && $_GET['action'] == 'update') {
    $user_id = $_GET['id'];
    
    // Fetch current status
    $status_query = "SELECT status FROM users WHERE user_id = '$user_id'";
    $status_result = mysqli_query($connect, $status_query);
    
    if ($status_result && mysqli_num_rows($status_result) > 0) {
        $row = mysqli_fetch_assoc($status_result);
        $current_status = $row['status'];
        
        // Toggle status
        $new_status = ($current_status == 'Active') ? 'Inactive' : 'Active';
        
        // Update query to toggle status
        $update_query = "UPDATE users SET status = '$new_status' WHERE user_id = '$user_id'";
        $update_result = mysqli_query($connect, $update_query);
        
        if ($update_result) {
            echo '<script>
                    Swal.fire({
                        icon: "success",
                        title: "User status updated successfully!",
                        showConfirmButton: false,
                        timer: 1500
                    });
                 </script>';

                 echo "<script> setTimeout(function(){ window.location.href = 'adminUser.php'; }, 1000); </script>";

        } else {
            echo '<script>
                    Swal.fire({
                        icon: "error",
                        title: "Failed to update user status.",
                        showConfirmButton: false,
                        timer: 1500
                    });
                 </script>';

                 echo "<script> setTimeout(function(){ window.location.href = 'adminUser.php'; }, 1000); </script>";

        }
    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "User not found.",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';
    }
    
    echo "<script> setTimeout(function(){ window.location.href = 'adminUser.php'; }, 1000); </script>";
}
?>

<!-- Backend code for updating status -->