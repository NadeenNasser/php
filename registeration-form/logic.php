<?php
session_start();
require_once "validation.php";

// redirection function
function redirect($url)
{
    header("Location: $url");
}
function ensure_folder($path) {
    if (!file_exists($path)) {
        mkdir($path, 0777, true);
    }
}
function file_rename($file, $newName)
{
    $extension = pathinfo($file, PATHINFO_EXTENSION);
    if($newName === "random") {
        // Get the original file extension
        return uniqid("img_", true) . "." . $extension;
    }else{
        // Get the original file extension
        return $newName . "." . $extension;
    }
}

function save_photo($image,$source,$folder,$newName,$errors)
{
        $uniqueName = file_rename($image, $newName);
        $photoDestination = $folder . "/" . $uniqueName;
        move_file($source, $photoDestination, $errors);

    return $photoDestination;
}

function move_file($source, $destination,$errors)
{
    if (!empty($errors)) {
        $_SESSION["{image_error_message"] = "files upload failed!";
    } elseif (move_uploaded_file($source, $destination)) {
        $_SESSION["image_success_message"] = "files successfully uploaded!";

    }
}

// input handling
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $success_message = "Form submitted successfully!";

    //validate data and store the returned errors into an array
    $errors = validate_data($_POST, $_FILES);

    //checking for errors
    if (!empty($errors)) {
        $_SESSION["data_error_message"] = $errors;
    } else {

        $_SESSION["data_success_message"] = $success_message;

        // if no errors are present save data
        $_SESSION["data"] = [
            "first_name" => $_POST["first_name"],
            "last_name" => $_POST["last_name"],
            "email" => $_POST["email"],
            "phone" => $_POST["phone_number"],
            "gender" => $_POST["gender"],
            "personal_photo" => $_FILES["personal_photo"]["name"],
             "has_car" => $_POST["has_car"],
        ];

        if ($_SESSION["data"]["has_car"] === "yes") {
            $_SESSION["data"]["car_type"] = $_POST["car_type"];
        }
    }

    //get user full name
    $firstName = $_POST["first_name"];
    $lastName  = $_POST["last_name"];
    $fullName  = $firstName . "_" . $lastName;

    $userFolder = "uploads/" . $fullName; // define user folder
    $galleryFolder = $userFolder . "/gallery";  // define gallery inside the user folder


    ensure_folder($userFolder); //create folder if it doesn't exist
    ensure_folder($galleryFolder); // create gallery if it doesn't exist


    //personal photo saving
    $photosource = $_FILES["personal_photo"]["tmp_name"];
    $photoName= $_FILES["personal_photo"]["name"];
    $newName="myphoto";

    //saving personal photo
    $_SESSION["personal_path"]= save_photo($photoName,$photosource,$userFolder,$newName,$errors);

    // gallery saving
    foreach ($_FILES["image"]["name"] as $key => $name) {

        $source = $_FILES["image"]["tmp_name"][$key];
        $photoName = $_FILES["image"]["name"][$key];
        $newName = "random";
        save_photo($photoName,$source,$galleryFolder,$newName,$errors);
    }

    //save gallery path
    $_SESSION["gallery_path"]= $galleryFolder;

    // redirecting to view page
    redirect("display.php");
    exit;
}