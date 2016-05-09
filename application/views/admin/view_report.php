<?php require_once 'header.php';?>
 <div class="MiddleContainer">
      <h1> View Report</h1>
      <br/>
       <a href="<?= base_url().'daily_report/export_data?ReportId='.$_GET['ReportId']; ?>">
			<button class="BlueBut" type="button">Export to Excel</button>
		</a>
		 <a href="<?= base_url().'daily_report/pdf_data?ReportId='.$_GET['ReportId']; ?>">
			<button class="BlueBut" type="button">Export to PDF</button>
		</a>
		
      <div class="FormArea"> 
     
		
      <input type="hidden" name="Id" value="<?= $report_detail[0]['Id']; ?>"> 
              
              <label>Employee Name:</label>
              <label class="DetailsLabel"><?= $employee_detail[0]['FirstName'] ?> <?= $employee_detail[0]['LastName'] ?></label>
              <br /><br />	
              		
              <label>Company Name:</label>
              <label class="DetailsLabel"><?= $client_detail[0]['CompanyName'] ?></label>
              <br /><br />			
			
              <label>Current Requirement:</label>
              <label class="DetailsLabel"><?= $report_detail[0]['CurrentRequirement'] ?></label>
              <br /><br />
              
              <label>Next COA:</label>
              <label class="DetailsLabel"><?= $report_detail[0]['NextCOA'] ?></label>
              <br /><br>
             
              <label>Remark:</label>
              <label class="DetailsLabel"><?= $report_detail[0]['Remark'] ?></label>              
              <br /><br />
              
              <label>Landline Number:</label>
              <label class="DetailsLabel"><?= $report_detail[0]['LandlineNumber'] ?></label>
              <br/><br />
              
              <label>Visit Date :</label>
              <label class="DetailsLabel"><?= $report_detail[0]['VisitDate'] ?></label>
              <br /><br>
                           
              <label>Follow Up :</label>              
              	<label class="DetailsLabel"><?php if($report_detail[0]['NewFlp'] == "NEW") echo "NEW" ;?>
              	<?php if($report_detail[0]['NewFlp'] == "FLP") echo "FLP" ;?></label>
			  <br>
		    
    </div>
</div>      
<?php require_once 'footer.php';?>