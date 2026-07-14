<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Aws\S3\S3Client;

function uploadToS3($file)
{
    $bucket = "ems-images-arshad107";

    $region = "ap-south-1";

    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => $region
    ]);

    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);

    $key = "employees/" . uniqid() . "." . $extension;

    $result = $s3->putObject([
        'Bucket' => $bucket,
        'Key' => $key,
        'SourceFile' => $file['tmp_name']
    ]);

    return $result['ObjectURL'];
}