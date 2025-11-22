<?php
require_once("../helper/all.php");
require_once("../model/classSetting.php");

$s = new classSetting();
$binary = $s->setting('binary');
error_reporting(1);
if (!isset($_SESSION['user_login']) || isset($_SESSION['user_login']) == "") {
    header("location:login.php");
}
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>ADMIN AREA | <?= isset($title) ? $title : 'Dashboard'; ?></title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../assets/plugins/fontawesome-pro-6.2.0/css/all.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="../assets/plugins/datatables/dataTables.bootstrap.css">
    <!-- <link href="https://cdn.datatables.net/v/bs/dt-1.13.6/b-2.4.1/b-colvis-2.4.1/datatables.min.css" rel="stylesheet"> -->
    <!-- Select2 -->
    <link rel="stylesheet" href="../assets/plugins/select2/select2.min.css">
    <!-- Theme style -->
    <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
    <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
    <!-- bootstrap datepicker -->
    <link rel="stylesheet" href="../assets/plugins/datepicker/datepicker3.css">
    <link rel="stylesheet" href="../assets/plugins/sweetalert/sweetalert2.min.css">
    <!-- Include daterangepicker library -->
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">

    <script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
    <!-- Include Moment.js and Daterangepicker library -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css">
    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>

    <!-- Include Chart.js library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <link rel="icon" href="../favicon.png" sizes="16x16" type="image/png">
    <style type="text/css" media="screen">
        .btn-transparent {
            background: none !important;
        }

        .table {
            width: 100% !important;
        }

        .table>thead>tr>th {
            vertical-align: bottom;
            border-bottom: 1px solid #ddd;
            background: #3c8dbc;
            color: #fff;
            font-size: 12px;
            padding-left: 10px !important;
            padding-right: 10px !important;
            text-align: center;
        }

        .table>tbody>tr>td {
            font-size: 13px;
        }

        .table>tfoot>tr>th {
            vertical-align: bottom;
            border-bottom: 1px solid #ddd;
            background: #3c8dbc;
            color: #fff;
            font-size: 12px;
            padding-left: 10px !important;
            padding-right: 10px !important;
        }

        .table-responsive {
            border: none !important;
            padding-top: 10px !important;
            padding-bottom: 20px !important;
            margin-bottom: 0px !important;
        }

        .mt-2 {
            margin-top: 10px;
        }

        .mb-2 {
            margin-bottom: 10px;
        }

        .mb-4 {
            margin-bottom: 20px;
        }

        .d-flex {
            display: flex;
        }

        .justify-content-end {
            justify-content: flex-end !important;
        }

        .flex-wrap-reverse {
            flex-wrap: wrap-reverse;
        }

        .align-self-center {
            align-items: center;
        }

        label {
            line-height: 30px;
        }

        .align-content-right {
            justify-content: right;
        }

        table.dataTable thead .sorting:after,
        table.dataTable thead .sorting_asc:after,
        table.dataTable thead .sorting_desc:after {
            font-size: 8px;
            top: 12px;
            right: 2px;
        }

        label.error {
            padding-top: 4px;
            padding-bottom: 0px;
            margin-bottom: 0px;
            color: #a94442;
            font-weight: 400 !important;
        }

        label.control-title {
            font-weight: bold !important;
            color: #3c8dbc;
            text-align: left;

        }

        .border-bottom-1 {
            border-bottom: 1px solid;
        }

        .swal2-popup {
            font-size: 1.2em !important;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .img-clickable {
            cursor: pointer;
        }

        .modal-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 15px;
        }

        .modal-title {
            margin: 0;
            font-size: 18px;
            /* Sesuaikan ukuran font jika perlu */
        }

        .close {
            font-size: 2.8rem;
            /* Ukuran tombol close */
            padding: 0;
            margin: 0;
            /* Pastikan tidak ada margin tambahan pada tombol */
            position: absolute;
            right: 15px;
            top: 15px;
        }

        .upload-area {
            border: 2px dashed #aaa;
            width: 150px;
            height: 150px;
            padding: 35px 5px;
            border-radius: 10px;
            text-align: center;
            cursor: pointer;
            margin-bottom: 20px;
            color: #666;
        }

        .preview-container {
            display: flex;
            flex-wrap: wrap;
            gap: 15px;
        }

        .image-box {
            position: relative;
            width: 150px;
            margin-top: 10px;
            margin-bottom: 10px;
        }

        .image-box img {
            width: 100%;
            height: 100px;
            object-fit: cover;
            border-radius: 8px;
        }
    </style>
</head>

