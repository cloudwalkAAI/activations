/**
 * Created by Laiza-PC on 29/02/2016.
 */

//$('#btn_update_calendar').on('click', function(){
    $('#form_creatives_tasks').ajaxForm({
        type: 'post',
        url: MyNameSpace.config.base_url+'jo/submit_date_calendar',
        beforeSubmit:function(){
            $('#btn_update_calendar').prop('disabled',true);
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
                $('#btn_update_calendar').prop('disabled',false);
                reload_task_cmd();
            }else{
                $('#creatives_box').show();
            }
        }
    });

    $('#btn_update_calendar_u').on('click',function(){
        $('#form_creatives_tasks_u').ajaxForm({
            type: 'post',
            url: MyNameSpace.config.base_url+'jo/submit_date_calendar_u',
            beforeSubmit:function(){
                $('#btn_update_client_u').prop('disabled',true);
            },
            success:  function(response){
                if( response != 'failed'){
                    var json = $.parseJSON(response);
                    $('tr#' + json['table_id']).replaceWith( json['table_task']  );
                    $('#modal_creatives_tasks_u').foundation( 'reveal', 'close' );
                    $('#btn_update_client_u').prop('disabled',false);
                }
            }
        });
    });

//});

$('.task_change').on('click',function(e){
    e.preventDefault();
    var cld = $(this).attr('alt');
    var cval = $(this).attr('value');

    $.ajax({
        url: MyNameSpace.config.base_url+'jo/update_pending',
        type:'post',
        data: {
            'cal_id' : cld,
            'cval' : cval
        },
        success: function(data) {
            console.log(data);
            if( data != 'failed' ){
                $('tbody#creatives_tbd tr#' + cld).replaceWith(data);
                reload_task_cmd();
            }
        }
    });
});

function reload_task_cmd(){
    $('.edit-btn-task').on('click',function(e){
        e.preventDefault();
        var cld = $(this).attr('alt');
        $.ajax({
            url: MyNameSpace.config.base_url+'jo/update_cal_task_getinfo',
            type:'post',
            data: {
                'cal_id' : cld
            },
            success: function(data) {
                var json = $.parseJSON(data);
                $('#task_id_u').val( json['cal_id'] );
                $('#sel_creatives_emp_u').val( json['eid'] );
                $('#creative_deadline_u').val( json['edate'] );
                $('#creative_description_u').val( json['desc'] );

                $('#creatives_box_u').hide();
                //$('tbody#creatives_tbd_u').append(response);
                $('#modal_creatives_tasks_u').foundation( 'reveal', 'close' );
                $('#btn_update_client_u').prop('disabled',false);

                $('#modal_creatives_tasks_u').foundation('reveal', 'open');
            }
        });
    });

    $('.del-btn-task').on('click',function(e){
        e.preventDefault();
        var cld = $(this).attr('alt');
        $.ajax({
            url: MyNameSpace.config.base_url+'jo/creatives_del',
            type:'post',
            data: {
                'cal_id' : cld
            },
            success: function(data) {
                $( 'tbody#creatives_tbd tr#' + data ).remove();
            }
        });
    });
}

reload_task_cmd();