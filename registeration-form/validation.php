<?php
//session_start();

function validate_min_length($value, $fieldname ,$min_length) // checks if length of filed inputs greater than min
{
    return strlen($value) < $min_length? " {$fieldname} must be at least {$min_length} ":null;

}

function validate_required($value,$fieldname) //checks if fields are empty
{
    return empty($value)? "please enter your {$fieldname}":null;
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

    // Image validation


    foreach ($files["images"]["name"] as $key => $name) {

        $tmpPath = $files["images"]["name"][$key];
        $mime = mime_content_type($tmpPath);

        if (!file_exists($files["image"]["tmp_name"][$key])) {
            $errors[] = "File does not exist";
        }
        if (filesize($files["image"]["tmp_name"][$key]) === 0) {
            $errors[] = "File is empty";
        }
        // checks the content of the file regardless of the extension and validates according to it
        if (!in_array($mime, $allowedTypes)) {
            $errors[] = "file isn't an image";
        }
        if ($files["image"]["size"][$key] > $maxSize) {
            $errors[] = "File size must be less than or equal to 2 MB";
        }
    }

    //remove null objects from error array
    return array_filter($errors);
}