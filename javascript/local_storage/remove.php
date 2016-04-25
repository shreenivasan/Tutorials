<!DOCTYPE html>
<html>
<body>

<div id="result"></div>

<script>
// Check browser support
if (typeof(Storage) !== "undefined") {
    // Store
     localStorage.removeItem("lastname");
    // Retrieve
    console.log(localStorage.getItem("lastname"))
    document.getElementById("result").innerHTML = localStorage.getItem("lastname");
} else {
    document.getElementById("result").innerHTML = "Sorry, your browser does not support Web Storage...";
}
</script>

</body>
</html>