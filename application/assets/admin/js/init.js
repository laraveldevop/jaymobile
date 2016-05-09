
$(document).ready(function() {
		
	$("input[type=checkbox]#middle").change(function(){
		var $b = $('input[type=checkbox]#middle');
		var $total=$b.length;
		var $len = $b.filter(':checked').length;
		
                if($len==1 || $len>1)
				{
					//$("input[type=submit]").removeAttr('disabled');
					//$("input[type=submit]#delete").css("color","#000000");
				}
				else
				{
					//$("input[type=submit]").attr('disabled','disabled');
					//$("input[type=submit]#delete").css("color","#797979");
				}
				if($len<1)
				{
					$("input[type=checkbox]#bottom").attr('checked',false)
				}
				if($len == $total)
				{
					$("input[type=checkbox]#bottom").attr('checked',true)		
				}
				else
				{		
					$("input[type=checkbox]#bottom").attr('checked',false)		
				}
				
		 });
	
		$("input[type=checkbox]#bottom").click(function(){
			var $b = $('input[type=checkbox]#middle');
			var $total=$b.length;
			
			if($total==1 || $total> 1 )
			{
				//$("input[type=submit]").removeAttr('disabled');
				//$("input[type=submit]#delete").css("color","#000000")
			}
			
		if($(this).is(':checked'))
		{
			$("input[type=checkbox]#middle").attr('checked',true)
		}
		
		if($(this).is(':not(:checked)'))
		{
			$("input[type=submit]").attr('disabled','disabled');
			$("input[type=checkbox]#middle").attr('checked',false)
			//$("input[type=submit]#delete").css("color","#797979")
		}
		});
});