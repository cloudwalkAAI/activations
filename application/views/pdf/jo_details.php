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
<h2>Animation Details</h2>
<table style="width:100%;" border="1">
    <thead>
    <tr>
        <th>Particulars</th>
        <th>Target Activity</th>
        <th colspan="5" style="text-align: center;">Target Schedule</th>
        <th>Target Schedule</th>
        <th>Target Duration</th>
    </tr>

    <tr>
        <th colspan="2"> </th>
        <th>Selling</th>
        <th>Flyering</th>
        <th>Survey</th>
        <th>Experiment</th>
        <th>Other</th>
        <th colspan="2"> </th>
    </tr>
    </thead>
    <tbody id="tbody_animation">

    <?php
    if( isset($eda_table) ){
        echo $eda_table;
    }else{
        echo '
            <tr>
                <td rowspan="10" style="text-align: center"> No details saved</td>
            </tr>
        ';
    }
    ?>
    </tbody>
</table>