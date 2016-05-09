<?php
require("header.php");
?>
<script type="text/javascript">
	jQuery(document).ready(function(){  
		$("#fotgotForm").validationEngine();                
	});	
</script>

  <div>
    <div class="Loginpart">
	<form name="" id="fotgotForm" method="post"> 
      <div class="Whitebg">
        <div class="LoginTitle"><img src="<?= $this->assets->url("login-icon.png","admin"); ?>" alt="Loign" title="Loign" class="Icon" /><strong>Forgot Password</strong> <div class="floatright"><a href="<?= base_url() ?>admin" class="Red-link">Sign In</a></div> </div>
			
			<div class="login_title" style="font-size:20px; text-align:center; float:none;"><?= $this->message_stack->message('message'); ?> </div>
        <div>
          <label>Email Address :</label>
          <input name="Email" type="text"  class="textfield validate[required,custom[email]]"  id="Email" />
          <br />
          <div class="Right">
         <!--   <input name="Login" type="button" value="Retrive Password" class="GreenBut" />-->
			<input type="submit" name="retrive_password" value="Retrive Password" class="GreenBut"  />
			<br />
<br />
<br />
</div>
        </div>
      </div>
	</form>
    </div>
  </div>
  <?php
require("footer.php");
?> 