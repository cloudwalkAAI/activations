<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Custom_model extends CI_Model
{
    public function __construct() {
        parent::__construct ();

    }

    function email_activation( $email_a = null, $fullname = null, $uid = null ){

        echo $email_a.' '.$fullname.' '.$uid;
        return false;

        // Sender email address
        $this->email->from( 'roel.r@cloudwalkdigital.com' );
        // Receiver email address.for single email
        $this->email->to( $email_a, $fullname);
        // Subject of email
        $this->email->subject('Activations registration!');
        // Message in email
        $this->email->message('Please click the link to enter your password http://www.aai2015.com/c?p='.md5($email_a).'&i='.$uid);
        // It returns boolean TRUE or FALSE based on success or failure
        $this->email->send();
    }

    function update_profile( $a = null, $b = null ){
//        if($a == null){
            $data = array(
                'img_loc' => $a
            );
            if( $b == null){
                $this->db->where( 'emp_id', $this->session->userdata('sess_id') );
            }else{
                $this->db->where( 'emp_id', $b );
            }

            $this->db->update( 'employee_list', $data );
//        }
    }

    function update_user_account( $a = null ){
        $data = array(
            'first_name'       => $a['prof_fname'],
            'middle_name'         => $a['prof_mname'],
            'sur_name'      => $a['prof_lname'],
            'contact_nos'      => implode(",",$a['ta_contact'])
        );

        $this->db->where('emp_id', $this->session->userdata('sess_id'));
        $this->db->update('employee_list', $data);

        return $this->db->affected_rows();
    }

    function upd_client( $a ){
        $int_rows = 0;

        $data = array(
            'company_name'      => $a['inp_companyname_u'],
            'contact_person'    => $a['inp_contactperson_u'],
            'contact_number'    => $a['inp_contactnumber_u'],
            'birth_date'        => $a['inp_birthday_u'],
            'email'             => $a['inp_email_u']
        );

        $this->db->where( 'client_id', $a['hid_client_id'] );
        $this->db->update( 'clients', $data );

        $int_rows += $this->db->affected_rows();

        $data = array(
            'brand_name' => implode(',',$a['ta_brand']),
        );
        $this->db->where( 'client_id', $a['hid_client_id'] );
        $this->db->update('brand', $data);

        $int_rows += $this->db->affected_rows();

        return $int_rows;
    }

    function update_info( $a ){

        $data_update = array(
            'role_type'     => $a['sel_role'],
            'first_name'    => $a['inp_firstname'],
            'middle_name'   => $a['inp_midname'],
            'sur_name'      => $a['inp_lastname'],
            'email'         => $a['inp_email'],
            'birth_date'    => $a['datepicker_emp'],
            'department'    => $a['sel_dept'],
            'position'      => $a['sel_pos'],
            'status'        => $a['sel_status']
        );
        $this->db->where('emp_id', $a['uid']);
        $this->db->update('employee_list', $data_update);

        if( $this->db->affected_rows() > 0 ){
            return 1;
        }else{
            return 0;
        }
    }

    function update_jo( $a ){
        print_r($a);

        $insid = 0;
        $data = array(
            'project_type'          => implode(',',$a['inp_projtype2']),
            'client_company_name'   => $a['inp_client2'],
            'brand'                 => implode(',',$a['inp_brand2']),
            'project_name'          => $a['inp_projname2']
        );

        $this->db->where('jo_id', $a['update_joid']);
        $this->db->update('job_order_list', $data);

        if( $this->db->affected_rows() > 0 ) {
            return 'updated';
        }else{
            return 'failed';
        }
    }

    function jo_pending( $cal_id ){
        $str_status = '';
        $query_ae = $this->db->get_where( 'calendar', array( 'cal_id' => $cal_id ) );
        if ($query_ae->num_rows() > 0) {
            $row_ae = $query_ae->row();
            if( $row_ae->endd != 'Done' ){
                $str_status = 'Done';
            }else{
                $str_status = 'Pending';
            }
        }

        $data = array(
            'endd' => $str_status
        );

        $this->db->where( 'cal_id', $cal_id );
        $this->db->update( 'calendar', $data );

        if( $this->db->affected_rows() > 0 ){

            $data = array(
                'message'          => 'Task '.$str_status.' by '.$this->session->userdata('sess_surname').', '.$this->session->userdata('sess_firstname'),
                'emp_id'           => $this->session->userdata('sess_id'),
                'dept_id'          => $this->session->userdata('sess_dept'),
                'date'    => date("m-d-Y H:i:s")
            );
            $this->db->insert('logs', $data);

            return $cal_id;
        }else{
            return 'failed';
        }
    }

    function update_task( $a ){
        $arr_new_task_update = array();
        $str_name = '';

        $data = array(
            'date' => $a['deadline_u'],
            'data' => $a['description_u'],
            'employee_id' => $a['sel_creatives_emp_u']
        );
        $this->db->where( 'cal_id', $a['task_id_u'] );
        $this->db->update( 'calendar', $data );

        if( $this->db->affected_rows() > 0 ){
            $query = $this->db->get_where('calendar', array('cal_id' => $a['task_id_u']));
            foreach($query->result() as $row){
                $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                foreach($query_emp->result() as $row_emp){
                    $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                }
                $arr_new_task_update['table_id'] = $row->cal_id;
                $arr_new_task_update['table_task'] = '
                    <tr id="'.$row->cal_id.'">
                        <td>'.$str_name.'</td>
                        <td>'.$row->date.'</td>
                        <td>'.$row->data.'</td>
                        <td><a href="#" class="task_change" alt="'.$row->cal_id.'" value="'.$this->input->get('a').'">'.$row->endd.'</a></td>
                        <td><a class="edit-btn-task" href="#" alt="'.$row->cal_id.'"><img src="'.base_url("assets/img/logos/Edit.png").'" /></a></td>
                    </tr>
                ';

                echo json_encode($arr_new_task_update);
            }
        }else{
            return 'failed';
        }
    }

    function update_task_prod_u( $a, $b = null ){
        $arr_new_task_update = array();
        $str_name = '';
        $data = array();

        if( $b != null){
            $data = array(
                'date' => $a['prod_deadline_u'],
                'data' => $a['prod_description_u'],
                'peg' => $b,
                'size' => $a['prod_size_u'],
                'qty' => $a['prod_qty_u'],
                'other_details' => $a['prod_other_details_u'],
                'employee_id' => $a['sel_prod_emp_u']
            );
        }else{
            $data = array(
                'date' => $a['prod_deadline_u'],
                'data' => $a['prod_description_u'],
                'size' => $a['prod_size_u'],
                'qty' => $a['prod_qty_u'],
                'other_details' => $a['prod_other_details_u'],
                'employee_id' => $a['sel_prod_emp_u']
            );
        }


        $this->db->where( 'cal_id', $a['task_id_u_prod'] );
        $this->db->update( 'calendar', $data );

        if( $this->db->affected_rows() > 0 ){
            $query = $this->db->get_where('calendar', array('cal_id' => $a['task_id_u_prod']));
            foreach($query->result() as $row){
                $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                foreach($query_emp->result() as $row_emp){
                    $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                }
                $filname = str_replace("assets/uploads/peg/","",$row->peg);

                $arr_new_task_update['table_id'] = $row->cal_id;
                $arr_new_task_update['table_task'] = '
                    <tr id="prod'.$row->cal_id.'">
                        <td>'.$str_name.'</td>
                        <td>'.$row->date.'</td>
                        <td><span title="'.$row->data.'" aria-describedby="tooltip-ijv27znv5a'.$row->cal_id.'" data-selector="tooltip-ijv27znv5a'.$row->cal_id.'" data-tooltip="" aria-haspopup="true" class="has-tip">Mouseover for More Info</span></td>
                        <td><a href="'.base_url($row->peg).'" target="_blank">'.$filname.'</a></td>
                        <td>'.$row->size.'</td>
                        <td>'.$row->qty.'</td>
                        <td><span title="'.$row->other_details.'" aria-describedby="tooltip-ijv27znv5'.$row->cal_id.'" data-selector="tooltip-ijv27znv5'.$row->cal_id.'" data-tooltip="" aria-haspopup="true" class="has-tip">Mouseover for More Info</span></td>
                        <td><a href="#" class="task_change" alt="'.$row->cal_id.'" value="'.$row->jo_id.'">'.$row->endd.'</a></td>
                        <td style="text-align:center;">
                            <a class="edit-btn-task-prod" href="#" alt="'.$row->cal_id.'"><img src="'.base_url("assets/img/logos/Edit.png").'" /></a>
                            <a class="del-btn-task-prod" href="#" alt="'.$row->cal_id.'"><img src="'.base_url("assets/img/logos/Delete.png").'" /></a>
                        </td>
                    </tr>
                ';

                echo json_encode($arr_new_task_update);
            }
        }else{
            return 'failed';
        }
    }

    function delete_cal_task($id){
        $this->db->delete('calendar', array('cal_id' => $id));
        if( $this->db->affected_rows() > 0){
            return $id;
        }else{
            return $this->db->affected_rows();
        }
    }

    function update_jo_col( $color ){
        $data = array(
            'jo_color' => $color['col']
        );
        $this->db->where('jo_number', $color['val']);
        $this->db->update('job_order_list', $data);

        return $color['col'];
    }

    function del_transmittal( $trans_id ){
        $data = array(
            'transmittal' => ''
        );
        $this->db->where('jo_id', $trans_id['jo_id']);
        $this->db->update('job_order_list', $data);
    }

    function update_req( $a ){
        $req_array = array();

        $data = array(
            'department_name'   => $a['rq_dept_u'],
            'deliverables'      => $a['editor_req_u'],
            'deadline'          => $a['rq_deadline_u'],
            'next_steps'        => $a['editor_ns_u']
        );
        $this->db->where( 'req_id', $a['rq_joid_u'] );
        $this->db->update( 'event_requirement', $data );

        if($this->db->affected_rows() > 0){
            $query = $this->db->get_where( 'event_requirement', array( 'req_id' => $a['rq_joid_u'] ) );
            foreach( $query->result() as $row ) {
                $req_array['dt_id'] = $row->req_id;
                $req_array['dt_table'] = '<tr id="'.$row->req_id.'">
                    <td>'.$row->department_name.'</td>
                    <td><span title="'.$row->deliverables.'" aria-describedby="tooltip-ijv27znv5" data-selector="tooltip-ijv27znv5" data-tooltip="" aria-haspopup="true" class="has-tip">Hover for More Info</span></td>
                    <td>'.$row->deadline.'</td>
                    <td><span title="'.$row->next_steps.'" aria-describedby="tooltip-ijv27znv5" data-selector="tooltip-ijv27znv5" data-tooltip="" aria-haspopup="true" class="has-tip">Hover for More Info</span></td>
                    <td style="text-align:center;">
                        <a class="edit-btn-req" href="#" alt="'.$row->req_id.'"><img src="'.base_url("assets/img/logos/Edit.png").'" /></a>
                        <a class="del-btn-req" href="#" alt="'.$row->req_id.'"><img src="'.base_url("assets/img/logos/Delete.png").'" /></a>
                    </td>
                </tr>';
            }
            return json_encode( $req_array );
        }else{
            return 0;
        }

    }

    function update_cmtuva($a){
        $arr_cmt_info = array();

        $data = array(
            'venue'         => $a['cmt_venue'],
            'area'          => $a['cmt_area'],
            'street'        => $a['cmt_st'],
            'rate'          => $a['cmt_rate'],
            'eft'           => $a['cmt_eft'],
            'target_hits'   => $a['cmt_tarhits'],
            'actual_hits'   => $a['cmt_achits'],
            'remarks'       => $a['cmt_rem'],
            'u_images'        => $a['cmt_upload_cmtuva'],
            'lsm'           => $a['cmt_lsm']
        );
        $this->db->where( 'location_id', $a['cmt_joid'] );
        $this->db->update( 'cmtuva_location_list', $data );

        $query = $this->db->get_where( 'cmtuva_location_list', array( 'location_id' => $a['cmt_joid'] ) );
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $arr_cmt_info['content'] = '
                    <tr id="cmt_'.$row->location_id.'">
                        <td>'.ucfirst( $row->venue ).'</td>
                        <td>'.ucfirst( $row->area ).'</td>
                        <td>'.ucfirst( $row->street ).'</td>
                        <td>Php '.ucfirst( $row->rate ).'</td>
                        <td>'.ucfirst( $row->eft ).'</td>
                        <td>'.ucfirst( $row->target_hits ).'</td>
                        <td>'.ucfirst( $row->actual_hits ).'</td>
                        <td>'.ucfirst( $row->lsm ).'</td>
                        <td style="text-align:center;">
                            <div class="column large-6 medium-6 small-6">
                                <a class="edit-btn-cmtuva" href="#" alt="'.$row->location_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Edit.png").'" /></a>
                            </div>
                            <div class="column large-6 medium-6 small-6">
                                <a class="del-btn-cmtuva" href="#" alt="'.$row->location_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Delete.png").'" /></a>
                            </div>
                        </td>
                    </tr>
                ';

                $arr_cmt_info['content_id'] = $row->location_id;
            }
        }
        echo json_encode($arr_cmt_info);
    }

    function update_cmae($a){
        $arr_cmt_info = array();

        $data = array(
            'venue'         => $a['cmae_sel_venue'],
            'area'          => $a['cmae_sel_area'],
            'street'        => $a['cmuae_street'],
            'date_start'    => $a['cmae_date'],
            'duration'      => $a['cmae_duration'],
            'rate'          => $a['cmae_rate'],
            'total_rate'    => $a['cmae_esp']
        );
        $this->db->where( 'cmae_id', $a['cm_id'] );
        $this->db->update( 'cmtuva_ae_list', $data );

        $query = $this->db->get_where( 'cmtuva_ae_list', array( 'cmae_id' => $a['cm_id'] ) );
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $arr_cmae = explode(",",$row->area);

                $arr_cmt_info['content'] = '
                    <tr id="cmae_'.$row->cmae_id.'">
                        <td>'.ucfirst( $row->venue ).'</td>
                        <td>'.ucfirst( $arr_cmae[0] ).'</td>
                        <td>'.ucfirst( $row->street ).'</td>
                        <td>'.$row->date_start.'</td>
                        <td>'.$row->duration.' day(s)</td>
                        <td>Php '.$row->rate.'</td>
                        <td>Php '.$row->total_rate.'</td>
                        <td style="text-align:center;">
                            <div class="column large-6 medium-6 small-6">
                                <a class="edit-btn-cmtuva-ae" href="#" alt="'.$row->cmae_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Edit.png").'" /></a>
                            </div>
                            <div class="column large-6 medium-6 small-6">
                                <a class="del-btn-cmtuva-ae" href="#" alt="'.$row->cmae_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Delete.png").'" /></a>
                            </div>
                        </td>
                    </tr>
                ';

                $arr_cmt_info['content_id'] = $row->cmae_id;
            }
        }
        echo json_encode($arr_cmt_info);
    }

    function deduct_item( $a ){
        $data = array(
            'qty'          => $a['deduct_total']
        );
        $this->db->where( 'stock_id', $a['deduct_select'] );
        $this->db->update( 'stocks', $data );

        $query = $this->db->get_where( 'stocks', array( 'stock_id' => $a['deduct_select'] ) );
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $str_data = '<tr id="ori'.$row->stock_id.'"><td>'.$row->item_code.'</td><td>'.$row->item_name.'</td><td>'.$row->description.'</td><td>'.$row->qty.'</td><td>'.$row->expiration.'</td><td>'.$row->date_stored.'</td></tr>***'.$row->stock_id.'';
            }
        }
        return $str_data;
    }

    function update_added_item($a){
        $data = array(
            'item_code'     => $a['edit_inv_code'],
            'item_name'     => $a['edit_inv_name'],
            'description'   => $a['edit_inv_description'],
            'qty'           => $a['edit_inv_qty'],
            'expiration'    => $a['edit_inv_expiration'],
        );
        $this->db->where( 'stock_id', $a['edit_inv_stck_id'] );
        $this->db->update( 'stocks', $data );

        $query = $this->db->get_where( 'stocks', array( 'stock_id' => $a['edit_inv_stck_id'] ) );
        if($query->num_rows() > 0) {
            $insid_current = $a['edit_inv_stck_id'];

            $arr_data['add_current'] = $this->get_tables_added( $insid_current );
            $arr_data['add_transaction'] = $this->table_append_add_item( $a, $insid_current );
        }
        return json_encode($arr_data);
    }

    function get_tables_added( $inv_id = null){
        $str_data = '';
        $query = $this->db->get_where('stocks', array( 'stock_id' => $inv_id ));
        foreach ( $query->result() as $row ){
            $str_data = '
            <tr id="ori'.$row->stock_id.'">
                <td>'.$row->item_code.'</td>
                <td>'.$row->item_name.'</td>
                <td>'.$row->description.'</td>
                <td>'.$row->qty.'</td>
                <td>'.$row->expiration.'</td>
                <td>'.$row->date_stored.'</td>
            </tr>***'.$row->stock_id.'
            ';
        }
        return $str_data;
    }

    function table_append_add_item( $a = null, $item_id = null ){
        $data = array(
            'item_id'           => $item_id,
            'sub_description'   => $a['edit_inv_description'],
            'item_qty'          => $a['edit_inv_qty'],
            'process'           => 'add',
            'personel'          => $a['edit_inv_delivered_by'],
            'received_by'       => $a['edit_inv_received_by'],
            'transacted_by'     => $this->session->userdata('sess_surname').', '.$this->session->userdata('sess_firstname').' '.$this->session->userdata('sess_middlename'),
            'transaction_date'  => date("m-d-Y H:i:s")
        );

        $this->db->where( 'trans_id', $a['edit_inv_trans_id'] );
        $this->db->update( 'stocks_sub', $data );

//        return $this->db->insert_id();
        return $this->inv_join_tables( $a['edit_inv_trans_id'] );
    }

    function inv_join_tables( $tbl_id = null ){
        $str_add_table = '';

        $this->db->select('*'); // Select field
        $this->db->from('stocks_sub'); // from Table1
        $this->db->join('stocks','stocks_sub.item_id = stocks.stock_id','INNER'); // Join table1 with table2 based on the foreign key
        $this->db->where('stocks_sub.trans_id',$tbl_id); // Set Filter
        $res = $this->db->get();

//        return json_encode($res->result());
        foreach ( $res->result() as $row ){
            $str_add_table = '<tr id="add"'.$row->trans_id.'><td><a class="inv_edit" href="#" alt="'.$row->trans_id.'">'.$row->item_code.'</a></td><td>'.$row->item_name.'</td><td>'.$row->description.'</td><td>'.$row->item_qty.'</td><td>'.$row->expiration.'</td><td>Delivered by : '.$row->personel.'<br> Received by : '.$row->received_by.'<br> Transacted by : '.$row->transacted_by.'</td><td>'.$row->date_stored.'</td></tr>***'.$row->trans_id.'';
        }

        return $str_add_table;
    }

    function update_cm_approval($e){
        $e_val = $this->session->userdata('sess_surname').', '.$this->session->userdata('sess_firstname').' '.$this->session->userdata('sess_middlename').' - '.date("m-d-Y H:i:s");

        $data = array(
            'approved_by' => $e_val
        );

        $this->db->where( 'trans_id', $e['trans_id'] );
        $this->db->update( 'stocks_sub', $data );

        if( $this->db->affected_rows() > 0 ){
//            return $e_val;
            return $this->ret_table_approval_released( $e['trans_id'] );
        }
    }

    function update_cm_release($e){
        $e_val = $this->session->userdata('sess_surname').', '.$this->session->userdata('sess_firstname').' '.$this->session->userdata('sess_middlename').' - '.date("m-d-Y H:i:s");

        $data = array(
            'released_by' => $e_val
        );

        $this->db->where( 'trans_id', $e['trans_id'] );
        $this->db->update( 'stocks_sub', $data );

        if( $this->db->affected_rows() > 0 ){
//            return $e_val;
            return $this->ret_table_approval_released( $e['trans_id'] );
        }
    }

    function ret_table_approval_released($eid){
        $this->db->select('*'); // Select field
        $this->db->from('stocks_sub'); // from Table1
        $this->db->join('stocks','stocks_sub.item_id = stocks.stock_id','INNER'); // Join table1 with table2 based on the foreign key
        $this->db->where('process','deduct');
        $this->db->where('trans_id',$eid);
        $this->db->order_by("trans_id","DESC");
        $res = $this->db->get();

        foreach ( $res->result() as $row ){

            $str_appr_rel = '';
            if( !$row->approved_by && ($this->session->userdata('sess_dept') == '6') ){
                $str_appr_rel .= '
									<label for="chk_approval">Approve : 
										<input type="checkbox" class="chk_approval" name="chk_approval" id="chk_approval" alt="'.$row->trans_id.'">
									</label>
								';
            }else{
                $str_appr_rel .= '
									Approved By : '.$row->approved_by.'
								';
                $str_appr_rel .= '<br>';
            }

            if( !$row->released_by && ($this->session->userdata('sess_dept') == '8') ){
                $str_appr_rel .= '
									<label for="chk_approval">Release : 
										<input type="checkbox" class="chk_released" name="chk_released" id="chk_released" alt="'.$row->trans_id.'">
									</label>
								';
            }else{
                $str_appr_rel .= '
									Released By : '.$row->released_by.'
								';
            }
            return '
            <tr id="trans'.$row->trans_id.'">
                <td>'.$row->item_name.'</td>
                <td>'.$row->jo_id.'</td>
                <td>'.$row->received_by.'</td>
                <td>'.$row->sub_description.'</td>
                <td>'.$row->item_qty.'</td>
                <td>'.$row->deducted_by.'<br>'.$str_appr_rel.'</td>
                <td>'.$row->transaction_date.'</td>
            </tr>***'.$row->trans_id.'
            ';
        }
    }
    function manpower_requirement( $a ){
        $data = array(
            'ba'            => $a['inp_req_ba_needed'],
            'ba_rate'       => $a['inp_req_ba_rate'],
            'pg'            => $a['inp_req_pg_needed'],
            'pg_rate'       => $a['inp_req_pg_rate'],
            'sampler'       => $a['inp_req_needed_sampler'],
            'sampler_rate'  => $a['inp_req_rate_sampler'],
            'seller'        => $a['inp_req_needed_seller'],
            'seller_rate'   => $a['inp_req_rate_seller'],
            'pa'            => $a['inp_req_needed_pa'],
            'pa_rate'       => $a['inp_req_rate_pa'],
            'setup'         => $a['inp_req_needed_set'],
            'setup_rate'    => $a['inp_req_rate_set'],
            'stylist'       => $a['inp_req_needed_stylist'],
            'stylist_rate'  => $a['inp_req_rate_stylist'],
            'dancer'        => $a['inp_req_needed_dancer'],
            'dancer_rate'   => $a['inp_req_rate_dancer'],
            'others'        => $a['inp_other_man_req'],
            'others_needed' => $a['inp_other_man_req_needed'],
            'others_rate'   => $a['inp_other_man_req_rate']
        );

        $query = $this->db->get_where( 'hr_requirements', array( 'jo_id' => $a['hid_req_man_id'] ) );
        if($query->num_rows() > 0){
            $this->db->where( 'jo_id', $a['hid_req_man_id'] );
            $this->db->update( 'hr_requirements', $data );
        }else{
            $data['jo_id'] = $a['hid_req_man_id'];
            $this->db->insert('hr_requirements', $data);
        }

        return $this->db->affected_rows();
    }

    function manpower_pool( $a ){
        $data = array(
            'pool_start'    => $a['pool_start'],
            'pool_deadline' => $a['pool_deadline'],
            'pool_pulled'   => $a['pool_pulled']
        );

        $query = $this->db->get_where( 'hr_pooling', array( 'jo_id' => $a['pooling_joid'] ) );
        if($query->num_rows() > 0){
            $this->db->where( 'jo_id', $a['pooling_joid'] );
            $this->db->update( 'hr_pooling', $data );
        }else{
            $data['jo_id'] = $a['pooling_joid'];
            $this->db->insert('hr_pooling', $data);
        }

        return ($a['pool_pulled']/$a['pool_overalltotal']) * 100;
    }
}