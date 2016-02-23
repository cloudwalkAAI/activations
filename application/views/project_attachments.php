<button class="button round right" data-reveal-id="attachModal"><i class="fi-plus large"></i></button>

<div id="attachModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
    <h2 id="modalTitle" class="text-center">Upload Attachments</h2>

    <div id="alert_box_attach" data-alert class="alert-box alert radius hide-normal">
        Upload fail.
        <a href="#" class="close">&times;</a>
    </div>

    <div id="alert_box_attach_ok" data-alert class="alert-box success radius hide-normal">
        Upload complete.
        <a href="#" class="close">&times;</a>
    </div>

    <div id="progress-div" class="column large-12"><div id="progress-bar" style="min-height: 40px;"></div></div>

    <form id="attach_form" action="" method="post" data-abide>
        <input type="hidden" name="attach_jo_id" value="<?= $this->input->get('a') ?>">

        <div>
            <label for="inp_file_attachments">
                <input type="file" id="inp_file_attachments" name="inp_file_attachments" required>
            </label>
            <small class="error">Please browse an attachment.</small>
        </div>

        <div>
            <label for="inp_file_attachments">
                <select name="sel_reference" id="sel_reference" required>
                    <option value="">Reference for</option>
                    <option value="activations">Activations</option>
                    <option value="bid_deck">Bid Deck</option>
                    <option value="checklist">Checklist</option>
                    <option value="in-store">In-Store</option>
                    <option value="mvrf">Manpower and Vehicle RF</option>
                    <option value="mom">Minutes of the Meeting</option>
                    <option value="initial">Post Evalution (Initial)</option>
                    <option value="final">Post Evalution (Final)</option>
                    <option value="logistics">Pre-Production and Logistics</option>
                    <option value="production">Production</option>
                    <option value="setup">Set-up</option>
                    <option value="weekly-report">Weekly Report</option>
                </select>
            </label>
            <small class="error">Select a reference.</small>
        </div>

        <button id="btn_add_attach" type="submit" class="button medium right"><i class="fi-upload"></i> Upload</button>
    </form>
    <br>
    <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>


<table class="twidth">
    <thead>
        <tr>
            <th>Date Uploaded</th>
            <th>File Name</th>
            <th>Reference for</th>
            <th>Download Link</th>
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
                        <td><a href="'.base_url( $row->file_location ).'" target="_blank">Download</td>
                    </tr>
                ';
            }
        ?>

    </tbody>
</table>