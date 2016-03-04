<?php
$mv = json_decode($mvrf_details);
?>

<img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
<hr>
<h2 style="text-decoration:underline;">Manpower and Vehicle</h2>
<hr>

<?=isset($mv->content) ? $mv->content : '';?>