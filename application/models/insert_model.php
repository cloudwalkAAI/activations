<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Insert_model extends CI_Model
{
    public function __construct() {
        parent::__construct();
        $this->load->model('custom_model');
        $this->load->model('get_model');
        $this->load->model('sms_model');

        /*email*/
        // The mail sending protocol.
        $config['protocol'] = 'smtp';
        // SMTP Server Address for Gmail.
        $config['smtp_host'] = 'mail.cloudwalkdigital.com';
        // SMTP Port - the port that you is required
        $config['smtp_port'] = 26;
        // SMTP Username like. (abc@gmail.com)
        $config['smtp_user'] = 'roel.r@cloudwalkdigital.com';
        // SMTP Password like (abc***##)
        $config['smtp_pass'] = 'Cloud2468';
        $config['mailtype'] = 'html';
        // Load email library and passing configured values to email library
        $this->load->library('email', $config);
    }

    function email_activation( $email_a = null, $fullname = null, $uid = null ){
        // Sender email address
        $this->email->from( 'roel.r@cloudwalkdigital.com' );
        // Receiver email address.for single email
        $this->email->to( $email_a, $fullname);
        // Subject of email
        $this->email->subject('Activations registration!');
        // Message in email
        $this->email->message('Please click the link to enter your password '.base_url('/c?p='.md5($email_a).'&i='.$uid));
        // It returns boolean TRUE or FALSE based on success or failure
        $this->email->send();
    }

    function email_calendar( $email_a = null, $fullname = null){
        // Sender email address
        $this->email->from( 'roel.r@cloudwalkdigital.com' );
        // Receiver email address.for single email
        $this->email->to( $email_a, $fullname);
        // Subject of email
        $this->email->subject('Email Notification!');
        // Message in email
        $this->email->message('Please click the link to enter your password '.base_url('/c?p='.md5($email_a)));
        // It returns boolean TRUE or FALSE based on success or failure
        $this->email->send();
    }

    function sms_compiler( $reciever_number = null, $message = null, $insid = null ){

        $text_array = array(
            'phone_num' => '639464187000', //reciever number
            'msg' => 'A JO has been created with JO ID of '.date("Y").str_pad( $insid, 5, "0", STR_PAD_LEFT ).'.'
        );

         $this->sms_model->sms_send( $text_array );

    }

    function sms_compiler_task( $reciever_number = null, $message = null ){

        $text_array = array(
            'phone_num' => '639464187000', //reciever number
            'msg' => 'Calendar has been updated'
        );

//         $this->sms_model->sms_send( $text_array );

    }

    function insert_jo( $a ){
        $insid = 0;
        $data = array(
            'emp_id'                => $this->session->userdata('sess_id'),
            'project_type'          => implode(',',$a['inp_projtype']),
            'client_company_name'   => $a['inp_client'],
            'brand'                 => implode(',',$a['inp_brand']),
            'project_name'          => $a['inp_projname'],
            'jo_color'              => 'red',
            'date_created'          => date("m-d-Y H:i:s")
        );

        $this->db->insert('job_order_list', $data);

        $insid = $this->db->insert_id();

        if( $this->db->affected_rows() > 0 ) {
            $data_update = array(
                'jo_number' => date("Y").str_pad( $insid, 5, "0", STR_PAD_LEFT )
            );
            $this->db->where('jo_id', $insid);
            $this->db->update('job_order_list', $data_update);

            $this->sms_compiler('639464187000','A Job Order has been created please check the Job order list. Thank you!',$insid);

        }

        return $insid;
    }

    function insert_client( $a ){
        $dtarr = json_decode($a);
        $i = 0;
//        print_r( $dtarr->inp_contactperson[0] );

        foreach( $dtarr->inp_contactperson as $rcount ){
            $data = array(
                'emp_id'                 => $this->session->userdata('sess_id'),
                'company_name'           => $dtarr->inp_companyname,
                'contact_person'         => $dtarr->inp_contactperson[$i],
                'contact_number'         => $dtarr->inp_contactnumber[$i],
                'birth_date'             => $dtarr->inp_birthday[$i],
                'email'                  => $dtarr->inp_email[$i],
                'date_created'           => date("m-d-Y H:i:s")
            );
            $this->db->insert('clients', $data);

            $insid = $this->db->insert_id();

            $data = array(
                'client_id'              => $insid,
                'brand_name'             => implode(',',$dtarr->ta_brand),
                'date_inputted'          => date("m-d-Y H:i:s")
            );

            $this->db->insert('brand', $data);
            $i++;
        }

        return $insid;
    }

    function add_employee( $a ){
        $insid = 0;
        $query = $this->db->get_where( 'employee_list', array( 'email' => $a['inp_email'] ) );
        if ($query->num_rows() <= 0) {
            $data = array(
                'role_type'       => $a['sel_role'],
                'email'           => $a['inp_email'],
                'emp_pass'        => md5('@tivisi0ns'),
                'first_name'      => $a['inp_firstname'],
                'sur_name'        => $a['inp_lastname'],
                'middle_name'     => $a['inp_midname'],
                'birth_date'      => $a['datepicker_emp'],
                'department'      => $a['sel_dept'],
                'position'        => $a['sel_pos'],
                'status'          => $a['sel_status'],
                'date_hired'      => date("m-d-Y"),
                'date_created'    => date("m-d-Y H:i:s")
            );

            $this->db->insert('employee_list', $data);

            $insid = $this->db->insert_id();

            $this->email_activation( $a['inp_email'], $a['inp_firstname'].' '.$a['inp_lastname'], $insid );

            if( $this->db->affected_rows() > 0 ) {
                $data_update = array(
                    'emp_id' => date("Y").str_pad( $insid, 6, "0", STR_PAD_LEFT )
                );
                $this->db->where('id', $insid);
                $this->db->update('employee_list', $data_update);
            }

            return $insid;
        }else{
            return 'exist';
        }


    }

    function save_mom( $a ){
        $data = array(
            'jo_id'             => $a['inp_joid'],
            'attendees'         => $a['inp_mom_attendees'],
            'mom_date'          => $a['inp_mom_date'],
            'location'          => $a['inp_mom_location'],
            'mom_time'          => '',
            'agenda'            => $a['inp_mom_agenda'],
            'what'              => $a['what_text'],
            'what_add_notes'    => $a['what_add'],
            'when'              => $a['when_date'],
            'when_add_notes'    => $a['when_add'],
            'where'             => $a['where_text'],
            'where_add_notes'   => $a['where_add'],
            'expected_guest'    => $a['inp_mom_exp_guest'],
            'campaign_text'     => $a['editor_campaign_overview'],
            'act_flow_text'     => $a['editor_activation_flow'],
            'other_details'     => $a['editor_other_details'],
            'nsd'               => $a['editor_next'],
            'date_created'      => date("Y-m-d H:i:s")
        );

        $this->db->insert('mom_list', $data);

        if( $this->db->affected_rows() > 0 ) {
            echo 'success';
        }else{
            echo 'fail';
        }
    }

    function save_ed( $a ){

        $data = array(

            'jo_id'                 => $a['jo_id'],
            'what'                  => $a['ed_what'],
            'what_add_notes'        => $a['ed_what_add'],
            'when'                  => $a['ed_when_date'],
            'when_add_notes'        => $a['ed_when_add'],
            'where'                 => $a['ed_where_text'],
            'where_add_notes'       => $a['ed_where_add'],
            'expected_guest'        => $a['ed_expected_guest'],
            'event_specification'   => $a['editor_event_spec'],
            'date_created'          => date("Y-m-d H:i:s")

        );

        $this->db->insert('event_detail_list', $data);

        if( $this->db->affected_rows() > 0 ) {
            echo 'success';
        }else{
            echo 'fail';
        }

    }

    function save_mvrf($a){
        $data = array(
            'jo_id'             => $a['mvrfid'],
            'date_created'      => date("Y-m-d H:i:s"),
            'contents'          => $a['ta_mvrf']
        );

        $this->db->insert('mvrf', $data);

        if( $this->db->affected_rows() > 0 ) {
            echo 'success';
        }else{
            echo 'fail';
        }
    }

    function save_other($a){
        $data = array(
            'jo_id'             => $a['otherid'],
            'date_created'      => date("Y-m-d H:i:s"),
            'text'              => $a['ta_Other']
        );

        $this->db->insert('jo_other', $data);

        if( $this->db->affected_rows() > 0 ) {
            echo 'success';
        }else{
            echo 'fail';
        }
    }

    function save_setup($a){
        $data = array(
            'jo_id'             => $a['setupid'],
            'date_created'      => date("Y-m-d H:i:s"),
            'contents_setup'              => $a['setup_particular']
        );

        $this->db->insert('set_up_details', $data);

        if( $this->db->affected_rows() > 0 ) {
            echo 'success';
        }else{
            echo 'fail';
        }
    }

    function save_attachment( $a, $location ){

        $data = array(

            'jo_id'         => $a['attach_jo_id'],
            'file_name'     => str_replace("assets/uploads/","",$location),
            'file_location' => $location,
            'reference_for' => $a['sel_reference'],
            'dept_id'       => $this->session->userdata('sess_dept'),
            'date_uploaded' => date("Y-m-d H:i:s")

        );

        $this->db->insert('project_attachments', $data);

        if( $this->db->affected_rows() > 0 ) {
            $insid = $this->db->insert_id();
            $req_array['dt_id'] = $insid;

            $query = $this->db->get_where( 'project_attachments', array( 'attachment_id' => $insid ) );
            foreach( $query->result() as $row ) {
                if( $row->dept_id == 1 ){
                    $str_trcolor = 'background:#fbfd04';
                }elseif( $row->dept_id == 2 ){
                    $str_trcolor = 'background:#01fafc';
                }elseif( $row->dept_id == 3 ){
                    $str_trcolor = 'background:#02fb00';
                }elseif( $row->dept_id == 5 ){
                    $str_trcolor = 'background:#f805fd';
                }elseif( $row->dept_id == 6 ){
                    $str_trcolor = 'background:#fc0404';
                }elseif( $row->dept_id == 7 ){
                    $str_trcolor = 'background:#0304fc';
                }elseif( $row->dept_id == 8 ){
                    $str_trcolor = 'background:#5d00e4';
                }elseif( $row->dept_id == 9 ){
                    $str_trcolor = 'background:#0b2e96';
                }elseif( $row->dept_id == 10 ){
                    $str_trcolor = 'background:#fbe8ea';
                }

                $req_array['dt_table'] = '
                    <tr style="'.$str_trcolor.' !important" id="att_pro'.$row->attachment_id.'">
                        <td>'.$row->date_uploaded.'</td>
                        <td>'.$row->file_name.'</td>
                        <td>'.$row->reference_for.'</td>
                        <td><a style="'.$str_trcolor.' !important" href="'.base_url( $row->file_location ).'" target="_blank">Download</td>
                    </tr>
                ';
            }
            return json_encode( $req_array );
        }else{
            echo 'fail';
        }

    }

    function save_ed_animation( $a ){
        $data = array(
            'jo_id'             => $a['eda_joid'],
            'particulars'       => $a['eda_particulars'],
            'target_activity'   => $a['eda_activity'],
            'target_schedule'   => $a['eda_sched'],
            'selling'           => $a['eda_sell'],
            'flyering'          => $a['eda_fly'],
            'survey'            => $a['eda_survey'],
            'experiment'        => $a['eda_experiment'],
            'other'             => $a['eda_other'],
            'target_date'       => $a['eda_datepicker'],
            'duration'          => $a['eda_duration'],
            'num_of_areas'      => nl2br($a['editor_detail']),
            'date_created'      => date("Y-m-d H:i:s")
        );

        $this->db->insert('event_animation_details', $data);

        if( $this->db->affected_rows() > 0 ) {
            echo $a['eda_joid'];
        }else{
            echo 'fail';
        }
    }

    function save_ed_req( $a ){
        $data = array(
            'jo_id'             => $a['rq_joid'],
            'department_name'   => $a['rq_dept'],
            'deliverables'      => nl2br($a['editor_req']),
            'deadline'          => $a['rq_deadline'],
            'next_steps'        => nl2br($a['editor_ns']),
            'date_created'      => date("Y-m-d H:i:s")
        );

        $this->db->insert( 'event_requirement', $data );

        if( $this->db->affected_rows() > 0 ) {
            echo $a['rq_joid'];
        }else{
            echo 'fail';
        }
    }

    function insert_protype( $a ){
        $data = array(
            'pt_name'             => ucfirst($a),
            'date_inputted'      => date("Y-m-d H:i:s")
        );

        $this->db->insert( 'project_type', $data );

        if( $this->db->affected_rows() > 0 ) {
            echo $a;
        }else{
            echo 'fail';
        }
    }

    function creative_update_calendar($calendar){
        $insid = 0;
        $query = $this->db->get_where( 'calendar', array( 'date' => $calendar['deadline'], 'employee_id' => $calendar['dept_id'] , 'jo_id' => $calendar['jo_id'] ) );
        if ($query->num_rows() == 0) {

            $data = array(
                'jo_id'         => $calendar['jo_id'],
                'date'          => $calendar['deadline'],
                'data'          => $calendar['description'],
                'dept_id'       => $calendar['dept_id'],
                'endd'          => 'Pending',
                'employee_id'   => $calendar['sel_creatives_emp']
            );

            $this->db->insert('calendar', $data);

            $insid = $this->db->insert_id();

            $query = $this->db->get_where( 'calendar', array( 'cal_id' => $insid ) );
            if($query->num_rows() > 0){
                foreach ($query->result() as $row)
                {
                    $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                    foreach($query_emp->result() as $row_emp){
                        $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                        $this->email_calendar($row_emp->email, $str_name);
//                        $this->email_calendar('chabi050613@gmail.com', $str_name);

//                        $this->sms_compiler_task('639464187000','Calendar has been updated');
//                        $this->sms_compiler_task($row_emp->contact_nos,'Calendar has been updated'); //chikka loaded
                    }

                }
            }
            return $insid;
        } else {
            return 'exist';
        }
    }

    function submit_date_calendar_prod( $calendar, $target = null ){
        $insid = 0;
        $query = $this->db->get_where( 'calendar', array( 'date' => $calendar['deadline'], 'employee_id' => $calendar['dept_id'] , 'jo_id' => $calendar['jo_id'] ) );
        if ($query->num_rows() == 0) {

            $data = array(
                'jo_id'         => $calendar['jo_id'],
                'date'          => $calendar['prod_deadline'],
                'data'          => $calendar['prod_description'],
                'dept_id'       => $this->session->userdata('sess_dept'),
                'peg'           => $target,
                'size'          => $calendar['prod_size'],
                'qty'           => $calendar['prod_qty'],
                'other_details' => $calendar['prod_other_details'],
                'prod_type'     => $calendar['sel_prod_type'],
                'print_prod'    => json_encode($calendar['chk_prod']),
                'endd'          => 'Pending',
                'employee_id'   => $calendar['sel_prod_emp']
            );

            $this->db->insert('calendar', $data);

            $insid = $this->db->insert_id();

            $query = $this->db->get_where( 'calendar', array( 'cal_id' => $insid ) );
            if($query->num_rows() > 0){
                foreach ($query->result() as $row)
                {
                    $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                    foreach($query_emp->result() as $row_emp){
                        $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                        $this->email_calendar($row_emp->email, $str_name);
//                        $this->email_calendar('chabi050613@gmail.com', $str_name);

//                        $this->sms_compiler_task('639464187000','Calendar has been updated');
//                        $this->sms_compiler_task($row_emp->contact_nos,'Calendar has been updated'); //chikka loaded
                    }

                }
            }
            return $insid;
        } else {
            return 'exist';
        }
    }

    function createDateRangeArray($strDateFrom,$strDateTo)
    {
        // takes two dates formatted as YYYY-MM-DD and creates an
        // inclusive array of the dates between the from and to dates.

        // could test validity of dates here but I'm already doing
        // that in the main script

        $aryRange=array();

        $iDateFrom=mktime(1,0,0,substr($strDateFrom,5,2),substr($strDateFrom,8,2),substr($strDateFrom,0,4));
        $iDateTo=mktime(1,0,0,substr($strDateTo,5,2),substr($strDateTo,8,2),substr($strDateTo,0,4));

        if ($iDateTo>=$iDateFrom)
        {
            array_push($aryRange,date('Y-m-j',$iDateFrom)); // first entry
            while ($iDateFrom<$iDateTo)
            {
                $iDateFrom+=86400; // add 24 hours
                array_push($aryRange,date('Y-m-j',$iDateFrom));
            }
        }
        return $aryRange;
    }
}