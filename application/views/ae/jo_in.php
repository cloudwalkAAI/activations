<div class="column large-2 medium-2 small-12">
    <?php
//        echo '<pre>';
//        print_r( json_decode($jo_details));
        $info = json_decode($jo_details);
//        print_r( $info->emp_info[0]->img_loc );
//        $createDate = new DateTime( $info->date_created );

//        $strip = $createDate->format('Y-m-d');

    ?>
    <div class="row text-center">
        <img src="<?= base_url( 'assets/img/profile/'.$info->emp_info[0]->img_loc ) ?>" alt="">
    </div>

    <div class="row">
        <?php
            echo '<h4>'.$info->emp_info[0]->sur_name.', '.$info->emp_info[0]->first_name.' '.$info->emp_info[0]->middle_name.'</h4>';
        ?>
    </div>
    <hr />

    <div class="row">
        <span>JO date created : <?= $info->date_created ?></span>
    </div>
    <div class="row">
        <span>Job order number : <?= $info->jo_number ?></span>
    </div>
    <div class="row">
        <span>Project type : <?= $info->project_type ?></span>
    </div>
    <div class="row">
        <span>Client : <?= $info->client_company_name ?></span>
    </div>
    <div class="row">
        <span>Brand : <?= $info->brand ?></span>
    </div>
    <div class="row">
        <span>Project name : <?= $info->project_name ?></span>
    </div>
    <div class="row">
        <span>DO/Contract Date :
            <?php
                if( $info->do_contract_no == '' ){
                    echo 'pending';
                }else{
                    echo $info->do_contract_no;
                }
            ?>
        </span>
    </div>
    <div class="row">
        <span>Billed date :
            <?php
                if( $info->billed_date == '' ){
                    echo 'pending';
                }else{
                    echo $info->billed_date;
                }
            ?>
        </span>
    </div>
    <div class="row">
        <span>Paid date :
            <?php
                if( $info->paid_date == '' ){
                    echo 'pending';
                }else{
                    echo $info->paid_date;
                }
            ?>
        </span>
    </div>
    <div class="row">
        <table id="tbl_mom" class="hide">
            <tr>
                <th>Minutes of the Meeting</th>
            </tr>
            <tr>
                <td>Date of revision</td>
            </tr>
            <?php
                $get_date_mom = json_decode( $mom_dates );
                if( isset( $get_date_mom ) ){
                    foreach( $get_date_mom as $id => $ddates ){
                        echo '
                            <tr>
                                <td><a class="loadmombydate" href="#" alt="' . $id . '">' . $ddates . '</a></td>
                            </tr>
                        ';
                    }
                }
            ?>
        </table>

        <table id="tbl_event_details" class="hide">
            <tr>
                <th>Event Details</th>
            </tr>
            <tr>
                <td>Dates of Revision</td>
            </tr>
            <?php
            $get_date_ed = json_decode( $detail_dates );
            if( isset( $get_date_ed ) ){
                foreach( $get_date_ed as $ided => $ddatesed ){
                    echo '
                            <tr>
                                <td><a class="loadedbydate" href="#" alt="' . $ided . '">' . $ddatesed . '</a></td>
                            </tr>
                        ';
                }
            }
            ?>
        </table>

        <table id="tbl_setup" class="hide">
            <tr>
                <th>Setup Details</th>
            </tr>
            <tr>
                <td>Dates of Revision</td>
            </tr>
            <?php
            $get_date_setup = json_decode( $setup_dates );
            if( isset( $get_date_setup ) ){
                foreach( $get_date_setup as $id => $ddates ){
                    echo '
                            <tr>
                                <td><a class="loadsetupbydate" href="#" alt="' . $id . '">' . $ddates . '</a></td>
                            </tr>
                        ';
                }
            }
            ?>
        </table>

        <table id="tbl_mvrf" class="hide">
            <tr>
                <th>MVRF</th>
            </tr>
            <tr>
                <td>Dates of Revision</td>
            </tr>
            <?php
            $get_date_mvrf = json_decode( $mvrf_dates );
            if( isset( $get_date_mvrf ) ){
                foreach( $get_date_mvrf as $id => $ddates ){
                    echo '
                            <tr>
                                <td><a class="loadmvrfbydate" href="#" alt="' . $id . '">' . $ddates . '</a></td>
                            </tr>
                        ';
                }
            }
            ?>
        </table>

        <table id="tbl_other" class="hide">
            <tr>
                <th>Other</th>
            </tr>
            <tr>
                <td>Dates of Revision</td>
            </tr>
            <?php
            $get_date_other = json_decode( $other_dates );
            if( isset( $get_date_other ) ){
                foreach( $get_date_other as $id => $ddates ){
                    echo '
                            <tr>
                                <td><a class="loadotherbydate" href="#" alt="' . $id . '">' . $ddates . '</a></td>
                            </tr>
                        ';
                }
            }
            ?>
        </table>

    </div>
