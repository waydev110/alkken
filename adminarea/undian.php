<?php 
require_once('helper/language.php');
require_once("helper/all.php");
error_reporting(1);
if(!isset($_SESSION['user_login']) || isset($_SESSION['user_login'])== ""){
  header("location:login.php");
}
if(!isset($_GET['jenis_kupon'])){
    echo 'Kembali';
    die;
}
require_once("model/classUndianKupon.php");
$obj = new classUndianKupon();
$jenis_kupon = $_GET['jenis_kupon'];
$data = $obj->show_undian($jenis_kupon);
$periode = $obj->show_periode($jenis_kupon);


?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Aplikasi Undian</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome-pro-6.2.0/css/all.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="assets/plugins/datatables/dataTables.bootstrap.css">
    <!-- <link href="https://cdn.datatables.net/v/bs/dt-1.13.6/b-2.4.1/b-colvis-2.4.1/datatables.min.css" rel="stylesheet"> -->
    <!-- Select2 -->
    <link rel="stylesheet" href="assets/plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="assets/dist/css/skins/_all-skins.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="assets/plugins/datepicker/datepicker3.css">
    <link rel="icon" href="../favicon.png" sizes="16x16" type="image/png">
    <style>
        body {
          background: url("bg.jpg") no-repeat top center!important;
        }
        .bg-winner {
            background-image:    url("bg-winner.jpg");
            background-size:     cover;
            background-repeat:   no-repeat;
            background-position: center center;  
        }
        #containerPemenang {
            min-height:400px;
            margin-top:100px;
            display: flex;
            align-content: center;
            justify-content: center;
            flex-direction: column;
        }
        #containerPemenang h2 {
            font-weight:bold;
            margin-top:0px;
        }
        @keyframes rollDice {
            0% { transform: translateY(0); }
            25% { transform: translateY(-30px); }
            50% { transform: translateY(0); }
            75% { transform: translateY(-30px); }
            100% { transform: translateY(0); }
        }

        .box-undian {
            border:3px #dfb41a dashed;
            padding:10px;
            border-radius : 20px;
        }
        .pemenang-undian {
            width: 110px;
            border: 3px #000 dashed;
            padding: 10px;
            border-radius: 0px;
            font-size: 16px;
            font-weight: bold;
            background-color: #fff5a8;   
        }
        .kupon-box{
            padding:15px;
            font-weight: bold;
            font-size:32px!important;
            color : #dfb41a;
            border-radius : 30px;
            background: rgb(40 60 162);
            background: linear-gradient(34deg, rgb(31 12 21) 0%, rgb(153 51 102) 50%, rgb(60 4 32) 100%);
        }
        .btn-primary {
            border-radius:10px;
            background: rgb(40 60 162);
            background: linear-gradient(34deg, rgb(31 12 21) 0%, rgb(153 51 102) 50%, rgb(60 4 32) 100%);
        }
        .login-box, .register-box {
            width: 360px;
            margin: 3% auto;
        }
        .card-pemenang{
            width: 100%;
            margin: 20px 0 auto;
            text-align:center
        }
        .body-pemenang{
            height:auto;
            width: 100%;
            margin: 20px auto;
            border-radius : 20px;         
            display: flex;
            gap: 10px;
            flex-wrap:wrap;
            /* border:3px #240000 dashed; */
            /* padding:20px; */
        }
        .card-footer{
            width: 100%;
            margin: 10px auto;
            padding-top:150px;
            text-align:center
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</head>
<body>

<body class="hold-transition login-page">
    <div class="login-box text-center">
        <img src="undian<?=$jenis_kupon?>.png" alt="" width="100%">
        <br>
        <br>
        <div class="login-box-body text-center kupon-box">
            <form id="undianForm">
                <div id="hasilPengundian" class="box-undian">KUPON UNDIAN</div>
            </form>

        </div>
        <br>
        <button type="button" class="btn btn-lg btn-primary" id="btnUndi" style="display:none">UNDI PEMENANG</button>
        <button type="button" class="btn btn-lg btn-primary" id="btnKonfirmasi" onclick="konfirmasi()" style="display:none">KONFIRMASI</button>

    </div>
    <div class="col-sm-2"> 
    </div>
    <div class="col-sm-8"> 
        <div class="card-pemenang">
            <img src="title-winner.png" alt="" width="280px">
            <div class="body-pemenang" id="listPemenang">
                
            </div>
        </div>
    </div>

    <audio id="backsound" loop>
        <source src="backsound.mp3" type="audio/mp3">
        Your browser does not support the audio element.
    </audio>

    <div class="col-sm-12">
        <div class="card-footer">
            <a href="index.php" class="btn btn-lg btn-primary">KEMBALI</a>
            <button type="button" class="btn btn-lg btn-primary" id="btnReset" onclick="reset_undian()">RESET UNDIAN</button>
            <button type="button" class="btn btn-lg btn-primary" id="btnTutup" onclick="tutup_undian()">TUTUP UNDIAN</button>
        </div>
    </div>

    <div class="modal fade bs-example-modal-lg" id="modalPemenang" tabindex="-1" role="dialog" aria-labelledby="modalDetailLabel">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-body bg-winner text-center">
                    <div id="containerPemenang">
                        
                    </div>
                    <button type="button" class="btn btn-lg btn-primary" data-dismiss="modal" aria-label="Close">OK</button>
                </div>
            </div>
        </div>
    </div>

<script>
var kuponUndian = [];
var jenis_kupon = '<?=$jenis_kupon?>';
var start_date = '<?=$periode->start_date?>';
var end_date = '<?=$periode->end_date?>';
var periode = '<?=$periode->id?>';
var btnUndi = $("#btnUndi");
var btnKonfirmasi = $("#btnKonfirmasi");
var listPemenang = $("#listPemenang");

$(document).ready(function(){
    getKupon();
    show_pemenang();
    btnUndi.click(function(){
        undiPemenang();
    });
});
function getKupon(){    
    $.ajax({
        url: 'controller/undian/get_kupon.php',
        type: 'post',
        data: {
                jenis_kupon:jenis_kupon,
                start_date:start_date,
                end_date:end_date,
            },
        success: function (result) {
            const obj = JSON.parse(result);
            if (obj.status == true) {
                kuponUndian = obj.kupon;
                if (kuponUndian.length > 0) {
                    $('#btnUndi').show();
                }
            } else {
                alert(obj.message);
            }
        }
    });
}

function konfirmasi(kupon_id){ 
    $.ajax({
        url: 'controller/undian/create_pemenang.php',
        type: 'post',
        data: {
                kupon_id:kupon_id,
                periode:periode
            },
        success: function (result) {
            const obj = JSON.parse(result);
            if (obj.status == true) {
                // listPemenang.append(obj.kupon_id);
                show_pemenang();
                btnKonfirmasi.attr("onclick", "konfirmasi()");
                btnKonfirmasi.hide();
                btnUndi.show();
                $('#containerPemenang').html(obj.pemenang);
                $('#modalPemenang').modal('show');
            } else {
                alert(obj.message);
            }
        }
    });
}
function show_pemenang(){ 
    $.ajax({
        url: 'controller/undian/show_pemenang.php',
        type: 'post',
        data: {
                jenis_kupon:jenis_kupon,
                periode:periode
            },
        success: function (result) {
            const obj = JSON.parse(result);
            listPemenang.html(obj.list_pemenang);
        }
    });
}
function tutup_undian(){    
    if(confirm('Apakah anda yakin undian untuk periode ini sudah selesai?')){
        $.ajax({
            url: 'controller/undian/tutup_undian.php',
            type: 'post',
            data: {
                    jenis_kupon:jenis_kupon,
                    start_date:start_date,
                    end_date:end_date,
                },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    alert(obj.message);
                    window.location = "index.php";
                } else {
                    alert(obj.message);
                }
            }
        });
    }
}
function reset_undian(){    
    if(confirm('Apakah anda yakin mereset undian untuk periode ini?')){
        $.ajax({
            url: 'controller/undian/reset_undian.php',
            type: 'post',
            data: {
                    jenis_kupon:jenis_kupon,
                    start_date:start_date,
                    end_date:end_date,
                    periode:periode
                },
            success: function (result) {
                const obj = JSON.parse(result);
                if (obj.status == true) {
                    alert(obj.message);
                    window.location = "index.php";
                } else {
                    alert(obj.message);
                }
            }
        });
    }
}

