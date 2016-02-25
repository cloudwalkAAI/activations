<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Activations</title>
    <link rel="stylesheet" href="<?=base_url('assets/css/custom.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/foundation.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/constants.css');?>">
    <link rel="stylesheet" href="<?=base_url('assets/css/foundation-icons/foundation-icons.css');?>">
	<link rel="shortcut icon" type="image/png" href="<?= base_url('assets/img/logos/header_logo-c.png')?>"/>
    <script>
        var MyNameSpace = {
            config: {
                base_url: "<?php echo base_url(); ?>",
                base_url_profile: "<?php echo base_url('assets/img/profile'); ?>"
            }
        }
    </script>
    <script type="text/javascript" src="<?= base_url('assets/js/jquery-1.11.3.min.js');?>"></script>    
    <script src="<?=base_url('assets/js/vendor/modernizr.js');?>"></script>
    <script src="<?=base_url('assets/js/ckeditorjs/ckeditor.js');?>"></script>
	<?php
		if(isset($homepage) && $homepage == true){
	?>
	<style type="text/css">
		body{
			background-image:url('<?=base_url('assets/img/bg/BG.jpg');?>');
			background-repeat:no-repeat;
			background-size:cover;
		}
	</style>
	<?php
		}
	?>
</head>
<body>

<div id="fb-root"></div>
<script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
        fjs.parentNode.insertBefore(js, fjs);
    }(document, 'script', 'facebook-jssdk'));</script>

<div class="off-canvas-wrap" data-offcanvas>
    <div class="inner-wrap">

        <?php
        if(isset($navigator)){
            echo $navigator;
        }
        ?>

        <section class="main-section">
            <?=$content?>
        </section>

        <a class="exit-off-canvas"></a>

    </div>
</div>

<script src="<?=base_url('assets/js/vendor/jquery.js');?>"></script>
<script src="<?=base_url('assets/js/foundation.min.js');?>"></script>
<script src="<?=base_url('assets/js/foundation/foundation.offcanvas.js');?>"></script>
<script src="<?=base_url('assets/js/jquery.form.js');?>"></script>
<script src="<?=base_url('assets/js/jquery-ui.min.js');?>"></script>
<script src="<?=base_url('assets/js/cf77f9273ab747e14102a80d1d5b6d51.js');?>"></script>
<script src="<?=base_url('assets/js/sorttable.js');?>"></script>
<script type="text/javascript" src="<?= base_url('assets/js/jquery.maskedinput.js');?>"></script>
<script>
    $(document).foundation({
        abide: {
            patterns: {
                password: /^(.){8,}$/
            }
        }
    });
    $(".off-canvas-submenu").hide();
    $(".off-canvas-submenu-call").click(function() {
        var icon = $(this).parent().next(".off-canvas-submenu").is(':visible') ? '+' : '-';
        $(this).parent().next(".off-canvas-submenu").slideToggle('fast');
        $(this).find("span").text(icon);
    });

</script>
</body>
<link rel="stylesheet" href="<?=base_url('assets/css/jquery.datetimepicker.css');?>">
<script src="<?=base_url('assets/js/datepicker/jquery.datetimepicker.full.min.js');?>"></script>
<script>
	jQuery(function($){
	   $("#inp_contactnumber").mask("(0999) 999-9999");
	});
    jQuery.datetimepicker.setLocale('en');

    jQuery('#datepicker_deadline, #datepicker_details, #inp_birthday').datetimepicker({
        timepicker:false,
        format:'m/d/Y'
    });

    jQuery('#datepicker_emp, #inp_birthday_u').datetimepicker({
        timepicker:false,
        format:'m/d/Y'
    });

    jQuery('#inp_mom_date').datetimepicker({
        timepicker:true,
        format:'Y/d/m h:i:s'
    });

    $(document).ready(function(){
        $('.calendar .day').click(function(){
            day_num = $(this).find('.day_num').html();
            day_data = prompt('Enter details');
            if (day_data != null){

                $.ajax({
                    url: window.location,
                    type: 'POST',
                    data: {
                        day: day_num,
                        data: day_data
                    },
                    success: function(msg){
                        location.reload();
                    }
                });
            }
        });
    });

</script>

</html>