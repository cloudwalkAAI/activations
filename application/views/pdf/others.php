<?php
$other = json_decode($other_details);
?>

<img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
<hr>
<h2 style="text-decoration:underline;">Others</h2>
<hr>

<?=isset($other->texts) ? $other->texts : '';?>
