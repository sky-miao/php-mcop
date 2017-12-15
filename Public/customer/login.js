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
            password:function(value){
                if (value.length<6) {
                    return 'Password is too short.';
                }
            },
        });
  
        form.on('submit(login)', function(data){
            
            $('#loginForm').submit();
  
        });
  
    });
})