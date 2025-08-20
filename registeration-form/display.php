<?php
session_start();

$photoPath = $_SESSION["personal_path"];
$galleryPath = $_SESSION["gallery_path"]."/";

$images=glob($galleryPath . "*.png");

?>

<h2>Personal Photo</h2>
<img src="<?php echo $photoPath; ?>" width="300" alt="Personal Photo"><br><br>

<?php
if (isset($_SESSION["data"])) {
    $data = $_SESSION["data"]; // assign to a variable for easy use


    echo "First Name: " . $data["first_name"] . "<br>";
    echo "Last Name: " . $data["last_name"] . "<br>";
    echo "Email: " . $data["email"] . "<br>";
    echo "Phone: " . $data["phone"] . "<br>";
    echo "Gender: " . $data["gender"]. "<br>";

    if ($data["has_car"] === "yes") {
        echo "Car Type: " . $data["car_type"] . "<br>";
    }

} else {
    echo "No data in session!";
    header("Location: form.php");
    exit;
}?>
<h2>gallery</h2>
<?php
if ($images) {
    foreach ($images as $image) {
        echo "<img src='$image' width='200' style='margin:10px; border:1px solid #ccc;' alt='image'>";
    }
} else {
    echo "No PNG images found in the folder.";
}


session_unset();
session_destroy();
?>