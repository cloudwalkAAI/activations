<h4>Project Tasks</h4>
<ul class="accordion" data-accordion>
    <li class="accordion-navigation">
        <a class="" href="#creatives_panel">Creatives</a>
        <div id="creatives_panel" class="content">
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Deadline</td>
                        <td>Description</td>
                        <td>Process</td>
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

                        echo '
                            <tr>
                                <td>'.$str_name.'</td>
                                <td>'.$row->date.'</td>
                                <td>'.$row->data.'</td>
                                <td>'.$row->endd.'</td>
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
        <a class="" href="#prod_panel">Production</a>
        <div id="prod_panel" class="content">
            <div class="row">
                <table id="tbl_prod" class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to</td>
                        <td>Deadline</td>
                        <td>Description</td>
                        <td>Visual Peg / Per file</td>
                        <td>Size</td>
                        <td>Qty</td>
                        <td>Other Details</td>
                        <td>Task</td>
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
                                    <td>'.$row->endd.'</td>
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
                        <td>Assigned to</td>
                        <td>Deadline</td>
                        <td>Description</td>
                        <td>Process</td>
                    </tr>
                    </thead>

                    <tbody id="hr_tbd">
                    <?php
                    $validat = '';
                    if( $this->session->userdata('sess_dept') == 5 && $this->session->userdata('sess_post') == 1 ){
                        $validat = 'validated';
                    }
                    $str_name = '';//test
                    $query = $this->db->get_where( 'calendar', array( 'dept_id' => 5, 'jo_id' => $this->input->get('a') ) );
                    foreach($query->result() as $row){

                        $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                        foreach($query_emp->result() as $row_emp){
                            $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                        }

                        echo '
                            <tr>
                                <td>'.$str_name.'</td>
                                <td>'.$row->date.'</td>
                                <td>'.$row->data.'</td>
                                <td>'.$row->endd.'</td>
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
        <a class="" href="#op_panel">Operations</a>
        <div id="op_panel" class="content">
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to</td>
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
                        <td>Assigned to</td>
                        <td>Contact Number</td>
                        <td>Ingress</td>
                        <td>Egress</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody id="">
                    <?php
                    $validat = '';
                    if( $this->session->userdata('sess_dept') == 5 && $this->session->userdata('sess_post') == 1 ){
                        $validat = 'validated';
                    }
                    $str_name = '';//test
                    $query = $this->db->get_where( 'calendar', array( 'dept_id' => 5, 'jo_id' => $this->input->get('a') ) );
                    foreach($query->result() as $row){

                        $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                        foreach($query_emp->result() as $row_emp){
                            $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                        }

                        echo '
                            <tr>
                                <td>'.$str_name.'</td>
                                <td>'.$row->date.'</td>
                                <td>'.$row->data.'</td>
                                <td>'.$row->endd.'</td>
                                <td> </td>
                            </tr>
                        ';
                    }
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
</ul>





