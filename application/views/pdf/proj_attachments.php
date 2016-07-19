<?php
$info = json_decode($jo_details);
?>

<img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
<hr>
<h2 style="text-decoration:underline;">Project Attachments</h2>
<hr>
<table style="width: 100%;">
    <tr>
        <td>Job order number : <span style="color:#2a92db;"><?= $info->jo_number ?></span></td>
    </tr>
    <tr>
        <td><?= $info->date_created ?></td>
    </tr>
    <tr>
        <td>Contract No.</td>
    </tr>
    <tr>
        <td><?= $info->contract_no ?></td>
    </tr>
    <tr>
        <td>Client : <span style="color:#2a92db;"><?= $info->client_company_name ?></span></td>
    </tr>
    <tr>
        <td>Product : <span style="color:#2a92db;"><?= $info->brand ?></span></td>
    </tr>
    <tr>
        <td>Project : <span style="color:#2a92db;"><?= $info->project_name ?></span></td>
    </tr>
    <tr>
        <td>Account Handler : <span style="color:#2a92db;"><?= $info->emp_info[0]->sur_name.', '.$info->emp_info[0]->first_name.' '.$info->emp_info[0]->middle_name ?></span></td>
    </tr>
</table>

<hr>

<table style="width: 100%;" border="1">
    <thead>
    <tr>
        <th>Date Uploaded</th>
        <th>File Name</th>
        <th>Reference for</th>
    </tr>
    </thead>
    <tbody>

    <?php
    $proattach = json_decode( $attachment_list );
    foreach( $proattach as $row){
        echo '
            <tr>
                <td>'.$row->date_uploaded.'</td>
                <td>'.$row->file_name.'</td>
                <td>'.$row->reference_for.'</td>
            </tr>
        ';
    }
    ?>

    </tbody>
</table>