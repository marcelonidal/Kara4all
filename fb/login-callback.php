<?php
session_start();

//@ REMOVE OS WARNINGS
$success = @include_once './fb/fbconfig.php';
if (!$success) {
    include_once '../fb/fbconfig.php';
}

$success = @include_once './bd/dbconnection.php';
if (!$success) {
    include_once '../bd/dbconnection.php';
}

//USADO PARA PEGAR O TOKEN
$helper = $fb->getRedirectLoginHelper();

try {
    $accessToken = $helper->getAccessToken();
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'ERRO AO BUSCAR O OBJ DO USER - Graph: ' . $e->getMessage() . '<br>';
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'ERRO NA AUTENTICACAO - Facebook SDK: ' . $e->getMessage() . '<br>';
    exit;
}

if (! isset($accessToken)) {
    if ($helper->getError()) {
        header('HTTP/1.0 401 Unauthorized');
        echo "Error: " . $helper->getError() . '<br>';
        echo "Error Code: " . $helper->getErrorCode() . '<br>';
        echo "Error Reason: " . $helper->getErrorReason() . '<br>';
        echo "Error Description: " . $helper->getErrorDescription() . '<br>';
    } else {
        header('HTTP/1.0 400 Bad Request');
        echo 'Bad request';
    }
    exit;
}

//var_dump($accessToken->getValue());

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

$tokenMetadata = $oAuth2Client->debugToken($accessToken);
//var_dump($tokenMetadata);

$tokenMetadata->validateAppId($appId);
$tokenMetadata->validateExpiration();

if (! $accessToken->isLongLived()) {
    // Exchanges a short-lived access token for a long-lived one
    try {
        $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);
    } catch (Facebook\Exceptions\FacebookSDKException $e) {
        echo '<p>Error getting long-lived access token: ' . $e->getMessage() . '</p><br>';
        exit;
    }
    //var_dump($accessToken->getValue());
}

$_SESSION['fb_token'] = (string) $accessToken;

//SETA O TOKEN PRAS CHAMADAS NO FB
$fb->setDefaultAccessToken($accessToken);

try {
    //$response = $fb->get('/me?fields=id,name,email', '{access-token}');
    //NAO PRECISA DO TOKEN PQ FOI SETADO ANTERIORMENTE
    $response = $fb->get('/me?fields=id,name,email');
    //echo var_dump($response);
} catch (Facebook\Exceptions\FacebookResponseException $e) {
    echo 'ERRO AO BUSCAR O OBJ DO USER - Graph: ' . $e->getMessage();
    exit;
} catch (Facebook\Exceptions\FacebookSDKException $e) {
    echo 'ERRO NA AUTENTICACAO - Facebook SDK: ' . $e->getMessage();
    exit;
}

//PEGA OS DADOS DO USER
$user = $response->getGraphUser();
//echo var_dump($user);

$fb_user_id = $user['id'];
$fb_user_name = $user['name'];
$fb_user_email = $user['email'];

/*
echo 'Name: ' . $user['name'];
echo 'Name: ' . $user->getName();
*/

$_SESSION['fb_user_id'] = $fb_user_id;
$_SESSION['fb_user_name'] = $fb_user_name;
$_SESSION['fb_user_email'] = $fb_user_email;
$_SESSION['iniLogin'] = true;

$success = @include_once './bd/fblogin.php';
if (!$success) {
    include_once '../bd/fblogin.php';
}

header('Location: ../index.php');
?>