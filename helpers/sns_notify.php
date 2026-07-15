<?php

require_once __DIR__ . '/../vendor/autoload.php';

use Aws\Sns\SnsClient;

function sendEmployeeNotification(
    $firstName,
    $lastName,
    $department,
    $designation
) {

    $sns = new SnsClient([
        'version' => 'latest',
        'region'  => 'ap-south-1'
    ]);

    $message =
"New Employee Added

Name: {$firstName} {$lastName}

Department: {$department}

Designation: {$designation}

Date: " . date("d M Y H:i");

    $sns->publish([

        'TopicArn' => 'arn:aws:sns:ap-south-1:569475966749:employee-notifications',

        'Subject' => 'Employee Management System',

        'Message' => $message

    ]);

}