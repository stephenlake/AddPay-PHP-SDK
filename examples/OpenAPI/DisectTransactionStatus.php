<?php

require_once(__DIR__ . '/../../core/bootstrap.php');

$api = new OpenAPI();

$http = $api->transactions()
            ->find('TRANSACTION_ID_HERE');

if ($http->succeeds()) {
    if ($http->statusIs(OpenApi::STATE_READY)) {
        // Handle READY transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_ACTIVE)) {
        // Handle ACTIVE transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_PARTIAL)) {
        // Handle PARTIAL transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_INVALID)) {
        // Handle INVALID transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_AVSPENDING)) {
        // Handle AVSPENDING transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_AVSSUBMITTED)) {
        // Handle AVSSUBMITTED transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_AVSFAILED)) {
        // Handle AVSFAILED transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_FAILED)) {
        // Handle FAILED transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_COMPLETED)) {
        // Handle COMPLETE transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_CANCELLED)) {
        // Handle CANCELLED transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_SECURE_AUTHED)) {
        // Handle SECUREAUTHED transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_SECURE_PENDING)) {
        // Handle SECUREPENDING transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_SECURE_AUTHED_FAILED)) {
        // Handle SECUREAUTHFAILED transaction
        // Read the AddPay API docs - handling is up to your application
    } elseif ($http->statusIs(OpenApi::STATE_SECURE_FAILED)) {
        // Handle SECUREFAILED transaction
        // Read the AddPay API docs - handling is up to your application
    }

    dd($http->getStatus());
} else {
    $errorCode = $http->getErrorCode();
    $errorMsg  = $http->getErrorMessage();

    echo "Error '{$errorCode}' with message '{$errorMsg}'.";

    dd($http->resource);
}
