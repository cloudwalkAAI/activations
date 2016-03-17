function reload_date_picker(){

    jQuery('#datepicker_deadline, #datepicker_details, #inp_birthday, #datepicker_emp, #inp_birthday_u').datetimepicker({
        timepicker:false,
        format:'m/d/Y'
    });
}

$('#btn_share_jo').on('click',function(){
    $('#share_jo_ae').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'jo/share_jo',
        success:  function(response){
            if( response > 0 ){
                $('#inp_ae_id').val('');
                $('#temp_name').val('');
                $('#alert_box_share').show();
                setTimeout(function(){
                    $('#alert_box_share').hide();
                },3000);
            }
        }
    });
});
$('#inp_ae_id').on('keydown',function(){
    if($('#inp_ae_id').val().length >= 10){
        $.ajax({
            url: MyNameSpace.config.base_url+'jo/search_ae',
            type:'post',
            data: {
                'aeid' : $('#inp_ae_id').val()
            },
            beforeSubmit: function(arr, jform, option){
                $('#temp_name').val('Please Wait...');
            },
            success: function(data) {
                if( data != null ){
                    $('#temp_name').val(data);
                }
            }
        });
    }
});

$('#inp_client_edit').on('change',function(){
    $.ajax({
        url: MyNameSpace.config.base_url+'jo/load_brand',
        type:'post',
        data: {
            cid : $('#inp_client_edit').val()
        },
        success: function(data) {
            var arr = data.split(',');
            $('label#hd').show();
            $('#inp_brand_edit').empty();

            $.each( json, function( key, value ) {
                $('#inp_brand_edit')
                    .append($("<option></option>")
                        .attr("value", value)
                        .text(value));
            });
        }
    });
});
$('#inp_client').on('change',function(){
    $.ajax({
        url: MyNameSpace.config.base_url+'jo/load_brand',
        type:'post',
        data: {
            cid : $('#inp_client').val()
        },
        success: function(data) {
            var arr = data.split(',');
            $('label#hd').show();
            $('#inp_brand').empty();

            $.each( arr, function( key, value ) {
                $('#inp_brand')
                    .append($("<option></option>")
                        .attr("value", value)
                        .text(value));
            });
        }
    });
});
$('#btn_save_jo_edit').on('click',function(){
    var dataString = "joid="+$();
    $.ajax({
        type: "POST",
        url: MyNameSpace.config.base_url +'jo/get_jo',
        data: dataString,
        success: function (response) {
            $('#joEditModal').foundation( 'reveal', 'close' );
        }
    });
});
function getJoId(x){
    var parent = $(x).parents(".jolist");
    var joid = parent.attr("alt");
    $("#joid").val(joid);
    var dataString = "joid="+joid;
    $('#joEditModal').foundation( 'reveal', 'open' );
    $.ajax({
        type: "POST",
        url: MyNameSpace.config.base_url +'jo/get_jo',
        data: dataString,
        success: function (response) {
            $("#contentJoEdit").empty();
            $("#contentJoEdit").html(response);
        }
    });
}

$('#form_jo').ajaxForm({
    type: 'POST',
    url: MyNameSpace.config.base_url+'jo/add_jo',
    beforeSubmit: function(arr, jform, option){
        $('#btn_save_jo').prop('disabled', true);

        if($('#inp_client').val() == 0){
            $("#alert_box").removeClass("success");
            $("#alert_box").removeClass("alert");
            $("#alert_box").addClass("warning");
            $('#alert_box').text();
            $('#alert_box').text("You haven't select a client!.");
            $('#alert_box').show();
            $('#btn_save_jo').prop('disabled', false);
            return false;
        }else if( $("#inp_brand").val() == 0 ){
            $("#alert_box").removeClass("success");
            $("#alert_box").removeClass("alert");
            $("#alert_box").addClass("warning");
            $('#alert_box').text();
            $('#alert_box').text("You haven't select a brand!.");
            $('#alert_box').show();
            $('#btn_save_jo').prop('disabled', false);
            return false;
        }else if( $("#form_jo input:checkbox:checked").length == 0 ){
            $("#alert_box").removeClass("success");
            $("#alert_box").removeClass("alert");
            $("#alert_box").addClass("warning");
            $('#alert_box').text();
            $('#alert_box').text("You haven't choose a project type!.");
            $('#alert_box').show();
            $('#btn_save_jo').prop('disabled', false);
            return false;
        }else if( $.trim( $('#inp_projname').val() ) == '' ){
            $("#alert_box").removeClass("success");
            $("#alert_box").removeClass("alert");
            $("#alert_box").addClass("warning");
            $('#alert_box').text();
            $('#alert_box').text("You haven't input a project name!.");
            $('#alert_box').show();
            $('#btn_save_jo').prop('disabled', false);
            return false;
        }else{
            $('#alert_box').hide();
        }
    },
    success:  function(response){
        //var rep1 = response.replace("[","");
        //var rep2 = rep1.replace("]","");
        var json = $.parseJSON(response);
        $('input:checkbox').removeAttr('checked');
        $('#inp_projname').val('');
        $('#inp_client').val('0');
        $('label#hd').hide();
        $('#btn_save_jo').prop('disabled', false);
        var lidata = '<li class="jolist">'+
            '<div class="small-7 medium-8 large-8 columns" style="padding: 50px;">' +
            '<h3>'+json.project_name+'</h3>' +
            '<h5><a href="'+MyNameSpace.config.base_url+'jo/in?a='+json.jo_id+'">JO NO.'+json.jo_number+'</a></h5>'+
            '<h6>'+json.date_created+'</h6>'+
            '</div>'+
            '<div class="small-5 medium-4 large-4 columns text-right" style="padding: 12px;">'+
            '<ul class="inline-list jorightlist right">'+
            '<li><a href="#"><img src="'+MyNameSpace.config.base_url+'assets/img/logos/Edit.png" /></a></li>'+
            '</ul>'+
            '<div class="large-12 columns text-right" style="padding-right: 30px;">'+
            '<p style="margin-top: 10px;">'+json.project_type+'</p>'+
            '<p>'+json.client_company_name+'</p>'+
            '<p>'+json.brand+'</p>'+
            '<p>DO: '+json.do_contract_no+'</p>'+
            '<p>Billed: '+json.billed_date+'</p>'+
            '<p>Paid: '+json.paid_date+'</p>'+
            '</div>'+
            '</div>'+
            '<div class="clearfix"></div>'+
            '</li>';

        $(lidata).appendTo("#jo_table_list");
        window.location.href = MyNameSpace.config.base_url + "jo";
    }

});

$('#btn_export').on('click', function(){
    $('#form_archive').ajaxForm({
        type: 'post',
        url: MyNameSpace.config.base_url+'jo/mpdf_ajax',
        success:  function(response){
            //window.open(response, '_blank');
            var newWin = window.open('', '_blank');
            newWin.location = response;
        }
    }).submit();
});

