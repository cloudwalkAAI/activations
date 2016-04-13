<h4>Project tasks</h4>
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
                            <td>Edit</td>
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
                    $query = $this->db->get_where( 'calendar', array('dept_id' => 10, 'jo_id' => $this->input->get('a') ) );
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
                                    <td><a class="edit-btn-task" href="#" alt="'.$row->cal_id.'"><img src="'.base_url("assets/img/logos/Edit.png").'" /></a></td>
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
        <a class="" href="#prod_panel">Production</a>
        <div id="prod_panel" class="content">
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





