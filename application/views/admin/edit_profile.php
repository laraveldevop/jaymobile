<?php require_once('header.php'); ?>
<script>
	$(document).ready(function(){
		$('#profile').validationEngine();
	});
</script>

    <div class="MiddleContainer">
      <h1>Edit Profile
      </h1>
        <div class="FormArea">
        <form name = 'profile' id = 'profile'  action='<?=base_url() ?>admin/profile' method = 'post'>
        
          <h2>Personal Information</h2>
          	<?php $message = $this->message_stack->message('message'); ?>
        	<?php if($message != "") : ?>
			<div class="SuccessMsg" style="font-size:20px; text-align:center; float:none;"><?= $message ?></div>
			<?php endif; ?>
          <label>User Name:</label>
          <input name="UserName" type="text" class="textfield validate[required]" id="UserName" value="<?= $profile[0]['UserName']; ?>"/>
          <br />
          
          <label>Email Id:</label>
          <input name="Email" type="text" class="textfield validate[required,custom[email]]"  id="Email" value="<?= $profile[0]['Email'];?>"/>
          <br />
          
          <label>Change Password:</label>
          <input name="Password" type="Password" class="textfield" id="Password"/>
          <br />
          
          <label> Confirm Password:</label>
          <input name="ConfirmPassword" type="password" class="textfield validate[equals[Password]]" id="ConfirmPassword"/>
          <br />
          
          <div class="FormButtons">
          	<input name="Update" type="submit"" value="Update" class="BlueBut" />
          	<input name="cancel" type="button" value="cancel" class="RedBut" onclick="javascript:history.go(-1)" />
          	
          </div>
        </form>
        </div>
       
      </div>
    </div>
<?php require_once('footer.php'); ?>