function undiPemenang(){    
    if (kuponUndian.length > 0) {
        btnUndi.hide();
        rollDiceAnimation();
        playBacksound();

        setTimeout(function(){
            var pemenangIndex = Math.floor(Math.random() * kuponUndian.length);
            var pemenang = kuponUndian[pemenangIndex];

            $("#hasilPengundian").html(pemenang.kupon);

            // Hentikan animasi dan backsound setelah pengundian selesai
            stopRollDiceAnimation();
            setTimeout(function(){
                stopBacksound();
                btnUndi.show();
                btnKonfirmasi.attr("onclick", "konfirmasi('"+pemenang.kupon+"')");
                btnKonfirmasi.show();
            }, 2000);
        }, 11000); // Ganti angka ini dengan durasi animasi

    } else {
        alert("Belum ada peserta yang mendaftar.");
    }
}

function rollDiceAnimation() {
    var iterationCount = 110;  // Jumlah iterasi animasi
    var intervalDuration = 100;  // Durasi interval dalam milidetik
    var resultElement = $("#hasilPengundian");
    var originalContent = resultElement.html();

    var intervalId = setInterval(function() {
        var randomIndex = Math.floor(Math.random() * kuponUndian.length);
        var randomPeserta = kuponUndian[randomIndex].kupon;
        resultElement.html(randomPeserta);
    }, intervalDuration);

    setTimeout(function() {
        clearInterval(intervalId);
        resultElement.html(originalContent);
        resultElement.addClass("rolling");
    }, intervalDuration * iterationCount);
}

function stopRollDiceAnimation() {
    $("#hasilPengundian").removeClass("rolling");
}

function playBacksound() {
    var audio = document.getElementById("backsound");
    audio.play();
}

function stopBacksound() {
    var audio = document.getElementById("backsound");
    audio.pause();
    audio.currentTime = 0;
}
</script>

</body>
</html>
