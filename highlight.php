<?php 
error_reporting(0);

if (isset($_GET["path"])) {
  $path = $_GET["path"];
} else {
  $path = ".";
}

if (is_dir($path) === true) {
  $i = 0;
  if ($handle = opendir($path)) {
    while (($file = readdir($handle)) !== false) {
      if ($file != "." && $file != "..") {
        echo nl2br("<a href=\"highlight.php?path={$path}" . DIRECTORY_SEPARATOR . "{$file}\">{$file}</a>\r\n");
        $i++;
      }
    }
    closedir($handle);
  }
} elseif (is_file($path) === true) {
  highlight_file($path);  
  //echo 'it ran';
}

?>