<?php
$info = json_decode($jo_details);
?>
<div class="row fullwidth jo-in" style="height:100%;">
    <div class="large-3 columns jo-sidebar text-center">
        <div class="img-cropper">
            <img class="img-responsive" src="<?= base_url( 'assets/img/profile/'.$info->emp_info[0]->img_loc ) ?>" onError="this.onerror=null;this.src='<?= base_url( 'assets/img/profile/default.jpg' ) ?>';" alt="">
        </div>
        <?php
        echo '<h3>'.$info->emp_info[0]->sur_name.', '.$info->emp_info[0]->first_name.' '.$info->emp_info[0]->middle_name.'</h3>';
        ?>
        <!--<h6>Position</h6>-->
        <div class="large-12 columns details">
            <h4>JOB ORDER DETAILS</h4>
            <hr/>
            <div class="large-10 columns large-centered text-left">
                <h5>Date Created</h5>
                <h6><?= $info->date_created ?></h6>
                <h5>Job Order No</h5>
                <a href="#" data-dropdown="drop_color" aria-controls="drop_color" aria-expanded="false"><h6 id="joid_color" style="color:<?=$info->jo_color?>;"><?= $info->jo_number ?></h6></a>
                <ul id="drop_color" class="f-dropdown" data-dropdown-content aria-hidden="true" tabindex="-1">
                    <li><a href="#" class="jo_change_color" alt="red" value="<?= $info->jo_number ?>">Red</a></li>
                    <li><a href="#" class="jo_change_color" alt="blue" value="<?= $info->jo_number ?>">Blue</a></li>
                </ul>
                <h5>Contract No.</h5>
                <h6><?= $info->contract_no ?></h6>
                <h5>Project Name</h5>
                <h6><?= $info->project_name ?></h6>
                <h5>Project Type</h5>
                <h6><?= $info->project_type ?></h6>
                <h5>Client</h5>
                <h6><?= $info->client_company_name ?></h6>
                <h5>Brand</h5>
                <h6><?= $info->brand ?></h6>
                <h5>DO No.</h5>
                <h6>
                    <?php
                    if( $info->do_contract_no == '' ){
                        echo 'pending';
                    }else{
                        echo $info->do_contract_no;
                    }
                    ?>
                </h6>
                <h5>Invoice</h5>
                <h6>
                    <?php
                    if( $info->billed_date == '' ){
                        echo 'pending';
                    }else{
                        echo $info->billed_date;
                    }
                    ?>
                </h6>
                <h5>Paid Date</h5>
                <h6>
                    <?php
                    if( $info->paid_date == '' ){
                        echo 'pending';
                    }else{
                        echo $info->paid_date;
                    }
                    ?>
                </h6>
                <?php
                if( $this->session->userdata('sess_id') == $info->emp_id ){
                    ?>
                    <hr>
                    <div id="alert_box_share" data-alert class="alert-box warning radius hide-normal">
                        Shared.
                        <a href="#" class="close">&times;</a>
                    </div>
                    <form id="share_jo_ae" action="" method="post">
                        <input type="hidden" name="share_joid" id="share_joid" value="<?= $info->jo_number ?>">
                        <input type="text" name="inp_ae_id" id="inp_ae_id" placeholder="Tag AE">
                        <input type="text" id="temp_name" disabled>
                        <button id="btn_share_jo" class="button radius twidth">Share It</button>
                    </form>
                    <hr>
                    <?php
                }
                ?>
				<div class="row">
					<table id="tbl_mom" class="hide large-12 columns">
						<tr>
							<th>Minutes of the Meeting</th>
						</tr>
						<tr>
							<td>Date of revision</td>
						</tr>
						<?php
							$get_date_mom = json_decode( $mom_dates );
							if( isset( $get_date_mom ) ){
								foreach( $get_date_mom as $id => $ddates ){
									echo '
										<tr>
											<td><a class="loadmombydate" href="#" alt="' . $id . '">' . $ddates . '</a></td>
										</tr>
									';
								}
							}
						?>
					</table>

					<table id="tbl_event_details" class="hide large-12 columns">
						<tr>
							<th>Event Details</th>
						</tr>
						<tr>
							<td>Dates of Revision</td>
						</tr>
						<?php
						$get_date_ed = json_decode( $detail_dates );
						if( isset( $get_date_ed ) ){
							foreach( $get_date_ed as $ided => $ddatesed ){
								echo '
										<tr>
											<td><a class="loadedbydate" href="#" alt="' . $ided . '">' . $ddatesed . '</a></td>
										</tr>
									';
							}
						}
						?>
					</table>

					<table id="tbl_setup" class="hide large-12 columns">
						<tr>
							<th>Setup Details</th>
						</tr>
						<tr>
							<td>Dates of Revision</td>
						</tr>
						<?php
						$get_date_setup = json_decode( $setup_dates );
						if( isset( $get_date_setup ) ){
							foreach( $get_date_setup as $id => $ddates ){
								echo '
										<tr>
											<td><a class="loadsetupbydate" href="#" alt="' . $id . '">' . $ddates . '</a></td>
										</tr>
									';
							}
						}
						?>
					</table>

					<table id="tbl_mvrf" class="hide large-12 columns">
						<tr>
							<th>MVRF</th>
						</tr>
						<tr>
							<td>Dates of Revision</td>
						</tr>
						<?php
						$get_date_mvrf = json_decode( $mvrf_dates );
						if( isset( $get_date_mvrf ) ){
							foreach( $get_date_mvrf as $id => $ddates ){
								echo '
										<tr>
											<td><a class="loadmvrfbydate" href="#" alt="' . $id . '">' . $ddates . '</a></td>
										</tr>
									';
							}
						}
						?>
					</table>

					<table id="tbl_other" class="hide large-12 columns">
						<tr>
							<th>Other</th>
						</tr>
						<tr>
							<td>Dates of Revision</td>
						</tr>
						<?php
						$get_date_other = json_decode( $other_dates );
						if( isset( $get_date_other ) ){
							foreach( $get_date_other as $id => $ddates ){
								echo '
										<tr>
											<td><a class="loadotherbydate" href="#" alt="' . $id . '">' . $ddates . '</a></td>
										</tr>
									';
							}
						}
						?>
					</table>

				</div>
            </div>
        </div>
    </div>
    <div class="large-9 columns jo-maincontent">
        <div class="row">
            <a href="#" style="margin-top: 9px;" id="pdf_selector" data-reveal-id="modal_pdf_selector" class="button tiny right">Print</a>
        </div>
        <div id="modal_pdf_selector" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
            <h2 id="modalTitle">Select Document to Archive</h2>
            <form id="form_archive" action="" method="post">
                <input type="hidden" id="jid" name="jid" value="<?=$this->input->get('a');?>">
                <input type="hidden" id="jno" name="jno" value="<?= $info->jo_number ?>">
                <label for="pdf_ex_jo" style="display: none;"><input type="checkbox" name="pdf_ex[]" id="pdf_ex_jo" value="jo_details"> Job Order</label>
                <label for="pdf_ex_mom"><input type="checkbox" name="pdf_ex[]" id="pdf_ex_mom" value="mom"> Minutes of the Meeting</label>
                <label for="pdf_ex_ed"><input type="checkbox" name="pdf_ex[]" id="pdf_ex_ed" value="ed"> Event Details</label>
                <label for="pdf_ex_proj_att"><input type="checkbox" name="pdf_ex[]" id="pdf_ex_proj_att" value="pjat"> Project Attachments</label>
                <label for="pdf_ex_setup"><input type="checkbox" name="pdf_ex[]" id="pdf_ex_setup" value="setup"> Setup Details</label>
                <label for="pdf_ex_mvrf"><input type="checkbox" name="pdf_ex[]" id="pdf_ex_mvrf" value="mvrf"> Manpower and vehicle request form</label>
                <label for="pdf_ex_oth"><input type="checkbox" name="pdf_ex[]" id="pdf_ex_oth" value="other"> Others</label>
                <input type="button" class="button tiny" value="Export" id="btn_export">
            </form>
        </div>
        <ul class="accordion" data-accordion>
            <li class="accordion-navigation acd">
                <a id="show_table_mom" href="#panel1a">Minutes of the Meeting<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
                <div id="panel1a" class="content">
                    <?= $mom ?>
                </div>
            </li>
            <li class="accordion-navigation acd">
                <a id="show_table_details" href="#panel2a">Event Details<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
                <div id="panel2a" class="content">
                    <?= $event_details ?>
                </div>
            </li>
            <li class="accordion-navigation acd">
                <a href="#accordion_emp_task">Tasks Assignment<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
                <div id="accordion_emp_task" class="content">
                    <?= $emp_task ?>
                </div>
            </li>
            <li class="accordion-navigation acd">
                <a id="show_table_projects" href="#panel3a">Project Attachments<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
                <div id="panel3a" class="content">
                    <?= $project_attachments ?>
                </div>
            </li>
            <li class="accordion-navigation acd">
                <a id="show_table_setup" href="#panel4a">Set Up Details<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
                <div id="panel4a" class="content">
                    <?= $setup_details ?>
                </div>
            </li>
            <li class="accordion-navigation acd">
                <a id="show_table_mvrf" href="#panel5a">Manpower and Vehicle Request Form<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
                <div id="panel5a" class="content">
                    <?= $mvrf_view ?>
                </div>
            </li>
            <li class="accordion-navigation acd">
                <a href="#accordion_references">References<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
                <div id="accordion_references" class="content">
                    <?= $reference ?>
                </div>
            </li>
            <li class="accordion-navigation acd">
                <a href="#accordion_other">Others<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
                <div id="accordion_other" class="content">
                    <?php
                    $other = json_decode($other_details);

                    $shared_array = array();
                    $this->db->select( 'shared_to, emp_id' );
                    $this->db->from( 'job_order_list' );
                    $this->db->where( 'jo_id', $this->input->get( 'a' ));
                    $query = $this->db->get();
                    if ($query->num_rows() > 0) {
                        $row = $query->row();
                        if (isset($row)) {
                            $shared_array = explode( ',', $row->shared_to );
                            $did = $row->emp_id;
                        }
                    }

                    if( isset( $shared_array ) ){
                        if ( in_array( $this->session->userdata('sess_id'), $shared_array ) || ( $this->session->userdata('sess_id') == $did ) ) {
                            $str_display = 'style="display:block;"';
                            $str_disa = '';
                        }else{
                            $str_display = 'style="display:none;"';
                            $str_disa = 'disabled';
                        }
                    }else{
                        if( ( $this->session->userdata('sess_dept') <= 2 ) && ( $this->session->userdata('sess_id') == $did ) ) {
                            $str_display = 'style="display:block;"';
                            $str_disa = '';
                        }else{
                            $str_display = 'style="display:none;"';
                            $str_disa = 'disabled';
                        }
                    }
                    ?>
                    <div id="alert_box_oth" data-alert class="alert-box alert radius hide-normal">
                        Special characters are not allowed
                        <a href="#" class="close">&times;</a>
                    </div>
                    <form id="other_form" action="" method="post">
                        <input type="hidden" name="otherid" value="<?=$this->input->get('a')?>">
                        <textarea name="ta_Other" id="ta_Other" cols="30" rows="10" <?=$str_disa?>><?=isset($other->texts) ? $other->texts : '';?></textarea>
                        <button id="btn_other_submit" type="button" <?=$str_display?>>Save</button>
                    </form>
                </div>
            </li>
            <li class="accordion-navigation acd">
                <a href="#accordion_comment">Comments<img class="img-responsive right" src="<?= base_url('assets/img/logos/arrowdown.png')?>"></a>
                <div id="accordion_comment" class="content">
                    <?= $comments ?>
                </div>
            </li>
        </ul>
    </div>
</div>
