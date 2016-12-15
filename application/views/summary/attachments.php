<table class="twidth">
    <thead>
    <tr>
        <th>Date Uploaded</th>
        <th>File Name</th>
        <th>Reference for</th>
        <th>Download Link</th>
    </tr>
    </thead>
    <tbody id="tbody_pro_att">

    <?php
    $str_trcolor = '';
    $proattach = json_decode( $attachment_list );
    foreach( $proattach as $row){

        if( $row->dept_id == 1 ){
            $str_trcolor = 'background:#fbfd04';
        }elseif( $row->dept_id == 2 ){
            $str_trcolor = 'background:#01fafc';
        }elseif( $row->dept_id == 3 ){
            $str_trcolor = 'background:#02fb00';
        }elseif( $row->dept_id == 5 ){
            $str_trcolor = 'background:#f805fd';
        }elseif( $row->dept_id == 6 ){
            $str_trcolor = 'background:#fc0404';
        }elseif( $row->dept_id == 7 ){
            $str_trcolor = 'background:#0304fc';
        }elseif( $row->dept_id == 8 ){
            $str_trcolor = 'background:#5d00e4';
        }elseif( $row->dept_id == 9 ){
            $str_trcolor = 'background:#0b2e96';
        }elseif( $row->dept_id == 10 ){
            $str_trcolor = 'background:#fbe8ea';
        }

        echo '
                <tr style="'.$str_trcolor.' !important" id="att_pro'.$row->attachment_id.'">
                    <td>'.$row->date_uploaded.'</td>
                    <td>'.$row->file_name.'</td>
                    <td>'.$row->reference_for.'</td>
                    <td><a style="'.$str_trcolor.' !important" href="'.base_url( $row->file_location ).'" target="_blank">Download</td>
                </tr>
            ';
    }
    ?>

    </tbody>
</table>