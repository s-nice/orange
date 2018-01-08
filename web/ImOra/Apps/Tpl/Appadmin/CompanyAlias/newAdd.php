<layout name="../Layout/Layout" />
<!--语义分词 编辑和添加-->
<div class="content_global">
	<div class="content_hieght">
		<div class="content_c">
			<div class="company_name">
				<h4>公司名称：</h4>
				<input type="text" id="js_company_name_input" placeholder='请输入公司名称'
				<if condition="isset($data) && $data['status'] eq 0"> value="{$data['data']['list'][0]['name']}" </if>
				>
			</div>
			<div class="company_name clear">
				<h4>中文关键词：</h4>
				<input type="text" id="js_company_keywordscn_input" <if condition="isset($data) && $data['status'] eq 0"> value="{$data['data']['list'][0]['keywordscn']}" </if>
				>
			</div>
			<div class="company_name clear">
				<h4>输入公司别名：</h4>
				<input type="text" id="js_alias_name_input"  default-txt='输入多个别名以&ldquo;,&rdquo;号隔开'>
				<span id="js_add_alias">添加</span>
			</div>

			<div class="add_company_alias clear" id="js_show_alias_wrap" <if condition="isset($data) && $data['status'] eq 0"> style="display:block"
				<else/>style="display:none"
			    </if>>
				<if condition="isset($data) && $data['status'] eq 0">
					<php>
						$aliasArr=explode(",",$data['data']['list'][0]['alias'])
					</php>
					<volist name="aliasArr" id="vo">
						<span class="js_alias_name" val="{$vo}"><em>{$vo}</em><i class="js_alias_del">X</i></span>
					</volist>
				</if>
				<!-- <span><em>橙鑫</em><i>X</i></span>
                <span><em>橙鑫数据</em><i>X</i></span>
                <span><em>橙鑫</em><i>X</i></span>
                <span><em>星球联盟</em><i>X</i></span> -->
			</div>
			<div class="alias_btn clear">
				<button  id="js_alias_save" class="big_button" type="button"
				<if condition="isset($data) && $data['status'] eq 0"> data-id="{$data['data']['list'][0]['id']}"
				</if>>保存</button>
				<a href="{$gUrl}"><button class="big_button" type="button">取消</button></a>
			</div>
		</div>
	</div>
</div>
<script>
	var gSaveUrl="{:U('Appadmin/CompanyAlias/saveAlias','','','',true)}"
	var gUrl="{$gUrl}";
</script>
