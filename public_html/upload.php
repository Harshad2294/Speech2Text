<?php
/*
  Author : Harshad Shettigar
  Description : PHP script to receive and save the uploaded file according to IP.
*/

require '../private/convert.php';
require '../private/load_config.php';
require '../private/S2T.php';
$data =  "";
if(isset($_FILES["file"]["tmp_name"])){
  $data =  file_get_contents($_FILES["file"]["tmp_name"]);
}
$uploadPath = "../upload/";
$convertedFilePath = "../converted/";
$fileDir = getUserIP();

if (!file_exists($uploadPath.$fileDir)) {
    mkdir($uploadPath.$fileDir, 0777, true);
    file_put_contents($uploadPath.$fileDir.'/'.$_FILES["file"]["name"], $data);
}
else {
  file_put_contents($uploadPath.$fileDir.'/'.$_FILES["file"]["name"], $data);
}

$newFile = convert($uploadPath,$fileDir.'/'.$_FILES["file"]["name"]);
if(isset($newFile)&&($newFile!=null)){
  convertSpeech2Text($convertedFilePath.$newFile,$url,$validKeys);
}

function getUserIP()
{
    // Get real visitor IP behind CloudFlare network
    if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
              $_SERVER['REMOTE_ADDR'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
              $_SERVER['HTTP_CLIENT_IP'] = $_SERVER["HTTP_CF_CONNECTING_IP"];
    }
    $client  = @$_SERVER['HTTP_CLIENT_IP'];
    $forward = @$_SERVER['HTTP_X_FORWARDED_FOR'];
    $remote  = $_SERVER['REMOTE_ADDR'];
    if(filter_var($client, FILTER_VALIDATE_IP)){
        $ip = $client;
    }
    elseif(filter_var($forward, FILTER_VALIDATE_IP)){
        $ip = $forward;
    }
    else{
        $ip = $remote;
    }
    return $ip;
}
?>
