<?php

require 'vendor/autoload.php';

use Aws\S3\S3Client;
use Aws\Exception\AwsException;

try {

    $s3 = new S3Client([
        'version' => 'latest',
        'region'  => 'ap-south-1'
    ]);

    echo "<h2>Connected to AWS SDK</h2>";

    $result = $s3->listBuckets();

    echo "<h3>Available Buckets:</h3>";

    echo "<ul>";

    foreach ($result['Buckets'] as $bucket) {

        echo "<li>" . htmlspecialchars($bucket['Name']) . "</li>";

    }

    echo "</ul>";

} catch (AwsException $e) {

    echo "<h3>AWS Error</h3>";

    echo "<pre>";

    echo $e->getMessage();

    echo "</pre>";

}