<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Update_model extends CI_Model
{
    public function __construct() {
        parent::__construct ();

    }

//    transfered to custom_model
//    function update_info( $a ){
//
//        $data_update = array(
//            'role_type'     => $a['sel_role_u'],
//            'first_name'    => $a['inp_firstname_u'],
//            'middle_name'   => $a['inp_midname_u'],
//            'sur_name'      => $a['inp_lastname_u'],
//            'email'         => $a['inp_email_u'],
//            'birth_date'    => $a['datepicker_emp_u'],
//            'department'    => $a['sel_dept_u'],
//            'position'      => $a['sel_pos_u'],
//            'status'        => $a['sel_status_u']
//        );
//        $this->db->where('emp_id', $a['uid']);
//        $this->db->update('employee_list', $data_update);
//
//        if( $this->db->affected_rows() > 0 ){
//            return 1;
//        }else{
//            return 0;
//        }
//    }
//
//    function update_user_account( $a ){
//        $data = array(
//            'first_name'       => $a['prof_fname'],
//            'middle_name'         => $a['prof_mname'],
//            'sur_name'      => $a['prof_lname'],
//            'contact_nos'      => $a['ta_contact']
//        );
//
//        $this->db->where('emp_id', $this->session->userdata('sess_id'));
//        $this->db->update('employee_list', $data);
//
//        return $this->db->affected_rows();
//    }

//transfered to custom_model
//    function upd_client( $a ){
//        $data = array(
//            'company_name'      => $a['inp_companyname_u'],
//            'contact_person'    => $a['inp_contactperson_u'],
//            'contact_number'    => $a['inp_contactnumber_u'],
//            'birth_date'        => $a['inp_birthday_u'],
//            'email'             => $a['inp_email_u']
//        );
//
//        $this->db->where( 'client_id', $a['hid_client_id'] );
//        $this->db->update( 'clients', $data );
//
//        return $this->db->affected_rows();
//    }

    function upd_pass( $a ){

        $query = $this->db->get_where( 'employee_list', array( 'id' => $a['user_id'] ) );
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
                if( ( md5($row->email) == $a['user_code'] ) || ( 'activati0ns' == $a['user_code'] ) ){
                    $data = array(
                        'emp_pass' => md5( $a['npass'] )
                    );

                    $this->db->where( 'id', $a['user_id'] );
                    $this->db->update( 'employee_list', $data );
                    return 'Password Changed';
                }else{
                    return 'Invalid code!';
                }
            }
        }else{
            return 'not registered';
        }

    }

    function upd_pass_set( $a ){

        $query = $this->db->get_where( 'employee_list', array( 'id' => $a['user_id'] ) );
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
//                if( md5($row->email) == $a['user_code'] ){
                    $data = array(
                        'emp_pass' => md5( $a['npass'] )
                    );

                    $this->db->where( 'id', $a['user_id'] );
                    $this->db->update( 'employee_list', $data );
                    return 'Password Changed';
//                }else{
//                    return 'Invalid code!';
//                }
            }
        }else{
            return 'not registered';
        }

    }

    function upd_pass_prof( $a ){
        $data = array(
            'emp_pass' => md5( $a['npass'] )
        );

        $this->db->where( 'emp_id', $this->session->userdata( 'sess_id' ) );
        $this->db->update( 'employee_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'changed';
        }else{
            return 'failed';
        }
    }
//transfered to custom_model
//    function update_profile( $a = null ){
//        if($a == null){
//            $data = array(
//                'img_loc' => $a
//            );
//            $this->db->where( 'emp_id', $this->session->userdata('sess_id') );
//            $this->db->update( 'employee_list', $data );
//        }
//    }
//
//    public function test(){
//        return 'test1';
//    }

