<?php
// echo"<pre>";print_r($batch_names);die(); 
?>
<script type="text/javascript">
	function ajaxfunction(parent) {

		var res = parent.split("->");

		//    console.log(parent);
		if (res[0] != "") {

			$.ajax({
				url: "<?php echo base_url('New_Events/get_subject_type?id='); ?>" + res[0] + "&endsem=" + res[3] + "&sessional=" + res[4],
				success: function (data) {
					$("#event").html(data);
				}

			});

		}
	}

	function sessional_sheet(parent) {

		var res = parent.split("->");
		var endsem_lock = res[4];
		var sessional_status = res[6];
		var endsem_status = res[5];
		console.log(endsem_lock, sessional_status, endsem_status)
		if (res[3] == "T") {
			if (sessional_status == 1 && endsem_status == 1) {
				if (endsem_lock == 2) {
					$("#tools").html("<option value='all-events'>All events</option><option value='rgpv-backup'>SESSIONAL SHEET THEORY</option><option value='rgpv-backup-endsem-theory'>ENDSEM SHEET THEORY</option>");
				} else {
					$("#tools").html("<option value='all-events'>All events</option><option value='rgpv-backup'>SESSIONAL SHEET THEORY</option>");
				}

			} else if (sessional_status == 1) {
				$("#tools").html("<option value='all-events'>All events</option><option value='rgpv-backup'>SESSIONAL SHEET THEORY</option>");
			} else if (endsem_status == 1) {
				if (endsem_lock == 2) {
					$("#tools").html("<option value='all-events'>All events</option><option value='rgpv-backup-endsem-theory'>ENDSEM SHEET THEORY</option>");
				}
			}

		} else if (res[3] == "P") {
			if (sessional_status == 1 && endsem_status == 1) {
				if (endsem_lock == 2) {
					$("#tools").html("<option value='all-events'>All events</option><option value='rgpv-backup-practical'>SESSIONAL SHEET PRACTICAL</option><option value='rgpv-backup-endsem-practical'>ENDSEM SHEET PRACTICAL</option><option value='record'>SESSIONAL PRACTICAL BLANK</option>");
				} else {
					$("#tools").html("<option value='all-events'>All events</option><option value='rgpv-backup-practical'>SESSIONAL SHEET PRACTICAL</option><option value='record'>SESSIONAL PRACTICAL BLANK</option>");
				}
			} else if (sessional_status == 1) {
				$("#tools").html("<option value='all-events'>All events</option><option value='rgpv-backup-practical'>SESSIONAL SHEET PRACTICAL</option><option value='record'>SESSIONAL PRACTICAL BLANK</option>");
			} else if (endsem_status == 1) {
				if (endsem_lock == 2) {
					$("#tools").html("<option value='all-events'>All events</option><option value='rgpv-backup-endsem-practical'>ENDSEM SHEET PRACTICAL</option><option value='record'>SESSIONAL PRACTICAL BLANK</option>");
				}

			}
		} else {
			$("#tools").html("<option value='all-events'>All events</option>");
		}
	}


</script>

<script type="text/javascript">
	function subject_type(parent) {
		console.log(parent);
		if (parent != "") {

			$.ajax({
				url: "<?php echo base_url('New_Events/get_subject_type?id='); ?>" + parent,
				success: function (data) {
					$("#event").html(data);
				}

			});

		}
	}


</script>



