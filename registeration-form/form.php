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

    <label>
        <input type="text" name="first_name" placeholder="First Name"> <br><br>
        <input type="text" name="last_name" placeholder="last Name" ><br><br>
        <input type="email" name="email" placeholder="Email" ><br><br>
        <input type="password" name="password" placeholder="password"><br><br>
        <input type="password" name="confirm_password" placeholder="confirm password" ><br><br>
        <input type="file"  name="image[]" multiple> <br><br>
    </label>

    <button type="submit">
        register
    </button> <br><br><br>

</form>

<?php

if (isset($_SESSION["data error message"])) {
    foreach ($_SESSION["data error message"] as $message) {
        echo "<p style='color:red;'>$message</p>";
    }
} elseif (isset($_SESSION["data success message"])) {
    echo "<p style='color:green'>{$_SESSION["data success message"]}</p>";
}

if(isset($_SESSION["image error message"])){
    echo "<p style='color:red;'>{$_SESSION["image error message"]}</p>";
}elseif(isset($_SESSION["image success message"])){
    echo "<p style='color:green;'>{$_SESSION["image success message"]}</p>";
}
var_dump($_FILES);
// unset all variables and destroy the session
session_unset();
session_destroy();

?>


</body>

</html>
