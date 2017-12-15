$(function(){

   
    layui.use(['form'], function(){
        var form = layui.form;
        var $ = layui.jquery;
        form.verify({
            emailVerify: function(value){
                var emailReg=/^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,10})+$/;
                if(!emailReg.test(value)){
                    return 'Email is error.';
                }

                
            },
           
        });
  
        form.on('submit(resetpassword)', function(data){
            $.ajax({
                url: ajaxUrl+'/resetPasswordEmail',
                type: 'POST',
                dataType: 'json',
                data: data.field,
                success:function(response){
                    if (response.code=='success') {
                        layer.msg(response.msg);
                    }else{
                        layer.msg(response.msg);
                    }
                }

            })
            
            return false;
  
        });
  
    });
})