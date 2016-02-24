<div class="column large-12 medium-12 small-12">
    <h3 class="text-center">Job Orders</h3>
    <?php
        if( $this->session->userdata('status') == 1 && $this->session->userdata('sess_role') == 'admin' || $this->session->userdata('sess_role') == 'employee' ){
    ?>
            <div class="column large-4 medium-4 small-12">
                <input id="search_jolist" type="text" placeholder="Search">
            </div>
            <div class="column large-offset-4 large-4 medium-4 medium-offset-4 small-12">
                <?php if( $this->session->userdata('sess_dept') <= 2 ){
                    echo '<a class="button right tiny" data-reveal-id="joModal" ><i class="fi-plus small"></i> Add Job Order</a>';
                }?>
            </div>


            <div id="joModal" class="reveal-modal small" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
                <h2 id="modalTitle">Add Job Order</h2>

                <div id="alert_box" data-alert class="alert-box alert radius hide-normal">
                    Special characters are not allowed
                    <a href="#" class="close">&times;</a>
                </div>

                <form id="form_jo" action="" method="post">
                    <label>Project Type</label>
                    <table id="pt_list" class="pt_list twidth">
                        <?= $project_type ?>
                    </table>

                    <div class="column large-8 medium-8 small-8">
                        <input type="text" class="twidth" id="other_pt" placeholder="Input other project type">
                    </div>
                    <div class="column large-4 medium-4 small-4">
                        <a href="#" id="btn_add_pt" class="button tiny twidth"><i class="fi-plus small"></i> Add</a>
                    </div>

                    <label for="inp_client">Client
                        <select name="inp_client" id="inp_client">
                            <option value="0">Select...</option>
                            <?php
                                foreach( $client_list as $row ){
                                    echo '
                                        <option value="'.$row['client_id'].'">'.$row['company_name'].'</option>
                                    ';
                                }
                            ?>
                        </select>
                    </label>
                    <label for="inp_brand" id="hd" class="hide">Brand
                        <select name="inp_brand" id="inp_brand">
                            <option value="0">Select...</option>
                        </select>
                    </label>

                    <label for="inp_projname">Project Name
                        <input type="text" id="inp_projname" name="inp_projname">
                    </label>

                    <button id="btn_save_jo" type="submit" class="button medium right"><i class="fi-save medium"></i> Save</button>
                </form>

                <a class="close-reveal-modal" aria-label="Close">&#215;</a>
            </div>
    <?php
        }
    ?>
    <table id="table_jo_list" class="twidth">
        <thead>
        <tr>
            <th width="110">Date Created</th>
            <th width="150">Job Order No.</th>
            <th width="180">DO/Contract No.(Date)</th>
            <th width="180">Project Name</th>
            <th width="100">Project Type</th>
            <th width="100">Client</th>
            <th width="110">Brand</th>
            <th width="110">Billed</th>
            <th width="110">Paid</th>
        </tr>
        </thead>
        <tbody id="jo_table_list">
            <?php
                $c = '';
                $b = '';

//                foreach( $toc->result_array() as $row){
                foreach( $jo_list as $row){

                    $query_company = $this->db->get_where( 'clients', array( 'client_id' => $row['client_company_name'] ) );
                    $row_company = $query_company->row();
                    if (isset($row_company))
                    {
                        $c = $row_company->company_name;
                    }

//                    $query_brand = $this->db->get_where( 'brand', array( 'brand_id' => $row['brand'] ) );
//                    $row_brand = $query_brand->row();
//                    if (isset($row_brand))
//                    {
//                        $b = $row_brand->brand_name;
//                    }

                    echo '
                        <tr>
                        <td>'.$row['date_created'].'</td>
                        <td><a href="'.base_url('jo/in?a=').$row['jo_id'].'">'.$row['jo_number'].'</a></tdtr>
                        <td>'.$row['do_contract_no'].'</td>
                        <td>'.$row['project_name'].'</td>
                        <td>'.$row['project_type'].'</td>
                        <td>'.$c.'</td>
                        <td>'.$row['brand'].'</td>
                        <td>'.$row['billed_date'].'</td>
                        <td>'.$row['paid_date'].'</td>
                        </tr>
                    ';
                }
            ?>
        </tbody>
    </table>
</div>
