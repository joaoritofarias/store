<?php
header("Content-Type: text/plain; charset=utf-8");
$str = base64_encode(file_get_contents("images/0150393_PE308518_S5.JPG"));

echo $str;