$('#emp_form').ajaxForm({
    type: 'POST',
    url: MyNameSpace.config.base_url+'emp/add_emp',
    beforeSubmit: function(arr, jform, option){
        $('#btn_add_emp').prop('disabled', true);

        if($('#sel_dept').val() == 0){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("Choose a department!");
            $('#alert_box_emp').show();
            $('#btn_add_emp').prop('disabled', false);
            return false;
        }else if( $("#sel_pos").val() == 0 ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("Choose a position!");
            $('#alert_box_emp').show();
            $('#btn_add_emp').prop('disabled', false);
            return false;
        }else if( $("#sel_role").val() == 0 ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("Choose a role!");
            $('#alert_box_emp').show();
            $('#btn_add_emp').prop('disabled', false);
            return false;
        }else if( $("#sel_status").val() == 0 ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("Choose a status!");
            $('#alert_box_emp').show();
            $('#btn_add_emp').prop('disabled', false);
            return false;
        }else if($.trim( $('#inp_firstname').val() ) == '' ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("You haven't input the first name!");
            $('#alert_box_emp').show();
            $('#btn_add_emp').prop('disabled', false);
            return false;
        }else if($.trim( $('#inp_email').val() ) == '' ){
            $("#alert_box_emp").removeClass("warning");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("You haven't input the email!");
            $('#alert_box_emp').show();
            $('#btn_add_emp').prop('disabled', false);
            return false;
        }else if( $.trim( $('#inp_lastname').val() ) == '' ){
            $("#alert_box_emp").removeClass("warning");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("You haven't input the last name!");
            $('#alert_box_emp').show();
            $('#btn_add_emp').prop('disabled', false);
            return false;
        }else if( $.trim( $('#inp_midname').val() ) == '' ){
            $("#alert_box_emp").removeClass("warning");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("You haven't input the middle name!");
            $('#alert_box_emp').show();
            $('#btn_add_emp').prop('disabled', false);
            return false;
        }else if( $.trim( $('#datepicker_emp').val() ) == '' || $('#datepicker_emp').val() == '00-00-0000' ){
            $("#alert_box_emp").removeClass("warning");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("You haven't input the date!");
            $('#alert_box_emp').show();
            $('#btn_add_emp').prop('disabled', false);
            return false;
        }else{
            $('#alert_box_emp').hide();
            $('#alert_box_progress').show();
        }
    },
    complete: function() { $('#alert_box_progress').hide();},
    success:  function(response){

        if( response == 'exist' ){

            $("#alert_box_emp_box").removeClass("success");
            $("#alert_box_emp_box").removeClass("alert");
            $("#alert_box_emp_box").addClass("warning");
            $('#alert_box_emp_box').text();
            $('#alert_box_emp_box').text("Email already used!");
            $('#alert_box_emp_box').show();

        }else{
			$('#alert_box_progress').html('Saved Successfully.');
			$('#alert_box_progress').show();
			setTimeout(function(){
				$('#alert_box_progress').hide();
				window.location.href = MyNameSpace.config.base_url+'emp';
			},3000);
        }
    }
});

$('#emp_form_up').ajaxForm({
    type: 'POST',
    url: MyNameSpace.config.base_url+'emp/update_details',
    beforeSubmit: function(arr, jform, option){
        $('#btn_add_emp_u').prop('disabled', true);

        if($('#sel_dept').val() == 0){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("Choose a department!");
            $('#alert_box_emp').show();
            $('#btn_add_emp_u').prop('disabled', false);
            return false;
        }else if( $("#sel_pos").val() == 0 ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("Choose a position!");
            $('#alert_box_emp').show();
            $('#btn_add_emp_u').prop('disabled', false);
            return false;
        }else if( $("#sel_role").val() == 0 ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("Choose a role!");
            $('#alert_box_emp').show();
            $('#btn_add_emp_u').prop('disabled', false);
            return false;
        }else if( $("#sel_status").val() == 0 ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("Choose a status!");
            $('#alert_box_emp').show();
            $('#btn_add_emp_u').prop('disabled', false);
            return false;
        }else if($.trim( $('#inp_firstname').val() ) == '' ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("You haven't input the first name!");
            $('#alert_box_emp').show();
            $('#btn_add_emp_u').prop('disabled', false);
            return false;
        }else if($.trim( $('#inp_email').val() ) == '' ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("You haven't input the email!");
            $('#alert_box_emp').show();
            $('#btn_add_emp_u').prop('disabled', false);
            return false;
        }else if( $.trim( $('#inp_lastname').val() ) == '' ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("You haven't input the last name!");
            $('#alert_box_emp').show();
            $('#btn_add_emp_u').prop('disabled', false);
            return false;
        }else if( $.trim( $('#inp_midname').val() ) == '' ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("You haven't input the middle name!");
            $('#alert_box_emp').show();
            $('#btn_add_emp_u').prop('disabled', false);
            return false;
        }else if( $.trim( $('#datepicker_emp').val() ) == '' || $('#datepicker_emp').val() == '00-00-0000' ){
            $("#alert_box_emp").removeClass("success");
            $("#alert_box_emp").removeClass("alert");
            $("#alert_box_emp").addClass("warning");
            $('#alert_box_emp').text();
            $('#alert_box_emp').text("You haven't input the date!");
            $('#alert_box_emp').show();
            $('#btn_add_emp_u').prop('disabled', false);
            return false;
        }else{
            $('#alert_box_emp').hide();
        }
    },
    success:  function(response){
        // var json = $.parseJSON(response);

        // $("#tbdy_emp").empty();

        // $.each( json, function( key, value ) {
        // // $(value).appendTo("#emp_table > tbody");
        // });
        //alert_box_emp_success
        $("#alert_box_emp_success").removeClass("success");
        $("#alert_box_emp_success").removeClass("alert");
        $("#alert_box_emp_success").addClass("warning");
        $('#alert_box_emp_success').text();
        $('#alert_box_emp_success').text("Saved Successfully.");
        $('#alert_box_emp_success').show();

        setTimeout(function(){
            $('#alert_box_emp_success').hide();
			window.location.href = MyNameSpace.config.base_url+'emp';
        },3000);

        // $('#alert_box_emp_success').val();		
        // $('#empModalupdate').foundation( 'reveal', 'open' );
        // $('#btn_add_emp_u').prop('disabled', false);
    }

});

$('#oldpass').on('keyup',function(){
    if($('#oldpass').val().length < 7){
        $('#sml_pass').show();
    }else if($('#oldpass').val().length >= 7){
        $('#sml_pass').css('display','none');
    }
});

$('#npass').on('keyup',function(){
    if($('#npass').val().length < 7){
        $('#sml_pass1').show();
    }else if($('#npass').val().length >= 7){
        $('#sml_pass1').css('display','none');
    }
});

$('#repass').keyup(function(){
    if($('#repass').val().length < 7){
        $('#sml_pass2').show();
    }else{
        $('#sml_pass2').css('display','none');
    }
});

