<?php
    $info = json_decode($jo_details);
?>

<img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
<br>
<hr>

Job order number : <span style="color:#2a92db;"><?= $info->jo_number ?></span><br>
<?= $info->date_created ?><br>
<br>
Client : <span style="color:#2a92db;"><?= $info->client_company_name ?></span><br>
Product : <span style="color:#2a92db;"><?= $info->brand ?></span><br>
Project : <span style="color:#2a92db;"><?= $info->project_name ?></span><br>
Account Handler : <span style="color:#2a92db;"><?= $info->emp_info[0]->sur_name.', '.$info->emp_info[0]->first_name.' '.$info->emp_info[0]->middle_name ?></span>
<br>
<hr>
