
    layui.use(['form','upload', 'laydate'], function(){
        var form = layui.form,
            layer = layui.layer,
            upload = layui.upload,
            laydate = layui.laydate;

       
        laydate.render({
            elem: '#date'
        });
       

        upload.render({
            elem: '#idcardfront',
            method:'POST',
            data:{name:'idcard_front'},
            url: moduleUrl+'/Upload/idcardUpload',
            accept:'images',
            exts:"jpg|png|gif|bmp|jpeg",
            size:'10240',
            done: function(res){
                $('#idcardfrontdiv').children('img').remove();
                var img="<img class='imgbox' src= '/Uploads/"+res.file.savepath+res.file.savename+"'/>";
                
                $('#idcardfrontdiv').append(img);
            }
        });

        upload.render({
            elem: '#idcardback',
            method:'POST',
            data:{name:'idcard_back'},
            accept:'images',
            exts:"jpg|png|gif|bmp|jpeg",
            size:'10240',
            url: moduleUrl+'/Upload/idcardUpload',
            done: function(res){
                $('#idcardbackdiv').children('img').remove();
                var img="<img  class='imgbox' src= '/Uploads/"+res.file.savepath+res.file.savename+"'/>";
                $('#idcardbackdiv').append(img);
            }
        });

      
        form.verify({
            first_name:function(value){

            },
            last_name:function(value){},
            street_address:function(value){},


     
        });

        var cansub=false;
        var message ='';
        //监听提交
        form.on('submit(kycvalidatesub)', function(data){
           
            $.ajax({
                url: ajaxUrl+'/hacIDCardImages',
                type: 'POST',
                dataType: 'json',
                data: '',
                async:false,
                success:function(res){
                    if (res.code=='success') {
                        cansub=true;
                    }else{
                        cansub=false;
                        message=res.message;
                    }
                }
               
            })
            if (cansub) {
                layer.open({
                    type: 1,
                    title: 'I Confirm the Following',
                    closeBtn: 1,
                    area: '500px;',
                    shade: 0.8,
                    id: 'validate_layout',
                    btn: ['Agree'],
                    btnAlign: 'c',
                    moveType: 1 ,
                    content: '<div style="padding: 50px; line-height: 22px;  color: black; font-weight: 300;">'
                    +'All the information I have entered is true and complete.<br/>'
                    +'I am not restricted under any law from providing this information<br>'
                    +'or purchasing Simple Token. '
                    +'I act my own behalf ,unless I have notified you in writing .'
                    +'I have Read ,understand and agree to OpenST Limiteds Privacy Policy'
                    +'I acknowledge this may change .I also understand that any '
                    +'purchase of Simple Token will be subject to additional terms and conditions '

                    +'</div>',
            
                    yes:function(index)
                    {
                        layer.close(index)
                        $('#kycvalidateform').submit();
                    }
                });
                
            }else{
                layer.msg(message);
                return false;
            }
            
        });


    });