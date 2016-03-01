<?php
$edcarray = array();
$edcarray = json_decode($result_ed);
?>
<div style="background-color: rgba(255,0,0,0);font-size:12px;font-family:'monospace';">
    <img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
    <hr>
    <h2 style="text-decoration:underline;">Event Details</h2>
    <hr>
    <table style="width: 100%;">
        <tr>
            <td colspan="2">What :  <span style="color:#2a92db;"><?=isset($edcarray->wt) ? ucfirst($edcarray->wt) : '';?></span></td>
            <td colspan="2">Notes :  <span style="color:#000000;"><?=isset($edcarray->wtad) ? ucfirst($edcarray->wtad) : '';?></span></td>
        </tr>
        <tr>
            <td colspan="2">When :  <span style="color:#2a92db;"><?=isset($edcarray->wn) ? ucfirst($edcarray->wn) : '';?></span></td>
            <td colspan="2">Notes :  <span style="color:#000000;"><?=isset($edcarray->wnad) ? ucfirst($edcarray->wnad) : '';?></span></td>
        </tr>
        <tr>
            <td colspan="2">Where :  <span style="color:#2a92db;"><?=isset($edcarray->we) ? ucfirst($edcarray->we) : '';?></span></td>
            <td colspan="2">Notes :  <span style="color:#000000;"><?=isset($edcarray->weadd) ? ucfirst($edcarray->weadd) : '';?></span></td>
        </tr>
        <tr>
            <td colspan="4">Expected Guests :  <span style="color:#2a92db;"><?=isset($edcarray->expected) ? $edcarray->expected : '';?></span></td>
        </tr>
        <tr>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td colspan="4"><h3>Event specification</h3></td>
        </tr>
        <tr>
            <td colspan="4"><?=isset($edcarray->espec) ? $edcarray->espec : '';?></td>
        </tr>
    </table>

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
    <br>
    <hr>

    <h2>Requirements</h2>
    <table style="width: 100%;" border="1">
        <thead>
        <tr>
            <th width="50">Department - Handler</th>
            <th width="100">Deliverables</th>
            <th width="50">Deadline</th>
            <th width="100">Next Steps</th>
        </tr>
        </thead>
        <tbody>
        <?php
        if( isset($req_table) ){
            echo $req_table;
        }else{
            echo '
                <tr>
                    <td rowspan="4" style="text-align: center"> No details saved</td>
                </tr>
            ';
        }
        ?>
        </tbody>
    </table>
</div>
