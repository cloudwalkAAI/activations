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
        $data = array(
            'endd' => 'Done'
        );
        $this->db->where( 'cal_id', $cal_id );
        $this->db->update( 'calendar', $data );

        if( $this->db->affected_rows() > 0 ){
            return $cal_id;
        }else{
            return 'failed';
        }
    }

}