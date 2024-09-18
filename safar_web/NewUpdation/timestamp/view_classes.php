<?php //echo "Site on maintainence" ;
// echo "<pre>";
// print_r($classes);
// die();
?>
<div id="page-wrapper">
			<div class="main-page">

			
 					  
				<h3 class="title1">Attendance Panel </h3>


<div class="panel panel-default table-responsive">
					<div class="panel-heading" role="tab" id="headingOne">
					  <h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse1" aria-expanded="true" aria-controls="collapse1">
					Subjects</a>
					  </h4>
					</div>
					<div id="collapse1" class="panel-collapse collapse in " role="tabpanel" aria-labelledby="headingOne">
					  <div class="panel-body  table-responsive  ">

					  	<table class="table table-bordered  table-hover"> 
					  		<thead> 
						  		<tr>
						         	<?php $sno=1; ?>
						         	<th>S.No</th>
						         	<th>Batch</th>
						         	<th style="width: 17% ;text-align: center;">Department</th>
						         	<th style="text-align: center;">Subject</th>
						         	<th style="text-align: center;">University Subject Code</th>
						         	<th style="text-align: center;">Type</th>
						         	<th style="text-align: center;">Course</th>
						         	<th style="text-align: center;">Action</th>
	         					</tr>
         					</thead>
         					<tbody>  
         		<?php
              // $different_section;
         		 foreach ($classes as $key => $value) { 

         				// if(!array_key_exists($value['section_id'], $different_section)){

         				// 			$different_section[$value['section_id']]=$value['section_name'];

         				// }

         			?> 
         		<tr>
         			<td><?=$sno++?></td>
					 
					 <!-- added dept code to batch name  -->

         			<td style="text-align: center;"><?=$value['batch']."-".$value['dept_code']?></td>
         			<td><?=$value['name']?></td>
         			<td><?=$value['subject_name']?></td>
         			<td><?=$value['university_sub_code']?></td>
         			<td><?=$value['type']?></td>
         			<td><?=$value['course']?></td>
         			<!-- <td>
         				<a href="<?=base_url('AttendenceSCD/fillAttendence/').base64_encode($value['clg_sub_code']).'/'.base64_encode($value['batch_id']).'/'.base64_encode($value['subject_name']).'/'.base64_encode($value['batch']).'/'.base64_encode($value['academic_session_id']).'/'.base64_encode($value['semester']) ; ?>" ><div class="btn btn-sm btn-info " >Take Attendance</div></a>

         				<a href="<?=base_url('AttendenceSCD/viewAttendenceFilter/').base64_encode($value['clg_sub_code']).'/'.base64_encode($value['batch_id']).'/'.base64_encode($value['academic_session_id']).'/'.base64_encode($value['semester']) ;?>" ><div class="btn btn-sm btn-success " > View Attendance</div></a> 
         				<a href="<?=base_url()?>/AttendenceSCD/modifyAttendence/<?=$value['batch_id']?>" ><div class="btn btn-sm btn-danger" > Modify</div></a>
         				<a href="<?=base_url()?>/AttendenceSCD/lecturePlan/<?=$value['batch_id']?>"> <div class="btn btn-sm btn-info " >Lecture Plan</div></a>
         			</td> -->

         			<!-- **********************************Lock sessional************************************ -->
         			<td>
                        <?php if($value['lock_status'] ==2 || $value['academic_status']==2) { ?>

                            <a><div class="btn btn-primary" Disabled> &#128274;Take Attendance</div></a>


                        <?php } else { ?>

                            <a href="<?=base_url('AttendenceSCD/fillAttendence/').base64_encode($value['clg_sub_code']).'/'.base64_encode($value['batch_id']).'/'.base64_encode($value['subject_name']).'/'.base64_encode($value['batch']).'/'.base64_encode($value['academic_session_id']).'/'.base64_encode($value['semester']) ; ?>" ><div class="btn btn-sm btn-info " >Take Attendance</div></a>

                        <?php } ?>
         				
         				<a href="<?=base_url('AttendenceSCD/viewAttendenceFilter/').base64_encode($value['clg_sub_code']).'/'.base64_encode($value['batch_id']).'/'.base64_encode($value['academic_session_id']).'/'.base64_encode($value['semester']).'/'.base64_encode($value['type']) ;?>" ><div class="btn btn-sm btn-success " > View Attendance</div></a> 

                        <?php if($value['lock_status'] == 2 || $value['academic_status']==2){ ?>

                            <a><div class="btn btn-danger" Disabled>&#128274; Modify</div></a>

                        <?php } else { ?>

                            <a href="<?=base_url()?>/AttendenceSCD/modifyAttendence/<?=$value['batch_id']?>" ><div class="btn btn-sm btn-danger" > Modify</div></a>
                        <?php }?>
         				
						<?php if($value['lock_status'] == 2 || $value['academic_status']==2){ ?>

				<a><div class="btn btn-info" Disabled>&#128274; Lecture Plan</div></a>

	   	         <?php } else { ?>	
         				<a href="<?=base_url()?>/AttendenceSCD/lecturePlan/<?=$value['batch_id']?>"> <div class="btn btn-sm btn-info " >Lecture Plan</div></a>
						 <?php }?>
         			</td>

         			<!-- ************************************************************************************************************************** -->

         		</tr>

         		<?php }  ?>		


        </tbody> </table>
					
