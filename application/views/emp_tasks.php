<h4>Project tasks</h4>
<ul class="accordion" data-accordion>
    <li class="accordion-navigation">
        <a class="" href="#creatives_panel">Creatives</a>
        <div id="creatives_panel" class="content">
<?php
if( $this->session->userdata('sess_dept') == 10 && $this->session->userdata('sess_post') == 1 ){
?>
            <div class="row force_right_align">
                <button class="small" data-reveal-id="modal_creatives_tasks">Add assignment</button>
            </div>

            <div id="modal_creatives_tasks" class="reveal-modal small" data-reveal aria-labelledby="modal_creatives" aria-hidden="true" role="dialog">
                <h2 id="modal_creatives">Assign a task to.</h2>

                <form id="form_creatives_tasks" action="" method="post">
                    <select name="sel_creatives_emp" id="sel_creatives_emp">
                        <option value="0">Select role</option>
                        <option value="admin">Admin</option>
                        <option value="employee">Employee</option>
                    </select>
                </form>
                <p>I'm a cool paragraph that lives inside of an even cooler modal. Wins!</p>
                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
            </div>
<?php
}
?>
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Start</td>
                        <td>Deadline</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    <li class="accordion-navigation">
        <a class="" href="#hr_panel">HR</a>
        <div id="hr_panel" class="content">
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Start</td>
                        <td>Deadline</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    <li class="accordion-navigation">
        <a class="" href="#act_panel">Activations</a>
        <div id="act_panel" class="content">
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Start</td>
                        <td>Deadline</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    <li class="accordion-navigation">
        <a class="" href="#op_panel">Operations</a>
        <div id="op_panel" class="content">
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Start</td>
                        <td>Deadline</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    <li class="accordion-navigation">
        <a class="" href="#prod_panel">Production</a>
        <div id="prod_panel" class="content">
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Start</td>
                        <td>Deadline</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
    <li class="accordion-navigation">
        <a class="" href="#set_panel">Set Up / Logistics</a>
        <div id="set_panel" class="content">
            <div class="row">
                <table class="twidth">
                    <thead>
                    <tr>
                        <td>Assigned to :</td>
                        <td>Start</td>
                        <td>Deadline</td>
                        <td>Description</td>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </li>
</ul>





