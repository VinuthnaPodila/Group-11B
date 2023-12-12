<!-- Include Header -->
<?php include("./header.php"); ?>


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px; min-height:70vh">
    <!-- My Quotes Table -->
    <div class="w3-container" id="myQuotes" style="margin-top: 40px">
        <h1 class="w3-xxlarge w3-text-green"><b>ALL QUERIES</b></h1>
        <hr style="width: 50px; border: 5px solid green" class="w3-round">

        <!-- Display Quotes in a Table -->
        <div class="table-responsive">
            <table class="w3-table-all">
                <thead>
                    <tr class="w3-green">
                        <th>S.N.</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>
                        <th>Message</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                $count = 1;
                // query to fetch all queries for the logged in user
                $query = "SELECT * from queries ORDER BY query_id DESC;
                ";
                $result = mysqli_query($connect, $query);

                while ($query = mysqli_fetch_object($result))
                {
                ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=$query->name?></td>
                        <td><?=$query->email?></td>
                        <td><?=$query->subject?></td>
                        <td><?=$query->message?></td>
                        <td><?=$query->date?></td>

                        <td><a href="?id=<?=$query->query_id?>&action=delete"><button class="btn btn-warning"><b>Delete
                                        Query</b></button></a>
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
    
    $query_id = $_GET['id']; 
    
    // Execute query to delete the order
    $delete_query = "DELETE FROM queries WHERE query_id = '$query_id'";
    $delete_result = mysqli_query($connect, $delete_query);

    if ($delete_result) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Great, Query Deleted Successfully!",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

        echo "<script> setTimeout(function(){ window.location.href = 'adminQuery.php'; }, 1000); </script>";

    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Sorry, Failed to delete query.",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'adminQuery.php'; }, 1000); </script>";

    }
}
?>
<!-- Backend code for removing order -->