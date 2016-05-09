<?php require("header.php"); ?>
<script type="text/javascript">


	$(document).ready(function(){  
		
		$("#signinForm").validationEngine();                
	});	
</script>

  <div>
    <div class="Loginpart">
	<form action="<?= base_url() ?>user/login" method="post" name="signinForm" id="signinForm">
      <div class="Whitebg">
        <div class="LoginTitle"><img src=" <?= $this->assets->url("login-icon.png","shared")?>" alt="Loign" title="Loign" class="Icon" /><strong>Welcome to CRM</strong></div>
	
			<div class="login_title" style="font-size:20px; text-align:center; float:none;"><?= $this->message_stack->message('message'); ?> </div>
        <div>
          <label>Email Address :</label>
          <input name="EmailId" type="text" class="textfield validate[required,custom[email]]"  id="EmailId" />
          <br />
          <label>Password :</label>
          <input name="Password" type="Password"  class="textfield validate[required]"  id="password"/>
          <br />
          <!--  <div class="Right">
            <input name="" type="checkbox" value="" />
            Remember me</div>
            -->
          <div class="Right LoginBut">
          <!--  <input name="Login" type="button" value="Login" class="GreenBut" />-->
			<input type="submit" name="login" value="Login" class="GreenBut" />
            <a href=" <?= base_url()?>user/forgot_password" class="Red-link" >Forgot Password?</a></div>
        </div>
		
		
      </div>
	 </form>
    </div>
  </div>
<?php
require("footer.php");
?> 