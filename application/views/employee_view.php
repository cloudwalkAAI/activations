<div class="row fullwidth bar_color1 text-center">
	<div class="large-12 columns" style="padding: 20px 0px;">
		<h5>Employees</h5>		
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

				<div id="joModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog" style="border-radius: 13px;">
					<h2 id="modalTitle" class="text-center">Create New Job Order</h2>
					<div id="alert_box" data-alert class="alert-box alert radius hide-normal">
						Special characters are not allowed
						<a href="#" class="close">&times;</a>
					</div>
					<form id="form_jo" action="" method="post">
						<div class="large-11 columns large-centered">
							<label> Project type</label>
                            <table id="pt_list" class="pt_list twidth">
                                <?= $project_type ?>
                            </table>

                            <div class="column large-8 medium-8 small-8" style="position: relative;z-index: 999;">
                                <input type="text" class="twidth" id="other_pt" placeholder="Input other project type">
                            </div>
                            <div class="column large-4 medium-4 small-4" style="position: relative;z-index: 999;">
                                <a href="#" id="btn_add_pt" class="button tiny twidth"><i class="fi-plus small"></i> Add</a>
                            </div>
						</div>	
						<div class="large-11 columns large-centered">
							<span>Client
								<select name="inp_client" id="inp_client">
									<option value="0">Select...</option>
									<?php
										foreach($client_list as $row){
											echo '
												<option value="'.$row['client_id'].'">'.$row['company_name'].'</option>
											';
										}
									?>
								</select>
							</span>
						</div>	
						<div class="large-11 columns large-centered">
							<label for="inp_brand" id="hd" class="hide">Brand
								<select name="inp_brand" id="inp_brand">
									<option value="0">Select...</option>
								</select>
							</label>
						</div>
						<div class="large-11 columns large-centered">
							<label for="inp_projname">Project Name
								<input type="text" id="inp_projname" name="inp_projname" placeholder="Project Name" />
							</label>
						</div>
						<div class="large-11 columns large-centered">
							<button id="btn_save_jo" type="submit" class="button medium expand">Create Job Order</button>
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
</div>
<div class="row">
	<div class="large-12 columns" style="padding-top: 22px;">
		<ul class="no-bullet" id="tbdy_emp">
		<?php
            $dept_str = '';
            $post_str = '';
        if( isset($emp_list) ){
            foreach( $emp_list as $row ){
				$data['row'] = $row;	
                $birthDate = explode("/", $row['birth_date']);

                $data['age'] = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                    ? ((date("Y") - $birthDate[2]) - 1)
                    : (date("Y") - $birthDate[2]));

                $query_dept = $this->db->get_where( 'departments', array( 'dept_id' => $row['department'] ) );
                $row_dept = $query_dept->row();
                if (isset($row_dept))
                {
                    $data['dept_str'] = $row_dept->department_name;
                }

                $query_post = $this->db->get_where( 'positions', array( 'position_id' => $row['position'] ) );
                $row_post = $query_post->row();
                if (isset($row_post))
                {
                    $data['post_str'] = $row_post->position_name;
					
                }
				$this->load->view("employee_list",$data);
				
            }
        }
        ?>
		</ul>
	</div>
</div>