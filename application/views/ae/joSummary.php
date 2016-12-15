<div class="row">
    <div class="large-12 columns" style="padding-top: 22px;">
        <ul class="no-bullet" id="jo_table_list">
            <?php
            $c = '';
            $b = '';

            //                foreach( $toc->result_array() as $row){
            foreach( $jo_list as $row) {

                $query_company = $this->db->get_where('clients', array('client_id' => $row['client_company_name']));
                $row_company = $query_company->row();
                if (isset($row_company)) {
                    $c = $row_company->company_name;
                }
                ?>
                <li class="jolist jo-item-<?php echo $row['jo_id']; ?>" alt="<?php echo $row['jo_id']; ?>" >
                    <div class="small-7 medium-8 large-8 columns" style="padding: 50px;">
                        <h3><?php echo '<a href="'.base_url('summary/view?jo=').$row['jo_id'].'" style="color:'.$row['jo_color'].';">'.$row['project_name'].'</a>'; ?></h3>
                        <h5><?php echo '<a href="'.base_url('jo/in?a=').$row['jo_id'].'">JO NO.'.$row['jo_number'].'</a>'; ?></h5>
                        <h6><?php echo $row['date_created']; ?></h6>
                    </div>
                    <div class="small-5 medium-4 large-4 columns text-right" style="padding: 12px;">
                        <ul class="inline-list jorightlist right">
                            <?php
                            if( $this->session->userdata('sess_dept') <=2 ){
                                ?>
                                <li><a class="edit_load_jo" data-reveal-id="edit_joModal" alt="<?php echo $row['jo_id']; ?>"><img src="<?php echo base_url('assets/img/logos/Edit.png');?>" /></a></li>
                                <?php
                            }
                            ?>

                            <!--<li><a href="#"><img src="<?php //echo base_url('assets/img/logos/Delete.png');?>"/></a></li>-->
                        </ul>
                        <div class="large-12 columns text-right" style="padding-right: 30px;">
                            <p style="margin-top: 10px;"><?php echo $row['project_type']; ?></p>
                            <p><?php echo $c; ?></p>
                            <p><?php echo isset($row['brand']) ? $row['brand']:'No Value'; ?></p>
                            <p>DO: <?php echo isset($row['do_contract_no']) ? $row['do_contract_no']:'No Value'; ?></p>
                            <p>Billed: <?php echo isset($row['billed_date']) ? $row['billed_date']:'No Value'; ?></p>
                            <p>Paid: <?php echo isset($row['paid_date']) ? $row['paid_date']:'No Value'; ?></p>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </li>
                <?php
            }
            ?>

        </ul>
    </div>
</div>