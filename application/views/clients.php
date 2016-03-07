<div class="row fullwidth bar_color1 text-center">
	<div class="large-12 columns" style="padding: 20px 0px;">
		<h5>Clients</h5>		
	</div>
</div>
<div class="row jopart">
		<div class="large-12 columns">
		<?php
			if( $this->session->userdata('status') == 1 && $this->session->userdata('sess_role') == 'admin' || $this->session->userdata('sess_role') == 'employee' ){
		?>
				<?php if( $this->session->userdata('sess_dept') <= 2 ){ ?>
					<a data-reveal-id="joModal" class="right plussign">&#43;</a>
				<?php } ?>

				<div id="joModal" class="reveal-modal medium" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" style="border-radius: 13px;">
					<h2 id="modalTitle" class="text-center">Create A New Client</h2>
					<div id="alert_box_client_s" data-alert class="alert-box radius hide-normal">
					  <a href="#" class="close">&times;</a>
					</div>
					<form id="form_client" method="post">
						<div class="row">
							<div class="large-6 columns" style="border-right: 2px solid #cfd0d2;">
								<div class="large-12 columns">
									<label for="inp_companyname">Company Name
										<input type="text" id="inp_companyname" name="inp_companyname" placeholder="Company Name" />
									</label>
								</div>
								<div class="large-12 columns">
									<label for="inp_contactperson">Contact Person
										<input type="text" id="inp_contactperson" name="inp_contactperson" placeholder="Contact Person" />
									</label>
								</div>
								<div class="large-12 columns">
									<label for="inp_contactnumber">Contact Number
										<input type="text" id="inp_contactnumber" name="inp_contactnumber" placeholder="Contact Number" />
									</label>
								</div>
								<div class="large-12 columns">
									<label for="inp_birthday">Birth Date
										<input type="text" id="inp_birthday" name="inp_birthday" placeholder="Birth Date" />
									</label>
								</div>
								<div class="large-12 columns">
									<label for="inp_email">Email Address
										<input type="text" id="inp_email" name="inp_email" placeholder="Email Address" />
									</label>
								</div>
							</div>
							<div class="large-6 columns rightside">
								<div class="large-12 columns" style="height: 283px;overflow: auto;">
									<label>Brands</label>
										<label class="input_fields_wrap">
											<div><input type="text" class="cls_brand" name="ta_brand[]"></div>
										</label>
								</div>
								<div class="large-12 columns">
									<label>
										<a href="#" class="add_brand_button tiny success twidth button radius">+ Add Brands</a>
									</label>
								</div>
							</div>
						</div>
						<div class="row" style="padding-top: 20px;">
							<div class="large-6 columns large-centered">
								<a href="#" class="button warning expand radius" id="btn_save_client">Save</a>
							</div>
						</div>
					</form>
					<a class="close-reveal-modal" aria-label="Close">&#215;</a>
				</div>
				<div id="joEditModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" style="border-radius: 13px;">
					<h2 id="modalTitle" class="text-center">Edit Job Order</h2>
					
					<div class="large-12 columns" id="contentJoEdit">
						loading...
					</div>
						
					<a class="close-reveal-modal" aria-label="Close">&#215;</a>
				</div>
			<?php
				}
			?>		
		</div>
		<div class="row collapse prefix-round" style="border-bottom: 2px solid #96adb5;">
			<div class="small-1 columns text-right">
				<img src="<?=base_url('assets/img/logos/Search.png');?>" class="img-responsive show-for-medium-up" style="max-width: 58px;margin-right: 6px;" />
			</div>
			<div class="small-11 columns">
				<input type="text" class="sjo" id="inp_search_client" placeholder="Search For A Client...">
			</div>
		</div>
	</div>
<div class="row">
	<div class="large-12 columns" style="padding-top: 22px;">
		<ul class="no-bullet" id="client_table">
		<?php
                foreach( $client_list as $row) {
					$data['row'] = $row;
					$this->load->view('client_listview',$data);
                }
			?>
>>>>>>> refs/remotes/origin/Henry-Branch

		</ul>
	</div>
</div>
<div id="myModalclient_u" class="reveal-modal small" data-reveal aria-hidden="true" role="dialog">
    <h2 class="text-center">Client Form</h2>

    <div id="alert_box_client" data-alert class="alert-box radius hide-normal">
      <a href="#" class="close">&times;</a>
    </div>

    <form id="form_client_u" action="" method="post" data-abide>
      <input type="hidden" id="hid_client_id" name="hid_client_id">
      <div class="row">
        <div class="small-12 columns">
          <input type="text" id="inp_companyname_u" name="inp_companyname_u" class="req" placeholder="Company Name">
        </div>
      </div>
      <div class="row">
        <div class="small-12 columns">
          <input type="text" id="inp_contactperson_u" name="inp_contactperson_u" class="req" placeholder="Contact Person">
        </div>
      </div>
      <div class="row">
        <div class="small-12 columns">
            <textarea id="inp_contactnumber_u" name="inp_contactnumber_u" class="req" cols="15" rows="3" placeholder="Contact Number"></textarea>
        </div>
      </div>
      <div class="row">
        <div class="small-12 columns">
          <input type="text" id="inp_birthday_u" name="inp_birthday_u" class="req" placeholder="Birthdate">
        </div>
      </div>
      <div class="row">
        <div class="small-12 columns">
          <input type="text" id="inp_email_u" name="inp_email_u" class="req" placeholder="Email Address">
        </div>
      </div>
        <div class="row">
            <div class="input_fields_wrap_u">

            </div>
        </div>
      <div class="row">
        <div class="small-offset-6 small-3 columns">
          <button class="button alert" aria-label="Close">Cancel</button>
        </div>
        <div class="small-3 columns">
          <button class="button success" id="btn_update_client">Update</button>
        </div>
      </div>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
  </div>