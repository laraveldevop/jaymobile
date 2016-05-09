<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>DollarTune - Admin Panel</title>
    <meta name="keywords" content="Dollar Tune Admin Panel"/>
    <meta name="description" content="Dollar Tune - Admin Panel">
    <meta name="author" content="DollarTune">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="<?php echo Session::token(); ?>">
    <meta name="csrf-token" content="<?php echo Session::token(); ?>" />

    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:400,600,700'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:300,400,500,700">

    <!-- Theme CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo URL::asset('public/assets/admin/skin/default_skin/css/theme.css'); ?>">

    <!-- Admin Panels CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo URL::asset('public/assets/admin/admin-tools/admin-plugins/admin-panels/adminpanels.css'); ?>">

    <!-- Admin Forms CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo URL::asset('public/assets/admin/admin-tools/admin-forms/css/admin-forms.css'); ?>">

    <!-- Favicon -->
    <link rel="shortcut icon" href="<?php echo URL::asset('public/assets/images/favicon.ico'); ?>">

    <!-- Custom CSS -->
    <link rel="stylesheet" type="text/css" href="<?php echo URL::asset('public/assets/admin/css/custom-style.css'); ?>">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->

    <!-- jQuery -->
    <script type="text/javascript" src="<?php echo URL::asset('public/assets/admin/js/jquery-1.4.2.js'); ?>"></script>
    <script type="text/javascript">
        var $noConf = jQuery.noConflict();
    </script>
    <script type="text/javascript" src="<?php echo URL::asset('public/assets/admin/js/jquery-1.11.1.min.js'); ?>"></script>
    <script type="text/javascript" rc="<?php echo URL::asset('public/assets/admin/js/jquery_ui/jquery-ui.min.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo URL::asset('public/assets/admin/js/custom/common.js'); ?>"></script>

    <!-- parsley -->
    <script src="<?php echo URL::asset('public/assets/admin/js/parsley/parsley.min.js'); ?>"></script>
    <script src="<?php echo URL::asset('public/assets/admin/js/parsley/parsley.extend.js'); ?>"></script>

    <!-- Progress bar-->
    <link rel="stylesheet" type="text/css" href="<?php echo URL::asset('public/assets/admin/js/progress/minified/progressjs.min.css'); ?>">
    <script type="text/javascript" src="<?php echo URL::asset('public/assets/admin/js/progress/minified/progress.min.js'); ?>"></script>

    <!-- Bootstrap -->
    <script type="text/javascript" src="<?php echo URL::asset('public/assets/admin/js/bootstrap/bootstrap.min.js'); ?>"></script>
</head>

<style>
    .dataTables_empty{
        text-align: center;
    }
</style>
<body class="sb-l-o sb-r-c">
<div class="overlay hide">
    <div class="overlay-loader"><img src="<?php echo URL::asset('public/assets/admin/images/loaders/p8.gif'); ?>" /></div>
</div>
<div class="se-pre-con"></div>
<!-- Start: Main -->
<div id="main">
<!-- Start: Header -->
<header class="navbar navbar-fixed-top bg-light">
    <div class="navbar-branding">
        <a class="navbar-brand" href="<?php echo URL::to('admin/dashboard'); ?>"> <b>DollarTune </b>Admin
        </a>
        <span id="toggle_sidemenu_l" class="glyphicons glyphicons-show_lines"></span>
        <ul class="nav navbar-nav pull-right hidden">
            <li>
                <a href="javascript:;" class="sidebar-menu-toggle">
                    <span class="octicon octicon-ruby fs20 mr10 pull-right "></span>
                </a>
            </li>
        </ul>
    </div>
    <ul class="nav navbar-nav navbar-right">
        <li class="dropdown">
            <a href="#" class="dropdown-toggle fw600 p15" data-toggle="dropdown"> <img
                    src="<?php echo URL::asset('public/assets/admin/images/avatars/5.jpg'); ?>" alt="avatar"
                    class="mw30 br64 mr15">
                <span><?php echo Session::get('Name'); ?></span>
                
            </a>
            <ul class="dropdown-menu dropdown-persist pn w250 bg-white" role="menu">
                <li class="br-t of-h">
                    <a href="<?php echo URL::to('admin/login/logout'); ?>"
                       class="fw600 p12 animated animated-short fadeInDown">
                        <span class="fa fa-power-off pr5"></span> Logout </a>
                </li>
            </ul>
        </li>
    </ul>
</header>
<!-- End: Header -->
<!-- Start: Sidebar -->
<aside id="sidebar_left" class="nano nano-primary">
    <div class="nano-content">
        <!-- sidebar menu -->
        <ul class="nav sidebar-menu">
            <li class="sidebar-label pt15">Admin Tools</li>
            <li page="advertiser">
                <a href="<?php echo URL::to('admin/advertiser/view'); ?>">
                    <span class="glyphicons glyphicons-snowflake"></span>
                    <span class="sidebar-title">Advertisers</span>
                </a>
            </li>
            <li page="work-order">
                <a href="<?php echo URL::to('admin/work_order/view'); ?>">
                    <span class="glyphicons glyphicons-notes_2"></span>
                    <span class="sidebar-title">Work Order</span>
                </a>
            </li>
            <li page="item">
                <a href="<?php echo URL::to('admin/item/view'); ?>">
                    <span class="glyphicons glyphicons-file"></span>
                    <span class="sidebar-title">Items</span>
                    
                </a>
            </li>
            <li page="campaign">
                <a href="<?php echo URL::to('admin/campaign/view'); ?>">
                    <span class="glyphicons glyphicons-charts"></span>
                    <span class="sidebar-title">Campaigns</span>
                </a>
            </li>
            <li page="service-provider">
                <a href="<?php echo URL::to('admin/service_provider/view'); ?>">
                    <span class="glyphicons glyphicons-wifi_alt"></span>
                    <span class="sidebar-title">Service Providers</span>
                </a>
            </li>
            <li page="user">
                <a href="<?php echo URL::to('admin/user/view'); ?>">
                    <span class="glyphicons glyphicons-parents"></span>
                    <span class="sidebar-title">Users</span>
                </a>
            </li>
            <li page="reports">
                <a href="<?php echo URL::to('admin/report/caller-tune'); ?>">
                    <span class="glyphicons glyphicons-charts"></span>
                    <span class="sidebar-title">Reports</span>
                </a>
            </li>
        </ul>
        <div class="sidebar-toggle-mini">
            <a href="javascript:;">
                <span class="fa fa-sign-out"></span>
            </a>
        </div>
    </div>
</aside>
<!-- Start: Content -->
<section id="content_wrapper">