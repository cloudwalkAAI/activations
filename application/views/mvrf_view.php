<?php
$mv = json_decode($mvrf_details);
?>
<form id="mvrf_form" action="" method="post">
    <input type="hidden" name="mvrfid" value="<?=$this->input->get('a')?>">
    <textarea name="ta_mvrf" id="ta_mvrf" cols="30" rows="10" <?=$this->session->userdata('sess_dept') > '2' ? 'disabled' : '';?>><?=isset($mv->content) ? $mv->content : '';?></textarea>
    <button id="btn_mvrf_submit" type="button" <?=$this->session->userdata('sess_dept') > '2' ? 'style="display:none;"' : '';?>>Save</button>
</form>