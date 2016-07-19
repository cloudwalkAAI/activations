<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Cal_model extends CI_Model {

    var $conf;

    function Cal_model (){

        $this->conf = array(
            'start_day' => 'monday',
            'show_next_prev' => true,
            'day_type'     => 'short',
            'next_prev_url' => base_url() . 'home/index'
        );

        $this->conf['template']='
                 {table_open}<table border="0" cellpadding="0" cellspacing="0" class="calendar twidth">{/table_open}

           {heading_row_start}<tr   >{/heading_row_start}

           {heading_previous_cell}<th><a href="{previous_url}"><img src="'.base_url('assets/img/calendar/left_arrow.png').'" alt=""></a></th>{/heading_previous_cell}
           {heading_title_cell}<th style="text-align: center; color: #2a91dc; font-size: 27px;"  colspan="{colspan}">{heading}</th>{/heading_title_cell}
           {heading_next_cell}<th style="text-align: right;"><a href="{next_url}"><img src="'.base_url('assets/img/calendar/right_arrow.png').'" alt=""></a></th>{/heading_next_cell}

           {heading_row_end}</tr>{/heading_row_end}

           {week_row_start}<tr>{/week_row_start}
           {week_day_cell}<td style="color: #a8a9ad;">{week_day}</td>{/week_day_cell}
           {week_row_end}</tr>{/week_row_end}

           {cal_row_start}<tr class="days">{/cal_row_start}
           {cal_cell_start}<td class="day">{/cal_cell_start}

           {cal_cell_content}
               <div class="day_num" >{day}</div>
               <div class="content" style="height: 75%;color:#f27f22;">{content}</div>
           {/cal_cell_content}
               {cal_cell_content_today}
               <div class="day_num highlight">{day}</div>
               <div class="content">{content}</div>
           {/cal_cell_content_today}

           {cal_cell_no_content}<div class="day_num">{day}</div>{/cal_cell_no_content}
           {cal_cell_no_content_today}<div class="day_num highlight">{day}</div>
           {/cal_cell_no_content_today}

           {cal_cell_blank}&nbsp;{/cal_cell_blank}

           {cal_cell_end}</td>{/cal_cell_end}
           {cal_row_end}</tr>{/cal_row_end}

           {table_close}</table>{/table_close}
           ';

    }

    function get_calendar_data($year, $month){

        $query = $this->db->select('jo_id, date, data, employee_id, endd')->from('calendar')
            ->like('date', "$year-$month", 'after')->where('endd','Pending')->where('dept_id',$this->session->userdata('sess_dept'))->get();

        $cal_data = array();

        foreach ( $query->result() as $row ) {
            $str_joname = '';
            $str_empname = '';
            $str_assigned = '';
            $str_color = '';
            $str_joid = 0;

            $query_jo = $this->db->select('project_name,jo_number,emp_id,jo_color')->from('job_order_list')
                ->like('jo_id', "$row->jo_id", 'after')->get();
            foreach ($query_jo->result()as $row_jo) {
                $str_joname = $row_jo->project_name;
                $str_joid = $row_jo->jo_number;
                $str_color = $row_jo->jo_color;

                    $query_emp = $this->db->select('first_name,sur_name')->from('employee_list')
                        ->like('emp_id', "$row_jo->emp_id", 'after')->get();
                    foreach ($query_emp->result()as $row_emp) {
                        $str_empname = $row_emp->sur_name.', '.$row_emp->sur_name;
                    }

            }

            $query_assigned = $this->db->get_where( 'employee_list', array( 'id' => $row->employee_id ) );
            if ($query_assigned->num_rows() > 0) {
                $row_ae = $query_assigned->row();
                $str_assigned = $row_ae->sur_name.', '.$row_ae->first_name;
            }

            $cal_data[substr($row->date,8,2)] = '<a href="'.base_url('jo/in?a='.$row->jo_id).
                '" data-tooltip aria-haspopup="true" class="has-tip calendar_font" title="Project ID : '.$str_joid.
                ' <br /> Project Name : '.$str_joname.'<br /> AE assigned : '.$str_empname.'<br /> Assigned to : '.
                $str_assigned.'" style="color:'.$str_color.';">'.$str_joname.'</a>';

        }
        return $cal_data;
    }

    function add_calendar_data($date, $data){

        if($this->db->select('date')->from('calendar')
            ->where('date', $date)->count_all_results()){

            $this->db->where('date', $date)
                ->update('calendar', array(
                    'date' => $date,
                    'data' => $data
                ));

        }else{

            $this->db->insert('calendar', array(
                'date' => $date,
                'data' => $data
            ));
        }

    }

    function generate ($year, $month) {

        $this->load->library('calendar', $this->conf);

        $cal_data = $this->get_calendar_data($year, $month);

        return $this->calendar->generate($year, $month, $cal_data);
    }
}

