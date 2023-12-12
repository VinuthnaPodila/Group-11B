<!-- Include Header -->
<?php                
 session_start();

include("./header.php"); 
?>


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


/* Additional CSS for centering the modal */
#valueModal {
    display: flex;
    align-items: center;
    justify-content: center;
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    z-index: 999;
}

/* Updated CSS to display values in a 3x3 box format */
.bill-slip-design {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 10px;
    width: 80%;
    margin: 20px auto;
}

.bill-slip-design h2 {
    margin: 10px 0;
    font-size: 16px;
    font-weight: bold;
    font-size: 22px;
}

.bill-slip-design .bill-info {
    grid-column: 1;
    text-align: left;
}

.bill-slip-design .bill-values {
    grid-column: 2;
    color: #555;
    display: grid;
    color: white;
    font-weight: bold;
    font-size: 22px;
}
</style>



<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px; min-height:70vh">
    <!-- My Deliveries Table -->
    <div class="w3-container" id="myDeliveries" style="margin-top: 40px">
        <h1 class="w3-xxlarge w3-text-blue"><b>ASSIGNED DELIVERIES</b></h1>
        <hr style="width: 50px; border: 5px solid blue" class="w3-round">

        <!-- Display Deliveries in a Table -->
        <div class="table-responsive">
            <table class="w3-table-all">
                <thead>
                    <tr class="w3-blue">
                        <th>S.N.</th>
                        <th>OrderID</th>
                        <th>Total Amt</th>
                        <th>Date</th>
                        <th>Quote</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                $company_id = $_SESSION['user_id'];                       

                $count = 1;

                // query to fetch all quotes for the logged in user
                $query = "SELECT deliveries.*, users.name, feedbacks.star_rating, feedbacks.feedback_text, quotes.package_size, quotes.package_weight, quotes.delivery_price, quotes.estimated_time
                FROM deliveries 
                INNER JOIN users ON deliveries.user_id = users.user_id 
                LEFT JOIN feedbacks ON deliveries.order_id = feedbacks.order_id
                LEFT JOIN quotes ON deliveries.quote_id = quotes.quote_id
                WHERE deliveries.delivery_status != 'Rejected' AND deliveries.company_id = '$company_id'
                ORDER BY deliveries.delivery_id DESC
                ";
                
                $result = mysqli_query($connect, $query);

                while ($quote = mysqli_fetch_object($result))
                {
                ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=$quote->order_id?></td>
                        <td>£<?=$quote->total_amt?></td>
                        <td><?=$quote->date?></td>
                        <td><button
                                onclick="openValueModal('<?=$quote->package_size?>', '<?=$quote->package_weight?>', '<?=$quote->delivery_price?>', '<?=$quote->estimated_time?>')"
                                class="btn btn-success"><b>Show Quote</b></button></td>
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
<div id="valueModal" class="w3-modal w3-black" style="display: none;">
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64"
        style="border: 2px solid #ccc; border-radius: 10px;">
        <!-- Close button -->
        <span class="w3-button w3-black w3-xxlarge w3-display-topright" onclick="closeModall()">&times;</span>
        <!-- Form for Quote -->
        <form id="quoteForm" method="POST">
            <div class="bill-slip-design">
                <div class="bill-info">
                    <h2>Enter Package Size:</h2>
                    <h2>Enter Package Weight:</h2>
                    <h2>Enter Delivery Price:</h2>
                    <h2>Enter Estimated Time:</h2>
                </div>
                <div class="bill-values">
                    <input type="text" id="sizeInput" name="package_size" readonly>
                    <input type=" text" id="weightInput" name="package_weight" readonly>
                    <input type=" number" id="priceInput" name="delivery_price" readonly>
                    <input type=" text" id="timeInput" name="estimated_time" readonly>
                </div>
            </div>
        </form>
    </div>
</div>




<script>
// JavaScript function to open modal with values
function openValueModal(packageSize, packageWeight, deliveryPrice, estimatedTime) {
    document.getElementById('sizeInput').value = packageSize;
    document.getElementById('weightInput').value = packageWeight;
    document.getElementById('priceInput').value = deliveryPrice;
    document.getElementById('timeInput').value = estimatedTime;

    // Display the modal
    document.getElementById('valueModal').style.display = 'block';
}

function closeModal() {
    document.getElementById('valueModal').style.display = 'none';
}


// JavaScript function to close the modal
function closeModall() {
    const modal = document.getElementById('valueModal');
    if (modal) {
        modal.style.display = 'none';
    }
}
</script>






<!-- Modal for updating status and Order Options -->
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
                    <!-- <option value="Approved">Approved</option> -->
                    <option value="Accepted">Accepted</option>
                    <option value="Ready-To-Ship">Ready-To-Ship</option>
                    <option value="Shipped">Shipped</option>
                    <option value="Out-For-Delivery">Out-For-Delivery</option>
                    <option value="Delivered">Delivered</option>
                    <!-- <option value="Rejected">Rejected</option> -->
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
                     SET delivery_status = '$delivery_status'                      
                     WHERE delivery_id = '$delivery_id'";
                     
    $update_result = mysqli_query($connect, $update_query);

    $bell_query = "INSERT INTO `notification` (`from`, `to`, `message`) VALUES ('Company', '$user_id', 'The status for the Order Id: $order_id has been updated to: $delivery_status')";
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

        echo "<script> setTimeout(function(){ window.location.href = 'companyDelivery.php'; }, 1000); </script>";

    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Sorry, Failed to update delivery status.",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'companyDelivery.php'; }, 1000); </script>";

    }
}
?>