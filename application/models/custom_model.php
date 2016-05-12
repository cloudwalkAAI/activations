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
}