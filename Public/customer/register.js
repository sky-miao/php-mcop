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
            repass:function(value){
                var pass=$('#L_pass').val();
                if (pass != value) {
                    return 'Two input password inconsistencies.';
                }
            }
        });
  
        form.on('submit(register)', function(data){
           
            if (cansub) {
                $('registerForm').submit();
            }else{
                layer.msg('Mailbox has been occupied.');
                return false;
            }
            
        });

        var cansub=false;

        $('#L_email').on('blur',function(){
            var email=$(this).val();

            $.ajax({
                url: ajaxUrl+'/checkEmailUsing',
                type: 'POST',
                dataType: 'json',
                data: {email: email},
                success:function(response){
                    console.log(response);
                    if (response.code!='success') {
                       
                        layer.msg(response.message);
                       
                        cansub=false;
                    }else{
                        cansub=true;
                    }
                }
            })  
        })  
  
  
    });
})