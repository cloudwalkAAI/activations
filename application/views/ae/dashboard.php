<?php
//    print_r($this->session->userdata('sess_dept'));

    if( $this->session->userdata('sess_dept') <= 2 ){
?>
        <div class="row">
            <div class="column large-6 medium-6 small-12 dash_col">
                <h3 class="text-center">Internal</h3>
                <a href="<?=base_url('jo?id='.$this->session->userdata('sess_id'))?>" class="dash_button button round">Job Order</a>
                <a href="<?=base_url('jo/production')?>" class="dash_button button round">Production</a>
                <a href="<?=base_url('jo/mvrf')?>" class="dash_button button round">Manpower / Vehicle Request Form</a>
                <a href="<?=base_url('jo/setup')?>" class="dash_button button round">Set Up</a>
                <a href="<?=base_url('jo/activations')?>" class="dash_button button round">Activations</a>
                <a href="<?=base_url('jo/instore')?>" class="dash_button button round">In-Store</a>
                <a href="<?=base_url('')?>" class="dash_button button round">Completed Job Orders</a>
            </div>
            <div class="column large-6 medium-6 small-12 dash_col">
                <h3 class="text-center">External</h3>
                <a href="<?=base_url('jo/motm')?>" class="dash_button button round">Minutes of the meeting</a>
                <a href="<?=base_url('jo/bd')?>" class="dash_button button round">Bid Deck</a>
                <a href="<?=base_url('jo/ppld')?>" class="dash_button button round">Pre Prod and Logistics Deck</a>
                <a href="<?=base_url('jo/wrd')?>" class="dash_button button round">Weekly Report Deck</a>
                <a href="<?=base_url('jo/iped')?>" class="dash_button button round">Initial Post Evaluation Deck</a>
                <a href="<?=base_url('jo/fped')?>" class="dash_button button round">Final Post Evaluation Deck</a>
                <a href="http://www.aai2015.com/home/send_sms" id="btn_text" class="dash_button button round hide-normal">Sample SMS</a>
            </div>
        </div>
<?php
    }elseif( $this->session->userdata('sess_dept') == '10' ){
?>
        <div class="row">
            <div class="column large-6 medium-6 small-12 dash_col">
                <?= $this->calendar->generate();?>
            </div>
            <div class="column large-6 medium-6 small-12 dash_col">
                <a href="<?=base_url('jo?id='.$this->session->userdata('sess_id'))?>" class="dash_button button round">Job Order</a>
            </div>
        </div>
<?php
    }
?>