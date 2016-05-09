<?php require_once 'header.php';?>
<script type="text/javascript">

var base_path = "<?= base_url(); ?>";
var error=true;

jQuery(document).ready(function(){
	$('#add_user').validationEngine();

	$("input[type=checkbox]#change").change(function(){
		
		if($(this).is(':checked'))
		{
			$('#change_password').show();
		}
		else
		{
			$('#change_password').hide();
		}
	});
	
	$("#datepicker").datepicker({
		showOn: "button",
		buttonImage:"<?= $this->assets->url("calendar-icon.png", "shared"); ?>" ,
		buttonImageOnly: true,
		dateFormat : 'yy-mm-dd',
		changeMonth: true,
		changeYear: true,  
		//yearRange: '1960:2000'
	});
	

	$('#LastName').blur(function()
			{
				var LastName = $(this).val();
				var FirstName=  $("#FirstName").val();
				var data= {FirstName:FirstName,LastName:LastName}
				
				if(FirstName!="")
				{	 
					 $.ajax ({
						
						
						type: "POST",
						url:base_path+'employee_report/check_name',
						data: data,
						cache: false,
						success: function(data)
						{			
								
						 	if(data == "true")
							{
						 		 error=false;
								$('#LastName').validationEngine('showPrompt','Client Name Already Exits','error', "topRight", true);
							}
							else
							{
								 error=true;
								$('#LastName').validationEngine('hidePrompt');
							}
						}
					 });
				}
			});

	$('#FirstName').blur(function()
			{
			
				var FirstName = $(this).val();
				var LastName= $("#LastName").val();
				var data= {FirstName:FirstName,LastName:LastName}

				if(LastName!="")
				{
					 $.ajax ({
						type: "POST",
						url:base_path+'employee_report/check_name',
						data: data,
						cache: false,
						success: function(data)
						{				
							if(data == "true")
							{
								 error=false;
								$('#LastName').validationEngine('showPrompt','Client Name Already Exits','error', "topRight", true);
							}
							else
							{
								 error=true;
								$('#LastName').validationEngine('hidePrompt');
							}
						}
					 });
				}
			});
});	

function check_data()
{
	var empid= $("#employeeid").val();	

	if(empid!='')
	{
		$('#LastName').validationEngine('hidePrompt');
		return true;
	}
	
	if(error)
	{
		return true;
	}
	else
	{
		return false;
	}	
}
</script>
 <div class="MiddleContainer">
      <h1> <?php if(isset($user_detail[0]['Id'])) { echo "Edit Employee"; } else { echo "Add Employee";} ?></h1>
      <div class="FormArea">
      <form name ='add_user' id ='add_user' action="<?= base_url(); ?>employee/add" method = 'post' onSubmit="return check_data()" >
      
      <input type="hidden" name="Id" value="<?= $user_detail[0]['Id']; ?>" id="employeeid"> 
      
      		  <label>Shop Name :</label>
              <input name="ShopName" type="text" class="textfield validate[required]"  id="ShopName" value="<?= $user_detail[0]['ShopName'] ?>" />
              <br />
          
              <label>First Name :</label>
              <input name="FirstName" type="text" class="textfield validate[required]"  id="FirstName" value="<?= $user_detail[0]['FirstName'] ?>" />
              <br />
            
              <label>Last Name :</label>
              <input name="LastName" type="text" class="textfield validate[required]" id="LastName" value="<?= $user_detail[0]['LastName'] ?>"/>
              <br />
              
              <label>Email Id :</label>
              <input name="UserName" type="text" class="textfield validate[required,custom[email]]" id="UserName" value="<?= $user_detail[0]['UserName'] ?>"/>
              <br />
               <label>Birth Date :</label>
              <input name="BirthDate" type="text" class="textfield validate[required]" readonly="readonly" id="datepicker" value="<?= $user_detail[0]['BirthDate'] ?>"/>
              <br />
            
               <label>Phone No:</label>
              <input name="PhoneNo" type="text" class="textfield validate[required,custom[onlyNumberSp]]" id="PhoneNo" value="<?= $user_detail[0]['PhoneNo'] ?>"/>
              <br />
              
               <label>Address :</label>
            		<textarea name="Address" rows="5" cols="31"  id="address" class="validate[required]"><?= $user_detail[0]['Address'] ?></textarea>
              <br />
               <br />
                  
              <label>Gender :</label>
              <div class="Radio" style="padding-top:8px;">
              <input type='radio' name='Gender' id='Gender' class='validate[required]' value='1' 
              <?php if($user_detail[0]['Gender'] == "1") { echo "checked=\"checked\""; }  ?> />Male
              <input type='radio' name='Gender' id='Gender' class='validate[required]' value='0'
              <?php if($user_detail[0]['Gender'] == "0") { echo "checked=\"checked\""; }  ?> />Female
              </div>
              <br>
              <?php if(!$this->input->get('UserId')){ ?>
              <label>Password  :</label>
	          <input name="Password1" type="password" class="textfield  validate[required]" id="Password1" />
	          <br />
	          
	          <label>Confirm Password :</label>
              <input name="ConfirmPassword" type="password"" class="textfield validate[equals[Password1]]" id="ConfirmPassword"/>
              <br />
              <?php }?>
              
              <?php if($this->input->get('UserId')){ ?>
              <label>Change Password? :</label>
              <div style="padding-top:8px;">
              <input type="checkbox" id="change">
              </div>
              <br />
               <?php }?>
              <div id="change_password" style="display:none">
               <label>New Password  :</label>
	          <input name="Password" type="password"" class="textfield  validate[required]" id="Password" />
	          <br />
	          
	          <label>Confirm Password :</label>
              <input name="ConfirmPassword" type="password"" class="textfield validate[equals[Password]]" id="ConfirmPassword"/>
              <br />
              </div>
                       
              <label>Status :</label>
              <div class="Radio" style="padding-top:8px;">
				<input type='radio' name='Status' id='status' class='validate[required]' value='1' 
				<?php if($user_detail[0]['Status'] == "1") { echo "checked=\"checked\""; }  ?> />Active
				<input type='radio' name='Status' id='status' class='validate[required]' value='0'
				<?php if($user_detail[0]['Status'] == "0") { echo "checked=\"checked\""; }  ?> />Inactive
			  </div>
			  <br>
              <label></label>
              <input type='submit'  id='save' class='BlueBut' <?php  if(isset($user_detail[0]['Id'])) {echo "value='Update' name='Update'";} else {echo "value='Save' name='Save' ";}?>  />
              <input type="button" name="Cancel" value="Cancel" class='RedBut'  onclick="javascript:history.go(-1)" >  
         </form>     
    </div>
</div>
<?php require_once 'footer.php';?>