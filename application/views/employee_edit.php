<?php
	if(isset($eid)){
		$jsonData = json_decode($this->get_model->get_employee_full_info($eid));		
	}
?>
<div class="large-11 columns large-centered emp_edit" style="box-shadow: 0px 0px 8px 1px #d7d7d7;margin-top: 16px;border-radius: 20px;padding-top: 19px;">
	<div class="large-12 columns">
		<div id="alert_box_emp" data-alert class="alert-box success radius hide-normal">
			Special characters are not allowed
			<a href="#" class="close">&times;</a>
		</div>

		<div id="alert_box_emp_box" data-alert class="alert-box success radius hide-normal">
			Special characters are not allowed
			<a href="#" class="close">&times;</a>
		</div>

		<div id="alert_box_progress" data-alert class="alert-box success radius hide-normal">
			Please Wait...
		</div>
	</div>
	<div class="large-4 columns">
	<?php
		if(isset($eid)){
	?>
	<form id="uploading_form">
			<input type="hidden" id="uid" name="uid" value="<?php echo $jsonData->eid; ?>">
			<input id="upload_file" name="upload_file" type="file" accept="image/*" style="display: none;" >
		<div class="img-cropper" style="width: 200px;height: 200px;position: relative;z-index: 0;<?php echo isset($eid) ? '':'visibility:hidden;'; ?>">		
			<img class="img-responsive" id="profile_img" src="<?= base_url( 'assets/img/profile/'.$jsonData->img_loc ) ?>" onError="this.onerror=null;this.src='<?= base_url( 'assets/img/profile/default.jpg' ) ?>';" alt="">		
			<div class="uploadArea"><button id="upload_file_button" type="button" class="small_up_btn" style="background: transparent;"><img style="width: 81px;" src="<?= base_url( 'assets/img/logos/up.png' ) ?>" /></button></div>
		</div>	
	</form>
		
		<h5 class="enumstyle text-center">Employee NO.</h5>
		<h6 class="enumstyle sub text-center"><?php echo isset($jsonData->eid) ? $jsonData->eid:''; ?></h6>
		<?php		
			}
		?>
	</div>
	<?php
		if(isset($eid)){
	?>
			<form id="emp_form_up" action="" method="post">
			<input type="hidden" id="uid" name="uid" value="<?php echo $jsonData->eid; ?>">
	<?php		
		}else{
	?>
			<form id="emp_form" action="" method="post">
	<?php		
		}
	?>		
	<div class="large-4 columns">
		<div class="large-12 columns">
			<label>First Name
				<input type="text" name="inp_firstname" id="inp_firstname" placeholder="First Name" required value="<?php echo isset($jsonData->first_name) ? $jsonData->first_name:''; ?>" />
			</label>
		</div>
		<div class="large-12 columns">
			<label>Last Name
				<input type="text" name="inp_lastname" id="inp_lastname" placeholder="Last Name" required value="<?php echo isset($jsonData->sur_name) ? $jsonData->sur_name:''; ?>" />
			</label>
		</div>	
		<div class="large-12 columns">
			<label>Birth Date
				<input type="text" id="datepicker_emp" name="datepicker_emp" placeholder="Birth Date" required value="<?php echo isset($jsonData->birth_date) ? $jsonData->birth_date:''; ?>" />
			</label>
		</div>	
		<div class="large-12 columns">
			<label>Role				
				<select name="sel_role" id="sel_role" required>
					<?php 
						if(isset($jsonData->role_type)){
					?>
							<option value="<?php echo strtolower($jsonData->role_type); ?>"><?php echo ucfirst($jsonData->role_type); ?></option>
					<?php						
						}
					?>			
					<option value="admin">Admin</option>
					<option value="employee">Employee</option>
				</select>
			</label>
		</div>	
		<div class="large-12 columns">
			<label>Position
				<select name="sel_pos" id="sel_pos" required>
					<?php 
						if(isset($jsonData->position)){
							foreach( $pos as $posts ){
								if(strtolower($dept['position_name']) == strtolower($jsonData->position)){
					?>
							<option value="<?php echo $posts['position_id']; ?>"><?php echo ucfirst($jsonData->position); ?></option>
					<?php	
								}
							}
										
						}
						foreach( $pos as $posts ){
							echo '
								<option value="' . $posts['position_id'] . '">'. ucfirst($posts['position_name']) .'</option>
							';
						}
					?>
				</select>
			</label>
		</div>	
		<div class="large-12 columns">
			<a href="<?= base_url('emp') ?>" class="button alert expand radius">Cancel</a>
		</div>	
	</div>
	<div class="large-4 columns">
		<div class="large-12 columns">
			<label>Middle Name
				<input type="text" name="inp_midname" id="inp_midname" placeholder="Middle Name" required value="<?php echo isset($jsonData->middle_name) ? $jsonData->middle_name:''; ?>" />
			</label>
		</div>	
		<div class="large-12 columns">
			<label>Email
				<input type="email" name="inp_email" id="inp_email" placeholder="Email" <?php echo isset($eid) ? 'readonly':''; ?> value="<?php echo isset($jsonData->email) ? $jsonData->email:''; ?>" />
			</label>
		</div>	
		<div class="large-12 columns" style="visibility:hidden;">
			<label>Department
				<input type="text" name="ass" placeholder="Department"  />
			</label>
		</div>	
		<div class="large-12 columns">
			<label>Department
				<select name="sel_dept" id="sel_dept" required>
					<?php 
						if(isset($jsonData->department)){
							foreach( $departments as $dept ){
								if(strtolower($dept['department_name']) == strtolower($jsonData->department)){
					?>
							<option value="<?php echo $dept['dept_id']; ?>"><?php echo ucfirst($jsonData->department); ?></option>
					<?php	
								}
							}
										
						}
						foreach( $departments as $dept ){
							echo '
								<option value="' . $dept['dept_id'] . '">'. ucfirst($dept['department_name']) .'</option>
							';
						}
					?>
				</select>
			</label>
		</div>	
		<div class="large-12 columns">
			<label>Status
				<select name="sel_status" id="sel_status" required>
					<?php 
						if(isset($jsonData->status)){
					?>
							<option value="<?php echo strtolower($jsonData->status); ?>"><?php echo ucfirst($jsonData->status); ?></option>
					<?php						
						}
					?>
					<option value="hired">Hired</option>
					<option value="evaluation">Evaluation</option>
				</select>
			</label>			
		</div>	
		<div class="large-12 columns">
			<button type="submit" class="button warning expand radius"><?php echo isset($eid) ? 'Update':'Save'; ?> Employee</button>
		</div>	
	</div>
	</form>
	<div class="clearfix"></div>
</div>