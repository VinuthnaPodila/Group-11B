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
        <h1 class="w3-xxlarge w3-text-green"><b>ALL QUOTES</b></h1>
        <hr style="width: 50px; border: 5px solid green" class="w3-round">

        <!-- Display Quotes in a Table -->
        <div class="table-responsive">
            <table class="w3-table-all">
                <thead>
                    <tr class="w3-green">
                        <th>S.N.</th>
                        <th>Prescription</th>
                        <th>Delivery Type</th>
                        <th>Delivery Address</th>
                        <th>Zip Code</th>
                        <th>Other Service</th>
                        <th>Late-Long</th>
                        <th>Quote</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                $count = 1;

                // query to fetch all quotes for the logged in user
                $query = "SELECT * FROM quotes ORDER BY quote_id DESC;
                ";
                $result = mysqli_query($connect, $query);

                while ($quote = mysqli_fetch_object($result))
                {
                ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><img src="../<?=$quote->image?>" onclick="onClick(this)" style="width:80px;height:80px"
                                alt="Prescription"></td>
                        <td><?=$quote->delivery_type?></td>
                        <td><?=$quote->delivery_address?></td>
                        <td><?=$quote->zip_code?></td>
                        <td><?=$quote->other_service?></td>
                        <td><?=$quote->latitude?>-<?=$quote->longitude?></td>
                        <td><button
                                onclick="openQuoteModal('<?=$quote->quote_id?>','<?=$quote->user_id?>','<?=$quote->package_size?>', '<?=$quote->package_weight?>', '<?=$quote->delivery_price?>', '<?=$quote->estimated_time?>')"
                                class="btn btn-warning"><b>Make Quote</b></button></td>

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
                    <input type="text" id="sizeInput" name="package_size" required>
                    <input type=" text" id="weightInput" name="package_weight" required>
                    <input type=" number" id="priceInput" name="delivery_price" required>
                    <input type=" text" id="timeInput" name="estimated_time" required>
                </div>
            </div>
            <!-- Submit Quote button -->
            <div style=" margin-top: 50px;" id="bothBtn">
                <button type="submit" name="SubmitQuote" class="btn btn-primary" style="width: 30%;"><b>Submit
                        Quote</b></button>
            </div>
            <!-- Hidden input fields for quote_id and user_id -->
            <input type="hidden" id="quoteIdInput" name="quote_id">
            <input type="hidden" id="userIdInput" name="user_id">
        </form>
    </div>
</div>




<script>
// JavaScript function to open modal with values
function openQuoteModal(quoteId, userId, packageSize, packageWeight, deliveryPrice, estimatedTime) {
    document.getElementById('quoteIdInput').value = quoteId;
    document.getElementById('userIdInput').value = userId;
    document.getElementById('sizeInput').value = packageSize;
    document.getElementById('weightInput').value = packageWeight;
    document.getElementById('priceInput').value = deliveryPrice;
    document.getElementById('timeInput').value = estimatedTime;

    // Select the submit button
    const submitBtn = document.getElementById('bothBtn');

    // Check if both star_rating and feedback_text are available
    if (deliveryPrice != 0 && submitBtn) {
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




<!-- Backend code for making quote -->
<?php
if (isset($_POST['SubmitQuote'])) {
    
    $user_id = $_POST['user_id'];
    $quote_id = $_POST['quote_id'];
    $package_size = $_POST['package_size'];
    $package_weight = $_POST['package_weight'];
    $delivery_price = $_POST['delivery_price'];
    $estimated_time = $_POST['estimated_time'];

    // Update the quotes table with the provided values
    $update_query = "UPDATE quotes 
                     SET package_size = '$package_size', 
                         package_weight = '$package_weight', 
                         delivery_price = '$delivery_price', 
                         estimated_time = '$estimated_time' 
                     WHERE quote_id = '$quote_id'";
                     
    $update_result = mysqli_query($connect, $update_query);

    $bell_query = "INSERT INTO `notification` (`from`, `to`, `message`) VALUES ('Admin', '$user_id', 'Your quote has been generated, please check.')";
    $bell_result = mysqli_query($connect, $bell_query);

    if ($update_result) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Quote Updated Successfully!",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

        echo "<script> setTimeout(function(){ window.location.href = 'adminQuote.php'; }, 1000); </script>";

    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Sorry, Failed to update quote.",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'adminQuote.php'; }, 1000); </script>";

    }
}
?>

<!-- Backend code for making quote -->