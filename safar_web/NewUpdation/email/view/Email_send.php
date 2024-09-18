<?php //print_r($_POST['department']); die(); ?>

<script type="text/javascript">
	function checkAll(ele) {
		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
			for (var i = 0; i < checkboxes.length; i++) {
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = true;
				}
			}
		} else {
			for (var i = 0; i < checkboxes.length; i++) {
				console.log(i)
				if (checkboxes[i].type == 'checkbox') {
					checkboxes[i].checked = false;
				}
			}
		}
	}
	function check(ele) {
		var checkboxes = document.getElementsByTagName('input');
		if (ele.checked) {
			console.log(ele.checked)
				(checkboxes.type == 'checkbox')
			checkboxes.checked = true;


		} else {
			console.log(ele.checked)

				(checkboxes.type == 'checkbox')
			checkboxes.checked = false;


		}
	}
</script>
<div id="page-wrapper" style="min-height: 330px;">
<?php
	if (!empty($this->session->flashdata('email_send'))) { ?>
		<h4 align="center" style="background-color:#D3D3D3 !important; border-radius:3px; line-height:30px;">
			<span style="margin:7px; color:green;">
				<?php print_r($this->session->flashdata('email_send'));?>
			</span>
		</h4></br>
	<?php } ?>

	<?php
	if (!empty($this->session->flashdata('email_send_fail'))) { ?>
		<h4 align="center" style="background-color:#D3D3D3 !important; border-radius:3px; line-height:30px;">
			<span style="margin:7px; color:red;">
				<?php print_r($this->session->flashdata('email_send_fail')); ?>
			</span>
		</h4></br>
	<?php } ?>
	<div class="main-page">
		<form action="<?php echo base_url('Email/list_student'); ?>" method="post">
			<div class="form-grids row widget-shadow" data-example-id="basic-forms">
				<div class="form-body">
					<div class="panel panel-info">
						<div class="panel-heading">
							<h2 class="panel-title" style="color:#000000;font-size: 20px !important;">Select Department
							</h2>
						</div>
						<div class="panel-body">
							<div class="row">
								<div class="form-group col-md-5">
									<label>Department<span style="color:red;"> * </span></label><br>
									<select id="department" class="form-control dept" name="department" required>
										<option value="">Select</option>
										<?php foreach ($department as $data) { ?>
											<option value="<?php echo $data['id']; ?>"><?php echo $data['name']; ?></option>
										<?php } ?>
									</select>
								</div>
								<div class="form-group col-md-5">
									<label>Semester<span style="color:red;"> *</span></label>
									<div>
										<select class="form-control" name="semester" id="semester" required>
											<option value="">Select Semester</option>
											<option value="1">1</option>
											<option value="2">2</option>
											<option value="3">3</option>
											<option value="4">4</option>
											<option value="5">5</option>
											<option value="6">6</option>
											<option value="7">7</option>
											<option value="8">8</option>
										</select>
									</div>
								</div>
								<?php $this->load->library('session');
								$row = $this->session->userdata('user'); ?>
								<!-- <input type="hidden" name="dept" value="<? php // echo $row['department_id']?>"> -->
								<div class="form-group col-md-2" ><br>
									<input type="submit" class="btn btn-success" name="submit">
								</div>
							</div>

						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="tables">
		<?php if (empty($list_student)) {
			?>
			<div class="table-responsive bs-example widget-shadow" id="table1" style="display: none;">
			<?php } else { ?>
				<div class="table-responsive bs-example widget-shadow" id="table1">
				<?php } ?>
				<form action="<?php echo base_url('Email/email'); ?>" method="post">
					<div class="table-responsive bs-example widget-shadow" id="table1">
						<h4 style="color: #e94e02;">List of Students:</h4>
						<input type="submit" name="rs" class="btn btn-primary" value="Send Mail" <?php if($active_session!=$academic_session) ?>/><br><br>
						<table class="table table-bordered table-striped">
							<thead>
								<tr>
									<th style="text-align:center;">S.No</th>
									<th style="text-align:center;">Student Name</th>
									<th style="text-align:center;">Email Id</th>
									<th style="text-align:center;">Computer Code</th>

									<th><input type="checkbox" onChange="checkAll(this)" name="chk[]" /> Send All</th>


								</tr>
							</thead>
							<tbody>
								<?php $i = 1;
								if (!empty($list_student))
									foreach ($list_student as $data) {
										if ($data) { ?>
											<?php //print_r($data); die(); ?>
											<tr>
												<td style="text-align:center;">
													<?php echo $i; ?>
												</td>
												<td>
													<?php echo $data['student_name'];
													$name= $data['student_name'];?>
												</td>
												<td>
													<?php $rs = $data['enrollment_number'] . ".ies@ipsacademy.org"; ?>
													<?php echo $rs; ?>
												</td>
												<td>
													<?php echo $data['computer_code']; ?>
												</td>



												<td style="text-align:center;">
														<input type="checkbox" id="inlineCheckbox" onChange="check(this)"
															name="checkbox[]" value="<?php echo $rs .','.$name; ?>">
											
												</td>



											</tr>
											<?php $i++;
										}
									} ?>
							</tbody>
						</table>
					</div>
				</form>
			</div>

		</div>



	</div>
</div>
<script>

	$('#checkbox-value').text($('#checkbox').val());

	$("#checkbox").on('change', function () {
		if ($(this).is(':checked')) {
			$(this).attr('value', 'true');
		} else {
			$(this).attr('value', 'false');
		}

		$('#checkbox-value').text($('#checkbox').val());
	});

</script>