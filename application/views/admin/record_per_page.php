<font size="3">Records Per Page</font>
<select name="page" id="select_page" class="DropList">
	<option value="500" <?php if($this->session->userdata("records_per_page")== '500') {echo  "selected='selected'"; }?> > 500</option>
	<option value="1000" <?php if($this->session->userdata("records_per_page")== '1000') {echo  "selected='selected'"; }?> >1000</option>
	<option value="2000" <?php if($this->session->userdata("records_per_page")== '2000') {echo  "selected='selected'"; } ?> >2000</option>
	<option value="5000" <?php if($this->session->userdata("records_per_page")== '5000') {echo  "selected='selected'"; } ?> >5000</option>
</select>
