<?php
require '../vendor/autoload.php';

function convert($uploadPath,$audioFile){
  $convertedPath = '../converted/';
  $audioFile = $uploadPath.$audioFile;
  $path_parts = pathinfo($audioFile);
  $ffmpeg = FFMpeg\FFMpeg::create(array(
'ffmpeg.binaries' => '../FFMpeg/ffmpeg',
'ffprobe.binaries' => '../FFMpeg/ffprobe',
'timeout' => 3600, // The timeout for the underlying process
'ffmpeg.threads' => 12, // The number of threads that FFMpeg should use
));
  $audio = $ffmpeg->open($audioFile);
  $format = new FFMpeg\Format\Audio\Flac();
  $format
    ->setAudioChannels(2)
    ->setAudioKiloBitrate(160);
  $path_parts['filename'];
  $audio->save($format, $convertedPath.$path_parts['filename'].'.flac');
  return $path_parts['filename'].".flac";
}
?>
