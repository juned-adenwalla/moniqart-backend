<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profilepic'])) {
    $targetDirectory = '/';
    $targetFile = $targetDirectory . basename($_FILES['profilepic']['name']);

    // Check if the file is an actual image
    $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
    $allowedExtensions = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($imageFileType, $allowedExtensions)) {
        echo 'Invalid image file format. Allowed formats: JPG, JPEG, PNG, GIF.';
        exit;
    }

    // Move the uploaded file to the target directory
    if (move_uploaded_file($_FILES['profilepic']['tmp_name'], $targetFile)) {
        echo 'File uploaded successfully.';
    } else {
        echo 'Error uploading file.';
    }
} else {
    echo 'Invalid request.';
}
?>