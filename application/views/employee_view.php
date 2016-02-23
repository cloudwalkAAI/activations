<h1 class="text-center">Employee List</h1>

<div class="column large-4 medium-4 small-12">
    <input id="search_emp" type="text" placeholder="Search">
</div>

<?php
if( $this->session->userdata('status') == 1 && $this->session->userdata('sess_role') == 'admin' ){
    ?>
<div class="column large-offset-4 large-4 medium-offset-4 medium-4 small-12">
    <a class="button right" data-reveal-id="empModal" ><i class="fi-plus small"></i> Add Employee</a>
</div>
    <div id="empModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <h2 id="modalTitle" class="text-center">Add Employee</h2>

        <div id="alert_box_emp" data-alert class="alert-box alert radius hide-normal">
            Special characters are not allowed
            <a href="#" class="close">&times;</a>
        </div>

        <div id="alert_box_emp_box" data-alert class="alert-box alert radius hide-normal">
            Special characters are not allowed
            <a href="#" class="close">&times;</a>
        </div>

        <div id="alert_box_progress" data-alert class="alert-box warning radius hide-normal">
            Please Wait...
        </div>

        <form id="emp_form" action="" method="post">

            <table class="twidth">
                <tr>
                    <td>
                        <select name="sel_role" id="sel_role">
                            <option value="0">Select role</option>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                        </select>
                    </td>
                    <td colspan="2"></td>
                </tr>
                <tr>
                    <td><input id="inp_firstname" name="inp_firstname" placeholder="First Name" type="text" ></td>
                    <td><input id="inp_midname" name="inp_midname" placeholder="Middle Name" type="text"></td>
                    <td><input id="inp_lastname" name="inp_lastname" placeholder="Last Name" type="text"></td>
                </tr>
                <tr>
                    <td colspan="3"><input id="inp_email" name="inp_email" placeholder="Email Address" type="text"></td>
                </tr>
                <tr>
                    <td>
                        <input id="datepicker_emp" name="datepicker_emp" placeholder="Birthdate" type="text">
<!--                        <input type="hidden" name="datepicker_emp">-->
                    </td>
                    <td>
                        <select name="sel_dept" id="sel_dept">
                            <option value="0">Select Department...</option>
                            <?php
                            foreach( $departments as $dept ){
                                echo '
                                    <option value="' . $dept['dept_id'] . '">'. ucfirst($dept['department_name']) .'</option>
                                ';
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="sel_pos" id="sel_pos">
                            <option value="0">Position</option>
                            <?php
                            foreach( $pos as $posts ){
                                echo '
                                    <option value="' . $posts['position_id'] . '">'. ucfirst($posts['position_name']) .'</option>
                                ';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <select name="sel_status" id="sel_status">
                            <option value="0">Select Employee Status...</option>
                            <option value="hired">Hired</option>
                            <option value="evaluation">Evaluation</option>
                        </select>
                    </td>
                    <td> </td>
                </tr>
            </table>

            <button id="btn_add_emp" type="submit" class="button medium right"><i class="fi-save medium"></i> Save</button>
        </form>

        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>


    <div id="empModalupdate" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
        <h2 id="modalTitle" class="text-center">Edit Employee</h2>

        <div id="alert_box_emp_u" data-alert class="alert-box alert radius hide-normal">
            Special characters are not allowed
            <a href="#" class="close">&times;</a>
        </div>

        <div id="alert_box_emp_success" data-alert class="alert-box success radius hide-normal">
            Special characters are not allowed
            <a href="#" class="close">&times;</a>
        </div>


            <table class="twidth">
                <tr>
                    <td colspan="3" class="text-center">
                        <img id="profile_img" class="profile_img" src="<?=base_url('assets/img/profile/default.jpg')?>" alt="">
                        <form id="uploading_form">
                            <input type="hidden" id="uid" name="uid">
                            <input id="upload_file" name="upload_file" type="file" accept="image/*" style="display: none;">
                        </form>

                        <button id="upload_file_button" class="small">Upload Profile</button>
                    </td>
                </tr>

                <form id="emp_form_up" action="" method="post">
                <tr>
                    <td>
                        <label id="empid"></label>
                        <input type="hidden" id="uid" name="uid">
                    </td>
                    <td colspan="2">
                        <select name="sel_role_u" id="sel_role_u">
                            <option value="0">Select role</option>
                            <option value="admin">Admin</option>
                            <option value="employee">Employee</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td><input id="inp_firstname_u" name="inp_firstname_u" placeholder="First Name" type="text" ></td>
                    <td><input id="inp_midname_u" name="inp_midname_u" placeholder="Middle Name" type="text"></td>
                    <td><input id="inp_lastname_u" name="inp_lastname_u" placeholder="Last Name" type="text"></td>
                </tr>
                <tr>
                    <td colspan="3"><input id="inp_email_u" name="inp_email_u" placeholder="Email Address" type="text"></td>
                </tr>
                <tr>
                    <td><input id="datepicker_emp_u" name="datepicker_emp_u" placeholder="00-00-0000" type="text"></td>
                    <td>
                        <select name="sel_dept_u" id="sel_dept_u">
                            <option value="0">Department</option>
                            <?php
                            foreach( $departments as $dept ){
                                echo '
                                    <option value="' . $dept['dept_id'] . '">'. ucfirst($dept['department_name']) .'</option>
                                ';
                            }
                            ?>
                        </select>
                    </td>
                    <td>
                        <select name="sel_pos_u" id="sel_pos_u">
                            <option value="0">Position</option>
                            <?php
                            foreach( $pos as $posts ){
                                echo '
                                    <option value="' . $posts['position_id'] . '">'. ucfirst($posts['position_name']) .'</option>
                                ';
                            }
                            ?>
                        </select>
                    </td>
                </tr>
                <tr>
                    <td colspan="2">
                        <select name="sel_status_u" id="sel_status_u">
                            <option value="0">Select Employee Status</option>
                            <option value="hired">Hired</option>
                            <option value="evaluation">Evaluation</option>
                            <option value="resigned">Resigned</option>
                        </select>
                    </td>
                    <td> </td>
                </tr>
            </table>

            <button id="btn_add_emp_u" type="submit" class="button medium right"><i class="fi-save medium"></i> Save</button>
        </form>

        <a class="close-reveal-modal" aria-label="Close">&#215;</a>
    </div>
<?php
}
?>

<table id="emp_table" class="twidth sortable">
    <thead>
        <tr>
            <th>Employee No.</th>
            <th>Last Name</th>
            <th>First Name</th>
            <th>Department</th>
            <th>Position</th>
            <th>Birthdate</th>
            <th>Age</th>
            <th>Status</th>
        </tr>
    </thead>
    <tbody id="tbdy_emp">
        <?php
            $dept_str = '';
            $post_str = '';
        if( isset($emp_list) ){
            foreach( $emp_list as $row ){
//                echo $row['emp_id'];

                $birthDate = explode("/", $row['birth_date']);

                $age = (date("md", date("U", mktime(0, 0, 0, $birthDate[0], $birthDate[1], $birthDate[2]))) > date("md")
                    ? ((date("Y") - $birthDate[2]) - 1)
                    : (date("Y") - $birthDate[2]));

                $query_dept = $this->db->get_where( 'departments', array( 'dept_id' => $row['department'] ) );
                $row_dept = $query_dept->row();
                if (isset($row_dept))
                {
                    $dept_str = $row_dept->department_name;
                }

                $query_post = $this->db->get_where( 'positions', array( 'position_id' => $row['position'] ) );
                $row_post = $query_post->row();
                if (isset($row_post))
                {
                    $post_str = $row_post->position_name;
                }

                echo '
                    <tr>
                        <td><a class="load_emp" href="javascript:void(0)" data-id="' . $row['id'] . '">' . $row['emp_id'] . '</a></td>
                        <td>' . ucfirst($row['sur_name'])  . '</td>
                        <td>' . ucfirst($row['first_name']) . '</td>
                        <td>' . ucfirst($dept_str) . '</td>
                        <td>' . ucfirst($post_str) . '</td>
                        <td>' . str_replace('-','/', $row['birth_date']) . '</td>
                        <td>' . $age . '</td>
                        <td>' . ucfirst($row['status']) . '</td>
                    </tr>
                ';
            }
        }
        ?>
    </tbody>
</table>
