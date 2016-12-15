<?php
$setups = json_decode($setup_details);
?>

<div name="setup_particular" id="setup_particular" <?=$str_disa?>><?=isset($setups->contents) ? $setups->contents : '';?></div>
