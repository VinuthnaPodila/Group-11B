<!-- Include Header -->
<?php include("./header.php"); ?>


<style>
/* Styles for star rating select */
select#starRating {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    width: 50%;
    margin-top: 10px;
}

/* Styles for review textarea */
textarea#review {
    padding: 10px;
    border-radius: 5px;
    border: 1px solid #ccc;
    font-size: 16px;
    width: 70%;
    margin-top: 10px;
    resize: vertical;
    /* Allows vertical resizing */
}

/* Styling for the button */
.btn-primary {
    background-color: #007bff;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    margin-top: 20px;
}

.btn-primary:hover {
    background-color: #0056b3;
}
</style>



<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px; min-height:70vh">
    <!-- My Deliveries Table -->
    <div class="w3-container" id="myDeliveries" style="margin-top: 40px">
        <h1 class="w3-xxlarge w3-text-green"><b>ALL DELIVERIES</b></h1>
        <hr style="width: 50px; border: 5px solid green" class="w3-round">

        <!-- Display Deliveries in a Table -->
        <div class="table-responsive">
            <table class="w3-table-all">
                <thead>
                    <tr class="w3-green">
                        <th>S.N.</th>
                        <th>OrderID</th>
                        <th>Total Amt</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                $count = 1;

                // query to fetch all quotes for the logged in user
                $query = "SELECT deliveries.*, users.name, feedbacks.star_rating, feedbacks.feedback_text 
                FROM deliveries 
                INNER JOIN users ON deliveries.user_id = users.user_id 
                LEFT JOIN feedbacks ON deliveries.order_id = feedbacks.order_id
                ORDER BY deliveries.delivery_id DESC";
                
                $result = mysqli_query($connect, $query);

                while ($quote = mysqli_fetch_object($result))
                {
                ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=$quote->order_id?></td>
                        <td>£<?=$quote->total_amt?></td>
                        <td><?=$quote->date?></td>
                        <td><?=$quote->delivery_status?></td>
                        <?php
                        if ($quote->delivery_status != 'Delivered' ) {
                        ?>
                        <td><button
                                onclick="openQuoteModal('<?=$quote->delivery_id?>','<?=$quote->user_id?>','<?=$quote->order_id?>')"
                                class="btn btn-warning"><b>Update Status</b></button></td>
                        <?php
                        }
                        else
                        {
                        ?>
                        <td><b><?=$quote->star_rating?>⭐ : <?=$quote->feedback_text?></b></td>
                        <?php
                        }
                        ?>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<!-- Modal for Bill Slip and Order Options -->
<div id="billModal" class="w3-modal w3-black" style="display: none;">
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64"
        style="border: 2px solid #ccc; border-radius: 10px;">
        <!-- Close button -->
        <span class="w3-button w3-black w3-xxlarge w3-display-topright" onclick="closeModal()">&times;</span>

        <!-- Form for Remove/Place Order -->
        <form id="orderForm" method="POST">

            <input type="hidden" id="deliveryIdInput" name="delivery_id">

            <!-- Select for star ratings -->
            <div style="margin-top: 20px;">
                <label for="starRating"><b>Select Status:</b></label><br>
                <select id="starRating" name="delivery_status">
                    <option value="Approved">Approved</option>
                    <!-- <option value="Shipped">Shipped</option>
                    <option value="Out-For-Delivery">Out-For-Delivery</option>
                    <option value="Delivered">Delivered</option> -->
                    <option value="Rejected">Rejected</option>
                </select>
            </div>


            <!-- Select for Companies -->
            <div style="margin-top: 20px;">
                <label for="companyDropdown"><b>Select Company:</b></label><br>
                <select id="starRating" name="company_id">

                    <?php
                // Perform a query to fetch users where user_type is 'Company'
                $companyQuery = mysqli_query($connect, "SELECT * FROM users WHERE user_type = 'Company'");
                
                // Loop through query results to create options for dropdown
                while ($company = mysqli_fetch_assoc($companyQuery)) {
                    $companyId = $company['user_id'];
                    $companyName = $company['name'];
                    echo "<option value='$companyId'>$companyName</option>";
                }
                ?>
                </select>
            </div>


            <!-- Hidden input fields for quote_id and user_id -->
            <input type="hidden" id="userIdInput" name="user_id">
            <input type="hidden" id="orderIdInput" name="order_id">

            <!-- Options to remove and place order -->
            <div style="margin-top: 20px;">
                <button type="submit" name="UpdateStatus" class="btn btn-primary butonn"
                    onclick="handleProcessing(this)"><b>Change Status</b></button>
            </div>
        </form>
    </div>
</div>


<script>
// JavaScript function to open modal with values
function openQuoteModal(delivery_id, user_id, order_id) {
    document.getElementById('deliveryIdInput').value = delivery_id;
    document.getElementById('userIdInput').value = user_id;
    document.getElementById('orderIdInput').value = order_id;


    // Display the modal
    document.getElementById('billModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('billModal').style.display = 'none';
}


// JavaScript function to close the modal
function closeModal() {
    const modal = document.getElementById('billModal');
    if (modal) {
        modal.style.display = 'none';
    }
}
</script>


<!-- Include Footer -->
<?php include("./footer.php"); ?>


<?php
if (isset($_POST['UpdateStatus'])) {
    
    $user_id = $_POST['user_id'];
    $company_id  = $_POST['company_id'];
    $order_id = $_POST['order_id'];
    $delivery_id = $_POST['delivery_id'];
    $delivery_status = $_POST['delivery_status'];

    // Update the delivery status
    $update_query = "UPDATE deliveries 
                     SET delivery_status = '$delivery_status', company_id  = '$company_id'                      
                     WHERE delivery_id = '$delivery_id'";
                     
    $update_result = mysqli_query($connect, $update_query);

    $bell_query = "INSERT INTO `notification` (`from`, `to`, `message`) VALUES ('Admin', '$user_id', 'The status for the Order Id: $order_id has been $delivery_status')";
    $bell_result = mysqli_query($connect, $bell_query);

    if ($update_result) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Delivery Status Updated Successfully!",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

        echo "<script> setTimeout(function(){ window.location.href = 'adminDelivery.php'; }, 1000); </script>";

    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Sorry, Failed to update delivery status.",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'adminDelivery.php'; }, 1000); </script>";

    }
}
?>