<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>:: prime CRM ::</title>

</head>
<script language="javascript">
	shared_img_path = "<?= base_url()."application/assets/shared/images/" ?>";
</script>
<?php 
$this->load->library('session');



$this->assets->load("style.css","shared");
//$this->assets->load("dropmenu.js","admin");
$this->assets->load("jquery-1.6.min.js","shared");
$this->assets->load("jquery.reveal.js","shared");
$this->assets->load("menu.css","shared");



//validation engine 

$this->assets->load("jquery.validationEngine.js","shared");
$this->assets->load("jquery.validationEngine-en.js","shared");
$this->assets->load("validationEngine.jquery.css","shared");



$this->assets->load("init.js","admin");

$this->assets->load("jquery-ui-1.8.14.custom.js","shared");
$this->assets->load("jquery-ui-timepicker-addon.js","shared");
$this->assets->load("jquery-ui-1.8.14.custom.css","shared");


//$this->assets->load("autosuggest_inquisitor.css","shared");
//$this->assets->load("autoSuggest.js","shared");

$this->assets->load("bsn.AutoSuggest_2.1.3.js","shared");
$this->assets->load("autosuggest_inquisitor.css","shared");



$this->assets->load("jquery-ui-timepicker-addon.css","shared");

$this->assets->load("dropbox.js","admin");


echo $this->assets->display_header_assets();
?>

<body>
<div class="login_title" style="font-size:20px; text-align:center; float:none;"></div>

<div class="sitecontainer">
  <div class="header">
  
    <div class="logo">Prime CRM </div>
    <?php if($this->session->userdata('Id'))
		{
		?>
		
 <div class="Profielbar"> <a  href="<?= base_url() ?>employee_report/view_all" class="Dashboard">Dashboard</a> | &nbsp;
 
	  <dl id="sample" class="dropdown">
        <dt><a href="#"> <img src="<?= $this->assets->url("profileimg.png","shared"); ?>"  alt="" title="" class="ProfileImg" /></a> <a href="#"><?= $this->session->userdata("UserName"); ?></a> <a href="javascript:;"><?= $this->session->userdata('user_id') ?></a></dt>
        <dd>
          <ul>
            <li><a href="<?= base_url() ?>admin/profile"> <img src="<?= $this->assets->url("profileimg.png","shared"); ?>"  alt="" title="" class="ProfileImg" /></a>
              <div class="ProfileText"><a href="<?= base_url() ?>admin/profile"><?= $this->session->userdata('admin_email_id') ?> </a><br />
                <small><?= $this->session->userdata('Email') ?></small><br />
                <a href="<?= base_url() ?>user/profile"><strong>Profile</strong></a></div>
              <div class="clear"></div>
              <div class="SignOut"><a href="<?= base_url() ?>user/sign_out">Sign out</a></div>
            </li>
          </ul>
        </dd>
      </dl>
    </div>  
      	<!--   <div id="ddtopmenubar" class="mattblackmenu">
      <ul>
        <li><a href="<?= base_url() ?>employee/view_all" rel="ddsubmenu1">Employees</a>
          <ul id="ddsubmenu1" class="ddsubmenustyle">
            <li><a href="<?= base_url() ?>employee/view_all"">Employees</a>
            </li>
            <li><a href="<?= base_url() ?>employee/add">Add Employee</a>
            </li>
          </ul>
        </li>
        
      </ul>
    </div>
     -->  
    <?php 
	 }
     ?>
      
  </div>
  