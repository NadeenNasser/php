<?php
session_start();
require_once "validation.php";

// redirection function
function redirect($url)
{
    header("Location: $url");
};

// input handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $success_message="Form submitted successfully!";
    $source=$_FILES["image"]["tmp_name"];

    //validate data and store the returned errors into an array
    $errors= validate_data($_POST, $_FILES);

    //checking for errors
    if (is_array($errors))
    {
        $_SESSION["data error message"] = $errors;
    }else{
        $_SESSION["data success message"] = $success_message;
    }

    //save image
    foreach ($_FILES["image"]["name"] as $key => $name) {

        $source = $_FILES["image"]["tmp_name"][$key];
        $extension = pathinfo($name, PATHINFO_EXTENSION); // Get the original file extension
        $uniqueName = uniqid("img_", true).".".$extension;
        $destination = "F:/xampp/htdocs/saved images/".$uniqueName;

        if (!empty($errors)) {
            $_SESSION["image error message"] = "File upload failed!";
        } elseif (move_uploaded_file($source, $destination)) {
            $_SESSION["image success message"] = "File successfully uploaded!";

        }
    }

    // redirecting to view page
    redirect("form.php");
    exit;
}