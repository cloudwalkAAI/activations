<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Get_model extends CI_Model
{
    function get_ae_jo( $empid = '' ){
        $this->db->order_by("jo_id","desc"); 
        $query = $this->db->get( 'job_order_list' );
        return $query->result_array();
//        return false;
//        if( $this->session->userdata('sess_dept') < 2 ){
//            $this->db->order_by("jo_id","desc");
//            $query = $this->db->get_where( 'job_order_list', array( 'emp_id' => $empid ) );
//            return $query->result_array();
//        }elseif( $this->session->userdata('sess_dept') != '2' ){
//            $this->db->order_by("jo_id","desc");
//            $query = $this->db->get( 'job_order_list' );
//            return $query->result_array();
//        }else{
//            return false;
//        }
    }

    function get_ae_jo_query( $empid, $a, $b){
        if( $empid == $this->session->userdata('sess_id') ){
            $query = $this->db->get_where( 'job_order_list', array( 'emp_id' => $empid ), $a, $b );
            return $query->result_array();
        }else{
            return false;
        }
    }

    function get_ae_jo_numrows( $empid ){
        if( $empid == $this->session->userdata('sess_id') ){
            $query = $this->db->get_where( 'job_order_list', array( 'emp_id' => $empid ) );
            return $query->num_rows();
        }else{
            return false;
        }
    }

    function get_ae_jo_details( $jo_id ){
        $arr_tonight = array();

        $this->db->select( 'project_type, client_company_name, brand, project_name' );
        $this->db->from( 'job_order_list' );
        $this->db->where( 'jo_id =', $jo_id );
        $query = $this->db->get();
        $row = $query->row();
        if (isset($row))
        {
            $arr_tonight['jo_id']           = $jo_id;
            $arr_tonight['cont_person']     = $this->get_client_info_jo_edit( $row->client_company_name );
            $arr_tonight['cont_person_id']  = $row->client_company_name;
            $arr_tonight['projtype_check']  = $this->get_project_type2( $row->project_type );
            $arr_tonight['projtype']        = $row->project_type;
            $arr_tonight['brand']           = $row->brand;
            $arr_tonight['brand_check']     = $this->get_brand_list2_jo( $row->client_company_name, $row->brand );

            $arr_tonight['project_name']    = $row->project_name;
        }
        return json_encode( $arr_tonight );
    }

    function get_project_type2( $a ){
        $input_text = '';
        $checked = '';
        $array_brands = array();
        $array_brands = explode(',',$a);
        $i=0;
        $query = $this->db->get( 'project_type' );
        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                if (in_array($row->pt_name, $array_brands)) {
                    $checked = 'checked';
                }else{
                    $checked = '';
                }
                $i++;
                if ($i <= 3) {
                    if($i==1){
                        $input_text .= '
                            <tr>
                                <td><input type="checkbox" name="inp_projtype2[]" id="inp_projtype2" value="' . $row->pt_name . '" '.$checked.'><span> ' . $row->pt_name . '</span></td>
                        ';
                    }else if($i % 3 == 0){
                        $input_text .= '
                                <td><input type="checkbox" name="inp_projtype2[]" id="inp_projtype2" value="' . $row->pt_name . '" '.$checked.'><span> ' . $row->pt_name . '</span></td>
                            </tr>
                        ';
                        $i=0;
                    }else{
                        $input_text .= '
                                <td><input type="checkbox" name="inp_projtype2[]" id="inp_projtype2" value="' . $row->pt_name . '" '.$checked.'><span> ' . $row->pt_name . '</span></td>
                        ';
                    }
                }
            }
        }
        return $input_text;
    }

    function get_brand_list2_jo( $a, $b ){
        $str_brand = '';
        $checked = '';
        $str_brand2 = array();
        $arr_brand = array();
        $i = 0;
        $this->db->select( 'client_id, brand_name' );
        $this->db->from( 'brand' );
        $this->db->where( 'client_id =', $a );
        $query = $this->db->get();
        foreach( $query->result() as $row ){
            $arr_brand = explode(',',$row->brand_name);
            $arr_brand2 = explode(',',$b);
            foreach( $arr_brand as $the_brand ){
                if( $the_brand != null ){
                    if (in_array($the_brand, $arr_brand2)) {
                        $checked = 'checked';
                    }else{
                        $checked = '';
                    }
                    $i++;
                    if ($i <= 3) {
                        if($i==1){
                            $str_brand .= '
                                <tr>
                                    <td><input type="checkbox" name="inp_brand2[]" id="inp_brand2" value="' . $the_brand . '" '.$checked.'><span> ' . $the_brand . '</span></td>
                            ';
                        }else if($i % 3 == 0){
                            $str_brand .= '
                                    <td><input type="checkbox" name="inp_brand2[]" id="inp_brand2" value="' . $the_brand . '" '.$checked.'><span> ' . $the_brand . '</span></td>
                                </tr>
                            ';
                            $i=0;
                        }else{
                            $str_brand .= '
                                    <td><input type="checkbox" name="inp_brand2[]" id="inp_brand2" value="' . $the_brand . '" '.$checked.'><span> ' . $the_brand . '</span></td>
                            ';
                        }
                    }
                }
            }
        }
        return $str_brand;
    }


    function get_client_info_jo_edit( $a ){
        $this->db->select( 'client_id, company_name, contact_person' );
        $this->db->from( 'clients' );
        $this->db->where( 'client_id =', $a );
        $query = $this->db->get();
        $row = $query->row();
        if (isset($row))
        {
            return $row->contact_person;
        }
    }

    function get_ae_jo_w( $id ){
        $jolist_array = array();

        $query = $this->db->get_where( 'job_order_list', array( 'jo_id' => $id ) );

        foreach ($query->result() as $row)
        {
            $str_conoo = '';
            $jolist_array['jo_id'] = $row->jo_id;
            $jolist_array['emp_id'] = $row->emp_id;
            $jolist_array['jo_number'] = $row->jo_number;
            $jolist_array['jo_color'] = $row->jo_color;

            $str_conoo .= '<ul class="no-bullet">';
            foreach( explode(',',$row->contract_no) as $conoo ){
                $str_conoo .= '<li>'.$conoo.'</li>';
            }
            $str_conoo .= '</ul>';

            $jolist_array['contract_no'] = $str_conoo;

            if( !is_null( $row->do_contract_no )){
                $jolist_array['do_contract_no'] = $row->do_contract_no;
            }else{
                $jolist_array['do_contract_no'] = '';
            }

            $jolist_array['project_name'] = $row->project_name;
            $jolist_array['project_type'] = $row->project_type;
            $jolist_array['client_company_name'] = $this->get_company( $row->client_company_name );
            $jolist_array['brand'] = $row->brand;

            if( !is_null( $row->billed_date ) ){
                $jolist_array['billed_date'] = $row->billed_date;
            }else{
                $jolist_array['billed_date'] = '';
            }

            if( !is_null( $row->paid_date ) ){
                $jolist_array['paid_date'] = $row->paid_date;
            }else{
                $jolist_array['paid_date'] = '';
            }

            $jolist_array['emp_info'] = $this->get_employee( $row->emp_id );
            $jolist_array['date_created'] = $row->date_created;
        }

        return json_encode( $jolist_array );
    }

    function get_company($c){
        $this->db->select( 'contact_person' );
        $this->db->from( 'clients' );
        $this->db->where( 'client_id =', $c );
        $query = $this->db->get();
        $row = $query->row();
        if (isset($row))
        {
            return $row->contact_person;
        }
    }

    function get_brand($a){
        $this->db->select( 'brand_name' );
        $this->db->from( 'brand' );
        $this->db->where( 'brand_id =', $a );
        $query = $this->db->get();
        $row = $query->row();
        if (isset($row))
        {
            return $row->brand_name;
        }
    }

    function get_client_list(){
        $this->db->select( 'client_id, company_name, contact_person' );
        $this->db->from( 'clients' );
        $this->db->group_by( 'company_name' );
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_brand_list( $a ){
        $str_brand = '';
        $arr_brand = array();
        $i = 0;
        $this->db->select( 'client_id, brand_name' );
        $this->db->from( 'brand' );
        $this->db->where( 'client_id =', $a );
        $query = $this->db->get();
        foreach( $query->result() as $row ){
            $arr_brand = explode(',',$row->brand_name);
            foreach( $arr_brand as $the_brand ){

                if( $the_brand != null ){
                    $i++;
                    if ($i <= 3) {
                        if($i==1){
                            $str_brand .= '
                                <tr>
                                    <td><input type="checkbox" name="inp_brand[]" id="inp_brand" value="' . $the_brand . '"><span> ' . $the_brand . '</span></td>
                            ';
                        }else if($i % 3 == 0){
                            $str_brand .= '
                                    <td><input type="checkbox" name="inp_brand[]" id="inp_brand" value="' . $the_brand . '"><span> ' . $the_brand . '</span></td>
                                </tr>
                            ';
                            $i=0;
                        }else{
                            $str_brand .= '
                                    <td><input type="checkbox" name="inp_brand[]" id="inp_brand" value="' . $the_brand . '"><span> ' . $the_brand . '</span></td>
                            ';
                        }
                    }
                }
            }
        }
        return $str_brand;
    }

    function get_brand_list2( $a ){
        $str_brand = '';
        $arr_brand = array();
        $i = 0;
        $this->db->select( 'client_id, brand_name' );
        $this->db->from( 'brand' );
        $this->db->where( 'client_id =', $a );
        $query = $this->db->get();
        foreach( $query->result() as $row ){
            $arr_brand = explode(',',$row->brand_name);
            foreach( $arr_brand as $the_brand ){
                if( $the_brand != null ){
                    $i++;
                    if ($i <= 3) {
                        if($i==1){
                            $str_brand .= '
                                <tr>
                                    <td><input type="checkbox" name="inp_brand2[]" id="inp_brand2" value="' . $the_brand . '"><span> ' . $the_brand . '</span></td>
                            ';
                        }else if($i % 3 == 0){
                            $str_brand .= '
                                    <td><input type="checkbox" name="inp_brand2[]" id="inp_brand2" value="' . $the_brand . '"><span> ' . $the_brand . '</span></td>
                                </tr>
                            ';
                            $i=0;
                        }else{
                            $str_brand .= '
                                    <td><input type="checkbox" name="inp_brand2[]" id="inp_brand2" value="' . $the_brand . '"><span> ' . $the_brand . '</span></td>
                            ';
                        }
                    }
                }
            }
        }
        return $str_brand;
    }

    function get_employee( $id ){
        $this->db->select( 'first_name, sur_name, middle_name, img_loc' );
        $this->db->from('employee_list');
        $this->db->where('emp_id =', $id);
        $query = $this->db->get();
        return $query->result_array();
    }

    function get_emp_list(){
        $this->db->order_by("id","desc");
        $query = $this->db->get('employee_list');
        return $query->result_array();
    }

    function get_emp_list_full(){
        $fulllist = array();
        $dept_str = '';
        $post_str = '';
        $string_to_be_pushed = '';
        $query = $this->db->get('employee_list');
//        return $query->result_array();
        foreach ($query->result() as $row) {

            $dept_str = $this->get_where_departments( $row->department );
            $post_str = $this->get_where_positions( $row->position );

            $birthDate = explode("/", $row->birth_date);

            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                ? ((date("Y") - $birthDate[2]) - 1)
                : (date("Y") - $birthDate[2]));

            $string_to_be_pushed = '
                <tr>
                    <td><a class="load_emp" href="javascript:void(0)" data-id="' . $row->id . '">' . $row->emp_id . '</a></td>
                    <td>' . $row->sur_name . '</td>
                    <td>' . $row->first_name . '</td>
                    <td>' . $dept_str . '</td>
                    <td>' . $post_str . '</td>
                    <td>' . $row->birth_date . '</td>
                    <td>' . $age . '</td>
                    <td>' . $row->status . '</td>
                </tr>
            ';

            array_push($fulllist, $string_to_be_pushed);
        }

        return json_encode( $fulllist );
    }

    function get_departments(){
        $this->db->order_by("department_name","asc");
        $query = $this->db->get('departments');
        return $query->result_array();
    }

    function get_where_departments( $a ){
        $this->db->select( 'department_name' );
        $this->db->from( 'departments' );
        $this->db->where( 'dept_id =', $a );
        $query = $this->db->get();
        $row = $query->row();
        if (isset($row))
        {
            return $row->department_name;
        }
    }

    function get_positions(){
        $query = $this->db->get('positions');
        return $query->result_array();
    }

    function get_where_positions( $a ){
        $this->db->select( 'position_name' );
        $this->db->from( 'positions' );
        $this->db->where( 'position_id =', $a );
        $query = $this->db->get();
        $row = $query->row();
        if (isset($row))
        {
            return $row->position_name;
        }
    }

    function get_employee_full_info( $id ){

        $emp_array = array();
        $this->db->select( 'emp_id, sur_name, first_name, department, position, birth_date, status, email, middle_name, role_type, img_loc' );
        $this->db->from('employee_list');
        $this->db->where('id =', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $emp_array['id'] = $id;
            $emp_array['eid'] = $row->emp_id;
            $emp_array['sur_name'] = $row->sur_name;
            $emp_array['first_name'] = $row->first_name;
            $emp_array['department'] = $this->get_where_departments( $row->department );
            $emp_array['position'] = $this->get_where_positions( $row->position );
            $emp_array['birth_date'] = $row->birth_date;
            $emp_array['email'] = $row->email;
            $emp_array['middle_name'] = $row->middle_name;
            $emp_array['role_type'] = $row->role_type;
            $emp_array['img_loc'] = $row->img_loc;

            $birthDate = explode("/", $row->birth_date);

            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                ? ((date("Y") - $birthDate[2]) - 1)
                : (date("Y") - $birthDate[2]));

            $emp_array['age'] = $age;
            $emp_array['status'] = $row->status;
        }

        return json_encode( $emp_array );

    }

    function get_employee_info( $id ){

        $emp_array = array();

        $this->db->select( 'id, emp_id, role_type, email, middle_name, sur_name, first_name, department, position, birth_date, status, img_loc' );
        $this->db->from('employee_list');
        $this->db->where('id =', $id);
        $query = $this->db->get();

        foreach ($query->result() as $row) {
            $emp_array['eeid'] = $row->id;
            $emp_array['eid'] = $row->emp_id;
            $emp_array['role'] = $row->role_type;
            $emp_array['email'] = $row->email;
            $emp_array['middle_name'] = $row->middle_name;
            $emp_array['sur_name'] = $row->sur_name;
            $emp_array['first_name'] = $row->first_name;
            $emp_array['department'] = $row->department;
            $emp_array['position'] = $row->position;
            $emp_array['birth_date'] = $row->birth_date;

            $birthDate = explode("/", $row->birth_date);

            $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                ? ((date("Y") - $birthDate[2]) - 1)
                : (date("Y") - $birthDate[2]));

            $emp_array['age'] = $age;
            $emp_array['img_loc'] = $row->img_loc;
            $emp_array['status'] = $row->status;
        }

        return json_encode( $emp_array );

    }

    function get_last_mom( $joid ){
        $last_mom_arr = array();

        $this->db->select( '*' );
        $this->db->from( 'mom_list' );
        $this->db->where( 'jo_id', $joid);
        $this->db->order_by("date_created","desc");
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
                $last_mom_arr['attend'] = $row->attendees;
                $last_mom_arr['agenda'] = $row->agenda;
                $last_mom_arr['date'] = $row->mom_date;
                $last_mom_arr['time'] = $row->mom_time;
                $last_mom_arr['location'] = $row->location;
                $last_mom_arr['what'] = $row->what;
                $last_mom_arr['what_notes'] = $row->what_add_notes;
                $last_mom_arr['when'] = $row->when;
                $last_mom_arr['when_notes'] = $row->when_add_notes;
                $last_mom_arr['where'] = $row->where;
                $last_mom_arr['where_notes'] = $row->where_add_notes;
                $last_mom_arr['guest'] = $row->expected_guest;
                $last_mom_arr['campaign'] = $row->campaign_text;
                $last_mom_arr['act_flow'] = $row->act_flow_text;
                $last_mom_arr['details'] = $row->other_details;
                $last_mom_arr['steps'] = $row->nsd;
                $last_mom_arr['dc'] = $row->date_created;
            }
        }
        return json_encode( $last_mom_arr );
    }

    function get_last_mvrf( $joid ){
        $last_mvrf_arr = array();

        $this->db->select( 'contents' );
        $this->db->from( 'mvrf' );
        $this->db->where( 'jo_id', $joid);
        $this->db->order_by("date_created","desc");
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
                $last_mvrf_arr['content'] = $row->contents;
            }
        }
        return json_encode( $last_mvrf_arr );
    }

    function get_last_other( $joid ){
        $last_other_arr = array();

        $this->db->select( 'text' );
        $this->db->from( 'jo_other' );
        $this->db->where( 'jo_id', $joid);
        $this->db->order_by("date_created","desc");
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
                $last_other_arr['texts'] = $row->text;
            }
        }
        return json_encode( $last_other_arr );
    }

    function get_last_setup( $joid ){
        $last_setup_arr = array();

        $this->db->select( 'contents_setup' );
        $this->db->from( 'set_up_details' );
        $this->db->where( 'jo_id', $joid);
        $this->db->order_by("date_created","desc");
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
                $last_setup_arr['contents'] = $row->contents_setup;
            }
        }
        return json_encode( $last_setup_arr );
    }

    function get_last_ed( $joid ){
        $last_ed_arr = array();

        $this->db->select( '*' );
        $this->db->from( 'event_detail_list' );
        $this->db->where( 'jo_id', $joid);
        $this->db->order_by("date_created","desc");
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
                $last_ed_arr['wt'] = $row->what;
                $last_ed_arr['wtad'] = $row->what_add_notes;
                $last_ed_arr['wn'] = $row->when;
                $last_ed_arr['wnad'] = $row->when_add_notes;
                $last_ed_arr['we'] = $row->where;
                $last_ed_arr['weadd'] = $row->where_add_notes;
                $last_ed_arr['expected'] = $row->expected_guest;
                $last_ed_arr['espec'] = $row->event_specification;
                $last_ed_arr['dc'] = $row->date_created;
            }
        }
        return json_encode( $last_ed_arr );
    }

    function get_mom_date_list( $joid ){/*mmm*/
        $last_mom_arr = array();

        $this->db->select( 'mom_id, date_created' );
        $this->db->from( 'mom_list' );
        $this->db->where( 'jo_id', $joid);
        $this->db->order_by("date_created","desc");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $last_mom_arr[$row->mom_id] = $row->date_created;
        }

        return json_encode( $last_mom_arr );
    }

    function get_setup_date_list( $joid ){/*mmm*/
        $last_setup_arr = array();

        $this->db->select( 'setup_id, date_created' );
        $this->db->from( 'set_up_details' );
        $this->db->where( 'jo_id', $joid);
        $this->db->order_by("date_created","desc");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $last_setup_arr[$row->setup_id] = $row->date_created;
        }

        return json_encode( $last_setup_arr );
    }

    function get_mvrf_dates_list( $joid ){/*mmm*/
        $last_mvrf_arr = array();

        $this->db->select( 'mvrf_id, date_created' );
        $this->db->from( 'mvrf' );
        $this->db->where( 'jo_id', $joid);
        $this->db->order_by("date_created","desc");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $last_mvrf_arr[$row->mvrf_id] = $row->date_created;
        }

        return json_encode( $last_mvrf_arr );
    }

    function get_other_dates_list( $joid ){/*mmm*/
        $last_other_arr = array();

        $this->db->select( 'other_id, date_created' );
        $this->db->from( 'jo_other' );
        $this->db->where( 'jo_id', $joid);
        $this->db->order_by("date_created","desc");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $last_other_arr[$row->other_id] = $row->date_created;
        }

        return json_encode( $last_other_arr );
    }

    function get_mimutes( $moid ){
        $query = $this->db->get_where( 'mom_list', array( 'mom_id' => $moid ) );
        return json_encode( $query->result() );
    }

    function get_mimutes_ed( $edid ){
        $query = $this->db->get_where( 'event_detail_list', array( 'ed_id' => $edid ) );
        echo json_encode( $query->result() );
    }

    function get_mimutes_setup( $setupid ){
        $query = $this->db->get_where( 'set_up_details', array( 'setup_id' => $setupid ) );
        echo json_encode( $query->result() );
    }

    function get_mimutes_mvrf( $mvrfid ){
        $query = $this->db->get_where( 'mvrf', array( 'mvrf_id' => $mvrfid ) );
        echo json_encode( $query->result() );
    }

    function get_list_attachment( $atachid ){
        $query = $this->db->get_where( 'project_attachments', array( 'jo_id' => $atachid ) );
        return json_encode( $query->result() );
    }

    function get_detail_dates_list( $joid ){
        $last_ed_arr = array();

        $this->db->select( 'ed_id, date_created' );
        $this->db->from( 'event_detail_list' );
        $this->db->where( 'jo_id', $joid);
        $this->db->order_by("date_created","desc");
        $query = $this->db->get();
        foreach ($query->result() as $row) {
            $last_ed_arr[$row->ed_id] = $row->date_created;
        }

        return json_encode( $last_ed_arr );
    }

    function get_setup_dates_list( $a ){
//        $query = $this->db->get_where( 'mom_list', array( 'mom_id' => $moid ) );
//        return json_encode( $query->result() );
    }