<div id="page-wrapper">

	<?php
	if (!empty($this->session->flashdata('success_mst'))) { ?>
		<div class="alert  alert-success">
			<h4>
				<b><?php print_r($this->session->flashdata('success_mst')); ?></b>
			</h4>
		</div>
	<?php } ?>
	<?php
	if (!empty($this->session->flashdata('grade_range_success'))) { ?>
		<div class="alert  alert-success">
			<h4>
				<b><?php print_r($this->session->flashdata('grade_range_success')); ?></b>
			</h4>
		</div>
	<?php } ?>
	<?php
	if (!empty($this->session->flashdata('grade_range_failure'))) { ?>
		<div class="alert  alert-danger">
			<h4>
				<b><?php print_r($this->session->flashdata('grade_range_failure')); ?></b>
			</h4>
		</div>
	<?php } ?>
	<?php
	if (!empty($this->session->flashdata('error_ha_marks'))) { ?>
		<div class="alert  alert-danger">
			<h4>
				<b><?php print_r($this->session->flashdata('error_ha_marks')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('error_mst_marks'))) { ?>
		<div class="alert  alert-danger">
			<h4>
				<b><?php print_r($this->session->flashdata('error_mst_marks')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('event_pic_deleted'))) { ?>
		<div class="alert  alert-success">
			<h4>
				<b><?php print_r($this->session->flashdata('event_pic_deleted')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('event_quest_updated'))) { ?>
		<div class="alert  alert-success">
			<h4>
				<b><?php print_r($this->session->flashdata('event_quest_updated')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('event_quest_uploaded'))) { ?>
		<div class="alert  alert-success">
			<h4>
				<b><?php print_r($this->session->flashdata('event_quest_uploaded')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('error_mst'))) { ?>
		<div class="alert  alert-danger">
			<h4>
				<b><?php print_r($this->session->flashdata('error_mst')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('event_quest_not_updated'))) { ?>
		<div class="alert  alert-danger">
			<h4>
				<b><?php print_r($this->session->flashdata('event_quest_not_updated')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('event_pic_not_deleted'))) { ?>
		<div class="alert  alert-danger">
			<h4>
				<b><?php print_r($this->session->flashdata('event_pic_not_deleted')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('event_quest_not_uploaded'))) { ?>
		<div class="alert  alert-danger">
			<h4>
				<b><?php print_r($this->session->flashdata('event_quest_not_uploaded')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('no_question_mst'))) { ?>
		<div class="alert  alert-danger">
			<h4>
				<b><?php print_r($this->session->flashdata('no_question_mst')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('success'))) { ?>
		<div class="alert  alert-success">
			<h4>
				<b><?php print_r($this->session->flashdata('success')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('faculty_lock'))) { ?>
		<div class="alert  alert-success">
			<h4>
				<b><?php print_r($this->session->flashdata('faculty_lock')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('fail'))) { ?>
		<div class="alert  alert-danger">
			<h4>
				<b><?php print_r($this->session->flashdata('fail')); ?></b>
			</h4>
		</div>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('event_deleted'))) { ?>
		<div class="alert  alert-danger">
			<h4>
				<b><?php print_r($this->session->flashdata('event_deleted')); ?></b>
			</h4>
		</div>
	<?php } ?>
	<?php
	if (!empty($this->session->flashdata('subject_added'))) { ?>
		<h4 align="center" style="background-color:#D3D3D3 !important; border-radius:3px; line-height:30px;">
			<span style="margin:7px; color:green;"><?php print_r($this->session->flashdata('subject_added')); ?></span>
		</h4></br>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('error'))) { ?>
		<h4 align="center" style="background-color:#D3D3D3 !important; border-radius:3px; line-height:30px;">
			<span style="margin:7px; color:red;"><?php print_r($this->session->flashdata('error')); ?></span>
		</h4></br>
	<?php } ?>

	<div class="row">
		<h3 class="title1">Event Creation</h3>
		<div class="form-three widget-shadow">
			<form class="form-horizontal" action="<?php echo base_url('New_Events/event_handler'); ?>" method="post">
				<div class="form-group">
					<label for="selector1" class="col-sm-2 control-label">Batch Name<span style="color:red;">
							*</span></label>
					<div class="col-sm-8">



						<select name="section_name" class="form-control1" onchange="ajaxfunction(this.value)" required>
							<option value="">Select Batch</option>

							<?php
							if (!empty($batch_names))
								foreach ($batch_names as $s) { ?>
									<option
										value="<?php
										echo $s['batch_id'] . '->' . $s['clg_sub_code'] . '->' . $s['batch'] . "->" . $s['department']['endsem'] . "->" . $s['department']['sessional']; ?>"><?php echo $s['dept_code']; ?>-<?php
											echo $s['semester']; ?> - <?php echo $s['batch']; ?>-<?php echo $s['subject_name']; ?>
										[<?php echo $s['type']; ?>]</option>
								<?php } ?>

						</select>

					</div>
				</div>




				<div class="form-group">
					<label for="selector1" class="col-sm-2 control-label">Event<span style="color:red;">
							*</span></label>
					<div class="col-sm-8">



						<select name="event" id="event" class="form-control1" required>
							<option value="">Select Event</option>





						</select>


					</div>
				</div>




				<div class="col-sm-offset-2">
					<input type="submit" name="button" value="Submit" class="btn btn-primary" />
				</div>
			</form>
		</div>
		</br>
		</br>


		<h3 class="title1">Events</h3>
		<div class="form-three widget-shadow">
			<form class="form-horizontal" action="<?php echo base_url('New_Events/event_actions'); ?>" method="post">
				<div class="form-group">
					<label for="selector1" class="col-sm-2 control-label">Semester ID - Subject<span style="color:red;">
							*</span></label>
					<div class="col-sm-8">

						<input type="hidden" name="type" value="<?php echo $type; ?>">

						<select name="section_name" class="form-control1" onchange="sessional_sheet(this.value)"
							required>
							<option value="">Select Section</option>

							<?php if (!empty($batch_names))
								foreach ($batch_names as $s) { ?>
									<option
										value="<?php echo $s['batch_id'] . '->' . $s['clg_sub_code']  . '->' . $s['batch'] . '->' . $s['type'] . '->' . $s['endsem_lock'] . "->" . $s['department']['endsem'] . "->" . $s['department']['sessional'] . '->' . $s['subject_name']; ?>">
										<?php echo $s['dept_code']; ?> - <?php echo $s['semester']; ?> -
										<?php echo $s['batch']; ?> - <?php echo $s['subject_name']; ?> [<?php echo $s['type']; ?>]
										(<?php echo $s['batch_id']; ?>)</option>
								<?php } ?>

						</select>

					</div>
				</div>

				<div class="form-group">
					<label for="selector1" class="col-sm-2 control-label">Tools<span style="color:red;">
							*</span></label>
					<div class="col-sm-8">



						<select name="tools" id="tools" class="form-control1" required>
							<option value="all-events">All events</option>
							<!-- <option value="rgpv-backup">SESSIONAL SHEET THEORY</option>
											<option value="rgpv-backup-practical">SESSIONAL SHEET PRACTICAL</option>
											<option value="rgpv-backup-endsem-theory">ENDSEM SHEET THEORY</option>
											<option value="rgpv-backup-endsem-practical">ENDSEM SHEET PRACTICAL</option> -->


							<!-- <option value="rgpv-sessional">RGPV Sessional Sheet</option>
											<option value="rgpv-main">RGPV Main Sheet</option> -->





						</select>

					</div>
				</div>



				<div class="form-group">
					<label for="selector1" class="col-sm-2 control-label">Event<span style="color:red;">
							*</span></label>
					<div class="col-sm-8">



						<select name="event" id="event" class="form-control1" required>
							<option value="view">View</option>
							<!-- <option value="excel">Download Excel</option>
											<option value="configure">Configure</option> -->



						</select>


					</div>
				</div>




				<div class="col-sm-offset-2">
					<input type="submit" name="button" value="Submit" class="btn btn-primary" />
				</div>
			</form>
		</div>


		<!-- New -->
		</br></br>
		<?php if ($type == "class_coordinator") { ?>
			<h3 class="title1">Combined Sheets</h3>
			<div class="form-three widget-shadow">
				<form class="form-horizontal" action="<?php echo base_url('New_Events/event_combined'); ?>" method="post">
					<div class="form-group">
						<label for="selector1" class="col-sm-2 control-label">Semester ID - Subject<span style="color:red;">
								*</span></label>
						<div class="col-sm-8">

							<input type="hidden" name="type" value="<?php echo $type; ?>">

							<select name="section_name" class="form-control1" required>
								<option value="">Select Section</option>

								<?php if (!empty($subjects))
									foreach ($subjects as $s) { ?>
										<option value="<?php echo $s->section_id ?>">

											<?php echo $s->section_name; ?>
										</option>
									<?php } ?>

							</select>

						</div>
					</div>

					<div class="form-group">
						<label for="selector1" class="col-sm-2 control-label">Tools<span style="color:red;">
								*</span></label>
						<div class="col-sm-8">



							<select name="tools" id="tools" class="form-control1" required>

								<option value="combined-mst">Combined MST Sheet</option>
								<option value="combined-home-assignment">Combined Home Assignment Sheet</option>
								<option value="combined-practical-assignment">Combined Practical Sheet</option>
								<option value="combined-internal-sheet">Combined Internal Sheet</option>


							</select>

						</div>
					</div>



					<div class="form-group">
						<label for="selector1" class="col-sm-2 control-label">Event<span style="color:red;">
								*</span></label>
						<div class="col-sm-8">



							<select name="event" id="event" class="form-control1" required>
								<option value="view">View</option>
								<!--	<option value="excel">Download Excel</option>
											<option value="configure">Configure</option>-->



							</select>


						</div>
					</div>




					<div class="col-sm-offset-2">
						<input type="submit" name="button" value="Submit" class="btn btn-primary" />
					</div>
				</form>
			</div><?php } ?>
	</div>



</div>