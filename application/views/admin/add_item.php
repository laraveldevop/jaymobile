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
      <h1> <?php if(isset($user_detail[0]['Id'])) { echo "Edit Employee Item"; } else { echo "Add Employee Item";} ?></h1>
      <div class="FormArea">
      <form name ='add_user' id ='add_user' action="<?= base_url(); ?>employee/add_item?UserId=<?= $this->session->userdata('UserId'); ?>" method = 'post' onSubmit="return check_data()" >
      
      <input type="hidden" name="Id" value="<?= $user_detail[0]['Id']; ?>" id="employeeid"> 
      
      		  <label>Item Name :</label>
              <input name="ItemName" type="text" class="textfield validate[required]"  id="ItemName" value="<?= $user_detail[0]['ItemName'] ?>" />
              <br />
			  
			  <label>Imei No :</label>
              <input name="Imei" type="text" class="textfield validate[required]"  id="Imei" value="<?= $user_detail[0]['Imei'] ?>" />
              <br />
          
              <label>Problem :</label>
              <input name="Problem" type="text" class="textfield validate[required]"  id="Problem" value="<?= $user_detail[0]['Problem'] ?>" />
              <br />
            
              <label>Discription :</label>
              	<textarea name="Discription" rows="5" cols="31"  id="Discription" class="validate[required]"><?= $user_detail[0]['Discription'] ?></textarea>
              <br />
              
              <label>Status :</label>
              <div class="Radio" style="padding-top:8px;">
				<input type='radio' name='Status' id='status' class='validate[required]' value='1' 
				<?php if($user_detail[0]['Status'] == "1") { echo "checked=\"checked\""; }  ?> />Complete
				<input type='radio' name='Status' id='status' class='validate[required]' value='0'
				<?php if($user_detail[0]['Status'] == "0") { echo "checked=\"checked\""; }  ?> />Incomplete
			  </div>
			  <br />
              <label></label>
              <input type='submit'  id='save' class='BlueBut' <?php  if(isset($user_detail[0]['Id'])) {echo "value='Update' name='Update'";} else {echo "value='Save' name='Save' ";}?>  />
              <input type="button" name="Cancel" value="Cancel" class='RedBut'  onclick="javascript:history.go(-1)" >  
         </form>     
    </div>
</div>
<?php require_once 'footer.php';?>