/**
 * Created by Laiza-PC on 29/02/2016.
 */

//$('#btn_update_calendar').on('click', function(){
    $('#form_creatives_tasks').ajaxForm({
        type: 'post',
        url: MyNameSpace.config.base_url+'jo/submit_date_calendar',
        beforeSubmit:function(){
            $('#btn_update_client').prop('disabled',true);
        },
        success:  function(response){
            if(response != 'exist'){
                $('#sel_creatives_emp').val(0);
                $('#creative_start').val('');
                $('#creative_deadline').val('');
                $('#creative_description').val('');

                $('#creatives_box').hide();
                $('tbody#creatives_tbd').append(response);
                $('#modal_creatives_tasks').foundation( 'reveal', 'close' );
                $('#btn_update_client').prop('disabled',false);
            }else{
                $('#creatives_box').show();
            }
        }
    });
//});

$('.task_change').on('click',function(){
    var cld = $(this).attr('alt');
    var cval = $(this).attr('value');
    $(this).closest('tr').remove();

    $.ajax({
        url: MyNameSpace.config.base_url+'jo/update_pending',
        type:'post',
        data: {
            'cal_id' : cld,
            'cval' : cval
        },
        beforeSubmit: function(arr, jform, option){
        },
        success: function(data) {
            if( data != 'failed' ){
                $(data).prependTo("tbody#creatives_tbd");
            }
        }
    });
});