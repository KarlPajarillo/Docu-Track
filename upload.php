<?php
$target_dir = "assets/uploads/";
$target_file = $target_dir . basename(date('YmdHis').'-'.$_FILES["file_name"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
  $check = getimagesize($_FILES["file_name"]["tmp_name"]);
  if($check !== false) {
    echo "File is an image - " . $check["mime"] . ".";
    $uploadOk = 1;
  } else {
    echo "File is not an image.";
    $uploadOk = 0;
  }
}

// Check if file already exists
if (file_exists($target_file)) {
  echo "File already exists. ";
  $uploadOk = 0;
}

// Check file size
if ($_FILES["file_name"]["size"] > 2000000) {
  echo "Your file is too large. ";
  $uploadOk = 0;
}

// Allow certain file formats
if($imageFileType != "doc" && $imageFileType != "docx" && $imageFileType != "pdf") {
  echo "Only Documents/PDFs are allowed in this attachment. ";
  $uploadOk = 0;
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
  echo "Your file was not uploaded. ";
// if everything is ok, try to upload file
} else {
  if (move_uploaded_file($_FILES["file_name"]["tmp_name"], $target_file)) {
    echo "Success,";
    echo htmlspecialchars( basename(date('YmdHis').'-'.$_FILES["file_name"]["name"]));
  } else {
    echo "Sorry, there was an error uploading your file.";
  }
}
?>