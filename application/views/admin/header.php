<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: My Photos Admin Panel ::</title>

</head>
<script language="javascript">
	shared_img_path = "<?= base_url()."application/assets/admin/images/" ?>";
</script>
<?php 
$this->load->library('session');
$this->assets->load("style.css","admin");
$this->assets->load("dropmenu.js","admin");
$this->assets->load("jquery-1.6.min.js","shared");
$this->assets->load("jquery.reveal.js","shared");
$this->assets->load("menu.css","admin");

//validation engine 

$this->assets->load("jquery.validationEngine.js","shared");
$this->assets->load("jquery.validationEngine-en.js","shared");
$this->assets->load("validationEngine.jquery.css","shared");



$this->assets->load("init.js","admin");

$this->assets->load("jquery-ui-1.8.14.custom.js","shared");
$this->assets->load("jquery-ui-timepicker-addon.js","shared");
$this->assets->load("jquery-ui-1.8.14.custom.css","shared");

$this->assets->load("jquery-ui-timepicker-addon.css","shared");

$this->assets->load("dropbox.js","admin");

// auto suggestion
$this->assets->load("bsn.AutoSuggest_2.1.3.js","shared");
$this->assets->load("autosuggest_inquisitor.css","shared");

echo $this->assets->display_header_assets();
?>

<body>
<div class="login_title" style="font-size:20px; text-align:center; float:none;"></div>

<div class="sitecontainer">
  <div class="header">
  
    <div class="logo">Admin Panel</div>
    <?php if($this->session->userdata('AdminId'))
		{
		?>		
 	<!--  -->  
    <div id="ddtopmenubar" class="mattblackmenu">
      <ul>
        <li><a href="<?= base_url() ?>employee/view_all" rel="ddsubmenu1">Users</a>
          <ul id="ddsubmenu1" class="ddsubmenustyle">
            <li><a href="<?= base_url() ?>employee/view_all"">Users</a>
            </li>
            <li><a href="<?= base_url() ?>employee/add">Add User</a>
            </li>
          </ul>
        </li>
        
      </ul>
    </div>
    <!--  -->
    <div class="Profielbar"> <a  href="<?= base_url() ?>employee/view_all" class="Dashboard">Dashboard</a> | &nbsp; 
	  <dl id="sample" class="dropdown">
        <dt><a href="#"> <img src="<?= $this->assets->url("profileimg.png","admin"); ?>"  alt="" title="" class="ProfileImg" /></a> <a href="#"><?= $this->session->userdata("UserName"); ?></a> <a href="javascript:;"><?= $this->session->userdata('user_id') ?></a></dt>
        <dd>
          <ul>
            <li><a href="<?= base_url() ?>admin/profile"> <img src="<?= $this->assets->url("profileimg.png","admin"); ?>"  alt="" title="" class="ProfileImg" /></a>
              <div class="ProfileText"><a href="<?= base_url() ?>admin/profile"><?= $this->session->userdata('admin_email_id') ?> </a><br />
                <small><?= $this->session->userdata('Email') ?></small><br />
                <a href="<?= base_url() ?>admin/profile"><strong>Profile</strong></a></div>
              <div class="clear"></div>
              <div class="SignOut"><a href="<?= base_url() ?>admin/sign_out">Sign out</a></div>
            </li>
          </ul>
        </dd>
      </dl>
    </div>
    <?php 
	 }
     ?>
  </div>