<?php

namespace Xanax\Plugin;

use Xanax\Classes\ClientURL;

class FFmpeg {
  
  public function downloadRemoteVideo($url, $filePath) {
    $cmd = sprintf("ffmpeg -i %s -c copy %s", $url, $filePath);
    exec ($cmd, $output, $returnVariable);
  }
  
}

?>
