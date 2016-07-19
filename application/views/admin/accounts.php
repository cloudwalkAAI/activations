<table class="twidth">
    <thead>
        <tr>
            <td colspan="12" class="text-center"><h3>Admin - Accounting</h3></td>
        </tr>
        <tr>
            <td colspan="3" style="background-color: green; color:white; text-align: center;">30 days</td>
            <td colspan="3" style="background-color: yellow; color:black; text-align: center;">45 days</td>
            <td colspan="3" style="background-color: red; color:white; text-align: center;">60 days</td>
            <td colspan="3" class="emergency" style="text-align: center;">More than 120 days</td>
        </tr>
        <tr>
            <td colspan="12">
                <div class="column large-5 medium-5 small-12 dash_col">
                    <div class="row collapse prefix-radius">
                        <div class="small-2 columns">
                            <span class="prefix fi-magnifying-glass medium"></span>
                        </div>
                        <div class="small-10 columns">
                            <input type="text" placeholder="Search.." id="search_accounts">
                        </div>
                    </div>
                </div>
            </td>
        </tr>
        <tr>
            <td width="150">Job Order No.</td>
            <td width="150">Contract Number</td>
            <td width="400">AE Assigned</td>
            <td width="200">Project Name</td>
            <td width="200">Client</td>
            <td width="150">Brand</td>
            <td width="150">CE</td>
            <td width="150">DO No. / PO</td>
            <td width="150">Transmittal</td>
            <td width="150">Invoice No.</td>
            <td width="150">Paid</td>
            <td width="150">Remarks</td>
        </tr>
    </thead>
    <tbody id="tbody_accounts" <?=$disabler?>>
        <?=$jolist?>
    </tbody>
</table>

<div id="do_Modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle">Upload DO</h2>
    <form id="form_up_do" action="" method="post">
        <input type="hidden" name="do_joid" id="do_joid">
        <input type="text" name="do_number" id="do_number" placeholder="DO Number">
        <input type="file" name="do_file" id="do_file">
        <button id="bton_do" class="tiny">Upload</button>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="bill_Modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle">Upload Invoice</h2>
    <form id="form_up_bill" action="" method="post">
        <input type="hidden" name="bill_joid" id="bill_joid">
        <input type="text" name="bill_date" id="bill_date" placeholder="Date">
        <input type="text" name="bill_number" id="bill_number" placeholder="Invoice">
        <input type="file" name="bill_file" id="bill_file">
        <button id="bton_bill" class="tiny">Upload</button>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="bill_Modal_u" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle">Update Invoice</h2>
    <form id="form_up_bill_u" action="" method="post">
        <input type="hidden" name="bill_joid_u" id="bill_joid_u">
        <input type="text" name="bill_date_u" id="bill_date_u" placeholder="Date">
        <input type="text" name="bill_number_u" id="bill_number_u" placeholder="Invoice">
        <a id="bill_download" href="" target="_blank">Download File</a>
        <input type="file" name="bill_file_u" id="bill_file_u">
        <button id="bton_bill_u" class="tiny">Upload</button>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="ce_Modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle">Upload CE</h2>
    <form id="form_up_ce" action="" method="post">
        <input type="hidden" name="ce_joid" id="ce_joid">
        <input type="text" name="ce_number" id="ce_number" placeholder="CE Number">
        <input type="file" name="ce_file" id="ce_file">
        <button id="bton_ce" class="tiny">Upload</button>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="paid_Modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle">Update Payment</h2>
    <form id="form_up_paid" action="" method="post">
        <input type="hidden" name="paid_joid" id="paid_joid">
        <input type="text" name="paid_datepicker" id="paid_datepicker" placeholder="Date">
<!--        <select name="paid_color" id="paid_color" style="display:none;">-->
<!--            <option value="white" style="background-color:white;">Select Color...</option>-->
<!--            <option value="red" style="background-color:red;"></option>-->
<!--            <option value="green" style="background-color:green;"></option>-->
<!--        </select>-->
        <input type="file" name="paid_file" id="paid_file">
        <button id="bton_paid" class="tiny">Paid</button>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<div id="remarks_Modal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle">Remarks</h2>
    <form id="form_remarks" action="" method="post">
        <input type="hidden" name="rem_joid" id="rem_joid">
        <textarea name="rem_text" id="rem_text" cols="30" rows="10"></textarea>
        <button id="bton_rem" class="tiny">Save</button>
    </form>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>