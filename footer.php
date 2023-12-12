<!-- W3.CSS Container -->
<div class="w3-light-grey w3-container row" style="margin-top:75px;text-align:center;">
    <div class="col-md-2"></div>
    <div class="col-md-10 text-center">
        <img src="../IMG/drone.png" alt="Drone Icon" style="width: 50px; height: auto; margin-bottom: 10px;">
        <p>© 2023 Drone Delivery Management. All Rights Reserved.</p>
    </div>
</div>


<script>
// Script to open and close sidebar
function w3_open() {
    document.getElementById("mySidebar").style.display = "block";
    document.getElementById("myOverlay").style.display = "block";
}

function w3_close() {
    document.getElementById("mySidebar").style.display = "none";
    document.getElementById("myOverlay").style.display = "none";
}

// Modal Image Gallery
function onClick(element) {
    document.getElementById("img01").src = element.src;
    document.getElementById("modal01").style.display = "block";
    var captionText = document.getElementById("caption");
    captionText.innerHTML = element.alt;
}
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>

</body>

</html>