$('#cpass_form').ajaxForm({
    type: 'POST',
    url: MyNameSpace.config.base_url+'c/cpass',
    beforeSubmit: function(arr, jform, option){
        $('#btn_cpass').prop('disabled', true);

        if($('#npass').val().length < 7){
            $("#sml_pass1").removeClass("success");
            $("#sml_pass1").removeClass("alert");
            $("#sml_pass1").addClass("warning");
            $('#sml_pass1').show();
            $('#btn_cpass').prop('disabled', false);
            return false;
        }else if( $("#repass").val().length < 7 ){
            $("#sml_pass2").removeClass("success");
            $("#sml_pass2").removeClass("alert");
            $("#sml_pass2").addClass("warning");
            $('#sml_pass2').show();
            $('#btn_cpass').prop('disabled', false);
            return false;
        }else if( $("#repass").val() == $('#npass').val() ){
            $("#sml_pass1").removeClass("success");
            $("#sml_pass1").removeClass("alert");
            $("#sml_pass1").addClass("warning");
            $('#sml_pass1').text('');
            $('#sml_pass1').text('Password do not match');
            $('#sml_pass1').show();

            $("#sml_pass2").removeClass("success");
            $("#sml_pass2").removeClass("alert");
            $("#sml_pass2").addClass("warning");
            $('#sml_pass2').text('');
            $('#sml_pass2').text('Password do not match');
            $('#sml_pass2').show();

            setTimeout(function(){
                $('#sml_pass1').css('display','none');
                $('#sml_pass2').css('display','none');
            },5000);
        }else{

        }
        $('#sml_pass1').css('display','none');
        $('#sml_pass2').css('display','none');
    },
    success:  function(response){
        //console.log(response);
        //var json = $.parseJSON(response);
        $('#pass_content').empty();
        $('#pass_content').append(response);
        $('#btn_cpass').prop('disabled', false);
        $('#cpass_alert').show();
    }

});

$('#cpass_form_profile').ajaxForm({
    type: 'POST',
    url: MyNameSpace.config.base_url+'c/cpass',
    beforeSubmit: function(arr, jform, option){
        $('#btn_cpass').prop('disabled', true);

        if($('#npass').val().length < 7){
            $("#sml_pass1").removeClass("success");
            $("#sml_pass1").removeClass("alert");
            $("#sml_pass1").addClass("warning");
            $('#sml_pass1').show();
            $('#btn_cpass').prop('disabled', false);
            return false;
        }else if( $("#repass").val().length < 7 ){
            $("#sml_pass2").removeClass("success");
            $("#sml_pass2").removeClass("alert");
            $("#sml_pass2").addClass("warning");
            $('#sml_pass2').show();
            $('#btn_cpass').prop('disabled', false);
            return false;
        }else if( $("#repass").val() == $('#npass').val() ){
            $("#sml_pass1").removeClass("success");
            $("#sml_pass1").removeClass("alert");
            $("#sml_pass1").addClass("warning");
            $('#sml_pass1').text('');
            $('#sml_pass1').text('Password do not match');
            $('#sml_pass1').show();

            $("#sml_pass2").removeClass("success");
            $("#sml_pass2").removeClass("alert");
            $("#sml_pass2").addClass("warning");
            $('#sml_pass2').text('');
            $('#sml_pass2').text('Password do not match');
            $('#sml_pass2').show();

            setTimeout(function(){
                $('#sml_pass1').css('display','none');
                $('#sml_pass2').css('display','none');
            },5000);
        }else{

        }
        $('#sml_pass1').css('display','none');
        $('#sml_pass2').css('display','none');
    },
    success:  function(response){
        //console.log(response);
        if( response == 'Password Changed' ){
            $('#alert_box_profile_pass').css('display','block');
            setTimeout(
                function(){
                    $('#alert_box_profile_pass').css('display','none');
                },3000
            );
        }

        $('#btn_cpass').prop('disabled', false);
    }

});

$('#cpass_form_profile_pv').ajaxForm({
    type: 'POST',
    url: MyNameSpace.config.base_url+'c/cpass_pv',
    beforeSubmit: function(arr, jform, option){
        $('#btn_cpass').prop('disabled', true);

        if($('#npass').val().length < 7){
            $("#sml_pass1").removeClass("success");
            $("#sml_pass1").removeClass("alert");
            $("#sml_pass1").addClass("warning");
            $('#sml_pass1').show();
            $('#btn_cpass').prop('disabled', false);
            return false;
        }else if( $("#repass").val().length < 7 ){
            $("#sml_pass2").removeClass("success");
            $("#sml_pass2").removeClass("alert");
            $("#sml_pass2").addClass("warning");
            $('#sml_pass2').show();
            $('#btn_cpass').prop('disabled', false);
            return false;
        }else if( $("#repass").val() == $('#npass').val() ){
            $("#sml_pass1").removeClass("success");
            $("#sml_pass1").removeClass("alert");
            $("#sml_pass1").addClass("warning");
            $('#sml_pass1').text('');
            $('#sml_pass1').text('Password do not match');
            $('#sml_pass1').show();

            $("#sml_pass2").removeClass("success");
            $("#sml_pass2").removeClass("alert");
            $("#sml_pass2").addClass("warning");
            $('#sml_pass2').text('');
            $('#sml_pass2').text('Password do not match');
            $('#sml_pass2').show();

            setTimeout(function(){
                $('#sml_pass').css('display','none');
                $('#sml_pass1').css('display','none');
                $('#sml_pass2').css('display','none');
            },5000);
        }else{

        }
        //$('#sml_pass1').css('display','none');
        //$('#sml_pass2').css('display','none');
    },
    success:  function(response){
        //console.log(response);
        if( response == 'changed' ){
            $("#alert_box_profile_pass").removeClass("alert");
            $("#alert_box_profile_pass").addClass("warning");
            $("#alert_box_profile_pass").text('');
            $("#alert_box_profile_pass").text('Update Success.');
            $('#alert_box_profile_pass').css('display','block');

            $('#oldpass').val('');
            $('#npass').val('');
            $('#repass').val('');

            $('#sml_pass').css('display','none');
            $('#sml_pass1').css('display','none');
            $('#sml_pass2').css('display','none');

            setTimeout(
                function(){
                    $('#modal_change_password').foundation('reveal', 'close');
                    $('#alert_box_profile_pass').css('display','none');
                },3000
            );
        }else if( response == 'pinc' ){
            $("#alert_box_profile_pass").removeClass("success");
            $("#alert_box_profile_pass").addClass("warning");
            $("#alert_box_profile_pass").text('');
            $("#alert_box_profile_pass").text('Password Incorrect.');
            $('#alert_box_profile_pass').css('display','block');

            $('#oldpass').val('');
            $('#npass').val('');
            $('#repass').val('');

            $('#sml_pass').css('display','none');
            $('#sml_pass1').css('display','none');
            $('#sml_pass2').css('display','none');

            setTimeout(
                function(){
                    $('#alert_box_profile_pass').css('display','none');
                },3000
            );
        }else{
            $("#alert_box_profile_pass").removeClass("success");
            $("#alert_box_profile_pass").addClass("warning");
            $("#alert_box_profile_pass").text('');
            $("#alert_box_profile_pass").text('Update Failed.');
            $('#alert_box_profile_pass').css('display','block');

            $('#oldpass').val('');
            $('#npass').val('');
            $('#repass').val('');
            $('#sml_pass').css('display','none');
            $('#sml_pass1').css('display','none');
            $('#sml_pass2').css('display','none');

            setTimeout(
                function(){
                    $('#alert_box_profile_pass').css('display','none');
                },3000
            );
        }

        $('#btn_cpass').prop('disabled', false);
    }

});

