<div class="large-3 large-centered columns" style="padding-top: 12%;">
    <div class="login-box">
        <div class="row">
            <div class="large-12 columns" style="text-align: center;">

                <div class="row">
                    <img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
                </div>
                <div class="row">
                    <label>
                        <?= $qresult ?>
                    </label>
                </div>
                <div class="row">

                    <?php
                        if( $qresult == 'Password Changed' ){
                            echo '<a href="'.base_url().'">Login to Activations</a>';
                        }else{
                            echo 'Please click again the link from your email inbox.';
                        }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>