<body class="hold-transition fixed skin-green-light sidebar-mini">
    <div class="wrapper">

        <header class="main-header">
            <!-- Logo -->
            <a href="index.php" class="logo">
                <span class="logo-mini"><b>A</b>DM</span>
                <span class="logo-lg"><b>Admin</b>istrator</span>
            </a>
            <nav class="navbar navbar-static-top">
                <?php require_once("view/partial/navbar_top.php"); ?>
            </nav>
        </header>
        <aside class="main-sidebar">
            <section class="sidebar">
                <div class="user-panel">
                    <div class="pull-left image">
                        <img src="../assets/dist/img/avatar5.png" class="img-circle" alt="User Image">
                    </div>
                    <div class="pull-left info">
                        <p><?= $_SESSION['nama_login']; ?></p>
                        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                    </div>
                </div>
                <?php require_once("view/partial/navbar_side.php"); ?>
            </section>
        </aside>

        <div class="content-wrapper">
            <section class="content-header">
                <h1>
                    Dashboard
                    <small>Control panel</small>
                </h1>
                <ol class="breadcrumb">
                    <li><a href="#"><i class="fa fa-dashboard"></i> Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </section>

            <section class="content">
                <?php require_once("routes.php"); ?>
            </section>
        </div>
        <footer class="main-footer">
            <div class="pull-right hidden-xs">
                <b>VERSI</b> 2.0
            </div>
            <strong>Copyright &copy; 2023 <a href="/">ADMIN AREA</a>.</strong> All rights
            reserved.
        </footer>
        <div class="control-sidebar-bg"></div>
    </div>
    <!-- Select2 -->
    <script src="../assets/plugins/select2/select2.full.min.js"></script>
    <!-- Bootstrap 3.3.6 -->
    <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
    <!-- DataTables -->
    <!--<script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>-->
    <!-- <script src="https://cdn.datatables.net/v/bs/dt-1.13.6/b-2.4.1/b-colvis-2.4.1/datatables.min.js"></script> -->
    <!--<script src="../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>-->
    <script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
    <script src="//cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.6/js/dataTables.buttons.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.bootstrap4.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.html5.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.print.min.js"></script>
    <script src="//cdn.datatables.net/buttons/1.5.6/js/buttons.colVis.min.js"></script>
    <!-- SlimScroll -->
    <script src="../assets/plugins/slimScroll/jquery.slimscroll.min.js"></script>
    <!-- AdminLTE App -->
    <script src="../assets/dist/js/app.min.js"></script>
    <!-- AdminLTE for demo purposes -->
    <script src="../assets/dist/js/demo.js"></script>
    <!-- bootstrap datepicker -->
    <script src="../assets/plugins/datepicker/bootstrap-datepicker.js"></script>
    <script src="../assets/plugins/autonumeric4/autoNumeric.min.js"></script>
    <script src="../assets/plugins/autoNumeric/autoNumeric.js"></script>
    <script src="../assets/plugins/sweetalert/sweetalert2.all.min.js"></script>

    <script>
        $(document).ready(function() {
            if ($('.select2').length > 0) {
                $(".select2").select2();
            }
            if ($('#example1').length > 0) {
                $("#example1").DataTable();
            }
            if ($('.autonumeric').length > 0) {
                anElement = new AutoNumeric('.autonumeric', 'integer');
            }
            if ($('#datepicker').length > 0) {
                $('#datepicker').datepicker({
                    autoclose: true
                });
            }
            if ($('.datepicker').length > 0) {
                $('.datepicker').datepicker({
                    autoclose: true
                });
            }
            if ($('.autonumeric2').length > 0) {
                $('.autonumeric2').autoNumeric('init', {
                    "aSep": ",",
                    "aDec": ".",
                    "mDec": "0",
                    "maxValue": "10000000000000",
                });
            }
            if ($('.autonumeric3').length > 0) {
                $('.autonumeric3').autoNumeric('init', {
                    "aSep": ".",
                    "aDec": ",",
                    "mDec": "0",
                    "maxValue": "10000000000000",
                });
            }
            if ($('.autonumeric4').length > 0) {
                $('.autonumeric4').autoNumeric('init', {
                    "aSep": ".",
                    "aDec": ",",
                    "mDec": "2",
                    "maxValue": "10000000000000",
                });
            }
            if ($('.autonumeric5').length > 0) {
                $('.autonumeric5').autoNumeric('init', {
                    "aSep": ".",
                    "aDec": ",",
                    "mDec": "4",
                    "maxValue": "10000000000000",
                });
            }
        });

        function copyToClipboard(element) {
            var $temp = $("<input>");
            $("body").append($temp);
            $temp.val($(element).text()).select();
            document.execCommand("copy");
            $temp.remove();
        }
    </script>
</body>

</html>