$('#attach_form').ajaxForm({
    type: 'POST',
    url: MyNameSpace.config.base_url+'jo/attached',
    beforeSubmit: function(arr, jform, option){
        $('#btn_add_attach').prop('disabled', true);
        if( $('#sel_reference').val() == 0 ){
            $('#ref_al').show();
            $('#btn_add_attach').prop('disabled', false);
            return false;
        }
    },
    uploadProgress: function (event, position, total, percentComplete){
        $('#ref_al').hide();
        $("#progress-bar").width(percentComplete + '%');
        $("#progress-bar").html('<div id="progress-status">' + percentComplete +' %</div>')
    },
    success:  function(response){
        //var json = $.parseJSON(response);
        $('#btn_add_attach').prop('disabled', false);
        if( response == 'success' ){
            $("#alert_box_attach").removeClass("success");
            $("#alert_box_attach").removeClass("alert");
            $("#alert_box_attach").addClass("warning");
            $('#alert_box_attach').hide();
            $('#alert_box_attach_ok').show();

            $('#inp_file_attachments').val('');
            $("#sel_reference").prop('selectedIndex', 0);

            setTimeout(function(){
                $('#attachModal').foundation('reveal', 'close');
                $('#alert_box_attach_ok').hide();
                setTimeout(function(){
                    location.reload();
                }, 2000);
            }, 3000);
        }else{
            $('#alert_box_attach_ok').hide();
            $('#alert_box_attach').show();
        }
    }
});

$('#profile_form').ajaxForm({
    type: 'POST',
    url: MyNameSpace.config.base_url+'emp/update_profile',
    beforeSubmit: function(arr, jform, option){
        $('#btn_profile_save').prop('disabled', true);
    },
    success:  function(response){
        var rep1 = response.replace("[","");
        var rep2 = rep1.replace("]","");
        var json = $.parseJSON(rep2);
        ////console.log(json);
        //$('#btn_profile_save').prop('disabled', false);

        if ( json.length == 0 ) {
            $("#alert_box_profile").removeClass("success");
            $("#alert_box_profile").addClass("success");
            $("#alert_box_profile").text('');
            $("#alert_box_profile").text('Json parse error.');
            $("#alert_box_profile").show();
            $('#btn_profile_save').prop('disabled', false);
        }else{

            $( '#prof_fname' ).val(json.first_name);
            $( '#prof_mname' ).val(json.middle_name);
            $( '#prof_lname' ).val(json.sur_name);
            $( '#ta_contact' ).text(json.contact_nos);

            $("#alert_box_profile").removeClass("alert");
            $("#alert_box_profile").addClass("success");
            $("#alert_box_profile").text('');
            $("#alert_box_profile").text('Update Success.');
            $("#alert_box_profile").show();
            $('#btn_profile_save').prop('disabled', false);
        }
    }
});

$('#btn_mom_submit').on('click', function(){
    $('#mom_form').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'jo/jo_save',
        data:{
            'editor_campaign_overview' : CKEDITOR.instances.editor_campaign_overview.getData(),
            'editor_activation_flow' : CKEDITOR.instances.editor_activation_flow.getData(),
            'editor_other_details' : CKEDITOR.instances.editor_other_details.getData(),
            'editor_next' : CKEDITOR.instances.editor_next.getData()
        },
        beforeSubmit: function(arr, jform, option){
            $('#btn_mom_submit').prop('disabled', true);
        },
        success:  function(response){
            if( response == 'success' ){
                $("#alert_box_mom_form_success").removeClass("success");
                $("#alert_box_mom_form_success").removeClass("alert");
                $("#alert_box_mom_form_success").addClass("warning");
                $('#alert_box_mom_form_fail').hide();
                $('#alert_box_mom_form_success').show();
            }else{
                $("#alert_box_mom_form_fail").removeClass("success");
                $("#alert_box_mom_form_fail").removeClass("alert");
                $("#alert_box_mom_form_fail").addClass("warning");
                $('#alert_box_mom_form_success').hide();
                $('#alert_box_mom_form_fail').show();
            }
            $('#btn_mom_submit').prop('disabled', false);
        }
    }).submit();
});

$('#btn_save_ed').on('click', function(){
    $('#event_details_form').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'jo/jo_save_ed',
        data:{
            'editor_event_spec' : CKEDITOR.instances.editor_event_spec.getData()
        },
        beforeSubmit: function(arr, jform, option){
            $('#btn_save_ed').prop('disabled', true);
        },
        success:  function(response){
            if( response == 'success' ){
                $("#alert_box_ed_form_success").removeClass("success");
                $("#alert_box_ed_form_success").removeClass("alert");
                $("#alert_box_ed_form_success").addClass("warning");
                $('#alert_box_ed_form_fail').hide();
                $('#alert_box_ed_form_success').show();
            }else{
                $("#alert_box_ed_form_fail").removeClass("success");
                $("#alert_box_ed_form_fail").removeClass("alert");
                $("#alert_box_ed_form_fail").addClass("warning");
                $('#alert_box_ed_form_success').hide();
                $('#alert_box_ed_form_fail').show();
            }
            $('#btn_save_ed').prop('disabled', false);
        }
    });
});

$('#btn_mvrf_submit').on('click',function(){
    $('#mvrf_form').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'jo/jo_mvrf',
        data:{
            'ta_mvrf' : CKEDITOR.instances.ta_mvrf.getData()
        },
        beforeSubmit: function(arr, jform, option){
            $('#btn_mvrf_submit').prop('disabled', true);

        },
        success:  function(response){
            if( response == 'success' ){
                $("#alert_box_mvfr").removeClass("alert");
                $("#alert_box_mvfr").addClass("warning");
                $('#alert_box_mvfr').text();
                $('#alert_box_mvfr').text("Successfully Saved");
                $('#alert_box_mvfr').show();
                setTimeout(function(){
                    $('#alert_box_mvfr').hide();
                },3000);
            }else{
                $("#alert_box_mvfr").removeClass("alert");
                $("#alert_box_mvfr").removeClass("success");
                $("#alert_box_mvfr").addClass("warning");
                $('#alert_box_mvfr').text();
                $('#alert_box_mvfr').text("Fail to Save");
                $('#alert_box_mvfr').show();
                setTimeout(function(){
                    $('#alert_box_mvfr').hide();
                },3000);
            }
            $('#btn_mvrf_submit').prop('disabled', false);
        }
    }).submit();
});

$('#btn_other_submit').on('click',function(){
    $('#other_form').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'jo/jo_other',
        data:{
            'ta_Other' : CKEDITOR.instances.ta_Other.getData()
        },
        beforeSubmit: function(arr, jform, option){
            $('#btn_other_submit').prop('disabled', true);

        },
        success:  function(response){
            // ////console.log(response);
            if( response == 'success' ){
                $("#alert_box_oth").removeClass("alert");
                $("#alert_box_oth").addClass("warning");
                $('#alert_box_oth').text();
                $('#alert_box_oth').text("Successfully Saved");
                $('#alert_box_oth').show();
                setTimeout(function(){
                    $('#alert_box_oth').hide();
                },3000);
            }else{
                $("#alert_box_oth").removeClass("alert");
                $("#alert_box_oth").addClass("warning");
                $('#alert_box_oth').text();
                $('#alert_box_oth').text("Fail to Save");
                $('#alert_box_oth').show();
                setTimeout(function(){
                    $('#alert_box_oth').hide();
                },3000);
            }
            $('#btn_other_submit').prop('disabled', false);
        }
    }).submit();
});