<?php 
	  	if($ind['co_ordinator']==1)
{ 
	//print_r($different_section);
	foreach ($different_section as $key => $value) {
		# code...
	
?>

<a href="<?=base_url()?>AttendenceSCD\takeOtherAttendence\<?=$key?>?sec=<?=$value?>" ><div  class="btn btn-primary" > Other Attandance <?=$value ?> </div></a>
<a href="<?=base_url()?>AttendenceSCD\viewOtherAttendence\<?=$key?>?sec=<?=$value?>" ><div  class="btn btn-danger" > View Attandance <?=$value ?> </div></a>
<a href="<?=base_url()?>AttendenceSCD\viewCombinedAttendence\<?=$key?>?sec=<?=$value?>" ><div  class="btn btn-success" > View Combine Attandance <?=$value ?> </div></a>
<?php 
}  

}
?>
  </div>
					</div>
				  </div>



<?php 
	  	if($ind['co_ordinator']==1)
{ 
	//print_r($different_section);
	foreach ($different_section as $key => $value) {
		# code...
	
?>
<form method="post" action="<?=base_url()?>AttendenceSCD/viewCombinedAttendenceAction" >
	<input type="hidden" name="section_id" value="<?=$key?>" >
<div class="panel panel-default table-responsive">
					<div class="panel-heading" role="tab" id="heading<?=$value?>">
					  <h4 class="panel-title">
						<a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapse<?=$value?>" aria-expanded="true" aria-controls="collapse<?=$value?>">
					Combined Attendance Reporting - <?=$value?></a>
					  </h4>
					</div>
					<div id="collapse<?=$value?>" class="panel-collapse collapse in " role="tabpanel" aria-labelledby="heading<?=$value?>">
					  <div class="panel-body  table-responsive  ">
<div class="row" > 
	<div class="col-lg-3 col-md-3 col-xs-6 col-sm-6" >
		<div class="form-group"> 
		<label> From<span style="color:red;"> * </span></label>
        <input type="date" name="to_date" value="2018-07-01" class="form-control" required="">
		</div>
	</div> 


	 <div class="col-lg-3 col-md-3 col-xs-6 col-sm-6" >
	 		<div class="form-group"> 
		<label> To<span style="color:red;"> * </span></label>
        <input type="date" name="from_date" value="<?=date("Y-m-d")?>" class="form-control" required="">
		</div>
	 </div>
 <div class="col-lg-3 col-md-3 col-xs-6 col-sm-6" >
	 		<div class="form-group"> 
		<label> Action</label>
       <select class="form-control" name="action" >
       	
            <option value="combined_attendence">Attendance Excel</option>
            <option value="combined_attendence_print">Attendance Print</option>
       <option value="office_attendence">Attendance (Office)</option>
        <!--          <option value="office_list">Att Eligbility List(Office)</option>	
	 -->

       </select>
		</div>
	 </div>
	  <div class="col-lg-2 col-md-2 col-xs-6 col-sm-6" >
	  	<label> &nbsp </label>
	 		<button  class="form-control btn btn-primary btn-sm ">Submit</button>
	 </div>

	 </div>
					  	  </div>
					</div>
				  </div>

</form>


<!-- 
<a href="<?=base_url()?>AttendenceSCD\takeOtherAttendence\<?=$key?>?sec=<?=$value?>" ><div  class="btn btn-primary" > Other Attendence <?=$value ?> </div></a> -->
<!-- <a href="<?=base_url()?>AttendenceSCD\viewCombinedAttendence\<?=$key?>?sec=<?=$value?>" ><div  class="btn btn-success" > View Combine Attendence <?=$value ?> </div></a> -->


<?php 
}  

}
?>
			

	  


	


          	</div>
</div>



