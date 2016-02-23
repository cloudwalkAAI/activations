<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {
    function checkuser($account){

        $query = $this->db->get_where('employee_list', array('email' => $account['username'], 'emp_pass' => md5($account['password'])));
        if ($query->num_rows() > 0)
        {

            foreach ($query->result_array() as $user)
            {

                if( $user['status'] == 'Hired' || $user['status'] == 'hired' ){
                    $this->session->set_userdata(array(
                        'sess_id'         => $user['emp_id'],
                        'sess_role'       => $user['role_type'],
                        'sess_email'      => $user['email'],
                        'sess_firstname'  => $user['first_name'],
                        'sess_surname'    => $user['sur_name'],
                        'sess_middlename' => $user['middle_name'],
                        'sess_birth_date' => $user['birth_date'],
                        'sess_status'     => $user['status'],
                        'sess_dept'       => $user['department'],
                        'sess_post'       => $user['position'],
                        'status'          => TRUE
                    ));
                    return 'registered';
                }else{
                    return 'not hired';
                }
            }

        }else{
            return 'unregistered';
        }

    }
}