$('#btn_setup_submit').on('click',function(){
    $('#setup_form').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'jo/jo_setup',
        data:{
            'setup_particular' : CKEDITOR.instances.setup_particular.getData()
        },
        beforeSubmit: function(arr, jform, option){
            $('#btn_setup_submit').prop('disabled', true);

        },
        success:  function(response){
            // ////console.log(response);
            if( response == 'success' ){
                $("#alert_box_set").removeClass("alert");
                $("#alert_box_set").addClass("warning");
                $('#alert_box_set').text();
                $('#alert_box_set').text("Successfully Saved");
                $('#alert_box_set').show();
                setTimeout(function(){
                    $('#alert_box_set').hide();
                },3000);
            }else{
                $("#alert_box_set").removeClass("success");
                $("#alert_box_set").addClass("warning");
                $('#alert_box_set').text();
                $('#alert_box_set').text("Fail to Save");
                $('#alert_box_set').show();
                setTimeout(function(){
                    $('#alert_box_set').hide();
                },3000);
            }
            $('#btn_setup_submit').prop('disabled', false);
        }
    }).submit();
});

$('#btn_add_detail').on('click', function(){
    $('#detail_form').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'jo/jo_save_ed_details',
        beforeSubmit: function(arr, jform, option){
            $('#btn_add_detail').prop('disabled', true);
        },
        success:  function(response){
            if( response == 'fail' ){

                $("#alert_box_details").removeClass("success");
                $("#alert_box_details").addClass("warning");
                $("#alert_box_details").text('');
                $("#alert_box_details").text('Save Failed.');
                $("#alert_box_details").show();

            }else{

                $("#eda_particulars").val("");
                $("#eda_activity").val("");
                $("#eda_sched").val("");
                $("#eda_sell").val("");
                $("#eda_fly").val("");
                $("#eda_survey").val("");
                $("#eda_experiment").val("");
                $("#eda_other").val("");
                $("#datepicker_details").val("");
                $("#eda_duration").val("");
                $("#editor_detail").val("");
                $("#alert_box_details").removeClass("alert");
                $("#alert_box_details").removeClass("success");
                $("#alert_box_details").addClass("warning");
                $("#alert_box_details").text('');
                $("#alert_box_details").text('Save Success.');
                $("#alert_box_details").show();

                reload_animation_table(response);

                setTimeout( function(){
                    $('#detailsModal').foundation('reveal', 'close');
                    $("#alert_box_details").hide();
                }, 3000 );
            }

            $('#btn_add_detail').prop('disabled', false);
        }
    });
});

$('#btn_add_requ').on('click', function(){
    $('#requ_form').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'jo/jo_save_req',
        beforeSubmit: function(arr, jform, option){
            $('#btn_add_requ').prop('disabled', true);
        },
        success:  function(response){
            //////console.log(response);
            if( response == 'fail' ){

                $("#alert_box_requ").removeClass("success");
                $("#alert_box_requ").addClass("warning");
                $("#alert_box_requ").text('');
                $("#alert_box_requ").text('Save Failed.');
                $("#alert_box_requ").show();

            }else{

                $("#sel_dept_ad").val('0');
                $("#editor_req").val('');
                $("#datepicker_deadline").val('');
                $("#editor_ns").val('');
                $("#alert_box_requ").removeClass("success");
                $("#alert_box_requ").addClass("warning");
                $("#alert_box_requ").text('');
                $("#alert_box_requ").text('Save Success.');
                $("#alert_box_requ").show();

                reload_req_table(response);

                setTimeout( function(){
                    $('#requModal').foundation('reveal', 'close');
                    $("#alert_box_requ").hide();
                }, 3000 );
            }
            $('#btn_add_requ').prop('disabled', false);
        }
    });
});

function reload_req_table( response_id ){
    $.ajax({
        url: MyNameSpace.config.base_url+'jo/reload_req_table',
        type:'post',
        data: {
            'reqid' : response_id
        },
        success: function(data) {
            $("#tbody_req").empty();
            $(data).appendTo("#tbl_req > tbody");
            search_req_reload();
        }
    });
}

function reload_animation_table( response_id ){
    $.ajax({
        url: MyNameSpace.config.base_url+'jo/reload_ada_table',
        type:'post',
        data: {
            'edaid' : response_id
        },
        success: function(data) {
            $("#tbody_animation").empty();
            $(data).appendTo("#tbl_animation > tbody");
            reload_table_animation();
        }
    });
}

$('#btn_add_pt').on('click', function(){
    $.ajax({
        url: MyNameSpace.config.base_url+'jo/add_pt',
        type:'post',
        data: {
            'pt_added' : $('#other_pt').val()
        },
        success: function(data) {
            ////console.log(data);
            $('#other_pt').val('')
            $('#pt_list').empty();
            $('#pt_list').append(data);
        }
    });
});

$('#form_client_u').ajaxForm({
    type: 'POST',
    url: MyNameSpace.config.base_url+'emp/update_client',
    beforeSubmit: function(arr, jform, option){
        $('#btn_update_client').prop('disabled', true);
        if( $.trim( $('#inp_companyname_u').val() ) == '' ){
            $("#alert_box_client").removeClass("success");
            $("#alert_box_client").addClass("warning");
            $('#alert_box_client').text();
            $('#alert_box_client').text("Input a company name.");
            $('#alert_box_client').show();
            $('#btn_update_client').prop('disabled', false);
            return false;
        }else if( $.trim( $('#inp_contactperson_u').val() ) == '' ){
            $("#alert_box_client").removeClass("success");
            $("#alert_box_client").addClass("warning");
            $('#alert_box_client').text();
            $('#alert_box_client').text("Input a contact person.");
            $('#alert_box_client').show();
            $('#btn_update_client').prop('disabled', false);
            return false;
        }else if( $.trim( $('#inp_contactnumber_u').val() ) == '' ){
            $("#alert_box_client").removeClass("success");
            $("#alert_box_client").addClass("warning");
            $('#alert_box_client').text();
            $('#alert_box_client').text("Input a contact number/s.");
            $('#alert_box_client').show();
            $('#btn_update_client').prop('disabled', false);
            return false;
        }else if( $.trim( $('#inp_birthday_u').val() ) == '' ){
            $("#alert_box_client").removeClass("success");
            $("#alert_box_client").addClass("warning");
            $('#alert_box_client').text();
            $('#alert_box_client').text("Select a birth date.");
            $('#alert_box_client').show();
            $('#btn_update_client').prop('disabled', false);
            return false;
        }else if( $.trim( $('#inp_email_u').val() ) == '' ){
            $("#alert_box_client").removeClass("success");
            $("#alert_box_client").addClass("warning");
            $('#alert_box_client').text();
            $('#alert_box_client').text("Input an email.");
            $('#alert_box_client').show();
            $('#btn_update_client').prop('disabled', false);
            return false;
        }
    },
    success:  function(response){
        //console.log(response);
        if( response > 0 ){
            $("#alert_box_client").removeClass("alert");
            $("#alert_box_client").addClass("warning");
            $("#alert_box_client").text('');
            $("#alert_box_client").text('Update Success. Refreshing page.');
            $("#alert_box_client").show();
            setTimeout(location.reload(), 3000);
        }else{
            $("#alert_box_client").removeClass("success");
            $("#alert_box_client").addClass("warning");
            $("#alert_box_client").text('');
            $("#alert_box_client").text('Json parse error.');
            $("#alert_box_client").show();
        }
        $('#btn_update_client').prop('disabled', false);
    }
});

