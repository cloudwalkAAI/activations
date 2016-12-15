<?php
$md = array();
$md = json_decode($mom_details);
?>

<div class="row motm">
    <div class="large-11 columns large-centered">
        <h4>Overview</h4>
        <div id="alert_box_mom_form_fail" data-alert class="alert-box alert radius hide-normal">
            Fail to save.
            <a href="#" class="close">&times;</a>
        </div>
            <div class="large-5 columns large-offset-1">
                <div class="large-12 columns">
                    Agenda <?=isset($md->agenda) ? $md->agenda : '';?>
                </div>
                <div class="large-12 columns">
                    Date and time <?=isset($md->date) ? $md->date : '';?>
                </div>
                <div class="large-12 columns">
                    Location <?=isset($md->location) ? $md->location : '';?>
                </div>
            </div>
            <div class="large-6 columns">
                <div class="large-12 columns">
                    Attendees <?=isset($md->attend) ? $md->attend : '';?>
                </div>
            </div>
            <hr/>
            <h4>Notes</h4>
            <div class="row motm-notes">
                <ul class="tabs" data-tab role="tablist">
                    <li class="tab-title active" role="presentation"><a href="#panel2-1" role="tab" tabindex="0" aria-selected="true" aria-controls="panel2-1">Event details</a></li>
                    <li class="tab-title" role="presentation"><a href="#panel2-2" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-2">Campaign overview</a></li>
                    <li class="tab-title" role="presentation"><a href="#panel2-3" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-3">Activation flow</a></li>
                    <li class="tab-title" role="presentation"><a href="#panel2-4" role="tab" tabindex="0" aria-selected="false" aria-controls="panel2-4">Other details</a></li>
                </ul>
                <div class="tabs-content">
                    <section role="tabpanel" aria-hidden="false" class="content active tabarea" id="panel2-1">
                        <table class="twidth">
                            <tr>
                                <td>What</td>
                                <td>
                                    <?=isset($md->what) ? $md->what : '';?>
                                </td>
                            </tr>
                            <tr>
                                <td>When</td>
                                <td>
                                    <?=isset($md->when) ? $md->when : '';?>
                                    <br>
                                    Additional Notes:
                                    <br>
                                    <?=isset($md->when_notes) ? $md->when_notes : '';?>
                                </td>
                            </tr>
                            <tr>
                                <td>Where</td>
                                <td>
                                    <?=isset($md->where) ? $md->where : '';?>
                                    <br>
                                    Additional Notes:
                                    <br>
                                    <?=isset($md->where_notes) ? $md->where_notes : '';?>
                                </td>
                            </tr>
                            <tr>
                                <td>Expected Guests</td>
                                <td>
                                    <?=isset($md->guest) ? $md->guest : '';?>
                                </td>
                            </tr>
                        </table>
                    </section>
                    <section role="tabpanel" aria-hidden="true" class="content tabarea" id="panel2-2">
                        <?=isset($md->campaign) ? $md->campaign : '';?>
                    </section>
                    <section role="tabpanel" aria-hidden="true" class="content tabarea" id="panel2-3">
                        <?=isset($md->act_flow) ? $md->act_flow : '';?>
                    </section>
                    <section role="tabpanel" aria-hidden="true" class="content tabarea" id="panel2-4">
                        <?=isset($md->details) ? $md->details : '';?>
                    </section>
                </div>
            </div>
            <h4>Next steps and deliverables</h4>
            <div class="large-12 columns">
                <?=isset($md->steps) ? $md->steps : '';?>
            </div>
    </div>
</div>