//    function get_mvrf_dates_list( $a ){
//        $query = $this->db->get_where( 'mom_list', array( 'mom_id' => $moid ) );
//        return json_encode( $query->result() );
//    }

//    function get_other_dates_list( $a ){
//        $query = $this->db->get_where( 'mom_list', array( 'mom_id' => $moid ) );
//        return json_encode( $query->result() );
//    }

    function emp_info( $a ){
        $this->db->select( 'emp_id, email, contact_nos, first_name, sur_name, middle_name, img_loc' );
        $this->db->from( 'employee_list' );
        $this->db->where( 'emp_id', $a);
        $query = $this->db->get();
        return json_encode( $query->result() );
    }

    function emp_jo_count( $a ){
        $query = $this->db->get_where( 'job_order_list', array( 'emp_id' => $a ) );
        return $query->num_rows();
    }

    function emp_last_task_off( $a ){
        $this->db->select( 'project_name' );
        $this->db->from( 'job_order_list' );
        $this->db->where( 'emp_id', $a );
        $this->db->order_by("jo_id","desc");
        $this->db->offset(1);
        $this->db->limit(2);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
                return $row->project_name;
            }
        }
    }

    function emp_last_task( $a ){
        $this->db->select( 'project_name' );
        $this->db->from( 'job_order_list' );
        $this->db->where( 'emp_id', $a );
        $this->db->order_by("jo_id","desc");
        $this->db->limit(1);
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            $row = $query->row();
            if (isset($row)) {
                return $row->project_name;
            }
        }

    }

    function get_client( $id ){
        $clientlist_array = array();

        $query = $this->db->get_where( 'clients', array( 'client_id' => $id ) );

        foreach ($query->result() as $row)
        {
            $clientlist_array['client_id'] = $row->jo_id;
            $clientlist_array['jo_number'] = $row->jo_number;

            if( !is_null( $row->do_contract_no )){
                $jolist_array['do_contract_no'] = $row->do_contract_no;
            }else{
                $jolist_array['do_contract_no'] = '';
            }

            $jolist_array['project_name'] = $row->project_name;
            $jolist_array['project_type'] = $row->project_type;
            $jolist_array['client_company_name'] = $this->get_company( $row->client_company_name );
            $jolist_array['brand'] = $this->get_brand( $row->brand );

            if( !is_null( $row->billed_date ) ){
                $jolist_array['billed_date'] = $row->billed_date;
            }else{
                $jolist_array['billed_date'] = '';
            }

            if( !is_null( $row->paid_date ) ){
                $jolist_array['paid_date'] = $row->paid_date;
            }else{
                $jolist_array['paid_date'] = '';
            }

            $jolist_array['emp_info'] = $this->get_employee( $row->emp_id );
            $jolist_array['date_created'] = $row->date_created;
        }

        return json_encode( $jolist_array );
    }

    function get_added_client( $client_id ){
        // $this->db->select( 'client_id, company_name, contact_person' );
        // $this->db->from( 'clients' );
        $this->db->where( 'client_id', $client_id );
        $this->db->order_by("client_id","desc");
        $this->db->limit(1);
        $query = $this->db->get('clients');
        if ($query->num_rows() > 0) {
            $row = $query->row_array();
            if (isset($row)) {
				$data['row'] = $row;
				$this->load->view('client_listview',$data);
                // echo '<tr><td><a class="load_client" href="#" alt="'.$row->client_id.'">'.str_pad( $row->client_id, 6, "0", STR_PAD_LEFT ).'</a></td><td>'.$row->company_name.'</td><td>'.$row->contact_person.'</td></tr>';
            }
        }
    }

    function get_load_client_list(){
        // $this->db->select( 'client_id, company_name, contact_person' );
        // $this->db->from( 'clients' );
        $this->db->order_by("client_id","desc");
        $query = $this->db->get('clients');		
        return $query->result_array();
    }

    function get_client_info( $a ){
        $query = $this->db->get_where( 'clients', array( 'client_id' => $a ) );
        return $query->result();
    }

    function get_client_brand( $a ){
        $input_text = '<a href="#" class="add_brand_button_u tiny twidth button">Add Brands</a>';
        $array_brands = array();
        $query = $this->db->get_where( 'brand', array( 'client_id' => $a ) );
        if($query->num_rows() > 0){
            foreach ($query->result() as $row)
            {

                $array_brands = explode(',',$row->brand_name);
                foreach($array_brands as $brand){
                    $input_text .= '<div><input type="text" name="ta_brand[]" value="'.$brand.'"/></div>';
                }
            }
        }
        return $input_text;
    }

    function get_project_type(){
        $input_text = '';
        $array_brands = array();
        $i=0;
        $query = $this->db->get( 'project_type' );
        if($query->num_rows() > 0){
            foreach ($query->result() as $row) {
                $i++;
                if ($i <= 3) {
                    if($i==1){
                        $input_text .= '
                            <tr>
                                <td><input type="checkbox" name="inp_projtype[]" id="inp_projtype" value="' . $row->pt_name . '"><span> ' . $row->pt_name . '</span></td>
                        ';
                    }else if($i % 3 == 0){
                        $input_text .= '
                                <td><input type="checkbox" name="inp_projtype[]" id="inp_projtype" value="' . $row->pt_name . '"><span> ' . $row->pt_name . '</span></td>
                            </tr>
                        ';
                        $i=0;
                    }else{
                        $input_text .= '
                                <td><input type="checkbox" name="inp_projtype[]" id="inp_projtype" value="' . $row->pt_name . '"><span> ' . $row->pt_name . '</span></td>
                        ';
                    }
                }
            }
        }
        return $input_text;
    }

    function check_account( $a, $b ){
        $this->db->select( 'email' );
        $this->db->from( 'employee_list' );
        $this->db->where( 'id', $b );
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();

            if (isset($row)) {

                if( md5($row->email) == $a ){
                    return 'allow';
                }else{
                    return 'not allowed';
                }

            }

        }

    }

    function get_ada_table( $a ){
        $result = "";
        $breaks = array("<br />","<br>","<br/>");

        $this->db->order_by("ad_id","desc");

        if( isset( $a['edaid'] ) ){
            $query = $this->db->get_where( 'event_animation_details', array( 'jo_id' => $a['edaid'] ) );
        }else{
            $query = $this->db->get_where( 'event_animation_details', array( 'jo_id' => $a ) );
        }

        foreach( $query->result() as $row ){
            $text = str_ireplace($breaks, "\r\n", $row->num_of_areas);
            $result .= '
                <tr>
                    <td>'.$row->particulars.'</td>
                    <td>'.$row->target_activity.'</td>
                    <td>'.$row->selling.'</td>
                    <td>'.$row->flyering.'</td>
                    <td>'.$row->survey.'</td>
                    <td>'.$row->experiment.'</td>
                    <td>'.$row->other.'</td>
                    <td>'.$row->target_date.'</td>
                    <td>'.$row->duration.'</td>
                    <td><span title="'.$text.'" aria-describedby="tooltip-ijv27znv5" data-selector="tooltip-ijv27znv5" data-tooltip="" aria-haspopup="true" class="has-tip">More Info</span></td>
                </tr>
            ';
        }
        return $result;
    }

    function get_ada_table_no_info( $a ){
        $result = "";
        $breaks = array("<br />","<br>","<br/>");

        $this->db->order_by("ad_id","desc");

        if( isset( $a['edaid'] ) ){
            $query = $this->db->get_where( 'event_animation_details', array( 'jo_id' => $a['edaid'] ) );
        }else{
            $query = $this->db->get_where( 'event_animation_details', array( 'jo_id' => $a ) );
        }

        foreach( $query->result() as $row ){
            $text = str_ireplace($breaks, "\r\n", $row->num_of_areas);
            $result .= '
                <tr>
                    <td>'.$row->particulars.'</td>
                    <td>'.$row->target_activity.'</td>
                    <td>'.$row->selling.'</td>
                    <td>'.$row->flyering.'</td>
                    <td>'.$row->survey.'</td>
                    <td>'.$row->experiment.'</td>
                    <td>'.$row->other.'</td>
                    <td>'.$row->target_date.'</td>
                    <td>'.$row->duration.'</td>
                </tr>
            ';
        }
        return $result;
    }

    function get_req_table( $a ){
        $result = "";
//        $breaks = array("<br />","<br>","<br/>");

        $this->db->order_by("req_id","desc");

        if( isset( $a['reqid'] ) ){
            $query = $this->db->get_where( 'event_requirement', array( 'jo_id' => $a['reqid'] ) );
        }else{
            $query = $this->db->get_where( 'event_requirement', array( 'jo_id' => $a ) );
        }

        foreach( $query->result() as $row ){
//            $text = str_ireplace($breaks, "\r\n", $row->deliverables);
//            $text1 = str_ireplace($breaks, "\r\n", $row->next_steps);
            $result .= '
                <tr>
                    <td>'.$row->department_name.'</td>
                    <td><span title="'.$row->deliverables.'" aria-describedby="tooltip-ijv27znv5" data-selector="tooltip-ijv27znv5" data-tooltip="" aria-haspopup="true" class="has-tip">Hover for More Info</span></td>
                    <td>'.$row->deadline.'</td>
                    <td><span title="'.$row->next_steps.'" aria-describedby="tooltip-ijv27znv5" data-selector="tooltip-ijv27znv5" data-tooltip="" aria-haspopup="true" class="has-tip">Hover for More Info</span></td>
                    <td style="text-align:center;">
                        <a class="edit-btn-req" href="#" alt="'.$row->req_id.'"><img src="'.base_url("assets/img/logos/Edit.png").'" /></a>
                        <a class="del-btn-req" href="#" alt="'.$row->req_id.'"><img src="'.base_url("assets/img/logos/Delete.png").'" /></a>
                    </td>
                </tr>
            ';
        }
        return $result;
    }

    function get_req_table_v2( $a ){
        $result = "";
//        $breaks = array("<br />","<br>","<br/>");

        $this->db->order_by("req_id","desc");

        if( isset( $a['reqid'] ) ){
            $query = $this->db->get_where( 'event_requirement', array( 'jo_id' => $a['reqid'] ) );
        }else{
            $query = $this->db->get_where( 'event_requirement', array( 'jo_id' => $a ) );
        }

        foreach( $query->result() as $row ){
            $result .= '
                <tr>
                    <td>'.$row->department_name.'</td>
                    <td>'.$row->deliverables.'</td>
                    <td>'.$row->deadline.'</td>
                    <td>'.$row->next_steps.'</td>
                </tr>
            ';
        }
        return $result;
    }

    function get_curp( $a ){
        $this->db->select( 'emp_pass' );
        $this->db->from( 'employee_list' );
        $this->db->where( 'emp_id', $this->session->userdata('sess_id') );
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            $row = $query->row();

            if (isset($row)) {

                if( md5( $a ) == $row->emp_pass ){
                    return 'r';
                }else{
                    return 'e';
                }

            }

        }
    }

    function getlastinsertdate($a){
        $str_dat='';
        $query = $this->db->get_where( 'calendar', array( 'cal_id' => $a ) );
        if($query->num_rows() > 0){
            foreach ($query->result() as $row)
            {
                $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
                foreach($query_emp->result() as $row_emp){
                    $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
                }

                $str_dat= '
                           <tr>
                                <td>'.$str_name.'</td>
                                <td>'.$row->date.'</td>
                                <td>'.$row->data.'</td>
                                <td>
                                    <a href="#" id="task_change" alt="'.$row->cal_id.'">'.
                                        $row->endd.
                                    '</a>
                                </td>
                                <td style="text-align:center;">
                                    <a class="edit-btn-task" href="#" alt="'.$row->cal_id.'">
                                        <img src="'.base_url("assets/img/logos/Edit.png").'" />
                                    </a>
                                    <a class="del-btn-task" href="#" alt="'.$row->cal_id.'">
                                        <img src="'.base_url("assets/img/logos/Delete.png").'" />
                                    </a>
                                </td>
                           </tr>
                           ';
            }
        }
        echo $str_dat;

    }

    function check_date($a){
        $query = $this->db->get_where( 'calendar', array( 'date' => $a ) );
        if ( $query->num_rows() > 0 ) {
            return 'Taken';
        }else{
            return 'notTaken';
        }
    }

    function accounts_get_emp($emp_id){
        $query_ae = $this->db->get_where( 'employee_list', array( 'emp_id' => $emp_id ) );
        if ($query_ae->num_rows() > 0) {
            $row_ae = $query_ae->row();
            if (isset($row_ae)) {
                return '<li style="font-size:12px";>'.$row_ae->sur_name.', '.$row_ae->first_name.' '.$row_ae->middle_name.'</li>';
            }else{
                return false;
            }
        }
    }

    function accounts_get_client( $client_id ){
        $query_ae = $this->db->get_where( 'clients', array( 'client_id' => $client_id ) );
        if ($query_ae->num_rows() > 0) {
            $row_ae = $query_ae->row();
            if (isset($row_ae)) {
                return $row_ae->contact_person;
            }else{
                return false;
            }
        }
    }

    function accounts_jo( $disabler ){
        $str_td_jo = '';
        $str_ae = '';
        $str_do = '';
        $str_bd = '';
        $str_ce = '';
        $str_tp = 0;
        $str_tp_bg = '';
        $str_tp_bg_class = '';
        $shared_arr = array();

        $this->db->select( 'jo_id, 	jo_number, contract_no, emp_id, do_contract_no, do_location, project_name, client_company_name, brand, billed_date, bill_location, paid_date, paid_location, shared_to, total_price, ce_number, ce_location, transmittal' );
        $this->db->from( 'job_order_list' );
        $this->db->order_by("jo_id", "desc");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row)
            {
                $str_con = '';
                $str_ae = '';
                $str_ae .= $this->accounts_get_emp($row->emp_id);

                $shared_arr = explode(",",$row->shared_to);
                foreach ( $shared_arr as $row_share )
                {
                    if( $this->accounts_get_emp($row_share) ){
                        $str_ae .= $this->accounts_get_emp($row_share);
                    }
                }

                if($row->do_contract_no){
                    $str_do = '<a href="'.base_url($row->do_location).'" target="_blank">'.$row->do_contract_no.'</a><a href="#" id="delete_do" alt="'.$row->jo_id.'" style="margin-left:10px;'.$disabler.'" >[x]</a>';
                }else{
                    $str_do = '<button class="button tiny btn_do twidth" alt="'.$row->jo_id.'" style="'.$disabler.'">Do</button>';
                }

                if($row->billed_date){
                    $str_bd = '<a href="'.base_url($row->bill_location).'" target="_blank">'.$row->billed_date.'</a><a href="#" id="delete_bd" alt="'.$row->jo_id.'" style="margin-left:10px;'.$disabler.'" >[x]</a>';
                }else{
                    $str_bd = '<button class="button tiny btn_bd twidth" alt="'.$row->jo_id.'"  style="'.$disabler.'">Invoice</button>';
                }

                if($row->ce_number){
                    $str_ce = '<a href="'.base_url($row->ce_location).'" target="_blank">'.$row->ce_number.'</a><a href="#" id="delete_ce" alt="'.$row->jo_id.'" style="margin-left:10px;'.$disabler.'" >[x]</a>';
                }else{
                    $str_ce = '<button class="button tiny btn_ce twidth" alt="'.$row->jo_id.'"  style="'.$disabler.'">CE</button>';
                }

                if( $row->paid_location == 'Paid' ){
                    $str_pd = '
                        <ul class="no-bullet">
                            <li>
                                <span>'.$row->paid_date.'</span>
                            </li>
                            <li>
                                <button class="button tiny btn_pd twidth alert" alt="'.$row->jo_id.'" value="Unpaid" style="'.$disabler.'">Paid</button>
                            </li>
                        </ul>
                    ';
                }else{
                    $str_pd = '<button class="button tiny btn_pd twidth success" alt="'.$row->jo_id.'" value="Paid" style="'.$disabler.'">Unpaid</button>';
                }

                if($row->transmittal != NULL){
                    $now = time(); // or your date as well
                    $your_date = strtotime( $row->transmittal );
                    $datediff = abs( $now - $your_date );

                    if( floor( $datediff/(60*60*24) ) <= 45 ){
                        $str_tp_bg = 'background-color: green; color:white;';
                    }elseif( ( floor( $datediff/(60*60*24) ) > 45 ) && ( floor( $datediff/(60*60*24) ) <= 60 ) ){
                        $str_tp_bg = 'background-color: yellow; color:black;';
                    }elseif( ( floor( $datediff/(60*60*24) ) > 60 ) && ( floor( $datediff/(60*60*24) ) <= 120 ) ){
                        $str_tp_bg = 'background-color: red; color:white;';
                    }else{
                        $str_tp_bg_class = 'emergency';
                        $str_tp_bg = '';
                    }

                    $str_tp = $row->transmittal.'<br />Day/s Passed '.floor($datediff/(60*60*24)).'<br/><br/><a style="font-size:2rem;" aria-label="Close" alt="'.$row->jo_id.'" class="del_trans">&#215;</a>';
                }else{
                    $str_tp = '<input alt="'.$row->jo_id.'" class="inp_trans" class="twidth" placeholder="Date" style="'.$disabler.'"> <label style="font-size:10px;">press enter to save</label>';
                }

                if($row->contract_no){
                    $str_con .= '<ul class="no-bullet">';
                    foreach( explode(',', $row->contract_no) as $cont ){
                        $str_con .= '
                        <li style="font-size:12px";>
                            '.$cont.'
                        </li>
                        ';
                    }
                    $str_con .= '</ul>';
                    $str_con .= '
                        <input class="inp_contract_no twidth" alt="'.$row->jo_id.'" placeholder="Cont. Num.." style="'.$disabler.'">
                        <span style="font-size:8px;'.$disabler.'">Press Enter to Save</span>
                    ';
                }else{
                    $str_con = '<input class="inp_contract_no twidth" alt="'.$row->jo_id.'" placeholder="Contract No." style="'.$disabler.'">';
                }

                $str_td_jo .= '
                    <tr>
                        <td style="color:'.$row->jo_color.';">'.$row->jo_number.'</td>
                        <td>'.$str_con.'</td>
                        <td>
                            <ul class="no-bullet">
                                '.$str_ae.'
                            </ul>
                        </td>
                        <td>'.$row->project_name.'</td>
                        <td>'.$this->accounts_get_client($row->client_company_name).'</td>
                        <td>'.$row->brand.'</td>
                        <td>'.$str_ce.'</td>
                        <td>'.$str_do.'</td>
                        <td class="'.$str_tp_bg_class.'" align="center" style="text-align: center;'.$str_tp_bg.'">'.$str_tp.'</td>
                        <td>'.$str_bd.'</td>
                        <td>
                            '.$str_pd.'
                        </td>
                        <td>
                            <button class="button tiny btn_rem twidth" value="'.$row->total_price.'" alt="'.$row->jo_id.'" style="'.$disabler.'">Remarks</button>
                        </td>
                    </tr>
                ';

                $str_tp_bg = '';
            }
        }

        return $str_td_jo;
    }

    function dt_calendar( $cal_id ){
        $str_name = '';//test
        $str_ret = '';//test
        $query = $this->db->get_where( 'calendar', array( 'cal_id' => $cal_id ) );
        foreach($query->result() as $row){
            $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
            foreach($query_emp->result() as $row_emp){
                $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
            }

            $str_ret = '<tr><td>'.$str_name.'</td><td>'.$row->date.'</td><td>'.$row->data.'</td><td><a href="#" id="task_change" alt="'.$row->cal_id.'">'.$row->endd.'</a></td><td style="text-align:center;"><a class="edit-btn-task" href="#" alt="'.$row->cal_id.'"><img src="'.base_url("assets/img/logos/Edit.png").'" /></a><a class="del-btn-task" href="#" alt="'.$row->cal_id.'"><img src="'.base_url("assets/img/logos/Delete.png").'" /></a></td></tr>';
        }

        return $str_ret;
    }

    function get_caltask($cal_id){
        $str_name = '';//test
        $arr_ret = array();//test
        $query = $this->db->get_where( 'calendar', array( 'cal_id' => $cal_id ) );
        foreach($query->result() as $row){
            $query_emp = $this->db->get_where('employee_list', array('id' => $row->employee_id));
            foreach($query_emp->result() as $row_emp){
                $str_name = $row_emp->sur_name.', '.$row_emp->first_name.' '.$row_emp->middle_name;
            }
            $arr_ret = array(
                'cal_id' => $cal_id,
                'ename' => $str_name,
                'eid' => $row->employee_id,
                'edate' => $row->date,
                'desc' => $row->data,
                'process' => $row->endd
            );
        }

        return json_encode($arr_ret);
    }
}