<layout name="../Layout/Layout" />
<div class="content_global">
	<div class="content_hieght">
		<div class="card_company news_c_s js_select_ul_list">
			<span>{$T->str_orange_type_cardtypename}：</span>
			<div class="card_company_list menu_list js_firsttype" >
				<input id="js_mod_select" class="js_list_val" type="text" value="{$list[0]['firstname']}" title="{$list[0]['firstname']}" readonly>
				<em id="js_seltitle"></em>
				<ul id="js_selcontent">
                    <foreach name="list" item="val">
                        <li val="{$val['id']}" data-pa="{$val['picpatha']}" data-pb="{$val['picpathb']}" title="{$val['firstname']}">{$val['firstname']}</li>
                    </foreach>
				</ul>
			</div>
		</div>
		<div class="news_c_s">
			<span>{$T->str_orange_type_modelstyle}：</span>
			<em>{$T->str_orange_type_editexplain}</em>
		</div>
		<div class="template_img js_pic_content">
            <a id="js_type_url" href="{:U(MODULE_NAME.'/OraMembershipCard/editTemplateStyle',array('cardTypeId'=>$list[0]['id']),'',true)}">
                <div class="template_up template_m_l">
                    <div class="img">
                        <img class="js_pic_a" <empty name="list[0]['picpatha']" >src="/images/pleaseUploadImg.png"<else />src="{$list[0]['picpatha']}"</empty> style='width:100%;height:100%;' >
                    </div>
                    <p>{$T->str_orange_type_front}</p>
                </div>
            </a>
            <a id="js_type_url_back" href="{:U(MODULE_NAME.'/OraMembershipCard/editTemplateStyle',array('cardTypeId'=>$list[0]['id'],'back'=>1),'',true)}">
                <div class="template_down">
                    <div class="img">
                        <img class="js_pic_b" <empty name="list[0]['picpathb']" >src="/images/pleaseUploadImg.png"<else />src="{$list[0]['picpathb']}"</empty> style='width:100%;height:100%;' >
                    </div>
                    <p>{$T->str_orange_type_con}</p>
                </div>
            </a>
        </div>
	</div>
</div>
<script>
    var js_to_style_Url = "{:U(MODULE_NAME.'/OraMembershipCard/editTemplateStyle','','',true)}";
    $(function(){
        $.oracardtype.cardstyle();
    })
</script>
			