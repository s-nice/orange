<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght js_formcontent">
        <form method="post" action="{:U(MODULE_NAME.'/OraPay/savaPay','','',true)}" >
            <div class="content_c js_orapay_content">
                <div class="newsCard_text">
                    <div class="modle_info">
                        <span>URL：</span>
                        <input class="js_img_url" style="width:298px"  name="url" maxlength="20" type="text" autocomplete="off">
                    </div>

                    <div class="num_BIN num_file clear ">
                        <span>上传图片：</span>
                        <input type="file" style="width:55px;" id="js_logoimg" name="picfile">
                        <button type="button">上传</button>
                    </div>
                    <div class="i_logo clear js_logoimg_show">
                        <img <if condition="isset($info)"> src="{$info['url']}" </if>style="width:100%;height:100%;">
                        <empty name="info['url']">
                            <em class="hand js_close" >X</em>
                            <else />
                            <em class="hand js_close"  style="display:block;">X</em>
                        </empty>
                    </div>
                </div>
            </div>
           <!-- <div class="exchange_btn_b js_btn_hid new_btns-a">
                <input type="hidden" name="orapayid" value="{$data['id']}" >
                <button type="button" class="js_save_btn" <if condition="isset($info)"> data-id="{$info['typeid']}" </if>>保存</button>
            </div>-->
        </form>
    </div>
</div>
<script>
    var gUrlUploadFile = "{:U('Appadmin/Collection/uploadFileTmp')}";
    var gUrl="{:U('Appadmin/OraAgreement/uploadImg')}";
    $(function(){
        //上传图片相关公用event
            $('#js_logoimg').off('change').on('change', function () { //长传图片
                uploadAddPageFile('js_logoimg', 'picfile');

            });

            $('.js_close').on('click', function () { //取消上传图片
                $('.js_logoimg_show img').removeAttr('src');
                $('.js_img_url').val('');
                $(this).hide();
            });

        /**
         * 上传图片
         *  @param  fileElementId str 上传INPUT ID
         *  @param  fileNameHid  str input name
         * */
       function  uploadAddPageFile (fileElementId, fileNameHid) {
            $.ajaxFileUpload({
                url: gUrlUploadFile,
                secureuri: false,
                fileElementId: fileElementId,
                data: {fileNameHid: fileNameHid},
                dataType: 'json',
                success: function (rtn, status) {
                    var imgUrl = rtn.data.absolutePath;
                    if (rtn.status == 1) {
                        $.global_msg.init({gType: 'alert', icon: 2, time: 3, msg: rtn.info});
                        return false;
                    } else {
                        $.post(gUrl,{'url':imgUrl},function(res){
                            $('.js_logoimg_show img').attr('src',res);
                            $('.js_img_url').val(res);
                        });

                        $('.js_close').show();
                    }
                },
                error: function (data, status, e) {
                }
            });
        }


    });
</script>

