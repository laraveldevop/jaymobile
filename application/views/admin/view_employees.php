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
      <div><h1>View Employee List</h1>
      
        <div class="record_per_page">
        	<form action="<?= base_url().'employee/record_per_page?action=employee/view_all' ?>" name="page_form" id="page_form" method="post">
				<?php require_once('record_per_page.php'); ?>
			</form>
        </div>
      </div>
    
      <div class="SearchArea">
        <div class="floatleft">
         <form action="<?= base_url().'employee/view_all' ?>" name="search_form" id="search_form" method="post" onSubmit="return fill_data()">
          Search
          <input name="search_data" id="search_data" type="text" class="textfield" <?php if($search) { echo "value=\"$search\""; } else { echo 'value=""'; }?>/>
          <input name="search" type="submit" value="Submit" class="BlueBut"/>
          <a href="<?= base_url() ?>employee/view_all?action=show_all"> <button  class="RedBut" type="button">Show All</button> </a>	
         </form>
        </div>
      </div>
      	<?php $message = $this->message_stack->message('message'); ?>
		<?php if($message != "") : ?>
			<div class="SuccessMsg" style="font-size:20px; text-align:center; float:none;"><?= $message ?></div>
		<?php endif; ?>

      <form method="post" action="<?= base_url().'employee/delete_multi' ?>" onSubmit="return confirm_message()" >
      	<div align="left"><br />
     		<a href="<?= base_url().'employee/add' ?>">
				<button class="BlueBut" type="button">Add Employee</button>
	 		</a>
        	<input type="submit" name="submit_del" value="Delete" id="delete" class="RedBut"/>	
      	</div>
      	
      	<table width="100%" cellspacing="1" cellpadding="5" border="0" class="TableBg">
        	<tbody>
          		<tr class="DarkBg">
          			<td width="5%"><input type="checkbox" id="bottom" /></td>
            		<td width="20%" align="left"> <a <?php if($sort_by == 'ShopName') { echo "class=\"sort_$sort_order\""; } else { echo "class=\"sort_main\""; } ?> href="<?php if($page_no) { echo base_url().'employee/view_all?sort_by=ShopName&sort_order='.(($sort_order == 'desc') ? 'asc' : 'desc').'&page_no='.$page_no; } else { echo base_url().'employee/view_all?sort_by=ShopName&sort_order='.(($sort_order == 'desc') ? 'asc' : 'desc'); } ?>" >
            		Shop Name </a></td>
            		<td width="20%" align="left"><a <?php if($sort_by == 'FirstName') { echo "class=\"sort_$sort_order\""; }  else { echo "class=\"sort_main\""; } ?> href="<?php if($page_no) { echo base_url().'employee/view_all?sort_by=FirstName&sort_order='.(($sort_order == 'desc') ? 'asc' : 'desc').'&page_no='.$page_no; } else { echo base_url().'employee/view_all?sort_by=FirstName&sort_order='.(($sort_order == 'desc') ? 'asc' : 'desc'); } ?>" >
            		First Name</a></td>
             		<td width="20%" align="left"><a <?php if($sort_by == 'LastName') { echo "class=\"sort_$sort_order\""; }  else { echo "class=\"sort_main\""; } ?> href="<?php if($page_no) { echo base_url().'employee/view_all?sort_by=LastName&sort_order='.(($sort_order == 'desc') ? 'asc' : 'desc').'&page_no='.$page_no; } else { echo base_url().'employee/view_all?sort_by=LastName&sort_order='.(($sort_order == 'desc') ? 'asc' : 'desc'); } ?>" >
             		Last Name</a></td>
             	
            		<td width="5%" align="center"><a <?php if($sort_by == 'Status') { echo "class=\"sort_$sort_order\""; }  else { echo "class=\"sort_main\""; } ?> href="<?php if($page_no) { echo base_url().'empoyee/view_all?sort_by=Status&sort_order='.(($sort_order == 'desc') ? 'asc' : 'desc').'&page_no='.$page_no; } else { echo base_url().'employee/view_all?sort_by=Status&sort_order='.(($sort_order == 'desc') ? 'asc' : 'desc'); } ?>" >
             		Status</a></td>
            		<td width="5%" align="center">Edit</td>
            		<td width="5%" align="center">Delete </td>
          		</tr>
   
    			<?php if(!empty($employees))
    			{
          			foreach($employees as $employee_data): ?>
          		<tr class="WhiteBg">
          			<td><input type="checkbox" class="checkbox" name="user_id[]" value="<?= $employee_data['Id']?>" id="middle" /></td>
            		<td align="left"><a href="<?= base_url().'employee/view_item?UserId='.$employee_data['Id']; ?>" style="color:red;" title="View Daily Report"><?=$employee_data['ShopName']; ?> </a></td>
            		<td align="left"><?= $employee_data['FirstName']; ?></td>
             		<td align="left"><?= $employee_data['LastName']; ?></td>
             		<td align="center">
						<?php 
						if($employee_data['Status']=='0') 
						{
							echo '<a href="'.base_url().'employee/change_status?id='.$employee_data['Id'].'" Title="Active This User" > <img src="'.$this->assets->url("status_inactive.png","admin").'"/> </a>';;
						}
						else if($employee_data['Status']=='1') 
						{
							echo '<a href="'.base_url().'employee/change_status?id='.$employee_data['Id'].'" Title="InActive This User" > <img src="'.$this->assets->url("status_active.png","admin").'"/> </a>';
						}
						?>
					</td>
					
            		<td align="center"><a href="<?= base_url().'employee/add?UserId='.$employee_data['Id']; ?>"><img src="<?= $this->assets->url('edit-icon.png','admin'); ?>" alt="Edit" title="Edit" /></a></td>
            		<td align="center"><a href="<?= base_url().'employee/delete_record?UserId='.$employee_data['Id']; ?>" onClick="return confirm('Are You Sure Delete Record!');"><img src="<?= $this->assets->url('delete-icon.png','admin'); ?>" alt="Delete" title="Delete" /></a></td>
          		</tr>
          		<?php endforeach;?> 
    			<?php
				}
				else 
				{
					echo '<tr  class="WhiteBg">
							<td colspan="8" align="center">
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