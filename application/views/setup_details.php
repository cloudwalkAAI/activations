<?php
$setups = json_decode($setup_details);
?>
<form id="setup_form" action="" method="post">
    <input type="hidden" name="setupid" value="<?=$this->input->get('a')?>">
    <textarea name="setup_particular" id="setup_particular" cols="30" rows="10" <?=$this->session->userdata('sess_dept') > '2' ? 'disabled' : '';?>><?=isset($setups->contents) ? $setups->contents : '';?></textarea>
    <button id="btn_setup_submit" type="button" <?=$this->session->userdata('sess_dept') > '2' ? 'style="display:none;"' : '';?>>Save</button>
</form>