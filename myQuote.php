<!-- Include Header -->
<?php include("./header.php"); ?>

<style>
/* Additional CSS for centering the modal */
#billModal {
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

.butonn {
    width: 30%;
}
</style>


<!-- !PAGE CONTENT! -->
<div class="w3-main" style="margin-left:300px;margin-right:40px; min-height:70vh">
    <!-- My Quotes Table -->
    <div class="w3-container" id="myQuotes" style="margin-top: 40px">
        <h1 class="w3-xxlarge w3-text-red"><b>MY QUOTES</b></h1>
        <hr style="width: 50px; border: 5px solid red" class="w3-round">

        <!-- Display Quotes in a Table -->
        <div class="table-responsive">
            <table class="w3-table-all">
                <thead>
                    <tr class="w3-red">
                        <th>S.N.</th>
                        <th>Prescription</th>
                        <th>Delivery Type</th>
                        <th>Delivery Address</th>
                        <th>Zip Code</th>
                        <th>Other Service</th>
                        <th>Quote</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                $user_id = $_SESSION['user_id'];                       
                $count = 1;

                // query to fetch all quotes for the logged in user
                $query = "SELECT quotes.*, deliveries.order_id
                FROM quotes
                LEFT JOIN deliveries ON quotes.quote_id = deliveries.quote_id
                WHERE quotes.user_id = '$user_id'
                ORDER BY quotes.quote_id DESC;
                ";
                $result = mysqli_query($connect, $query);

                while ($quote = mysqli_fetch_object($result))
                {
                ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><img src="<?=$quote->image?>" onclick="onClick(this)" style="width:80px;height:80px"
                                alt="Prescription"></td>
                        <td><?=$quote->delivery_type?></td>
                        <td><?=$quote->delivery_address?></td>
                        <td><?=$quote->zip_code?></td>
                        <td><?=$quote->other_service?></td>
                        <?php
                        if ($quote->delivery_price == 0) {
                           ?>
                        <td>Pending</td>
                        <?php
                        } 
                        else 
                        {
                        ?>
                        <td><button
                                onclick="openQuoteModal('<?=$quote->order_id?>','<?=$quote->quote_id?>','<?=$quote->user_id?>','<?=$quote->package_size?>', '<?=$quote->package_weight?>', '<?=$quote->delivery_price?>', '<?=$quote->estimated_time?>')"
                                class="btn btn-success">Show Quote</button></td>
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

<!-- Modal for full size images on click-->
<div id="modal01" class="w3-modal w3-black" style="padding-top:0" onclick="this.style.display='none'">
    <span class="w3-button w3-black w3-xxlarge w3-display-topright">×</span>
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64">
        <img id="img01" class="w3-image">
        <p id="caption"></p>
    </div>
</div>



<!-- Modal for Bill Slip and Order Options -->
<div id="billModal" class="w3-modal w3-black" style="display: none;">
    <div class="w3-modal-content w3-animate-zoom w3-center w3-transparent w3-padding-64"
        style="border: 2px solid #ccc; border-radius: 10px;">
        <!-- Close button -->
        <span class="w3-button w3-black w3-xxlarge w3-display-topright" onclick="closeModal()">&times;</span>
        <!-- Your bill slip design goes here -->
        <div class="bill-slip-design">
            <div class="bill-info">
                <h2>Package Size:</h2>
                <h2>Package Weight:</h2>
                <h2>Delivery Price:</h2>
                <h2>Estimated Time:</h2>
            </div>
            <div class="bill-values">
                <span id="displayPackageSize"></span>
                <span id="displayPackageWeight"></span>
                <span id="displayDeliveryPrice"></span>
                <span id="displayEstimatedTime"></span>
            </div>
        </div>

        <!-- Form for Remove/Place Order -->
        <form id="orderForm" method="POST">

            <input type="hidden" id="quoteIdInput" name="quote_id">
            <input type="hidden" id="userIdInput" name="user_id">
            <input type="hidden" id="deliveryPriceInput" name="total_amt">

            <!-- Options to remove and place order -->
            <div style="margin-top: 50px;" id="bothBtn">
                <button type="submit" name="RemoveOrder" class="btn btn-danger butonn"
                    onclick="handleProcessing(this)"><b>Remove Order</b></button>
                <button type=" submit" name="PlaceOrder" class="btn btn-success butonn"
                    style=" margin-left: 10px;"><b>Place Order</b></button>
            </div>
        </form>
    </div>
</div>



<script>
// JavaScript function to open modal with values
function openQuoteModal(order_id, quoteId, userId, packageSize, packageWeight, deliveryPrice, estimatedTime) {
    document.getElementById('quoteIdInput').value = quoteId;
    document.getElementById('userIdInput').value = userId;
    document.getElementById('deliveryPriceInput').value = deliveryPrice;

    // Display other values in the designated elements if needed
    document.getElementById('displayPackageSize').innerText = packageSize;
    document.getElementById('displayPackageWeight').innerText = packageWeight;
    document.getElementById('displayDeliveryPrice').innerText = '£' + deliveryPrice;
    document.getElementById('displayEstimatedTime').innerText = estimatedTime;

    // Select the submit button
    const submitBtn = document.getElementById('bothBtn');

    // Check if both star_rating and feedback_text are available
    if (order_id != '' && submitBtn) {
        submitBtn.style.display = 'none';
    } else {
        submitBtn.style.display = 'block';
    }

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


<!-- Backend code for removing order -->
<?php
if (isset($_POST['RemoveOrder'])) {

    $quote_id = $_POST['quote_id']; 
    
    // Execute query to delete the order
    $delete_query = "DELETE FROM quotes WHERE quote_id = '$quote_id'";
    $delete_result = mysqli_query($connect, $delete_query);

    if ($delete_result) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Great, Order Deleted Successfully!",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

        echo "<script> setTimeout(function(){ window.location.href = 'myQuote.php'; }, 1000); </script>";

    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Sorry, Failed to delete order.",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'myQuote.php'; }, 1000); </script>";

    }
}
?>
<!-- Backend code for removing order -->

<!-- Backend code for placing order -->
<?php
if (isset($_POST['PlaceOrder'])) {

    $user_id = $_POST['user_id'];
    $quote_id = $_POST['quote_id'];
    $total_amt = $_POST['total_amt'];
    $delivery_status = 'Pending';

    $random_number = mt_rand(10000, 99999); 
    $order_id = "ORD" . '_' . $random_number;


    // Execute query to place the order
    $insert_query = "INSERT INTO deliveries (user_id, quote_id, order_id, total_amt, delivery_status) VALUES ('$user_id', '$quote_id', '$order_id', '$total_amt', '$delivery_status')";
    $insert_result = mysqli_query($connect, $insert_query);

    if ($insert_result) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Thankyou, Order Placed Successfully!",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'myDelivery.php'; }, 1000); </script>";

    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Sorry, Failed to place order.",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'myQuote.php'; }, 1000); </script>";

    }
}
?>

<!-- Backend code for placing order -->