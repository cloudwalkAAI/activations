<div class="large-3 large-centered columns" style="padding-top: 12%;">
    <div class="login-box">
        <div class="row">
            <div class="large-12 columns">
                <form action="<?=base_url('login/verification');?>" method="POST">

                    <div class="row" style="text-align: center;">
                        <img class="login_logo" src="<?= base_url('assets/img/logos/header_logo-c.png')?>" alt="">
                    </div>

                    <?php
                    if( isset($param_get) ){
                        echo '
                            <div data-alert class="alert-box alert radius">
                                Invalid login
                                <a href="#" class="close">&times;</a>
                            </div>
                        ';
                    }
                    ?>
                    <div class="row">
                        <div class="large-12 columns">
                            <input type="text" name="username" placeholder="Username" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <input type="password" name="password" placeholder="Password" />
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 large-centered columns">
                            <input type="submit" class="button expand" value="Log In"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>