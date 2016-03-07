<h4>Project tasks</h4>
<ul class="accordion" data-accordion>
    <li class="accordion-navigation">
        <a class="" href="#creatives_panel">Creatives</a>
        <div id="creatives_panel" class="content">
<?php
if( $this->session->userdata('sess_dept') == 10 && $this->session->userdata('sess_post') == 1 ){
?>
            <div class="row force_right_align">
                <button class="small" data-reveal-id="modal_creatives_tasks">Add assignment</button>
            </div>


            <div id="modal_creatives_tasks" class="reveal-modal small" data-reveal aria-labelledby="modal_creatives" aria-hidden="true" role="dialog">
                <h2 id="modal_creatives">Assign a task to.</h2>

                <div id="creatives_box" data-alert class="alert-box warning radius hide-normal">
                    Date exists
                    <a href="#" class="close">&times;</a>
                </div>

                <form id="form_creatives_tasks" action="" method="post">
                    <input type="hidden" name="dept_id" value="10">
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
                    <input id="creative_start" type="text" name="start" class="req" placeholder="Start">
                    <input id="creative_deadline" type="text" name="deadline" class="req" placeholder="Deadline">
                    <input id="creative_description" type="text" name="description" class="req" placeholder="Description">

                    <div class="row force_right_align">
                        <button class="button success" id="btn_update_calendar" type="submit">Update</button>
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
                        <td>Start</td>
                        <td>Deadline</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody id="creatives_tbd">
                        <?php
                        $str_name = '';//test
                        $query = $this->db->get_where('calendar', array('dept_id' => 10));
                        foreach($query->result() as $row){

                            $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                            foreach($query_emp->result() as $row_emp){
                                $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                            }

                            echo '
                            <tr>
                                <td>'.$str_name.'</td>
                                <td>'.$row->date.'</td>
                                <td>'.$row->endd.'</td>
                                <td>'.$row->data.'</td>
                            </tr>
                            ';
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
        <a class="" href="#act_panel">Activations</a>
        <div id="act_panel" class="content">
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
</ul>





