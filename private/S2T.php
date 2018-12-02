<?php
//require 'load_config.php';

function convertSpeech2Text($filename,$url,$validKeys)
{
  //print_r($validKeys);
  if($validKeys!=null&&$url!=null)
  {
   $file = fopen($filename, 'r');
   $size = filesize($filename);
   $fildata = fread($file,$size);
   $headers = array(    "Content-Type: audio/flac",
                        "Transfer-Encoding: chunked"
                        );
   $ch = curl_init();
   curl_setopt($ch, CURLOPT_URL, $url);
   curl_setopt($ch, CURLOPT_USERPWD, "apikey:$validKeys[0]");
   curl_setopt($ch, CURLOPT_POST, TRUE);
   curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
   curl_setopt($ch, CURLOPT_BINARYTRANSFER, TRUE);
   curl_setopt($ch, CURLOPT_POSTFIELDS, $fildata);
   curl_setopt($ch, CURLOPT_INFILE, $file);
   curl_setopt($ch, CURLOPT_INFILESIZE, $size);
   curl_setopt($ch, CURLOPT_VERBOSE, true);
   curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
   curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

   $executed = curl_exec($ch);
   curl_close($ch);
   $resArr = array();
   $resArr = json_decode($executed);
  echo "<pre id='jsonOutput'>"; print_r($resArr); echo "</pre>";

 }
}
?>
