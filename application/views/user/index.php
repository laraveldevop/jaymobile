<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
		<title>My Gallery</title>
        <!--[if IE 6]>
            <script src="js/ie6-transparency.js"></script>
            <script>
                DD_belatedPNG.fix('#header .logo img, .subtitle img, .slideshow-container, .navigation-container #thumbs .thumbs li .thumb img, .navigation a.next, .footer-line, #sidebar .author-photo, .line, .commentlist .comment-reply-link, #contact-page #contact .submit');
            </script>
            <link rel="stylesheet" type="text/css" href="styles/ie6.css" />
        <![endif]-->
        <!--[if IE 7]>
            <link rel="stylesheet" type="text/css" href="styles/ie7.css" />
        <![endif]-->
        <!--[if IE 8]>
            <link rel="stylesheet" type="text/css" href="styles/ie8.css" />
        <![endif]-->
</head>
<?php
$this->load->library('session');

$this->assets->load("style.css");
$this->assets->load("styles/galleriffic.css");
$this->assets->load("jquery-1.3.2.js");
$this->assets->load("jquery.opacityrollover.js");
$this->assets->load("jquery.galleriffic.js");
$this->assets->load("gallery-settings.js");

echo $this->assets->display_header_assets();
?>
<style type="text/css">
    .slideshow img { height: 45%;}
</style>
    <body>
    	<div id="wrap">
        	<div id="header">
            	<div class="logo">
                    <a href=""><img src="<?= $this->assets->url("name.png"); ?>" alt="logo" /></a>
                </div><!--end logo-->
                <div class="subtitle">
                	<img src="<?= $this->assets->url("subtitle.png"); ?>" alt="description" />
                </div><!--end subtitle-->
                <div id="nav">
                	<ul id="nav-pages">
						<li><a href="javascript:;" class="current">Home</a><span>~</span></li>
						<li><a href="javascript:;">Short Bio</a><span>~</span></li>
						<li><a href="javascript:;">Services</a><span>~</span></li>
						<li><a href="javascript:;">Articles</a><span>~</span></li>
						<li><a href="javascript:;">Contact Me</a></li>
            		</ul><!--end nav-pages-->
                </div> <!--end nav-->
            </div><!--end header-->
            <?php $mp3_path = base_url().'application/mp3/'; ?>
    		<object data="music.wav" type="audio/x-mplayer2" width="320" height="240">
				<param name="src" value="<?= $mp3_path; ?>SHIV-TANDAV-STOTRAM.mp3">
				<param name="autoplay" value="false">
				<param name="autoStart" value="0">
				Hear the sound : <a href="<?= $mp3_path; ?>SHIV-TANDAV-STOTRAM.mp3" target="_blank">music one </a>
			</object>
			<object data="music.wav" type="audio/x-mplayer2" width="320" height="240">
				<param name="src" value="<?= $mp3_path; ?>SHIVMAHIMNAMH.mp3">
				<param name="autoplay" value="false">
				<param name="autoStart" value="0">
				| <a href="<?= $mp3_path; ?>SHIVMAHIMNAMH.mp3" target="_blank">music two </a>
			</object>

			<object data="music.wav" type="audio/x-mplayer2" width="320" height="240">
				<param name="src" value="<?= $mp3_path; ?>Didi.mp4">
				<param name="autoplay" value="false">
				<param name="autoStart" value="0">
				| <a href="<?= $mp3_path; ?>Didi.mp4" target="_blank">Video One </a>
			</object>
	        <div id="frontpage-content">
    			<div id="container">

					<div class="gallery-content">
						<div class="slideshow-container">
							<div id="slideshow" class="slideshow"></div>
						</div><!--end slideshow-container-->
					</div><!--end gallery-content-->
				</div><!--end container-->
				<div class="navigation-container">
					<div id="thumbs" class="navigation">
						<a class="pageLink prev" style="visibility: hidden;" href="javascript:;" title="Previous Page"></a>
						<ul class="thumbs noscript">
		                    <li>
								<a class="thumb" href="<?= $this->assets->url("photos/1.jpg"); ?>">
									<img src="<?= $this->assets->url("photos/1.jpg"); ?>" width="130" height="75" />
								</a>
							</li>
							<li>
								<a class="thumb" href="<?= $this->assets->url("photos/2.jpg"); ?>">
									<img src="<?= $this->assets->url("photos/2.jpg"); ?>" width="130" height="75" />
								</a>
							</li>
							<li>
								<a class="thumb" href="<?= $this->assets->url("photos/3.jpg"); ?>">
									<img src="<?= $this->assets->url("photos/3.jpg"); ?>" width="130" height="75" />
								</a>
							</li>
							<li>
								<a class="thumb" href="<?= $this->assets->url("photos/1.jpg"); ?>">
									<img src="<?= $this->assets->url("photos/1.jpg"); ?>" width="130" height="75" />
								</a>
							</li>
							<li>
								<a class="thumb" href="<?= $this->assets->url("photos/2.jpg"); ?>">
									<img src="<?= $this->assets->url("photos/2.jpg"); ?>" width="130" height="75" />
								</a>
							</li>
							<li>
								<a class="thumb" href="<?= $this->assets->url("photos/3.jpg"); ?>">
									<img src="<?= $this->assets->url("photos/3.jpg"); ?>" width="130" height="75" />
								</a>
							</li>
							<li>
								<a class="thumb" href="<?= $this->assets->url("photos/1.jpg"); ?>">
									<img src="<?= $this->assets->url("photos/1.jpg"); ?>" width="130" height="75" />
								</a>
							</li>

		                </ul>
						<a class="pageLink next" style="visibility: hidden;" href="javascript:;" title="Next Page"></a>
					</div><!--end thumbs-->
		    	</div><!--end navigation-containter-->
    		</div><!--end frontpage-content-->
    		<div id="footer">
    			<div class="footer-line"></div>
					<p class="copyright">Copyright &copy; <?= date('Y'); ?> &middot; Piyush Viradiya &middot; All Rights Reserved</p>
			</div><!--end footer-->
		</div> <!--end wrap-->
	</body>
</html>