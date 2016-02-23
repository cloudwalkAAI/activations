<?php
    $disabler = '';
    $discode = $this->input->get( 'inv' );
    if($discode != 1){
        $disabler = 'style="display:none;"';
    }

    if( $change_pass = 'allow' ){
        echo '
        <div id="pass_content">
            <div class="large-3 large-centered columns" style="padding-top: 12%;">
                <div class="login-box">
                    <div class="row">
                        <div class="large-12 columns">

                            <div class="row" style="text-align: center;">
                                <img class="login_logo" src="'.base_url('assets/img/logos/header_logo-c.png').'" alt="">
                            </div>

                            <div data-alert class="alert-box alert radius" '.$disabler.'>
                                Password not equal.
                                <a href="#" class="close">&times;</a>
                            </div>

                            <form id="cpass_form" action="" method="post">
                                <input type="hidden" name="user_id" value="'.$iddata.'">
                                <input type="hidden" name="user_code" value="'.$cp.'">
                                <div class="row">
                                    <div class="large-12 columns">
                                        <input id="npass" type="password" name="npass" placeholder="New Password"/>
                                        <small id="sml_pass1" class="error" style="display:none;">Input a minimum of 7 characters.</small>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="large-12 columns">
                                        <input id="repass" type="password" name="repass" placeholder="Retype Password"/>
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
                    </div>
                </div>
            </div>
        </div>
        ';
    }else{
        echo 'Invalid account';
    }
?>


