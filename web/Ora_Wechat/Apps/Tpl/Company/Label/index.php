<layout name="../Layout/Company/AdminLTE_layout" />
<div class="tree-main">
	<!-- 面包屑start -->
	<include file="Common/breadCrumbs"/>
	<!-- 面包屑end -->
    <div class="top-null"></div>
    <div class="division-content">
        <div class="division-nav">
            <a href="{:U(MODULE_NAME.'/AdminSet/index','','',true)}"><span>权限设置</span></a>
            <a href="{:U(MODULE_NAME.'/Departments/index','','',true)}"><span>部门管理</span></a>
            <a href="{:U(MODULE_NAME.'/Staff/index','','',true)}"><span>员工管理</span></a>
            <a href="{:U(MODULE_NAME.'/Label/index','','',true)}"><span class="active">标签管理</span></a>
        </div>
		<div class="division-con">
			<div class="label-manage">
				<div class="label-remove">
					<button type="button" class="js_labels_del">删除</button>
				</div>
				<div class="label-list">
					<ul class="label-ul js_label_ul">
						<foreach name="list" item="val">
						<li tagid="{$val.id}">
							<div class="label-ch js_label_deal">
								<label class="input-th" for=""><input type="checkbox" /><em></em></label>
								<span class="js_label" title="{$val.tags}">{$val.tags}</span>
								<em class="label-w-i label-edit-i js_label_edit"></em>
								<em class="label-w-i label-remove-i js_label_del"></em>
							</div>
							<!--编辑-->
							<div class="label-ch label-none js_label_btn">
								<input class="label-edit" type="text" />
								<button class="label-edit-btn js_label_sub" type="button">确定</button>
								<button class="label-edit-btn label-btn-cancel js_label_can" type="button">取消</button>
							</div>
						</li>
						</foreach>
					</ul>
					<div class="add-label">
						<span class="add-label-icon js_label_add">+</span>
						<em class="js_label_add">添加标签</em>
					</div>
				</div>
			</div>
	        <div class="page-box">
				<include file="@Layout/pagemain" />
			</div>
		</div>

    </div>
</div>

<!--  分享二维码弹框  -->
<include file="Common/entQrCode"/>

<!--备用框-->
<div class="js_temp_box"></div>
<script>
	var editLabelUrl = "__URL__/editLabel";
	var delLabelUrl = "__URL__/delLabel";
	$(function(){
		$.label.index();
	})
</script>



