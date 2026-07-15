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
function getS3ImageUrl($imageUrl)
{
    if (empty($imageUrl)) {
        return "";
    }

    $bucket = "ems-images-arshad107";
    $region = "ap-south-1";

    $s3 = new Aws\S3\S3Client([
        'version' => 'latest',
        'region'  => $region
    ]);

    // Convert full URL to object key
    $key = str_replace(
        "https://{$bucket}.s3.{$region}.amazonaws.com/",
        "",
        $imageUrl
    );

    $cmd = $s3->getCommand('GetObject', [
        'Bucket' => $bucket,
        'Key'    => $key
    ]);

    $request = $s3->createPresignedRequest($cmd, '+15 minutes');

    return (string)$request->getUri();
}