</div>
<div class="column large-10 medium-10 small-12">
    <div class="row">
        <a href="#" style="margin-top: 9px;" id="pdf_selector" data-reveal-id="modal_pdf_selector" class="button tiny right">Print</a>
    </div>
    <div id="modal_pdf_selector" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
<!--        <h2 id="modalTitle">Select Archive</h2>-->

        <input type="hidden" id="jid" name="jid" value="<?=$this->input->get('a');?>">
<!--        <label for="pdf_ex_mom"><input type="checkbox" name="pdf_ex[]" id="pdf_ex_mom" value="mom">Minutes of the Meeting</label>-->
<!--        <label for="pdf_ex_ed"><input type="checkbox" name="pdf_ex[]" id="pdf_ex_ed" value="ed">Event Details</label>-->
<!--        <input type="button" class="button" value="Export" id="btn_export">-->
        <a href="<?=base_url('jo/mpdf?jid='.$this->input->get('a'))?>" id="pdf-btn" target="_blank" href="">Save and Print PDF</a>

    </div>
    <ul class="accordion" data-accordion>
        <li class="accordion-navigation">
            <a id="show_table_mom" class="accordion_bg" href="#panel1a">Minutes of the meeting</a>
            <div id="panel1a" class="content">
                <?= $mom ?>
            </div>
        </li>
        <li class="accordion-navigation">
            <a id="show_table_details" class="accordion_bg" href="#panel2a">Event details</a>
            <div id="panel2a" class="content">
                <?= $event_details ?>
            </div>
        </li>
        <li class="accordion-navigation">
            <a id="show_emp_tasks" class="accordion_bg" href="#accordion_emp_task">Tasks assignment</a>
            <div id="accordion_emp_task" class="content">
                <?= $emp_task ?>
            </div>
        </li>
        <li class="accordion-navigation">
            <a id="show_table_projects" class="accordion_bg" href="#panel3a">Project attachments</a>
            <div id="panel3a" class="content">
                <?= $project_attachments ?>
            </div>
        </li>
        <li class="accordion-navigation">
            <a id="show_table_setup" class="accordion_bg" href="#panel4a">Set up details</a>
            <div id="panel4a" class="content">
                <?= $setup_details ?>
            </div>
        </li>
        <li class="accordion-navigation">
            <a id="show_table_mvrf" class="accordion_bg" href="#panel5a">Manpower and vehicle request form</a>
            <div id="panel5a" class="content">
                <?= $mvrf_view ?>
            </div>
        </li>
        <li class="accordion-navigation">
            <a id="show_table_references" class="accordion_bg" href="#accordion_references">References</a>
            <div id="accordion_references" class="content">
                <?= $reference ?>
            </div>
        </li>
        <li class="accordion-navigation">
            <a id="show_table_other" class="accordion_bg" href="#accordion_other">Other</a>
            <div id="accordion_other" class="content">
                <?php
                    $other = json_decode($other_details);
                ?>
                <form id="other_form" action="" method="post">
                    <input type="hidden" name="otherid" value="<?=$this->input->get('a')?>">
                    <textarea name="ta_Other" id="ta_Other" cols="30" rows="10" <?=$this->session->userdata('sess_dept') > '2' ? 'disabled' : '';?>><?=isset($other->texts) ? $other->texts : '';?></textarea>
                    <button id="btn_other_submit" type="button" <?=$this->session->userdata('sess_dept') > '2' ? 'style="display:none;"' : '';?>>Save</button>
                </form>

            </div>
        </li>
        <li class="accordion-navigation">
            <a id="comment_box" class="accordion_bg" href="#accordion_comment">Comments</a>
            <div id="accordion_comment" class="content">
                <?= $comments ?>
            </div>
        </li>
    </ul>
</div>