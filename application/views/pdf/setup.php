<?php
$setups = json_decode($setup_details);
?>

<img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
<hr>
<h2 style="text-decoration:underline;">Setup Details</h2>
<hr>

<?=isset($setups->contents) ? $setups->contents : '';?>
