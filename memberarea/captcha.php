<?php
session_start();

function createCaptcha() {
    $kode = "bcdefghjkmnp";
    $pass = array(); 
    $panjangkode = strlen($kode) - 2; 
    for ($i = 0; $i < 4; $i++) {
        $n = rand(0, $panjangkode);
        $pass[] = $kode[$n];
    }
    return implode($pass); 
}

// hasil kode acak disimpan di $code
$code = createCaptcha();

// kode acak disimpan di dalam session agar data dapat dipassing ke halaman lain
$_SESSION["captcha"] = $code;

// membuat background
$wh = imagecreatetruecolor(150, 40);
$bgc = imagecolorallocate($wh, 255, 255, 255);  // Background color
imagefill($wh, 0, 0, $bgc);

// Path to the TTF font file
$fontPath = __DIR__ . '/Hey_Comic.ttf';  // Use absolute path

// Check if font file exists, otherwise use built-in font
$useTTF = file_exists($fontPath);
for ($i = 0; $i < strlen($code); $i++) {
    // Generate random color for each character
    $randomColor = imagecolorallocate($wh, rand(0, 255), rand(0, 255), rand(0, 255));  // Random color
    
    // Draw the character with the random color
    if ($useTTF) {
        imagettftext($wh, 20, 0, $x, 30, $randomColor, $fontPath, $code[$i]);
    } else {
        imagestring($wh, 5, $x, 10, $code[$i], $randomColor);
    }
    
    // Increase the space between characters
    $x += 30; 
}

// membuat gambar
header('Content-Type: image/jpg');
imagejpeg($wh);
imagedestroy($wh);
?>
