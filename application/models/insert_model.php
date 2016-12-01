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

    function email_calendar( $email_a = null, $fullname = null, $joid = null, $details = null){
        // Sender email address
        $this->email->from( 'info@activationsadvertising.com' );
        // Receiver email address.for single email
        $this->email->to( $email_a, $fullname);
        // Subject of email
        $this->email->subject('AAI JO Update');
        // Message in email
        $this->email->message('A task has been assigned to you '.$fullname.' with JO number '.$joid.'.'.$details );
        // It returns boolean TRUE or FALSE based on success or failure
        $this->email->send();

//        echo $this->email->print_debugger();
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

    function insert_jo( $a, $newClient ){
//        print_r(implode(',',$a['inp_projtype']));

        $branding = '';
        $compileIDs = array();
        $compileIDs = json_decode($a['clientsID']);

        $srep = str_replace('\"','',$newClient);
        $srep1 = str_replace('"','',$srep);

        if(isset($compileIDs)){
            array_push($compileIDs,$srep1);
        }

        if( $a['inp_brand'] == null ){
            $branding = $a['inp_brand'];
        }else{
            $branding = implode(',',$a['inp_brand']);
        }

        $insid = 0;
        $data = array(
            'emp_id'                => $this->session->userdata('sess_id'),
            'project_type'          => implode(',',$a['inp_projtype']),
            'client_company_name'   => $a['inp_client'],
            'clientids'             => json_encode($compileIDs),
            'brand'                 => $branding,
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

//            $this->sms_compiler('639464187000','A Job Order has been created please check the Job order list. Thank you!',$insid);

        }

        return $insid;
    }

    function insert_client( $a ){
        $dtarr = json_decode($a);
        $insid= '';
        $i = 0;
//        echo json_encode( $dtarr->inp_contactperson );

        if( json_encode( $dtarr->inp_contactperson ) == '[""]' ){ return false; }

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

            if( $insid == '' ){
                $insid = '"'.$this->db->insert_id().'"';
            }else{
                $insid .= ',"'.$this->db->insert_id().'"';
            }

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
                        $query_emp = $this->db->get_where('job_order_list', array('jo_id' => $insid));
                        foreach($query_emp->result() as $row_jo){
                            $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                            $str_aeinfo = '';

                            $query_aeinfo = $this->db->get_where('employee_list', array('emp_id' => $row_jo->emp_id));
                            foreach($query_aeinfo->result() as $ae_info){
                                $str_aeinfo = $ae_info->sur_name.', '.$ae_info->first_name.' '.$ae_info->middle_name;
                            }

                            $str_details = '
                                <br>
                                <br>
                                Project Name : '.$row_jo->project_name.'<br>
                                Project Type : '.$row_jo->project_type.'<br>
                                AE Assigned : '.$str_aeinfo.'<br>
                                Brand : '.$row_jo->brand.'<br>
                                Created : '.$row_jo->date_created.'<br>
                                Description : '.$row_jo->data.'
                                <br>
                            ';

                            $this->email_calendar($row_emp->email, $str_name, $row_jo->jo_number, $str_details);

//                        $this->sms_compiler_task('639464187000','Calendar has been updated');
//                        $this->sms_compiler_task($row_emp->contact_nos,'Calendar has been updated'); //chikka loaded
                        }
                    }
                }
            }
            return $insid;
        } else {
            return 'exist';
        }
    }

    function hr_update_calendar($calendar){
        $insid = 0;
        $query = $this->db->get_where( 'calendar', array( 'date' => $calendar['hr_deadline'], 'employee_id' => $calendar['hr_dept_id'] , 'jo_id' => $calendar['jo_id'] ) );
        if ($query->num_rows() == 0) {

            $data = array(
                'jo_id'         => $calendar['hr_jo_id'],
                'date'          => $calendar['hr_deadline'],
                'data'          => $calendar['hr_description'],
                'dept_id'       => $calendar['hr_dept_id'],
                'endd'          => 'Pending',
                'employee_id'   => $calendar['sel_hr_emp']
            );

            $this->db->insert('calendar', $data);

            $insid = $this->db->insert_id();

            $query = $this->db->get_where( 'calendar', array( 'cal_id' => $insid ) );
            if($query->num_rows() > 0){
                foreach ($query->result() as $row)
                {
                    $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                    foreach($query_emp->result() as $row_emp){
                        $query_emp = $this->db->get_where('job_order_list', array('jo_id' => $insid));
                        foreach($query_emp->result() as $row_jo){
                            $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                            $str_aeinfo = '';

                            $query_aeinfo = $this->db->get_where('employee_list', array('emp_id' => $row_jo->emp_id));
                            foreach($query_aeinfo->result() as $ae_info){
                                $str_aeinfo = $ae_info->sur_name.', '.$ae_info->first_name.' '.$ae_info->middle_name;
                            }

                            $str_details = '
                                <br>
                                <br>
                                Project Name : '.$row_jo->project_name.'<br>
                                Project Type : '.$row_jo->project_type.'<br>
                                AE Assigned : '.$str_aeinfo.'<br>
                                Brand : '.$row_jo->brand.'<br>
                                Created : '.$row_jo->date_created.'<br>
                                Description : '.$row_jo->data.'
                                <br>
                            ';

                            $this->email_calendar($row_emp->email, $str_name, $row_jo->jo_number, $str_details);

//                        $this->sms_compiler_task('639464187000','Calendar has been updated');
//                        $this->sms_compiler_task($row_emp->contact_nos,'Calendar has been updated'); //chikka loaded
                        }
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
                        $this->email_calendar($row_emp->email, $str_name, $calendar['jo_id']);
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

    function add_venue($a,$targ){
        $str_return = '';

        $data = array(
            'category'      => ucfirst($a['inp_category']),
            'subcategory'   => ucfirst($a['inp_subcategory']),
            'area'          => $a['inp_area'],
            'sub_Area'      => $a['inp_SubArea'],
            'venue'         => ucwords($a['inp_venue']),
            'street'        => $a['inp_street'],
            'lsm'           => $a['inp_lsm'],
            'rate'          => $a['inp_ratesMin'],
            'rate_Max'      => $a['inp_ratesMax'],
            'eft'           => $a['inp_eft'],
            'eft_male'      => $a['inp_eft_male'],
            'eft_female'    => $a['inp_eft_female'],
            'actual_hits'   => $a['inp_achits_m'],
            'actual_hits_f'   => $a['inp_achits_f'],
            'actual_dry_m'   => $a['inp_dry_male'],
            'actual_dry_f'   => $a['inp_dry_female'],
            'actual_exper_m'   => $a['inp_exper_male'],
            'actual_exper_f'   => $a['inp_exper_female'],
            'contact_person'   => $a['inp_cname'],
            'contact_email'   => $a['inp_email'],
            'contact_number'   => $a['inp_phone'],
//            'target_hits'   => $a['inp_tarhits'],
//            'target_hits'   => $a['inp_tarhits'],
            'remarks'       => $a['inp_cmremarks'],
            'u_images'        => $targ
        );

        $this->db->insert( 'cmtuva_location_list', $data );

        $insid = $this->db->insert_id();

        $query = $this->db->get_where( 'cmtuva_location_list', array( 'location_id' => $insid ) );
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $preview = '';
                if( !empty($row->images) ){
                    $preview = '<a href="'.$row->images.'" target="_blank">Preview</a>';
                }
                $str_return = '
                    <tr id="cmt_'.$row->location_id.'">
                        <td>'.ucfirst( $row->category ).'</td>
                        <td>'.ucfirst( $row->subcategory ).'</td>
                        <td>'.ucfirst( $row->area ).'</td>
                        <td>'.ucfirst( $row->sub_Area ).'</td>
                        <td>'.ucfirst( $row->venue ).'</td>
                        <td>'.ucfirst( $row->street ).'</td>
                        <td>'.ucfirst( $row->lsm ).'</td>
                        <td>Php '.$row->rate.'</td>
                        <td>Php '.$row->rate_Max.'</td>
                        <td>'.ucfirst( $row->eft ).'</td>
                        <td>'.ucfirst( $row->eft_male ).'</td>
                        <td>'.ucfirst( $row->eft_female ).'</td>
                        <td>'.ucfirst( $row->actual_hits ).'</td>
                        <td>'.ucfirst( $row->actual_hits_f ).'</td>
                        <td>'.ucfirst( $row->actual_dry_m ).'</td>
                        <td>'.ucfirst( $row->actual_dry_f ).'</td>
                        <td>'.ucfirst( $row->actual_exper_m ).'</td>
                        <td>'.ucfirst( $row->actual_exper_f ).'</td>
                        <td>'.ucfirst( $row->contact_person ).'</td>
                        <td>'.$row->contact_email.'</td>
                        <td>'.ucfirst( $row->contact_number ).'</td>
                        <td>'.$row->remarks.'</td>
                        <td>'.$preview.'</td>
                        <td style="text-align:center;">
                                    <a class="edit-btn-cmtuva" href="#" alt="'.$row->location_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Edit.png").'" /></a>
                        </td>
                        <td><a class="del-btn-cmtuva" href="#" alt="'.$row->location_id.'"><img class="btn-delete-edit-size" src="'.base_url("assets/img/logos/Delete.png").'" /></a></td>
                    </tr>
                ';
            }
            return $str_return;
        }
    }

    function ins_ae_loc($a){

        $dtr = array();
        $dtr = explode(",",$a['cmtuva_sel_area']);

        $data = array(
            'loc_id'        => $a['loc_id'],
            'jo_id'         => $a['jo_id'],
            'venue'         => $a['cmtuva_sel_venue'],
            'area'          => $dtr[0],
            'street'        => $a['cmae_street'],
            'date_start'    => $a['cmtuva_date'],
            'duration'      => $a['cmtuva_duration'],
            'rate'          => $a['cmtuva_rate'],
            'total_rate'    => $a['cmtuva_esp']
        );

        $this->db->insert( 'cmtuva_ae_list', $data );

        $insid = $this->db->insert_id();

        $query = $this->db->get_where( 'cmtuva_ae_list', array( 'cmae_id' => $insid ) );
        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {

                $str_return = '
                    <tr id="cmae_'.$row->cmae_id.'">
                        <td>'.ucfirst( $row->venue ).'</td>
                        <td>'.ucfirst( $dtr[0] ).'</td>
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
            }
            return $str_return;
        }
    }
/*inventory*/
    function add_item_to_inventory( $a = null ){
        $arr_data = array();

        $data = array(
            'item_code'     => $a['inv_code'],
            'item_name'     => $a['inv_name'],
            'description'   => $a['inv_description'],
            'qty'           => $a['inv_qty'],
            'expiration'    => $a['inv_expiration'],
            'date_stored'   => date("m-d-Y H:i:s")
        );

        $query = $this->db->get_where('stocks', array( 'item_code' => $a['inv_code'], 'item_name' => $a['inv_name'] ));

        if( $query->num_rows() == 0 ){
            $this->db->insert( 'stocks', $data );

            $insid_current = $this->db->insert_id();

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
            </tr>
            ';
        }
        return $str_data;
    }

    function table_append_add_item( $a = null, $item_id = null ){
        $data = array(
            'item_id'           => $item_id,
            'sub_description'   => $a['inv_description'],
            'item_qty'          => $a['inv_qty'],
            'process'           => 'add',
            'personel'          => $a['inv_delivered_by'],
            'received_by'       => $a['inv_received_by'],
            'transacted_by'     => $this->session->userdata('sess_surname').', '.$this->session->userdata('sess_firstname').' '.$this->session->userdata('sess_middlename'),
            'transaction_date'  => date("m-d-Y H:i:s")
        );

        $this->db->insert( 'stocks_sub', $data );

//        return $this->db->insert_id();
        return $this->inv_join_tables( $this->db->insert_id() );
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
            $str_add_table = '<tr id="add"'.$row->trans_id.'><td>'.$row->item_code.'</td><td>'.$row->item_name.'</td><td>'.$row->description.'</td><td>'.$row->item_qty.'</td><td>'.$row->expiration.'</td><td>Delivered by : '.$row->personel.'<br> Received by : '.$row->received_by.'<br> Transacted by : '.$row->transacted_by.'</td><td>'.$row->date_stored.'</td></tr>';
        }

        return $str_add_table;
    }

    function deduct_item( $a ){
        $data = array(
            'item_id'           => $a['deduct_select'],
            'jo_id'             => $a['deduct_jo'],
            'received_by'       => $a['deduct_rece'],
            'sub_description'   => $a['deduct_desc'],
            'item_qty'          => $a['deduct_qty'],
            'process'           => 'deduct',
            'deducted_by'       => $this->session->userdata('sess_surname').', '.$this->session->userdata('sess_firstname').' '.$this->session->userdata('sess_middlename'),
            'transacted_by'       => $this->session->userdata('sess_surname').', '.$this->session->userdata('sess_firstname').' '.$this->session->userdata('sess_middlename'),
            'transaction_date'  => date("m-d-Y H:i:s")
        );

        $this->db->insert( 'stocks_sub', $data );

        return $this->inv_join_deduct( $this->db->insert_id() );
    }

    function inv_join_deduct( $tbl_id = null ){
        $str_add_table = '';

        $this->db->select('*'); // Select field
        $this->db->from('stocks_sub'); // from Table1
        $this->db->join('stocks','stocks_sub.item_id = stocks.stock_id','INNER'); // Join table1 with table2 based on the foreign key
        $this->db->where('stocks_sub.trans_id',$tbl_id); // Set Filter
        $res = $this->db->get();

//        return json_encode($res->result());
        $row = $res->row();
//        foreach ( $res->result() as $row ){
            $str_add_table = '<tr id="trans'.$row->trans_id.'"><td>'.$row->item_name.'</td><td>'.$row->jo_id.'</td><td>'.$row->received_by.'</td><td>'.$row->sub_description.'</td><td>'.$row->item_qty.'</td><td>'.$row->deducted_by.'</td><td>'.$row->transaction_date.'</td></tr>';
//        }

        return $str_add_table;
    }

    function return_item_to_inventory( $a ){
        $data = array(
            'item_id'           => $a['returned_select'],
            'received_by'       => $a['return_recieved'],
            'personel'          => $a['return_by'],
            'sub_description'   => $a['return_desc'],
            'item_qty'          => $a['return_qty'],
            'process'           => 'return',
            'transacted_by'     => $this->session->userdata('sess_surname').', '.$this->session->userdata('sess_firstname').' '.$this->session->userdata('sess_middlename'),
            'transaction_date'  => date("m-d-Y H:i:s")
        );

        $this->db->insert( 'stocks_sub', $data );

        if( $this->db->insert_id() > 0 ){
            return $this->return_update($a);
        }
    }

    function return_update( $a ){
        $data = array(
            'qty'          => $a['return_current_stocks']
        );
        $this->db->where( 'stock_id', $a['returned_select'] );
        $this->db->update( 'stocks', $data );

        $arr_date = array();

        $this->db->select('*'); // Select field
        $this->db->from('stocks_sub'); // from Table1
        $this->db->join('stocks','stocks_sub.item_id = stocks.stock_id','INNER');
        $this->db->where('stock_id',$a['returned_select']);
        $query = $this->db->get();

        if($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $arr_date['ori'] = '
                    <tr id="ori'.$row->stock_id.'">
                        <td>'.$row->item_code.'</td>
                        <td>'.$row->item_name.'</td>
                        <td>'.$row->description.'</td>
                        <td>'.$row->qty.'</td>
                        <td>'.$row->expiration.'</td>
                        <td>'.$row->date_stored.'</td>
                    </tr>***'.$row->stock_id.'
                ';
                $arr_date['return_table'] = '
                    <tr id="ret'.$row->stock_id.'">
                        <td>'.$row->item_code.' - '.$row->item_name.'</td>
                        <td>'.$row->personel.'</td>
                        <td>'.$row->received_by.'</td>
                        <td>'.$row->description.'</td>
                        <td>'.$row->item_qty.'</td>
                        <td>'.$row->transaction_date.'</td>
                    </tr>
                ';
            }
        }
        return json_encode($arr_date);
    }
