<?php 
require_once '../helper/all.php';
error_reporting(1);
if(!isset($_SESSION['session_stokis_id'])){
  header("location:login.php");
}
$session_stokis_id = $_SESSION['session_stokis_id'];
$session_id_stokis = $_SESSION['session_id_stokis'];
$session_nama_stokis = $_SESSION['session_nama_stokis'];
?>
<!DOCTYPE html>
<html>

    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <title><?=$lang['stokis']?> | <?=isset($title) ? $title : 'Dashboard';?></title>
        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        <link rel="stylesheet" href="../assets/bootstrap/css/bootstrap.min.css">
        <link rel="stylesheet" href="../assets/plugins/fontawesome-pro-6.2.0/css/all.css">
        <!-- DataTables -->
        <link rel="stylesheet" href="../assets/plugins/datatables/dataTables.bootstrap.css">
        <!-- Select2 -->
        <link rel="stylesheet" href="../assets/plugins/select2/css/select2.min.css">
        <!-- Theme style -->
        <link rel="stylesheet" href="../assets/dist/css/AdminLTE.min.css">
        <link rel="stylesheet" href="../assets/dist/css/skins/_all-skins.min.css">
        <!-- bootstrap datepicker -->
        <link rel="stylesheet" href="../assets/plugins/datepicker/datepicker3.css">
        <link rel="icon" href="../favicon.png" sizes="16x16" type="image/png">
        <style type="text/css" media="screen">
            .table{
                width:100%!important;
            }
            .table>thead>tr>th {
                vertical-align: bottom;
                border-bottom: 1px solid #ddd;
                background: #33624e;
                color: #fff;
                font-size: 12px;
                padding-left:10px!important;
                padding-right:10px!important;
                text-align:center;
            }
            .table>tbody>tr>td {
                font-size: 13px;
            }

            .table>tfoot>tr>th {
                vertical-align: bottom;
                border-bottom: 1px solid #ddd;
                background: #33624e;
                color: #fff;
                font-size: 12px;
                padding-left:10px!important;
                padding-right:10px!important;
            }
            .table-responsive {
                border:none!important;
                padding-top:10px!important;
                padding-bottom:20px!important;
                margin-bottom:0px!important;
            }
            table.dataTable thead .sorting:after, table.dataTable thead .sorting_asc:after, table.dataTable thead .sorting_desc:after {
                font-size: 8px;
                top:12px;
                right:2px;
            }
            label.error{
                padding-top:4px;
                padding-bottom:0px;
                margin-bottom:0px;
                color:#a94442;
                font-weight:400!important;
            }
            label.control-title{
                font-weight:bold!important;
                color:#33624e;
                text-align:left;

            }
            .border-bottom-1{                
                border-bottom:1px solid;
            }
            div.dataTables_filter {
                float: right!important;
            }
            @media (max-width: 767px){
                .fixed .content-wrapper, .fixed .right-side {
                    padding-top: 50px;
                }
                .main-sidebar, .left-side {
                    padding-top: 60px;
                }
            }
            
        </style>
        
        <style>
            .title {
                white-space: nowrap;
                overflow: hidden;
                text-overflow: ellipsis;
                max-width: 100%;
                margin-bottom: 0px;
            }
            .card-product {
                padding: 8px;
                background-color: #FFFFFF;
                border-radius: 12px;
                margin-bottom: 20px;
            }
            .card-image {
                display: block;
            }
            .card-product .jenis-title{
                text-align: center;
                display: grid;
                padding-left: 10px;
                padding-right: 10px;
            }

            .card-product img {
                border-radius: 4px;
            }

            .price {
                color: #ee5b1e;
                margin-top: 0px;
                margin-bottom: 5px;
                font-size: 20px;
                font-weight: bold;
            }

            .stock {
                margin-top: 0px;
                font-size: 11px !important;
            }

            .card-title {
                font-size: 24px !important;
                margin-top: 0px;
                margin-bottom: 10px;
            }

            .card-detail {
                padding: 15px;
                background-color: #FFFFFF;
                border-radius: 12px;
                color: #094d7c;
            }

            .card-summary {
                padding: 0px 15px 15px 15px;
                background-color: #fff;
                border:2px solid #094d7c;
                margin-top: 15px;
                margin-bottom: 15px;
                border-radius: 5px;
            }

            .card-summary .subtotal {
                font-size: 14px;
                font-weight: bold;
            }

            .card-summary .total {
                margin-top: 15px;
                font-size: 20px;
                font-weight: bold;
            }

            .card-order {
                min-height: 250px;
                padding-top: 15px;
            }

            .card-customer {
                padding: 15px 15px 5px 15px;
                background-color: #FFFFFF;
                margin-top: 0px;
                margin-bottom: 15px;
                border-radius: 12px;
            }

            .header-title .select2-container--default .select2-selection--single,
            .header-title .select2-selection .select2-selection--single {
                border-radius: 12px;
                font-size: 16px;
            }

            .header-title {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                padding: 0 10px;
                gap: 15px;
                margin-bottom:10px;
            }
            .product-order {
                display: flex;
                align-items: center;
                justify-content: space-between;
                padding: 0;
                gap: 15px;
                margin-bottom:10px;
            }
            .product-order-detail {
                display: flex;
                align-items: center;
                justify-content: flex-start;
                gap: 15px
            }
            h5.jenis-title {
                padding:10px 2px;
                margin-top: 5px;
                margin-bottom: 6px;
                font-size: 13px!important;
                font-weight: 700;
            }
            .stokis-title {
                font-size: 13px!important;
                font-weight: 500;
            }
            .h2-title {
                margin-top: 0px;
                margin-bottom: 0px;
                font-size: 18px;
            }

            .btn-rounded {
                border-radius: 50px;
                font-size: 14px;
                padding: auto 10px;
            }
            .price-order{
                margin-top: 0px;
                margin-bottom: 0px;
                font-size:12px;
            }
            .my-0{
                margin-top:0;
                margin-bottom:0;
            }
            .px-4{
                padding:4px 10px
            }
            .bg-success {
                background-color: #ffffffc4;
            }
            .bg-danger {
                background-color: #fffb0094;
            }
            .header-content-right {
                display: flex;
                align-items: center;
                justify-content: flex-end;
                gap:10px;
            }
            .form-control {
                border-radius: 25px;
            }
            label {
                margin-top: 5px;
                text-align:right;
                display: block;
            }
            .py-2 {
                padding-top:8px;
                padding-bottom:8px;
            }
            .np-title{
                font-size:24px;
                font-weight: bold;
                color:red;
            }
            .d-flex{
                display: flex;
            }
            .align-self-center{
                align-items: center;
            }
            .pcard-description{
                display: flex;
                justify-content: space-evenly;
            }
            .pcard-description p{
                font-size: 11px;
                font-weight: bold;
            }
            .tag {
                display: inline-block;
                margin:0 auto;
                padding:2px 10px;
                border-radius: 15px;
                font-size: 11px;
            }
            .tag-primary{
                background-color: #ee5b1e;
                color:#FFFFFF;
            }
        </style>
        <!-- jQuery 2.2.3 -->
        <script src="../assets/plugins/jQuery/jquery-2.2.3.min.js"></script>
        <!-- page script -->
    </head>

    <body class="hold-transition fixed skin-green-light sidebar-mini">
        <div class="wrapper">

            <header class="main-header">
                <!-- Logo -->
                <a href="index.php" class="logo hidden-xs">
                    <span class="logo-mini">PS</span>
                    <span class="logo-lg"><b>Stokis</b></span>
                </a>
                <nav class="navbar navbar-static-top">
                    <?php require_once("view/partial/navbar_top.php");?>
                </nav>
            </header>
            <aside class="main-sidebar">
                <section class="sidebar">
                    <div class="user-panel">
                        <div class="pull-left image">
                            <img src="../assets/dist/img/stokis.png" class="img-circle" alt="User Image">
                        </div>
                        <div class="pull-left info">
                            <p><?=$_SESSION['session_nama_stokis'];?></p>
                            <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
                        </div>
                    </div>
                    <?php require_once("view/partial/navbar_side.php"); ?>
                </section>
            </aside>

            <div class="content-wrapper">
                <section class="content-header hidden-xs">
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
                    <b>V3</b> 2.0
                </div>
                <strong>Copyright &copy; 2023 <a href="/">ADMIN AREA</a>.</strong> All rights
                reserved.
            </footer>
            <div class="control-sidebar-bg"></div>
        </div>
        <!-- Select2 -->
        <!-- Bootstrap 3.3.6 -->
        <script src="../assets/bootstrap/js/bootstrap.min.js"></script>
        <!-- DataTables -->
        <script src="../assets/plugins/datatables/jquery.dataTables.min.js"></script>
        <script src="../assets/plugins/datatables/dataTables.bootstrap.min.js"></script>
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
        <script src="../assets/plugins/select2/js/select2.min.js"></script>

        <script>
            $(document).ready(function () {
                if($('.select2').length > 0) {
                    $(".select2").select2();
                }
                if($('#example1').length > 0) {
                    $("#example1").DataTable();
                }
                if($('.autonumeric').length > 0) {
                    anElement = new AutoNumeric('.autonumeric', 'integer');
                }
                if($('#datepicker').length > 0) {
                    $('#datepicker').datepicker({
                        autoclose: true
                    });
                }
                if($('.autonumeric2').length > 0) {
                    $('.autonumeric2').autoNumeric('init', {
                        "aSep": ",",
                        "aDec": ".",
                        "mDec": "0",
                        "maxValue": "10000000000000",
                    });
                }
            });
        </script>
    </body>
</html>