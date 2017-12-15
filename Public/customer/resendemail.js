$(function(){

    layui.use(['layer','jquery'], function(){
        var $ = layui.jquery;
        var layer = layui.layer;
        $('#resendemail').click(function() {
        
            $.ajax({
                url: ajaxUrl+'/resendEmail',
                type: 'POST',
                dataType: 'json',
                data: {},
            })
            .done(function(res) {
                layer.alert(res.message,{
                    skin: 'layui-layer-molv',
                    closeBtn:0,
                    btn: ['Close'],
                    title:'Info',
                });
            })
            .fail(function() {
                layer.msg('System Error.');
            })
            
            
        });
      
    }); 
   
})