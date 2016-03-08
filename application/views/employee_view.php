<div class="row fullwidth bar_color1 text-center">
	<div class="large-12 columns" style="padding: 20px 0px;">
		<h5>Employees</h5>		
	</div>
</div>
<div class="row jopart">
	<div class="large-12 columns">
		<?php
			if( $this->session->userdata('status') == 1 && $this->session->userdata('sess_role') == 'admin' || $this->session->userdata('sess_role') == 'employee' ){
		?>
		<?php if( $this->session->userdata('sess_dept') <= 2 ){ ?>
			<a href="<?= base_url('emp/addEmployee') ?>" class="right plussign">&#43;</a>
		<?php } ?>
		<?php
			}
		?>		
	</div>
</div>

<div class="row">
	<div class="large-12 columns" style="padding-top: 22px;">
		<ul class="no-bullet" id="tbdy_emp">
		<?php
            $dept_str = '';
            $post_str = '';
        if( isset($emp_list) ){
            foreach( $emp_list as $row ){
				$data['row'] = $row;	
                $birthDate = explode("/", $row['birth_date']);

                $data['age'] = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                    ? ((date("Y") - $birthDate[2]) - 1)
                    : (date("Y") - $birthDate[2]));

                $query_dept = $this->db->get_where( 'departments', array( 'dept_id' => $row['department'] ) );
                $row_dept = $query_dept->row();
                if (isset($row_dept))
                {
                    $data['dept_str'] = $row_dept->department_name;
                }

                $query_post = $this->db->get_where( 'positions', array( 'position_id' => $row['position'] ) );
                $row_post = $query_post->row();
                if (isset($row_post))
                {
                    $data['post_str'] = $row_post->position_name;
					
                }
				$this->load->view("employee_list",$data);
				
            }
        }
        ?>
		</ul>
	</div>
</div>