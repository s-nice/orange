<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght js_formcontent">
        <form method="post" action="{:U(MODULE_NAME.'/OraPay/savaPay','','',true)}" >
        <div class="content_c js_orapay_content">
            <div class="newsCard_text">
                <div class="modle_info">
                    <span>分类名称：</span>
                    <input class="js_noempty" style="width:298px" <if condition="isset($info)">value="{$info['type']}" </if>name="type" maxlength="12" type="text" placeholder="必填、不可重复" autocomplete="off">
                </div>
                <div class="modle_info">
                    <span>推广文字：</span>
                    <input class="js_noempty" style="width:298px" <if condition="isset($info)">value="{$info['content']}" </if> name="content" maxlength="20" type="text" placeholder="必填、不可重复" autocomplete="off">
                </div>

                <div class="num_BIN num_file clear ">
                    <span>上传图片：</span>
                    <input type="file" style="width:55px;" id="js_logoimg" name="picfile">
                    <button type="button" class="js_upload_button">上传</button>
                </div>
                <div class="i_logo clear js_logoimg_show">
                    <img <if condition="isset($info)"> src="{$info['url']}" </if>style="width:100%;height:100%;">
                    <empty name="info['url']">
                        <em class="hand js_close" >X</em>
                        <else />
                        <em class="hand js_close"  style="display:block;">X</em>
                    </empty>
                    <input class="js_noempty js_img_url" type="hidden"
                    <if condition="isset($info)"> value="{$info['url']}" nochange=1 </if> name="url" >
                    <span class="text-t">请上传JPG、JPEG、GIF或PNG格式图片,最大不超过2M.</span>
                </div>
            </div>
        </div>
        <div class="exchange_btn_b js_btn_hid new_btns-a">
            <input type="hidden" name="orapayid" value="{$data['id']}" >
            <button type="button" class="js_save_btn" <if condition="isset($info)"> data-id="{$info['typeid']}" </if>>保存</button>
        </div>
        </form>
    </div>
</div>
<script>
    var gUrlUploadFile = "{:U('Appadmin/Collection/uploadFileTmp')}";
    var gAjaxUrl="{:U('Appadmin/EquityCard/ajaxFn')}";
    var gIndexUrl="{:U('Appadmin/EquityCard/index')}";
    $(function(){
        $.equityCard.add_init();
    })
</script>

