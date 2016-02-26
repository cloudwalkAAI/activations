<?php
$md = array();
$md = json_decode($result_mom);
?>

<div style="background-color: rgba(255,0,0,0);font-size:12px;font-family:'monospace';">
    <img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
    <hr>
    <h2 style="text-decoration:underline;">Minutes of the Meeting</h2>
    <hr>
    <table style="width: 100%;">
        <tr>
            <td colspan="4"><h3>Overview</h3></td>
        </tr>
        <tr>
            <td colspan="2">Attendees : <span style="color:#2a92db;"><?=isset($md->attend) ? $md->attend : '';?></span></td>
            <td colspan="2">Date and time :  <span style="color:#2a92db;"><?=isset($md->date) ? $md->date : '';?></span></td>
        </tr>
        <tr>
            <td colspan="2">Location :  <span style="color:#2a92db;"><?=isset($md->location) ? $md->location : '';?></span></td>
            <td colspan="2">Agenda :  <span style="color:#2a92db;"><?=isset($md->agenda) ? $md->agenda : '';?></span></td>
        </tr>
        <tr>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td colspan="4"><h3>Notes</h3></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"><h4>Event Details</h4></td>
        </tr>
        <tr>
            <td colspan="2">What :  <span style="color:#2a92db;"><?=isset($md->what) ? ucfirst($md->what) : '';?></span></td>
            <td colspan="2">Notes :  <span style="color:#000000;"><?=isset($md->what_notes) ? ucfirst($md->what_notes) : '';?></span></td>
        </tr>
        <tr>
            <td colspan="2">When :  <span style="color:#2a92db;"><?=isset($md->when) ? ucfirst($md->when) : '';?></td>
            <td colspan="2">Notes :  <span style="color:#000000;"><?=isset($md->when_notes) ? ucfirst($md->when_notes) : '';?></span></td>
        </tr>
        <tr>
            <td colspan="2">Where :  <span style="color:#2a92db;"><?=isset($md->where) ? ucfirst($md->where) : '';?></td>
            <td colspan="2">Notes :  <span style="color:#000000;"><?=isset($md->where_notes) ? ucfirst($md->where_notes) : '';?></span></td>
        </tr>
        <tr>
            <td colspan="4">Expected Guests :  <span style="color:#2a92db;"><?=isset($md->guest) ? $md->guest : '';?></span></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="4"><h4>Campaign overview</h4></td>
        </tr>
        <tr>
            <td colspan="4"> <span style="color:#2a92db;"><?=isset($md->campaign) ? $md->campaign : '';?></span></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="4"><h4>Activation flow</h4></td>
        </tr>
        <tr>
            <td colspan="4"> <span style="color:#2a92db;"><?=isset($md->act_flow) ? $md->act_flow : '';?></span></td>
        </tr>
        <tr>
            <td><br></td>
        </tr>
        <tr>
            <td colspan="4"><h4>Other details</h4></td>
        </tr>
        <tr>
            <td colspan="4"> <span style="color:#2a92db;"><?=isset($md->details) ? $md->details : '';?></span></td>
        </tr>
        <tr>
            <td colspan="4"></td>
        </tr>
        <tr>
            <td colspan="4"><hr></td>
        </tr>
        <tr>
            <td colspan="4"><h3>Next steps and deliverables</h3></td>
        </tr>
        <tr>
            <td colspan="4"> <span style="color:#2a92db;"><?=isset($md->steps) ? $md->steps : '';?></span></td>
        </tr>
    </table>
</div>