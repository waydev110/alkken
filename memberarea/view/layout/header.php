
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="generator" content="">
    <title>Memberarea - <?=isset($title)?$title:'Home';?></title>

    <!-- manifest meta -->
    <meta name="apple-mobile-web-app-capable" content="yes">
    <!-- <link rel="manifest" href="manifest.json" /> -->

    <!-- Favicons -->
    <link rel="icon" href="../favicon.png" sizes="16x16" type="image/png">

    <!-- Google fonts-->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;600;700&display=swap" rel="stylesheet">

    <!-- bootstrap icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">

    <!-- swiper carousel css -->
    <link rel="stylesheet" href="assets/vendor/swiperjs-6.6.2/swiper-bundle.min.css">
    <link rel="stylesheet" href="assets/vendor/fontawesome-pro-6.4.2/css/all.css">
    <link rel="stylesheet" href="assets/vendor/datepicker/datepicker3.css">
    

    <!-- style css for this template -->
    <link href="assets/css/style.css" rel="stylesheet" id="style">
    <link href="assets/css/coupon.css" rel="stylesheet" id="style">
    <link rel="stylesheet" href="assets/vendor/sweetalert/sweetalert2.min.css">
    <link rel="stylesheet" href="assets/vendor/owlcarousel/owl.carousel.min.css">
    <style>
        :root {
            --black: #0a0a0a;
            --dark: #1a1a1a;
            --gold: #d4af37;
            --gold-light: #f4d03f;
            --white: #ffffff;
            --gray: #888888;
            --border: rgba(212, 175, 55, 0.2);
            --primary-gradient: linear-gradient(135deg, #1a1a1a 0%, #2d2d2d 100%);
            --gold-gradient: linear-gradient(135deg, #d4af37 0%, #f4d03f 100%);
            --card-shadow: 0 10px 30px rgba(0, 0, 0, 0.3);
            --input-focus: 0 0 0 3px rgba(212, 175, 55, 0.2);
        }
        
        body {
            background: linear-gradient(135deg, #0a0a0a 0%, #1a1a1a 100%);
            color: var(--white);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            min-height: 100vh;
        }
        .bg-theme {
            background: var(--dark);
        }
    </style>
</head>
<body class="body-scroll theme-<?=$theme?>" data-page="index">
<?php include 'view/layout/waiting.php'; ?>