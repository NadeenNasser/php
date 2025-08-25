<?php

function validate_min_length($value, $fieldname ,$min_length) // checks if length of filed inputs greater than min
{
    return strlen($value) < $min_length? " {$fieldname} must be at least {$min_length} ":null;

}

function validate_required($value,$fieldname) //checks if fields are empty
{
    return empty($value)? "please enter your {$fieldname}":null;
}

function image_validation($image,$mime,$allowedTypes,$maxSize)
{
    if (!file_exists($image)) {
         return " {$image} does not exist";
    }elseif (filesize($image) === 0) {
         return "{$image} is empty";
    } elseif (filesize($image)> $maxSize) {
         return " {$image} size must be less than or equal to 2 MB";
    }elseif (!in_array($mime, $allowedTypes)) {
         return "{$image} isn't an image";
    }
    return null;
}

function validate_data($data, $files)
{
    $minPassLen = 7;  //minimum password length
    $minLen = 3;     // minimum name length
    $errors = []; // array to store errors
    $maxSize = 2 * 1024 * 1024; // 2 MB
    $allowedTypes = ["image/png", "image/jpeg"];
    $fields= ["first_name", "last_name", "email", "password"];

    // password confirmation
    if (empty($data["confirm_password"])) {
        $errors[] = "Please confirm your password";
    } elseif ($data["confirm_password"] !== $data["password"]) {
        $errors[] = "Passwords do not match";
    }

    // check if required fields are empty
    foreach ($fields as $field){
        $errors[]= validate_required($data[$field], $field);
    }

    //validate minimum length
    $errors[] = validate_min_length($data["first_name"], $fields[0], $minLen);
    $errors[] = validate_min_length($data["last_name"], $fields[1], $minLen);
    $errors[] = validate_min_length($data["password"], $fields[3], $minPassLen);

    // personal photo
    if($files["personal_photo"]["error"]=== UPLOAD_ERR_OK) {
        $tmpPath = $files["personal_photo"]["tmp_name"];
        $mime = mime_content_type($tmpPath);
        $errors[] = image_validation($tmpPath,$mime,$allowedTypes, $maxSize);
    }

    //validate gallery
    foreach ($files["image"]["name"] as $key => $name) {

        $tmpPath = $files["image"]["tmp_name"][$key];
        $mime = mime_content_type($tmpPath);
        $errors[]=image_validation($tmpPath,$mime,$allowedTypes,$maxSize);
    }

    //remove null objects from error array
    return array_filter($errors);
}