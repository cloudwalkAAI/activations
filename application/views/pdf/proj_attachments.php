<img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
<hr>
<h2 style="text-decoration:underline;">Project Attachments</h2>
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