//do
    function upload_attachment( $form_values, $file_location ){
        $data = array(
            'do_contract_no' => $form_values['do_number'],
            'do_location' => $file_location
        );
        $this->db->where( 'jo_id', $form_values['do_joid'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }

    }

    function del_do( $a ){
        $data = array(
            'do_contract_no' => NULL,
            'do_location' => NULL
        );
        $this->db->where( 'jo_id', $a['jo_id'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }
    }

//price
    function update_price( $a ){
        $data = array(
            'total_price' => $a['rem_text']
        );
        $this->db->where( 'jo_id', $a['rem_joid'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }
    }

//bill
    function upload_attachment_bill( $form_values, $file_location ){
        $data = array(
            'billed_date' => $form_values['bill_date'].','.$form_values['bill_number'],
            'bill_location' => $file_location
        );
        $this->db->where( 'jo_id', $form_values['bill_joid'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }

    }

    function upload_attachment_bill_u( $form_values, $file_location = null ){
        if( $file_location != null){
            $data = array(
                'billed_date' => $form_values['bill_date_u'].','.$form_values['bill_number_u'],
                'bill_location' => $file_location
            );
        }else{
            $data = array(
                'billed_date' => $form_values['bill_date_u'].','.$form_values['bill_number_u'],
            );
        }

        $this->db->where( 'jo_id', $form_values['bill_joid_u'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }

    }

    function del_bd( $a ){
        $data = array(
            'billed_date' => NULL,
            'bill_location' => NULL
        );
        $this->db->where( 'jo_id', $a['jo_id'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }
    }

//ce
    function upload_attachment_ce( $form_values, $file_location ){
        $data = array(
            'ce_number' => $form_values['ce_number'],
            'ce_location' => $file_location
        );
        $this->db->where( 'jo_id', $form_values['ce_joid'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }

    }

    function del_ce( $a ){
        $data = array(
            'ce_number' => NULL,
            'ce_location' => NULL
        );
        $this->db->where( 'jo_id', $a['jo_id'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }
    }
//paid
    function upload_attachment_paid( $form_values ){
        $data = array(
            'paid_date' => $form_values['paid_datepicker'],
            'paid_location' => $form_values['paid_color']
        );
        $this->db->where( 'jo_id', $form_values['paid_joid'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }

    }

    function del_paid( $a ){
        $data = array(
            'paid_date' => NULL,
            'paid_location' => NULL
        );
        $this->db->where( 'jo_id', $a['jo_id'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }
    }

    function update_trans( $a ){
        $data = array(
            'transmittal' => $a['trans_date']
        );
        $this->db->where( 'jo_id', $a['jo_id'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }
    }

    function update_cono( $a ){
        $arr_cono = array();

        $this->db->select( 'contract_no' );
        $this->db->from( 'job_order_list' );
        $this->db->where( 'jo_id', $a['jo_id'] );
        $this->db->order_by("jo_id", "desc");
        $query = $this->db->get();
//        if ($query->num_rows() > 0) {


            foreach ($query->result() as $row) {
                if( $row->contract_no ){
                    $query_jo = $this->db->get_where('job_order_list', array('jo_id' => $a['jo_id']));
                    $row_jo = $query_jo->row();
//                    foreach($query_jo->result() as $row_jo){
                        $arr_cono = explode( ',', $row_jo->contract_no );
                        if (!in_array($a['cono'], $arr_cono))
                        {
                            array_push( $arr_cono, $a['cono'] );
                        }
//                    }
                }else{
                    array_push( $arr_cono, $a['cono'] );
                }

                $data = array(
                    'contract_no' => implode(',', $arr_cono)
                );
                $this->db->where( 'jo_id', $a['jo_id'] );
                $this->db->update( 'job_order_list', $data );

                if( $this->db->affected_rows() > 0 ){
                    return 'updated';
                }else{
                    return 'failed';
                }
            }
//        }
    }

    function update_payment( $a ){
        $data = array(
            'paid_date' => date("m-d-Y H:i:s"),
            'paid_location' => $a['py']
        );
        $this->db->where( 'jo_id', $a['jo_id'] );
        $this->db->update( 'job_order_list', $data );

        if( $this->db->affected_rows() > 0 ){
            return 'updated';
        }else{
            return 'failed';
        }
    }
}