$('.loadmombydate').on('click', function(){
    //alert($(this).attr('alt'));
    $.ajax({
        url: MyNameSpace.config.base_url+'jo/gminutes',
        type:'post',
        data: {
            'moid' : $(this).attr('alt')
        },
        success: function(data) {
            var rep1 = data.replace("[","");
            var rep2 = rep1.replace("]","");
            var json = $.parseJSON(rep2);

            $('.cc').val('');

            $('#inp_joid').val( json.jo_id );
            $('#what_text').val( json.what );
            $('#what_add').val( json.what_add_notes );
            $('#when_date').val( json.when );
            $('#when_add').val( json.what_add_notes );
            $('#where_text').val( json.where );
            $('#where_add').val( json.where_add_notes );
            $('#inp_mom_exp_guest').val( json.expected_guest );
            CKEDITOR.instances.editor_campaign_overview.setData( json.campaign_text );
            CKEDITOR.instances.editor_activation_flow.setData( json.act_flow_text );
            CKEDITOR.instances.editor_other_details.setData( json.other_details );
            CKEDITOR.instances.editor_next.setData( json.nsd );
            $('#inp_mom_attendees').val( json.attendees );
            $('#inp_mom_date').val( json.mom_date );
            $('#inp_mom_location').val( json.location );
            $('#inp_mom_agenda').val( json.agenda );
        }
    });
});

$('.loadedbydate').on('click', function(){
    //alert($(this).attr('alt'));return false;
    $.ajax({
        url: MyNameSpace.config.base_url+'jo/edgminutes',
        type:'post',
        data: {
            'edid' : $(this).attr('alt')
        },
        success: function(data) {
            var rep1 = data.replace("[","");
            var rep2 = rep1.replace("]","");
            var json = $.parseJSON(rep2);

            CKEDITOR.instances.editor_event_spec.setData( json.event_specification );
            $('#ed_what').val( json.what );
            $('#ed_what_add').val( json.what_add_notes );
            $('#ed_when_date').val( json.when );
            $('#ed_when_add').val( json.when_add_notes );
            $('#ed_where_text').val( json.what_add_notes );
            $('#ed_where_add').val( json.where_add_notes );
            $('#ed_expected_guest').val( json.expected_guest );

        }
    });
});

$('.loadsetupbydate').on('click', function(){
    //alert($(this).attr('alt'));return false;
    $.ajax({
        url: MyNameSpace.config.base_url+'jo/setupgminutes',
        type:'post',
        data: {
            'setupid' : $(this).attr('alt')
        },
        success: function(data) {
            var rep1 = data.replace("[","");
            var rep2 = rep1.replace("]","");
            var json = $.parseJSON(rep2);

            CKEDITOR.instances.setup_particular.setData( json.contents_setup );
        }
    });
});

$('.loadmvrfbydate').on('click', function(){
    //alert($(this).attr('alt'));return false;
    $.ajax({
        url: MyNameSpace.config.base_url+'jo/mvrfminutes',
        type:'post',
        data: {
            'mvrfid' : $(this).attr('alt')
        },
        success: function(data) {
            var rep1 = data.replace("[","");
            var rep2 = rep1.replace("]","");
            var json = $.parseJSON(rep2);

            CKEDITOR.instances.ta_mvrf.setData( json.contents );
        }
    });
});

function client_reload(){
    $('.load_client').on('click', function(){
        $.ajax({
            url: MyNameSpace.config.base_url+'emp/load_client_info',
            type:'post',
            data: {
                'setupid' : $(this).attr('alt')
            },
            success: function(data) {
                $.each($.parseJSON(data), function (item, value) {
                    if( item == 0 ){
                        $('#hid_client_id').val( value.client_id );
                        $('#inp_companyname_u').val( value.company_name );
                        $('#inp_contactperson_u').val( value.contact_person );
                        $('#inp_contactnumber_u').val( value.contact_number );
                        $('#inp_birthday_u').val( value.birth_date );
                        $('#inp_email_u').val( value.email );
                    }else if( item == 1 ){
                        $('div.input_fields_wrap_u').empty(); //add input box
                        $('div.input_fields_wrap_u').append(value); //add input box
                    }
                });
                reload_brand_u();
                $('#myModalclient_u').foundation('reveal', 'open');
            }
        });
    });

}
client_reload();

function load_click_emp(){
    $('.load_emp').on( 'click', function(){
        $.ajax({
            url: MyNameSpace.config.base_url+'emp/emp_details',
            type:'post',
            data: {
                usersid : $(this).data("id")
            },
            success: function(data) {
                var json = $.parseJSON(data);
                $('#user_id').val( json.eeid );
                $('#empid').text( 'ID no. : '+json.eid );
                $('#uid').val( json.eid );
                $('#inp_firstname_u').val( json.first_name );
                $('#inp_email_u').val( json.email );
                $('#inp_lastname_u').val( json.sur_name );
                $('#inp_midname_u').val( json.middle_name );
                $('#datepicker_emp_u').val( json.birth_date );

                //$('#profile_picture').val( json.img_loc );

                if( !jQuery.isEmptyObject( json.img_loc ) ){
                    //console.log(MyNameSpace.config.base_url_profile +'/'+ json.img_loc);
                    $("#profile_img").attr( "src", MyNameSpace.config.base_url_profile +'/'+ json.img_loc );
                }else{
                    $("#profile_img").attr( "src", MyNameSpace.config.base_url_profile +'/default.jpg' );
                }

                $("#sel_dept_u").val( json.department );
                $("#sel_pos_u").val( json.position );
                $("#sel_role_u").val( json.role );
                $("#sel_status_u").val( json.status );
                $('#empModalupdate').foundation('reveal', 'open');
            }
        });
    });
}
load_click_emp();

$('#upload_file').on('change', function(){
    readURL(this);
    $('#uploading_form').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url + 'settings/upload_img',
        success:  function(response){
            //console.log(response);
            if( response.substring(0, 6) == 'assets' ){
                $('.profile_img').attr("src", MyNameSpace.config.base_url+response);
            }else if( response == 'File is not an image.' ){
                $("#alert_box_upload").removeClass("success");
                $("#alert_box_upload").addClass("warning");
                $('#upload_desc').text('');
                $('#upload_desc').text(response);
                $('#uploadModal').foundation('reveal', 'open');
            }else if( response == 'Sorry, file already exists.' ){
                $("#alert_box_upload").removeClass("success");
                $("#alert_box_upload").addClass("warning");
                $('#upload_desc').text('');
                $('#upload_desc').text(response);
                $('#uploadModal').foundation('reveal', 'open');
            }else if( response == 'Sorry, your file is too large.' ){
                $("#alert_box_upload").removeClass("success");
                $("#alert_box_upload").addClass("warning");
                $('#upload_desc').text('');
                $('#upload_desc').text(response);
                $('#uploadModal').foundation('reveal', 'open');
            }else if( response == 'Sorry, only JPG, JPEG, PNG & GIF files are allowed.' ){
                $("#alert_box_upload").removeClass("success");
                $("#alert_box_upload").addClass("warning");
                $('#upload_desc').text('');
                $('#upload_desc').text(response);
                $('#uploadModal').foundation('reveal', 'open');
            }else if( response == 'Sorry, your file was not uploaded.' ){
                $("#alert_box_upload").removeClass("success");
                $("#alert_box_upload").addClass("warning");
                $('#upload_desc').text('');
                $('#upload_desc').text(response);
                $('#uploadModal').foundation('reveal', 'open');
            }else if( response == 'Sorry, there was an error uploading your file.' ){
                $("#alert_box_upload").removeClass("success");
                $("#alert_box_upload").addClass("warning");
                $('#upload_desc').text('');
                $('#upload_desc').text(response);
                $('#uploadModal').foundation('reveal', 'open');
            }else{
                $("#alert_box_upload").removeClass("success");
                $("#alert_box_upload").addClass("warning");
                $('#upload_desc').text('');
                $('#upload_desc').text('Somethings wrong. Please contact the administrator.');
                $('#uploadModal').foundation('reveal', 'open');
            }
        }
    }).submit();

});

