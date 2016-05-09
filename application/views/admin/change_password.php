
<?php require("header_admin.php"); ?>
<script type="text/javascript" >

jQuery(document).ready(function(){
	jQuery("#change_password").validationEngine()
});
</script>
  <div class="container">
    <div class="LeftContainer">
      <h1>Products</h1>
      <ul>
        <li><a href="#">Add Product</a></li>
        <li><a href="#" class="Selected">Search Product</a></li>
        <li><a href="#">Brand</a></li>
        <li><a href="#">Size</a></li>
        <li><a href="#">Color</a></li>
      </ul>
    </div>
    <div class="MiddleContainer">
	<div class="login_title" style="font-size:20px; text-align:center; float:none;">	<?= $this->session->flashdata('item'); ?> </div>
	<form action="<?=base_url(); ?>admin/change_password" method="post" id="change_password" >
      <h1>Change Password</h1>
      <div class="FormArea"><label>Old Password:</label><input name="old_password" type="password" class="textfield validate[required]" id="old_password" /><br />

     <label>New Password:</label><input name="password" id="password" type="password" class="textfield validate[required]"/><br />

      <label>Confirm Password:</label>
	  <input name="confirm_password" type="password" class="textfield validate[equals,password]"  id="confirm_password"/>
      <div class="FormButtons">
      	<input name="Update" type="submit" value="Update" class="BlueBut" /> 
	
		<input name="cancel" type="reset" value="cancel" class="RedBut" onclick="javascript:history.go(-1)" />
	
      </div>
	  
	  </div>
	</form>
</div>
            
    </div>
  </div>
  <div class="footer"> Managed with <a href="#">Yudiz</a>.</div>
</div>
</body>
</html>
