<?php

require_once "helpers/s3_upload.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    $url = uploadToS3($_FILES['image']);

    echo "<h2>Uploaded Successfully</h2>";

    echo "<a href='$url' target='_blank'>$url</a>";

}

?>

<form method="POST" enctype="multipart/form-data">

<input type="file" name="image">

<button>Upload</button>

</form>