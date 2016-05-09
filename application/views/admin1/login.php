<!DOCTYPE html>
<html>

<head>
    <!-- Meta, title, CSS, favicons, etc. -->
    <meta charset="utf-8">
    <title>Jay Mobile - Admin Panel</title>
    <meta name="keywords" content="Jay Mobile Admin Panel" />
    <meta name="description" content="Jay Mobile - Admin Panel">
    <meta name="author" content="JayMobile">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Font CSS (Via CDN) -->
    <link rel='stylesheet' type='text/css' href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800'>
    <link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Roboto:400,500,700,300">
    <?php
        $this->load->library('session');
        //<!-- Theme CSS -->
        $this->assets->load("skin/default_skin/css/theme.css","admin1");
        //<!-- Admin Forms CSS -->
        $this->assets->load("admin-tools/admin-forms/css/admin-forms.css","admin1");
        $this->assets->load("jquery-1.11.1.min.js","admin1");

        echo $this->assets->display_header_assets();
    ?>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
</head>
<script language="javascript">
	shared_img_path = "<?= base_url()."application/assets/admin/images/" ?>";
</script>
<?php $background_img = $this->assets->url("patterns/backgrounds/1.jpg","admin1"); ?>
<body class="external-page sb-l-c sb-r-c" style="background: url('<?php echo $background_img; ?>');">
<!-- Start: Settings Scripts -->
<script>
    var boxtest = localStorage.getItem('boxed');
    if (boxtest === 'true') {
        document.body.className += ' boxed-layout';
    }
</script>
<!-- End: Settings Scripts -->
<!-- Start: Main -->
<div id="main" class="animated fadeIn">

    <!-- Start: Content -->
    <section id="content_wrapper">

        <!-- begin canvas animation bg -->
        <div id="canvas-wrapper">
            <canvas id="demo-canvas"></canvas>
        </div>

        <!-- Begin: Content -->
        <section id="content">
            <div class="admin-form theme-info" id="login1">
                <div class="row mb15 table-layout">
                    <div class="va-m pln">
                        <a href="javascript:;" title="Return to Dashboard">
                            <img src="<?php echo $this->assets->url("logos/logo_white.png","admin1"); ?>" title="AdminDesigns Logo" class="img-responsive w250">
                        </a>
                    </div>
                </div>
                <div class="panel panel-info mt10 br-n">
                    <form method="post" action="<?php echo base_url(); ?>admin/login" id="contact">
                        <div class="panel-body bg-light p30">
                            <div class="row">
                                <div class="col-sm-12 pr30">
                                    <!-- error message div -->
                                    <div class="login_title" style="font-size:20px; text-align:center; float:none;"><?= $this->message_stack->message('message'); ?> </div>
                                    <!-- end error message div -->
                                    <div class="section">
                                        <label class="field-label text-muted fs18 mb10">Email</label>
                                        <label class="field prepend-icon">
                                            <input type="text" name="EmailId" id="email" class="gui-input" placeholder="Enter email">
                                            <label for="email" class="field-icon"><i class="fa fa-user"></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- end section -->
                                    <div class="section">
                                        <label class="field-label text-muted fs18 mb10">Password</label>
                                        <label class="field prepend-icon">
                                            <input type="password" name="Password" id="password" class="gui-input" placeholder="Enter password">
                                            <label for="password" class="field-icon"><i class="fa fa-lock"></i>
                                            </label>
                                        </label>
                                    </div>
                                    <!-- end section -->
                                    <button type="submit" class="button btn-primary mr10 pull-right">Sign In</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </section>
        <!-- End: Content -->
    </section>
    <!-- End: Content-Wrapper -->
</div>
<!-- End: Main -->

<!-- BEGIN: PAGE SCRIPTS -->
<?php
    //<!-- jQuery -->
    $this->assets->load("jquery_ui/jquery-ui.min.js","admin1");
    //<!-- Bootstrap -->
    $this->assets->load("bootstrap/bootstrap.min.js","admin1");
    //<!-- Page Plugins -->
    $this->assets->load("pages/login/EasePack.min.js","admin1");
    $this->assets->load("pages/login/rAF.js","admin1");
    $this->assets->load("pages/login/TweenLite.min.js","admin1");
    $this->assets->load("pages/login/login.js","admin1");
    //<!-- Theme Javascript -->
    $this->assets->load("utility/utility.js","admin1");
    $this->assets->load("main.js","admin1");
    $this->assets->load("demo.js","admin1");

    echo $this->assets->display_header_assets();
?>
<!-- Page Javascript -->
<script type="text/javascript">
    jQuery(document).ready(function() {

        "use strict";

        // Init Theme Core
        Core.init();

        // Init Demo JS
        Demo.init();

        // Init CanvasBG and pass target starting location
        CanvasBG.init({
            Loc: {
                x: window.innerWidth / 2,
                y: window.innerHeight / 3.3
            }
        });


    });
</script>

<!-- END: PAGE SCRIPTS -->

</body>

</html>