$('#upload_file_button').on('click', function(){
    //alert('test');
    $('#upload_file').click();
});

/*for animation table*/
function reload_table_animation(){
    var $rows_animation = $('#tbody_animation tr');
    $('#search_animation').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows_animation.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
}
reload_table_animation();
/*end for jo table*/

/*for employee table*/
var $rows_emp = $('#tbdy_emp li');
$('#search_emp').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows_emp.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
/*end for employee table*/

/*for requirements table*/
function search_req_reload(){
    var $rows_req = $('#tbody_req tr');
    $('#search_requirements').keyup(function() {
        var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

        $rows_req.show().filter(function() {
            var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
            return !~text.indexOf(val);
        }).hide();
    });
}
search_req_reload();
/*end for requirements table*/

/*for account jo table*/
var $rows_account_jo = $('#tbody_account_jo tr');
$('#search_account_jo').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows_account_jo.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
/*end for account jo table*/

/*for clients table*/
var $rows_client = $('#client_table li');
$('#inp_search_client').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows_client.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
/*end for clients table*/

/*for JO list table*/
var $rows_jolist = $('#jo_table_list li');
$('#search_jolist').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows_jolist.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
/*end for JO list table*/

/*for JO-ED list table*/
var $rows_joanimlist = $('#tbody_animation tr');
$('#search_animation').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows_joanimlist.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
/*end for JO-ED list table*/

/*for JO-AD list table*/
var $rows_joreqlist = $('#tbody_req tr');
$('#search_requirements').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows_joreqlist.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
/*end for JO-AD list table*/

/*for accounts list table*/
var $rows_accounts = $('#tbody_accounts tr');
$('#search_accounts').keyup(function() {
    var val = $.trim($(this).val()).replace(/ +/g, ' ').toLowerCase();

    $rows_accounts.show().filter(function() {
        var text = $(this).text().replace(/\s+/g, ' ').toLowerCase();
        return !~text.indexOf(val);
    }).hide();
});
/*end for JO-AD list table*/

$('#show_table_mom').on('click', function(){
    $('#tbl_mom').toggle( "slide" );
    $('#tbl_other').hide( "slide" );
    $('#tbl_event_details').hide( "slide" );
    $('#tbl_setup').hide( "slide" );
    $('#tbl_mvrf').hide( "slide" );
});

$('#show_table_details').on('click', function(){
    $('#tbl_event_details').toggle( "slide" );
    $('#tbl_mom').hide( "slide" );
    $('#tbl_other').hide( "slide" );
    $('#tbl_setup').hide( "slide" );
    $('#tbl_mvrf').hide( "slide" );
});

$('#show_table_setup').on('click', function(){
    $('#tbl_setup').toggle( "slide" );
    $('#tbl_event_details').hide( "slide" );
    $('#tbl_mom').hide( "slide" );
    $('#tbl_other').hide( "slide" );
    $('#tbl_mvrf').hide( "slide" );
});

$('#show_table_mvrf').on('click', function(){
    $('#tbl_mvrf').toggle( "slide" );
    $('#tbl_setup').hide( "slide" );
    $('#tbl_event_details').hide( "slide" );
    $('#tbl_mom').hide( "slide" );
    $('#tbl_other').hide( "slide" );
});

$('#show_table_other').on('click', function(){
    $('#tbl_other').toggle( "slide" );
    $('#tbl_setup').hide( "slide" );
    $('#tbl_event_details').hide( "slide" );
    $('#tbl_mom').hide( "slide" );
    $('#tbl_mvrf').hide( "slide" );
});

$('#btn_save_client').on('click', function() {
    $('#form_client').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url + 'jo/add_client',
        beforeSubmit: function (arr, jform, option) {
            $('#btn_save_client').prop('disabled', true);
            $('#alert_box_client_s').hide();
            if( $.trim( $('#inp_companyname').val() ) == '' ){
                $("#alert_box_client_s").removeClass("success");
                $("#alert_box_client_s").addClass("warning");
                $('#alert_box_client_s').text();
                $('#alert_box_client_s').text("Input a company name.");
                $('#alert_box_client_s').show();
                $('#btn_save_client').prop('disabled', false);
                return false;
            }else if( $.trim( $('#inp_contactperson').val() ) == '' ){
                $("#alert_box_client_s").removeClass("success");
                $("#alert_box_client_s").addClass("warning");
                $('#alert_box_client_s').text();
                $('#alert_box_client_s').text("Input a contact person.");
                $('#alert_box_client_s').show();
                $('#btn_save_client').prop('disabled', false);
                return false;
            }else if( $.trim( $('#inp_contactnumber').val() ) == '' ){
                $("#alert_box_client_s").removeClass("success");
                $("#alert_box_client_s").addClass("warning");
                $('#alert_box_client_s').text();
                $('#alert_box_client_s').text("Input a contact number/s.");
                $('#alert_box_client_s').show();
                $('#btn_save_client').prop('disabled', false);
                return false;
            }else if( $.trim( $('#inp_birthday').val() ) == '' ){
                $("#alert_box_client_s").removeClass("success");
                $("#alert_box_client_s").addClass("warning");
                $('#alert_box_client_s').text();
                $('#alert_box_client_s').text("Select a birth date.");
                $('#alert_box_client_s').show();
                $('#btn_save_client').prop('disabled', false);
                return false;
            }else if( $.trim( $('#inp_email').val() ) == '' ){
                $("#alert_box_client_s").removeClass("success");
                $("#alert_box_client_s").addClass("warning");
                $('#alert_box_client_s').text();
                $('#alert_box_client_s').text("Input an email.");
                $('#alert_box_client_s').show();
                $('#btn_save_client').prop('disabled', false);
                return false;
            }
        },
        success: function (response) {
            location.reload();
            //$("#client_table").prepend( response );
            //$('#inp_companyname').val('');
            //$('#inp_contactperson').val('');
            //$('#inp_contactnumber').val('');
            //$('#inp_birthday').val('');
            //$('#inp_email').val('');
            //$('#joModal').foundation('reveal', 'close');
            //client_reload();
            //$('#inp_companyname').val('');
            //$('#inp_contactperson').val('');
            //$('#inp_contactnumber').val('');
            //$('#inp_birthday').val('');
            //$('#inp_email').val('');
            //$('.cls_brand').val('');
            //$('#joModal').foundation( 'reveal', 'close' );
        }

    }).submit();
});

$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_field_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" name="ta_contact[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

$(document).ready(function() {
    var max_fields      = 10; //maximum input boxes allowed
    var wrapper         = $(".input_fields_wrap"); //Fields wrapper
    var add_button      = $(".add_brand_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields){ //max input box allowed
            x++; //text box increment
            $(wrapper).append('<div><input type="text" class="cls_brand" name="ta_brand[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
        }
    });

    $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});

