<?php

//@ REMOVE OS WARNINGS
$success = @include_once './vendor/facebook/autoload.php';
if (!$success) {
    include_once '../vendor/facebook/autoload.php';
}

$appId = '';

//INSTANCIA O FACEBOOK PHP SDK v5.
$fb = new Facebook\Facebook([
    'app_id' => $appId,
    'app_secret' => '',
    'default_graph_version' => 'v2.10'
]);

?>