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
        <h1 class="w3-xxlarge w3-text-red"><b>MY DELIVERIES</b></h1>
        <hr style="width: 50px; border: 5px solid red" class="w3-round">

        <!-- Display Deliveries in a Table -->
        <div class="table-responsive">
            <table class="w3-table-all">
                <thead>
                    <tr class="w3-red">
                        <th>S.N.</th>
                        <th>User</th>
                        <th>OrderID</th>
                        <th>Total Amt</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>

                    <?php 
                $user_id = $_SESSION['user_id'];                       
                $count = 1;

                // query to fetch all quotes for the logged in user
                $query = "SELECT deliveries.*, users.name, feedbacks.star_rating, feedbacks.feedback_text 
                FROM deliveries 
                INNER JOIN users ON deliveries.user_id = users.user_id 
                LEFT JOIN feedbacks ON deliveries.order_id = feedbacks.order_id
                WHERE deliveries.user_id = '$user_id' 
                ORDER BY deliveries.delivery_id DESC";
                
                $result = mysqli_query($connect, $query);

                while ($quote = mysqli_fetch_object($result))
                {
                ?>
                    <tr>
                        <td><?=$count++?></td>
                        <td><?=$quote->name?></td>
                        <td><?=$quote->order_id?></td>
                        <td>£<?=$quote->total_amt?></td>
                        <td><?=$quote->date?></td>
                        <td><?=$quote->delivery_status?></td>
                        <?php
                        if ($quote->delivery_status != 'Delivered' ) {
                        ?>
                        <td>In Process</td>
                        <?php
                        } 
                        else if($quote->star_rating != null && $quote->feedback_text != null)
                        {
                        ?>
                        <td><button
                                onclick="openQuoteModal('<?=$quote->order_id?>','<?=$quote->user_id?>','<?=$quote->star_rating?>','<?=$quote->feedback_text?>')"
                                class="btn btn-success"><b>View Rating</b></button></td>
                        <?php
                        } 
                        else 
                        {
                        ?>
                        <td><button onclick="openQuoteModal('<?=$quote->order_id?>','<?=$quote->user_id?>','0','')"
                                class="btn btn-success"><b>Rate Order</b></button></td>
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

            <input type="hidden" id="deliveryIdInput" name="order_id">
            <input type="hidden" id="userIdInput" name="user_id">

            <!-- Select for star ratings -->
            <div style="margin-top: 20px;">
                <label for="starRating"><b>Select Rating:</b></label><br>
                <select id="starRating" name="star_rating">
                    <option value="5">⭐ ⭐ ⭐ ⭐ ⭐</option>
                    <option value="4">⭐ ⭐ ⭐ ⭐</option>
                    <option value="3">⭐ ⭐ ⭐</option>
                    <option value="2">⭐ ⭐</option>
                    <option value="1">⭐</option>
                </select>
            </div>

            <!-- Input for review -->
            <div style="margin-top: 20px;" id="submitButtonContainer">
                <label for="review"><b>Enter Review:</b></label><br>
                <textarea id="review" name="feedback_text" rows="4" cols="50"></textarea>
            </div>


            <!-- Options to remove and place order -->
            <div style="margin-top: 20px;" id="submitBtn">
                <button type="submit" name="SubmitReview" class="btn btn-primary butonn"
                    onclick="handleProcessing(this)"><b>Submit Review</b></button>
            </div>
        </form>
    </div>
</div>


<script>
// JavaScript function to open modal with values
function openQuoteModal(order_id, userId, star_rating, feedback_text) {
    document.getElementById('deliveryIdInput').value = order_id;
    document.getElementById('userIdInput').value = userId;

    // Set the star rating
    const starRatingSelect = document.getElementById('starRating');
    starRatingSelect.value = star_rating;

    // Set the feedback text
    document.getElementById('review').value = feedback_text;

    // Select the submit button
    const submitBtn = document.getElementById('submitBtn');

    // Check if both star_rating and feedback_text are available
    if (star_rating != '' && feedback_text != '' && submitBtn) {
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


<!-- Backend code for submitig rating -->
<?php
if (isset($_POST['SubmitReview'])) {

    $order_id = $_POST['order_id'];
    $user_id = $_POST['user_id'];
    $star_rating = $_POST['star_rating'];
    $feedback_text = $_POST['feedback_text'];

    // Execute query to place the order
    $insert_query = "INSERT INTO feedbacks (order_id, user_id, star_rating, feedback_text) VALUES ('$order_id', '$user_id', '$star_rating', '$feedback_text')";
    $insert_result = mysqli_query($connect, $insert_query);

    if ($insert_result) {
        echo '<script>
                Swal.fire({
                    icon: "success",
                    title: "Thankyou, Rating and Review Submitted!",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'myDelivery.php'; }, 1000); </script>";

    } else {
        echo '<script>
                Swal.fire({
                    icon: "error",
                    title: "Sorry, Failed to submit rating and review.",
                    showConfirmButton: false,
                    timer: 1500
                });
             </script>';

             echo "<script> setTimeout(function(){ window.location.href = 'myDelivery.php'; }, 1000); </script>";

    }
}
?>

<!-- Backend code for submitig rating -->