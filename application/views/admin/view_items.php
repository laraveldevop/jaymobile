<?php require_once 'header.php';?>

<script type="text/javascript">
jQuery(document).ready(function(){
	$('#select_page').change(function(){
		$('#page_form').submit();
	});
});


function fill_data()
{
	var search_data=document.getElementById('search_data').value;

	if(search_data=='')
	{
		alert('Enter Search Name');
		return false;
	}
	else
	{
		return true;
	}	
}

function confirm_message()
{
	var $b = $('input[type=checkbox]#middle');
	var $total=$b.length;
	var $len = $b.filter(':checked').length;
	if(!($len > 0))
	{
		alert("Please Select Record for Delete!");
		return false;
	}
	if(confirm('Are You Sure Delete This Records!'))
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
      <div><h1>View Employee Items List</h1>
      
        <div class="record_per_page">
        	<form action="<?= base_url().'employee/record_per_page?action=employee/view_item?UserId='.$this->session->userdata('UserId'); ?>" name="page_form" id="page_form" method="post">
				<?php require_once('record_per_page.php'); ?>
			</form>
        </div>
      </div>
    
      <div class="SearchArea">
        <div class="floatleft">
         <form action="<?= base_url().'employee/view_item?UserId='.$this->session->userdata('UserId'); ?>" name="search_form" id="search_form" method="post" onSubmit="return fill_data()">
          Search
          <input name="search_data" id="search_data" type="text" class="textfield" <?php if($search) { echo "value=\"$search\""; } else { echo 'value=""'; }?>/>
          <input name="search" type="submit" value="Submit" class="BlueBut"/>
          <a href="<?= base_url() ?>employee/view_item?UserId=<?= $this->session->userdata('UserId'); ?>&action=show_all"> <button  class="RedBut" type="button">Show All</button> </a>	
         </form>
        </div>
      </div>
      	<?php $message = $this->message_stack->message('message'); ?>
		<?php if($message != "") : ?>
			<div class="SuccessMsg" style="font-size:20px; text-align:center; float:none;"><?= $message ?></div>
		<?php endif; ?>

      <form method="post" action="<?= base_url().'employee/delete_multi_item?UserId='.$this->session->userdata('UserId'); ?>" onSubmit="return confirm_message()" >
      	<div align="left"><br />
     		<a href="<?= base_url().'employee/add_item?UserId='.$this->session->userdata('UserId'); ?>">
				<button class="BlueBut" type="button">Add Item</button>
	 		</a>
        	<input type="submit" name="submit_del" value="Delete" id="delete" class="RedBut"/>	
      	</div>
      	
      	<table width="100%" cellspacing="1" cellpadding="5" border="0" class="TableBg">
        	<tbody>
          		<tr class="DarkBg">
          			<td width="5%"><input type="checkbox" id="bottom" /></td>
            		<td width="20%" align="left"> Item Name</td>
					<td width="20%" align="left"> Imei No</td>
					<td width="20%" align="left"> In Date</td>
            		<td width="20%" align="left">Problem</td>
             		<td width="20%" align="left">Discription</td>
            		<td width="5%" align="center">Status</td>
            		<td width="5%" align="center">Edit</td>
            		<td width="5%" align="center">Delete </td>
          		</tr>
   
    			<?php if(!empty($employees))
    			{
          			foreach($employees as $employee_data): ?>
          		<tr class="WhiteBg">
          			<td><input type="checkbox" class="checkbox" name="user_id[]" value="<?= $employee_data['Id']?>" id="middle" /></td>
            		<td align="left"><a href="<?= base_url().'employee/add_item?Id='.$employee_data['Id']; ?>" style="color:red;" title="View Daily Report"><?=$employee_data['ItemName']; ?> </a></td>
            		<td align="left"><?= $employee_data['Imei']; ?></td>
					<td align="left"><?= date("d/m/Y H:i:s",strtotime($employee_data['CreatedAt'])); ?></td>
					<td align="left"><?= $employee_data['Problem']; ?></td>
             		<td align="left"><?= $employee_data['Discription']; ?></td>
             		<td align="center">
						<?php 
						if($employee_data['Status']=='0') 
						{
							echo '<a href="'.base_url().'employee/change_status_item?UserId='.$this->session->userdata('UserId').'&id='.$employee_data['Id'].'" Title="Complete This Item" > <img src="'.$this->assets->url("status_inactive.png","admin").'"/> </a>';;
						}
						else if($employee_data['Status']=='1') 
						{
							echo '<a href="'.base_url().'employee/change_status_item?UserId='.$this->session->userdata('UserId').'&id='.$employee_data['Id'].'" Title="Incomplete This Item" > <img src="'.$this->assets->url("status_active.png","admin").'"/> </a>';
						}
						?>
					</td>
					
            		<td align="center"><a href="<?= base_url().'employee/add_item?UserId='.$this->session->userdata('UserId').'&Id='.$employee_data['Id']; ?>"><img src="<?= $this->assets->url('edit-icon.png','admin'); ?>" alt="Edit" title="Edit" /></a></td>
            		<td align="center"><a href="<?= base_url().'employee/delete_record_item?UserId='.$this->session->userdata('UserId').'&Id='.$employee_data['Id']; ?>" onClick="return confirm('Are You Sure Delete Record!');"><img src="<?= $this->assets->url('delete-icon.png','admin'); ?>" alt="Delete" title="Delete" /></a></td>
          		</tr>
          		<?php endforeach;?> 
    			<?php
				}
				else 
				{
					echo '<tr  class="WhiteBg">
							<td colspan="9" align="center">
							No Record Found 
						</tr>';
				} 
				?>
        	</tbody>
      	</table>
      </form>
	<?php echo  $this->pagination->create_links(); ?>
	<br/>
    </div>
<?php require_once 'footer.php';?>