<?php session_start() ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Registration Form</title>
</head>

<body>

<h2>Registration Form</h2>
<h3> Hello </h3>


<form method="POST" action="logic.php" enctype="multipart/form-data">

    <input type="text" name="first_name" placeholder="First Name" required><br><br>
    <input type="text" name="last_name" placeholder="Last Name" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="tel" name="phone_number" placeholder="Phone Number" required><br><br>

    <input type="password" name="password" placeholder="Password" required><br><br>
    <input type="password" name="confirm_password" placeholder="Confirm Password" required><br><br>

    Gender:
    <label><input type="radio" name="gender" value="female" required> Female</label>
    <label><input type="radio" name="gender" value="male" required> Male</label>
    <br><br>

    <p>Do you have a car?</p>
    <label><input type="radio" name="has_car" value="yes" onclick="toggleCarType(true)" required> Yes</label>
    <label><input type="radio" name="has_car" value="no" onclick="toggleCarType(false)"> No</label>
    <br><br>

    <!-- Hidden car type dropdown -->
    <div id="car_type_section" style="display:none;">
        <label for="car_type">Select your car type:</label>
        <select name="car_type" id="car_type">
            <option value="">--Choose a car--</option>
            <option value="BMW">BMW</option>
            <option value="fiat">fiat</option>
            <option value="lada">lada</option>
            <option value="mini cooper">mini cooper</option>
        </select>
    </div>
    <br>

    <label for="photo">Add a personal image:</label>
    <input type="file" name="personal_photo" id="photo" required><br><br>

    <label for="gallery">Upload gallery images:</label>
    <input type="file" name="image[]" id="gallery" multiple required><br><br>

    <button type="submit">Register</button>

</form>
<script>
    function toggleCarType(show) {
        document.getElementById("car_type_section").style.display = show ? "block" : "none";
    }
</script>

<?php

if (isset($_SESSION["data_error_message"])) {
    foreach ($_SESSION["data_error_message"] as $message) {
        echo "<p style='color:red;'>$message</p>";
    }
} elseif (isset($_SESSION["data_success_message"])) {
    echo "<p style='color:green'>{$_SESSION["data_success_message"]}</p>";
}

if(isset($_SESSION["image_error_message"])){
    echo "<p style='color:red;'>{$_SESSION["image_error_message"]}</p>";
}elseif(isset($_SESSION["image_success_message"])){
    echo "<p style='color:green;'>{$_SESSION["image_success_message"]}</p>";
}

// unset all variables and destroy the session
//session_unset();
//session_destroy();

?>


</body>

</html>