/*end inventory*/

/*hr dashboard*/
    function msave($manpower){
        $r_manp = array();
        $str_table = '';
        $int_table = 0;
        foreach ($manpower['man_name'] as $key=>$value){
            if( !empty($value) && !empty($manpower['man_contact'][$key]) ){
                $data = array(
                    'name'      => $value,
                    'contact'   => $manpower['man_contact'][$key],
                    'agency'    => $manpower['man_agency'],
                    'type'      => $manpower['man_type'][$key],
                    'added_by'  => $this->session->userdata('sess_surname').', '.$this->session->userdata('sess_firstname').' '.$this->session->userdata('sess_middlename'),
                    'added_date'=> date("m-d-Y H:i:s")
                );
                $this->db->insert( 'hr_manpower', $data );
                $int_table += $this->db->insert_id();
            }
            $str_table .= $this->get_manpower_ae_added($this->db->insert_id());
        }
        $r_manp['response'] = $int_table;
        $r_manp['table'] = $str_table;

        echo json_encode($r_manp);
    }

    function get_manpower_ae_added ( $insid = null ){
        $query = $this->db->get_where('hr_manpower', array('manpower_id'=>$insid));
        $row = $query->row();

        return '
            <tr>
                <td>'.$row->name.'</td>
                <td>'.$row->contact.'</td>
                <td>'.$row->type.'</td>
                <td>'.$row->agency.'</td>
            </tr>
        ';
    }
    /*enc hr dashboard*/

    function fill_manpower( $v ){
        $mp_arr = array();
        $mp_arr = explode( ",", $v['inp_hrid'] );
        $str_mpower = '';

        foreach ($mp_arr as $hr_data){
            $query = $this->db->get_where( 'hr_line_up', array( 'manpower_id' => $hr_data, 'jo_id' => $v['inp_hrjoid'] ) );
            if( $query->num_rows() <= 0 ){
                $data = array(
                    'manpower_id'   => $hr_data,
                    'jo_id'         => $v['inp_hrjoid'],
                    'designation'   => $v['inp_designation'],
                    'assigned_by'   => $this->session->userdata('sess_surname').', '.$this->session->userdata('sess_firstname').' '.$this->session->userdata('sess_middlename'),
                    'assigned_date' => date("m-d-Y H:i:s")
                );
                $this->db->insert( 'hr_line_up', $data );

                $str_mpower .= $this->manpower_assigned_table( $this->db->insert_id() );
            }
        }
        return $str_mpower;
    }

    function manpower_assigned_table($ins_id){
        $res = $this->db->get_where('hr_line_up', array('lineup_id'=>$ins_id));
        $row = $res->row();

        $this->db->where('manpower_id',$row->manpower_id);
        $res_manp = $this->db->get('hr_manpower');
        $ret_manp = $res_manp->row();

        return '
        <tr id="manp'.$row->lineup_id.'">
            <td>'.$row->designation.'</td>
            <td>'.$ret_manp->name.'</td>
            <td>'.$ret_manp->contact.'</td>
            <td>'.$ret_manp->type.'</td>
            <td>'.$ret_manp->agency.'</td>
        </tr>
        ';

    }
}