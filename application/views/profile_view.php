<?php
//    echo $this->session->userdata('sess_status') ;
    $arr_profile = json_decode( $data_prof );
?>

<h1 class="text-center">Settings</h1>

<div class="column large-offset-2 large-8 medium-offset-2 medium-8 small-12">
    <h4 class="text-center">Account</h4>
    <div class="column large-4 medium-4 small-12 text-center">
        <img class="profile_img" src="<?=isset($arr_profile[0]->img_loc) ? base_url( 'assets/img/profile/'.$arr_profile[0]->img_loc ) : 'assets/img/profile/default.jpg';?>" alt="">
        <form id="uploading_form">
            <input id="upload_file" name="upload_file" type="file" accept="image/*" style="display: none;">
        </form>

        <button id="upload_file_button" class="small">Upload Profile</button>
        <div id="uploadModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
            <div id="alert_box_upload" data-alert class="alert-box alert radius">
                <p id="upload_desc"></p>
            </div>
            <a class="close-reveal-modal" aria-label="Close">&#215;</a>
        </div>
    </div>
    <div class="column large-8 medium-8 small-12">

        <div id="alert_box_profile" data-alert class="alert-box alert radius hide-normal">
            Special characters are not allowed
            <a href="#" class="close">&times;</a>
        </div>

        <form id="profile_form" action="" method="post">
            <table class="twidth">
                <tr>
                    <td width="100">Name:</td>
                    <td width="100"><input class="vert-mid" type="text" id="prof_fname" name="prof_fname" value="<?=isset($arr_profile[0]->first_name) ? $arr_profile[0]->first_name : '';?>"></td>
                    <td width="100"><input class="vert-mid" type="text" id="prof_mname" name="prof_mname" value="<?=isset($arr_profile[0]->middle_name) ? $arr_profile[0]->middle_name : '';?>"></td>
                    <td width="100"><input class="vert-mid" type="text" id="prof_lname" name="prof_lname" value="<?=isset($arr_profile[0]->sur_name) ? $arr_profile[0]->sur_name : '';?>"></td>
                </tr>
                <tr>
                    <td colspan="4">Email : <?= $arr_profile[0]->email ?></td>
                </tr>
                <tr>
                    <td colspan="2">Contact No/s.</td>
                    <td colspan="2">
                        <div class="contact_append_text">
                            <div class="input_fields_wrap">
                                <button class="add_field_button tiny twidth">Add More Contact Details</button>
                                <?php
                                    $i = 0;
                                    if( isset($arr_profile[0]->contact_nos) ){
                                        $ctacts = explode(',',$arr_profile[0]->contact_nos);
                                        foreach( $ctacts as $cdetails ){
                                            $i++;
                                            if( $i == 1 ){
                                                echo '<div><input type="text" name="ta_contact[]" placeholder="Main Number" value="'.$cdetails.'"></div>';
                                            }else{
                                                echo '<div><input type="text" name="ta_contact[]" value="'.$cdetails.'"></div>';
                                            }
                                        }
                                    }else{
                                        echo '<div><input type="text" name="ta_contact[]" placeholder="Main Number"></div>';
                                    }
                                ?>
                            </div>
                        </div>
                    </td>
                </tr>
                <tr>
                    <td colspan="4"><!--<a class="vert-mid" href="#" data-reveal-id="modal_account_details">Account Details</a>--></td>
                </tr>
                <tr>
                    <td colspan="3"><a id="btn_change_pass" data-reveal-id="modal_change_password" class="button small vert-mid">Change Password</a></td>
                    <td><button id="btn_profile_save" class="button small right vert-mid" type="submit">Save</button></td>
                </tr>
            </table>
        </form>
    </div>
</div>

<div id="modal_change_password" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle">Change Password</h2>
    <div id="alert_box_profile_pass" data-alert class="alert-box alert radius hide-normal">
        Special characters are not allowed
        <a href="#" class="close">&times;</a>
    </div>
    <form id="cpass_form_profile_pv" action="" method="post">
        <input type="hidden" name="user_id" value="<?=$this->session->userdata('sess_id');?>">
        <div class="row">
            <div class="large-12 columns">
                <input id="oldpass" type="password" name="oldpass" placeholder="Old Password"/>
                <small id="sml_pass" class="error" style="display:none;">Input a minimum of 7 characters.</small>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <input id="npass" type="password" name="npass" placeholder="New Password"/>
                <small id="sml_pass1" class="error" style="display:none;">Input a minimum of 7 characters.</small>
            </div>
        </div>
        <div class="row">
            <div class="large-12 columns">
                <input id="repass" type="password" name="repass" placeholder="Retype New Password"/>
                <small id="sml_pass2" class="error" style="display:none;">Input a minimum of 7 characters.</small>
            </div>
        </div>
        <div class="row">
            <div class="large-12 large-centered columns">
                <input id="btn_cpass" type="submit" class="button expand" value="Change Password"/>
            </div>
        </div>
    </form>
</div>

<div id="modal_account_details" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle">Account Details</h2>
    <span>JO Added : <?= $jo_counts ?></span><br>
    <span>Task Currently Executing : <?= $current_task ?></span><br>
    <span>Last JO Done : <?= $last_task ?></span><br>
    <input id="search_account_jo" type="text" placeholder="Search">
    <table class="twidth">
        <thead>
            <tr>
                <td>Job Order No.</td>
                <td>Project Type</td>
                <td>Client</td>
                <td>Brand</td>
                <td>Project Name</td>
            </tr>
        </thead>
        <tbody id="tbody_account_jo">
        <?php
        $c = '';
        $b = '';

        //                foreach( $toc->result_array() as $row){
        if( isset($jolist) ){

            foreach( $jolist as $row){
                $query_company = $this->db->get_where( 'clients', array( 'client_id' => $row['client_company_name'] ) );
                $row_company = $query_company->row();
                if (isset($row_company))
                {
                    $c = $row_company->company_name;
                }

                echo '
                    <tr>
                    <td><a href="'.base_url('jo/in?a=').$row['jo_id'].'">'.$row['jo_number'].'</a></tdtr>
                    <td>'.$row['project_type'].'</td>
                    <td>'.$c.'</td>
                    <td>'.$row['brand'].'</td>
                    <td>'.$row['project_name'].'</td>
                    </tr>
                ';
            }
        }
        ?>
        </tbody>
    </table>

    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>