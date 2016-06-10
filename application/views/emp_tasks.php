<h4>Project Tasks</h4>
<ul class="accordion" data-accordion>
    <li class="accordion-navigation">
        <a class="" href="#creatives_panel">Creatives</a>
        <div id="creatives_panel" class="content">
            <?php
            if( $this->session->userdata('sess_dept') == 10 && $this->session->userdata('sess_post') == 1 ){
                ?>
                <div class="row force_right_align">
                    <button class="small" data-reveal-id="modal_creatives_tasks">Add Assignment</button>
                </div>


                <div id="modal_creatives_tasks" class="reveal-modal small" data-reveal aria-labelledby="modal_creatives" aria-hidden="true" role="dialog">
                    <h2 id="modal_creatives">Assign a task to</h2>

                    <div id="creatives_box" data-alert class="alert-box warning radius hide-normal">
                        Date exists
                        <a href="#" class="close">&times;</a>
                    </div>

                    <form id="form_creatives_tasks" action="" method="post">
                        <input type="hidden" name="dept_id" value="10">
                        <input type="hidden" name="jo_id" value="<?=$this->input->get('a');?>">
                        <select name="sel_creatives_emp" id="sel_creatives_emp">
                            <option value="0">Select Employee</option>
                            <?php
                            $query = $this->db->get_where('employee_list', array('department' => 10));

                            foreach( $query->result() as $row ){
                                echo '<option value="'.$row->id.'" >'.$row->sur_name.', '.$row->first_name.' '.$row->middle_name.'</option>';
                            }
                            ?>
                            <!--                        <option value="employee">Employee</option>-->
                        </select>
                        <input id="joid_task" type="hidden" name="joid_task" value="<?=$this->input->get('a');?>">
                        <input id="creative_deadline" type="text" name="deadline" class="req" placeholder="Deadline">
                        <input id="creative_description" type="text" name="description" class="req" placeholder="Description">

                        <div class="row force_right_align">
                            <button class="button success" id="btn_update_calendar" type="submit">Assign</button>
                        </div>
                    </form>
                    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
                </div>

                <div id="modal_creatives_tasks_u" class="reveal-modal small" data-reveal aria-labelledby="modal_creatives" aria-hidden="true" role="dialog">
                    <h2 id="modal_creatives_u">Assign a task to</h2>

                    <div id="creatives_box_u" data-alert class="alert-box warning radius hide-normal">
                        Date exists
                        <a href="#" class="close">&times;</a>
                    </div>

                    <form id="form_creatives_tasks_u" action="" method="post">
                        <input type="hidden" name="dept_id_u" value="10">
                        <input type="hidden" id="task_id_u" name="task_id_u">
                        <select name="sel_creatives_emp_u" id="sel_creatives_emp_u">
                            <option value="0">Select Employee</option>
                            <?php
                            $query = $this->db->get_where('employee_list', array('department' => 10));

                            foreach( $query->result() as $row ){
                                echo '<option value="'.$row->id.'" >'.$row->sur_name.', '.$row->first_name.' '.$row->middle_name.'</option>';
                            }
                            ?>
                        </select>
                        <input id="joid_task_u" type="hidden" name="joid_task_u" value="<?=$this->input->get('a');?>">
                        <input id="creative_deadline_u" type="text" name="deadline_u" class="req" placeholder="Deadline">
                        <input id="creative_description_u" type="text" name="description_u" class="req" placeholder="Description">

                        <div class="row force_right_align">
                            <button class="button success" id="btn_update_calendar_u" type="submit">Update</button>
                        </div>
                    </form>
                    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Deadline</td>
                        <td>Description</td>
                        <td>Process</td>
                        <?php
                        if( $this->session->userdata('sess_dept') == 10 && $this->session->userdata('sess_post') == 1 ){
                        ?>
                            <td> </td>
                        <?php
                        }
                        ?>

                    </tr>
                    </thead>
                    <tbody id="creatives_tbd">
                    <?php
                    $validat = '';
                    if( $this->session->userdata('sess_dept') == 10 && $this->session->userdata('sess_post') == 1 ){
                        $validat = 'validated';
                    }
                    $str_name = '';//test
                    $query = $this->db->get_where( 'calendar', array( 'dept_id' => 10, 'jo_id' => $this->input->get('a') ) );
                    foreach($query->result() as $row){

                        $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                        foreach($query_emp->result() as $row_emp){
                            $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                        }


                        if($validat == 'validated'){
                            echo '
                                <tr id="'.$row->cal_id.'">
                                    <td>'.$str_name.'</td>
                                    <td>'.$row->date.'</td>
                                    <td>'.$row->data.'</td>
                                    <td><a href="#" class="task_change" alt="'.$row->cal_id.'" value="'.$this->input->get('a').'">'.$row->endd.'</a></td>
                                    <td style="text-align:center;">
                                        <a class="edit-btn-task" href="#" alt="'.$row->cal_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Edit.png").'" /></a>
                                        <a class="del-btn-task" href="#" alt="'.$row->cal_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Delete.png").'" /></a>
                                    </td>
                                </tr>
                            ';
                        }else{
                            echo '
                                <tr>
                                    <td>'.$str_name.'</td>
                                    <td>'.$row->date.'</td>
                                    <td>'.$row->data.'</td>
                                    <td>'.$row->endd.'</td>
                                </tr>
                            ';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    <li class="accordion-navigation">
        <a class="" href="#prod_panel">Production</a>
        <div id="prod_panel" class="content">
            <?php
            if( $this->session->userdata('sess_dept') == 7 && $this->session->userdata('sess_post') == 1 ) {
                ?>
                <div class="row force_right_align">
                    <button class="small" data-reveal-id="modal_prod_tasks">Add Assignment</button>
                </div>


                <div id="modal_prod_tasks" class="reveal-modal large" data-reveal aria-labelledby="modal_prod" aria-hidden="true" role="dialog">
                    <h2 id="modal_prod">Assign a task to</h2>

                    <div id="prod_box" data-alert class="alert-box warning radius hide-normal">
                        Date exists
                        <a href="#" class="close">&times;</a>
                    </div>

                    <form id="form_prod_tasks" action="" method="post">
                        <input type="hidden" name="dept_id" value="10">
                        <input type="hidden" name="jo_id" value="<?=$this->input->get('a');?>">

                        <div class="column large-6 medium-6 small-12">
                            <select class="radius" name="sel_prod_emp" id="sel_prod_emp">
                                <option value="0">Select Employee</option>
                                <?php
                                $query = $this->db->get_where('employee_list', array('department' => 7));

                                foreach( $query->result() as $row ){
                                    echo '<option value="'.$row->id.'" >'.$row->sur_name.', '.$row->first_name.' '.$row->middle_name.'</option>';
                                }
                                ?>
                                <!--                        <option value="employee">Employee</option>-->
                            </select>
                            <input id="joid_task" type="hidden" name="joid_task" value="<?=$this->input->get('a');?>">
                            <input id="prod_deadline" type="text" name="prod_deadline" class="req radius" placeholder="Deadline">
                            <select class="radius" name="sel_prod_type" id="sel_prod_type">
                                <option value="0">Select...</option>
                                <option value="Print Production">Print Production</option>
                                <option value="Booth Production">Booth Production</option>
                                <option value="Photo wall and Panels Production">Photo wall and Panels Production</option>
                                <option value="Shirts Production">Shirts Production</option>
                                <option value="Event Staging Requirements">Event Staging Requirements</option>
                                <option value="Purchase Requirements">Purchase Requirements</option>
                            </select>
                            <div class="column large-6 medium-6 small-6 print_production" style="display: none;">
                                <label for="chk_tarp"><input type="checkbox" name="chk_prod[]" id="chk_tarp" value="Tarpaulin"> Tarpaulin</label>
                                <label for="chk_stick"><input type="checkbox" name="chk_prod[]" id="chk_stick" value="Stickers"> Stickers</label>
                            </div>
                            <div class="column large-6 medium-6 small-6 print_production" style="display: none;">
                                <label for="chk_offset"><input type="checkbox" name="chk_prod[]" id="chk_offset" value="Offset"> Offset</label>
                                <label for="chk_digital"><input type="checkbox" name="chk_prod[]" id="chk_digital" value="Digital"> Digital</label>
                            </div>
                            <textarea style="resize: none;" class="radius" name="prod_description" id="prod_description" cols="30" rows="10" placeholder="Description"></textarea>
                            <input class="radius" type="file" name="prod_file" id="prod_file">
                        </div>

                        <div class="column large-6 medium-6 small-12">
                            <input class="radius" type="text" name="prod_size" id="prod_size" placeholder="Size">
                            <input class="radius" type="number" name="prod_qty" id="prod_qty" placeholder="Qty">
                            <textarea style="resize: none;" class="radius" name="prod_other_details" id="prod_other_details" cols="30" rows="10" placeholder="Other Details"></textarea>
                        </div>

                        <div class="row force_right_align">
                            <button class="button success" id="btn_update_calendar_prod" type="submit">Assign</button>
                        </div>
                    </form>
                    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
                </div>

                <div id="modal_prod_tasks_u" class="reveal-modal large" data-reveal aria-labelledby="modal_prod" aria-hidden="true" role="dialog">
                    <h2 id="modal_prod_u">Assign a task to</h2>

                    <div id="prod_box_u" data-alert class="alert-box warning radius hide-normal">
                        Date exists
                        <a href="#" class="close">&times;</a>
                    </div>

                    <form id="form_prod_tasks_u" action="" method="post">
                        <input type="hidden" name="dept_id" value="10">
                        <input type="hidden" name="jo_id" value="<?=$this->input->get('a');?>">
                        <input type="hidden" id="task_id_u_prod" name="task_id_u_prod">
                        <div class="column large-6 medium-6 small-12">
                            <select class="radius" name="sel_prod_emp_u" id="sel_prod_emp_u">
                                <option value="0">Select Employee</option>
                                <?php
                                $query = $this->db->get_where('employee_list', array('department' => 7));
                                foreach( $query->result() as $row ){
                                    echo '<option value="'.$row->id.'" >'.$row->sur_name.', '.$row->first_name.' '.$row->middle_name.'</option>';
                                }
                                ?>
                                <!--                        <option value="employee">Employee</option>-->
                            </select>
                            <input id="joid_task" type="hidden" name="joid_task" value="<?=$this->input->get('a');?>">
                            <input id="prod_deadline_u" type="text" name="prod_deadline_u" class="req radius" placeholder="Deadline">
                            <textarea style="resize: none;" class="radius" name="prod_description_u" id="prod_description_u" cols="30" rows="10" placeholder="Description"></textarea>
                            <a href="#" id="prod_dl_link">Download</a>
                            <input class="radius" type="file" name="prod_file_u" id="prod_file_u">
                        </div>

                        <div class="column large-6 medium-6 small-12">
                            <input class="radius" type="text" name="prod_size_u" id="prod_size_u" placeholder="Size">
                            <input class="radius" type="number" name="prod_qty_u" id="prod_qty_u" placeholder="Qty">
                            <textarea style="resize: none;" class="radius" name="prod_other_details_u" id="prod_other_details_u" cols="30" rows="10" placeholder="Other Details"></textarea>
                        </div>

                        <div class="row force_right_align">
                            <button class="button success" id="btn_update_calendar_prod_u" type="submit">Update</button>
                        </div>
                    </form>
                    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
                </div>
                <?php
            }
            ?>
            <div class="row">
                <table id="tbl_prod" class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Deadline</td>
                        <td>Description</td>
                        <td>Visual Peg / Per file</td>
                        <td>Size</td>
                        <td>Qty</td>
                        <td>Other Details</td>
                        <td>Task</td>
                        <td> </td>
                    </tr>
                    </thead>
                    <tbody id="tbd_prod">
                    <?php
                    $validat = '';
                    if( $this->session->userdata('sess_dept') == 7 && $this->session->userdata('sess_post') == 1 ){
                        $validat = 'validated';
                    }
                    $str_name = '';//test
                    $str_print_prod = '';//test
                    $i = 0;

                    $query = $this->db->get_where( 'calendar', array( 'dept_id' => 7, 'jo_id' => $this->input->get('a') ) );
                    foreach($query->result() as $row){

                        $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                        foreach($query_emp->result() as $row_emp){
                            $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                        }

                        $filname = str_replace("assets/uploads/peg/","",$row->peg);

                        $str_r = str_replace("[","",$row->print_prod);
                        $str_r1 = str_replace("]","",$str_r);
                        $str_r2 = str_replace('"','',$str_r1);

                        foreach ( explode(",", $str_r2) as $print_prod ){
                            $i++;
                            if( $i == 2 && $print_prod != NULL ){
                                $str_print_prod .= $print_prod;
                            }elseif( $print_prod != NULL ){
                                $str_print_prod .= ', '.$print_prod;
                            }

                        }

                        if($validat == 'validated'){
                            echo '
                                <tr id="prod'.$row->cal_id.'">
                                    <td>'.$str_name.'</td>
                                    <td>'.$row->date.'</td>
                                    <td>'.$row->prod_type.' - '.$str_print_prod.'<br /><br /><span title="'.$row->data.'" aria-describedby="tooltip-ijv27znv5a'.$row->cal_id.'" data-selector="tooltip-ijv27znv5a'.$row->cal_id.'" data-tooltip="" aria-haspopup="true" class="has-tip">Mouseover for More Info</span></td>
                                    <td><a href="'.base_url($row->peg).'" target="_blank">'.$filname.'</a></td>
                                    <td>'.$row->size.'</td>
                                    <td>'.$row->qty.'</td>
                                    <td><span title="'.$row->other_details.'" aria-describedby="tooltip-ijv27znv5'.$row->cal_id.'" data-selector="tooltip-ijv27znv5'.$row->cal_id.'" data-tooltip="" aria-haspopup="true" class="has-tip">Mouseover for More Info</span></td>
                                    <td><a href="#" class="task_change" alt="'.$row->cal_id.'" value="'.$this->input->get('a').'">'.$row->endd.'</a></td>
                                    <td style="text-align:center;">
                                        <a class="edit-btn-task-prod" href="#" alt="'.$row->cal_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Edit.png").'" /></a>
                                        <a class="del-btn-task-prod" href="#" alt="'.$row->cal_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Delete.png").'" /></a>
                                    </td>
                                </tr>
                            ';
                            $str_print_prod = '';
                        }else{
                            echo '
                                <tr>
                                    <td>'.$str_name.'</td>
                                    <td>'.$row->date.'</td>
                                    <td>'.$row->data.'</td>
                                    <td>'.$row->endd.'</td>
                                </tr>
                            ';
                        }
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    <li class="accordion-navigation">
        <a class="" href="#hr_panel">HR</a>
        <div id="hr_panel" class="content">
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Start</td>
                        <td>Deadline</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    <li class="accordion-navigation">
        <a class="" href="#op_panel">Operations</a>
        <div id="op_panel" class="content">
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Start</td>
                        <td>Deadline</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>   
    <li class="accordion-navigation">
        <a class="" href="#set_panel">Set Up / Logistics</a>
        <div id="set_panel" class="content">
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Contact Number</td>
                        <td>Ingress</td>
                        <td>Egress</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
</ul>





