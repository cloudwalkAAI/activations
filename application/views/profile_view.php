<?php
    $arr_profile = json_decode( $data_prof );
?>
<div class="row fullwidth bar_color1 text-center">
	<div class="large-12 columns" style="padding: 20px 0px;">
		<h5>Settings</h5>
	</div>
</div>
<div class="row fullwidth settingspage" style="padding-top: 39px;">
	<div class="large-12 columns">
		<div id="uploadModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
				<div id="alert_box_upload" data-alert class="alert-box alert radius">
                <p id="upload_desc"></p>
            </div>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
		<div id="alert_box_profile" data-alert class="alert-box warning radius hide-normal">
			Special characters are not allowed
			<a href="#" class="close">&times;</a>
		</div>	
	</div>
	<div class="large-4 columns">
		<div class="img-cropper" style="width: 200px;height: 200px;position: relative;z-index: 0;">		
			<img class="img-responsive" id="profile_img" src="<?php echo base_url( 'assets/img/profile/'.$arr_profile[0]->img_loc ); ?>" onError="this.onerror=null;this.src='<?= base_url( 'assets/img/profile/default.jpg' ) ?>';" alt="">		
			<div class="uploadArea"><button id="upload_file_button" type="button" class="small_up_btn" style="background: transparent;"><img style="width: 81px;" src="<?= base_url( 'assets/img/logos/up.png' ) ?>" /></button></div>
		</div>
		<form id="uploading_form">
            <input id="upload_file" name="upload_file" type="file" accept="image/*" style="display: none;">
        </form>
	</div>
	<form id="profile_form" action="" method="post">
	<div class="large-4 columns">
		<div class="large-12 columns">
			<label>First Name
			<input type="text" name="prof_fname" id="prof_fname" placeholder="First Name" required value="<?=isset($arr_profile[0]->first_name) ? $arr_profile[0]->first_name : '';?>" />
			</label>
		</div>
		<div class="large-12 columns">
			<label>Middle Name
			<input type="text" name="prof_mname" id="prof_mname" placeholder="Middle Name" required value="<?=isset($arr_profile[0]->middle_name) ? $arr_profile[0]->middle_name : '';?>" />
			</label>
		</div>
		<div class="large-12 columns">
			<label>Last Name
			<input type="text" name="prof_lname" id="prof_lname" placeholder="Last Name" required value="<?=isset($arr_profile[0]->sur_name) ? $arr_profile[0]->sur_name : '';?>" />
			</label>
		</div>
		<div class="large-12 columns">
			<label>Email
			<p><?= $arr_profile[0]->email ?></p>
			</label>
		</div>
	</div>
	<div class="large-4 columns">
	<?php
		$i = 0;
		$main_cnum = '';
		$cnums_list = '';
		if( isset($arr_profile[0]->contact_nos) ){
			$ctacts = explode(',',$arr_profile[0]->contact_nos);
			foreach( $ctacts as $cdetails ){
				$i++;
				if( $i == 1 ){
					$main_cnum .='<div><input type="text" name="ta_contact[]" placeholder="Main Number" value="'.$cdetails.'"></div>';
				}else{
					$cnums_list .='<div><input type="text" name="ta_contact[]" value="'.$cdetails.'"></div>';
				}
			}
		}else{
			$main_cnum .='<div><input type="text" name="ta_contact[]" placeholder="Main Number"></div>';
		}
	?>
		<div class="large-12 columns">
			<label>Contact Number
				<?php echo $main_cnum; ?>
			</label>
		</div>
		<div class="large-12 columns input_fields_wrap">
			<?php echo $cnums_list; ?>
		</div>
		<div class="large-12 columns">
			<button class="add_field_button success twidth radius">Add More Contact Details</button>
		</div>
	</div>
	<div class="large-12 columns">
		<div class="large-4 large-offset-4 columns">
			<div class="large-12 columns">
				<a id="btn_change_pass" data-reveal-id="modal_change_password" class="button success expand radius">Change Password</a>
			</div>	
		</div>
		<div class="large-4 columns">
			<div class="large-12 columns">
				<button type="submit" id="btn_profile_save" class="button warning expand radius">Save</button>
			</div>	
		</div>
	</div>
	</form>
</div>
<div id="modal_change_password" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle">Change Password</h2>
    <div id="alert_box_profile_pass" data-alert class="alert-box alert radius hide-normal">
        Special characters are not allowed
        <a href="#" class="close">&times;</a>
    </div>
    <form id="cpass_form_profile_pv" action="" method="post">
        <input type="hidden" name="user_id" value="<?=$this->session->userdata('sess_id');?>">
        <div class="row">
            <div class="large-12 columns">
                <input id="oldpass" type="password" name="oldpass" placeholder="Old Password"/>
                <small id="sml_pass" class="error" style="display:none;">Input a minimum of 7 characters.</small>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <input id="npass" type="password" name="npass" placeholder="New Password"/>
                <small id="sml_pass1" class="error" style="display:none;">Input a minimum of 7 characters.</small>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <input id="repass" type="password" name="repass" placeholder="Retype New Password"/>
                <small id="sml_pass2" class="error" style="display:none;">Input a minimum of 7 characters.</small>
            </div>
        </div>
        <div class="row">
            <div class="large-12 large-centered columns">
                <input id="btn_cpass" type="submit" class="button expand" value="Change Password"/>
            </div>
        </div>
    </form>
</div>