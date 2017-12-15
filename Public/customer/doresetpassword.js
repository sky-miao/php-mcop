$(function(){

   
    layui.use(['form'], function(){
        var form = layui.form;
        var $ = layui.jquery;
        form.verify({
            password: function(value){
               
                if(value.length<6){
                    return 'password is too short.';
                }

                
            },

            password_confirm:function(value)
            {
                var pass=$('#L_pass').val();
                if (pass != value) {
                    return 'Two input password inconsistencies.';
                }
            }
           
        });
  
        form.on('submit(resetpassword)', function(data){
           
            $('#reset').submit();
            return false;
  
        });
  
    });
})