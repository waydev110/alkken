<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

function createCaptcha() {
    $kode = "bcdefghjkmnp";
    $pass = [];
    for ($i = 0; $i < 4; $i++) {
        $pass[] = $kode[rand(0, strlen($kode) - 1)];
    }
    return implode($pass);
}

$code = createCaptcha();
$_SESSION["captcha"] = $code;

// create image
$wh = imagecreatetruecolor(150, 40);
$bgc = imagecolorallocate($wh, 255, 255, 255);
imagefill($wh, 0, 0, $bgc);

// font path
$fontPath = __DIR__ . '/TimesNewRomanceBold-3zzoy.ttf';

$x = 20;
for ($i = 0; $i < strlen($code); $i++) {
    $color = imagecolorallocate($wh, rand(0,255), rand(0,255), rand(0,255));
    imagettftext($wh, 22, rand(-10,10), $x, 30, $color, $fontPath, $code[$i]);
    $x += 30;
}

header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Type: image/png');
imagepng($wh);
imagedestroy($wh);
?>