$(document).ready(function() {
    var max_fields_c      = 10; //maximum input boxes allowed
    var wrapper_c         = $(".input_fields_wrap_client"); //Fields wrapper
    var add_button_c      = $(".add_client_button"); //Add button ID

    var x = 1; //initlal text box count
    $(add_button_c).click(function(e){ //on add input button click
        e.preventDefault();
        if(x < max_fields_c){ //max input box allowed
            x++; //text box increment
            $(wrapper_c).append('<div><hr>' +
                '<div class=""><div class="small-12 columns"><label for="inp_contactperson">Contact Person<input type="text" id="inp_contactperson" name="inp_contactperson[]" placeholder="Contact Person"></label></div></div><div class=""><div class="small-12 columns"><label for="inp_contactnumber">Contact Number<input type="text" id="inp_contactnumber" class="inp_contactnumber" name="inp_contactnumber[]"  placeholder="Contact Number"></label></div></div><div class=""><div class="small-12 columns"><label for="inp_birthday">Birth Date<input type="text" id="inp_birthday" name="inp_birthday[]" placeholder="Birth Date"></label></div></div><div class=""><div class="small-12 columns"><label for="inp_email">Email Address<input type="text" id="inp_email" name="inp_email[]" placeholder="Email Address"></label></div></div>' +
                '<a href="#" class="remove_field">Remove</a>' +
                '</div>'); //add input box
            reload_date_picker();
        }
        $(".inp_contactnumber").mask("(0999) 999-9999");

    });

    $(wrapper_c).on("click",".remove_field", function(e){ //user click on remove text
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});


function reload_brand_u(){
    $(document).ready(function() {
        var max_fields      = 10; //maximum input boxes allowed
        var wrapper         = $(".input_fields_wrap_u"); //Fields wrapper
        var add_button      = $(".add_brand_button_u"); //Add button ID

        var x = 1; //initlal text box count
        $(add_button).click(function(e){ //on add input button click
            e.preventDefault();
            if(x < max_fields){ //max input box allowed
                x++; //text box increment
                $(wrapper).append('<div><input type="text" class="cls_brand" name="ta_brand[]"/><a href="#" class="remove_field">Remove</a></div>'); //add input box
            }
        });

        $(wrapper).on("click",".remove_field", function(e){ //user click on remove text
            e.preventDefault(); $(this).parent('div').remove(); x--;
        })
    });
}

reload_brand_u();

//do
$('.btn_do').on('click', function(){
    $('#do_joid').val( $(this).attr('alt') );
    $('#do_Modal').foundation('reveal', 'open');
});

$('#bton_do').on('click', function(){
    $('#form_up_do').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'admin/upload_do',
        beforeSubmit: function(arr, jform, option){
            $('#bton_do').prop('disabled', true);
        },
        success:  function(response){
            //console.log(response);
            //$('#bton_do').prop('disabled', false);
            location.reload();
        }
    });
});

$('#delete_do').on('click', function(){
    $.ajax({
        url: MyNameSpace.config.base_url+'admin/del_do',
        type:'post',
        data: {
            'jo_id' : $(this).attr('alt')
        },
        beforeSubmit: function(arr, jform, option){
            //$('#temp_name').val('Please Wait...');
        },
        success: function(data) {
            //console.log(data);
            location.reload();
        }
    });
});

//total
$("#inp_tp").keyup(function(event){
    var check_string = $(this).val();
    var new_string = '';

    if(event.keyCode == 13){
        //$("#id_of_button").click();
        //alert('test');
        $.ajax({
            url: MyNameSpace.config.base_url+'admin/check_price',
            type:'post',
            data: {
                'total_value' : check_string,
                'jo_id' : $(this).attr('alt')
            },
            beforeSubmit: function(arr, jform, option){
                //$('#temp_name').val('Please Wait...');
            },
            success: function(data) {
                //console.log(data);
                location.reload();
            }
        });
    }else{
        if( isNaN( check_string ) ){
            new_string = check_string.replace(/\D/g,'');
            $(this).val( new_string );
        }
    }
});

//bill
$('.btn_bd').on('click', function(){
    $('#bill_joid').val( $(this).attr('alt') );
    $('#bill_Modal').foundation('reveal', 'open');
});

$('#bton_bill').on('click', function(){
    $('#form_up_bill').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'admin/upload_bill',
        beforeSubmit: function(arr, jform, option){
            $('#bton_bill').prop('disabled', true);
        },
        success:  function(response){
            //console.log(response);
            //$('#bton_do').prop('disabled', false);
            location.reload();
        }
    });
});

$('#delete_bd').on('click', function(){
    $.ajax({
        url: MyNameSpace.config.base_url+'admin/del_bd',
        type:'post',
        data: {
            'jo_id' : $(this).attr('alt')
        },
        beforeSubmit: function(arr, jform, option){
            //$('#temp_name').val('Please Wait...');
        },
        success: function(data) {
            //console.log(data);
            location.reload();
        }
    });
});

//CE
$('.btn_ce').on('click', function(){
    $('#ce_joid').val( $(this).attr('alt') );
    $('#ce_Modal').foundation('reveal', 'open');
});

$('#bton_ce').on('click', function(){
    $('#form_up_ce').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'admin/upload_ce',
        beforeSubmit: function(arr, jform, option){
            $('#bton_ce').prop('disabled', true);
        },
        success:  function(response){
            location.reload();
        }
    });
});

$('#delete_ce').on('click', function(){
    $.ajax({
        url: MyNameSpace.config.base_url+'admin/del_ce',
        type:'post',
        data: {
            'jo_id' : $(this).attr('alt')
        },
        beforeSubmit: function(arr, jform, option){
            //$('#temp_name').val('Please Wait...');
        },
        success: function(data) {
            //console.log(data);
            location.reload();
        }
    });
});

//paid
$('.btn_pd').on('click', function(){
    $('#paid_joid').val( $(this).attr('alt') );
    $('#paid_Modal').foundation('reveal', 'open');
});

$('#bton_paid').on('click', function(){
    $('#form_up_paid').ajaxForm({
        type: 'POST',
        url: MyNameSpace.config.base_url+'admin/upload_paid',
        beforeSubmit: function(arr, jform, option){
            $('#bton_paid').prop('disabled', true);
        },
        success:  function(response){
            location.reload();
        }
    });
});

$('#delete_paid').on('click', function(){
    $.ajax({
        url: MyNameSpace.config.base_url+'admin/del_paid',
        type:'post',
        data: {
            'jo_id' : $(this).attr('alt')
        },
        beforeSubmit: function(arr, jform, option){
            //$('#temp_name').val('Please Wait...');
        },
        success: function(data) {
            //console.log(data);
            location.reload();
        }
    });
});

if($('textarea').length > 1) {
    CKEDITOR.replace( 'editor_campaign_overview' );
    CKEDITOR.replace( 'editor_activation_flow' );
    CKEDITOR.replace( 'editor_other_details' );
    CKEDITOR.replace( 'editor_next' );
    CKEDITOR.replace( 'editor_event_spec' );
    //CKEDITOR.replace( 'editor_detail_text' );
    //CKEDITOR.replace( 'editor_req' );
    //CKEDITOR.replace( 'editor_ns' );
    CKEDITOR.replace( 'setup_particular' );
    CKEDITOR.replace( 'ta_mvrf' );
    CKEDITOR.replace( 'ta_Other' );
}
