<layout name="../Layout/Company/AdminLTE_layout" />
<div class="tree-main">
	<!-- 面包屑start -->
	<include file="Common/breadCrumbs"/>
	<!-- 面包屑end -->
    <div class="top-null"></div>
    <div class="division-content">
        <div class="division-nav">
            <a href="{:U(MODULE_NAME.'/AdminSet/index','','',true)}"><span class="active">权限设置</span></a>
            <a href="{:U(MODULE_NAME.'/Departments/index','','',true)}"><span>部门管理</span></a>
            <a href="{:U(MODULE_NAME.'/Staff/index','','',true)}"><span>员工管理</span></a>
            <a href="{:U(MODULE_NAME.'/Label/index','','',true)}"><span>标签管理</span></a>
        </div>
        <div class="division-con js_container">
            <div class="set-power-main js_set_list">
                <div class="all-stall-set js_set_list_item">
                    <label class="input-th"><input type="checkbox" name="setallshare" <eq name="data['open']" value="1">checked</eq> /><em></em></label><span>全部共享   - 所有员工都可以访问公司的所有名片</span>
                </div>
                <div class="setpower-btn">
                    <button type="button" class="js_set_submit">确定</button>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  分享二维码弹框  -->
<include file="Common/entQrCode"/>

<script>
    var js_url_setindex = "{:U(MODULE_NAME.'/AdminSet/index','','',true)}";
    var js_url_setedit = "{:U(MODULE_NAME.'/AdminSet/setPowers','','',true)}";
    $(function(){
        $('.js_container').on('click','.js_set_submit',function(){
            var types = 2;
            var checksval = $('.js_container .js_set_list_item input').prop('checked');
            if(checksval === true) types = 1;

            $.ajax({
                url:js_url_setedit,
                type:'post',
                dataType:'json',
                data:'type='+types,
                success:function(res){
                    if(res!=0){
                        $.dialog.alert({content:"操作失败"});
                        return false;
                    }else{
                        $.dialog.alert({content:"设置成功"});
                        //window.location.href = js_url_setindex;
                    }
                },
                error:function(res){}
            });

        });
    });
</script>

<!--个人信息编辑弹框-->
<div class="bg-op-dialog"></div>
<div class="x-dialog g-edit-dialog">
	<div class="x-main">
		<div class="x-tit">
			<h3>个人信息</h3>
			<span class="close-dia"></span>
		</div>
		<div class="x-content g-info-h">
			<div class="edit-form">
				<div class="edit-form-item">
					<span>姓名</span>
					<input class="ed-i-input ge-input" type="text" />
					<div class="ge-info-div">
						<em>王昕</em>
						<i></i>
					</div>
				</div>
				<div class="edit-form-item clear">
					<span>手机</span>
					<input class="ed-i-input ge-input" type="text" />
					<div class="ge-info-div">
						<em>18501009786</em>
						<i></i>
					</div>
				</div>
				<div class="edit-form-item clear">
					<span>公司</span>
					<input class="ed-i-input ge-input" type="text" />
					<div class="ge-info-div">
						<em>北京橙鑫数据科技有限公司</em>
						<i></i>
					</div>
					
				</div>
				<div class="edit-form-item clear">
					<span>邮箱</span>
					<input class="ed-i-input ge-input" type="text" />
					<div class="ge-info-div">
						<em>13607895645@163.com</em>
						<i></i>
					</div>
				</div>
				<div class="edit-btn-d ge-btn">
					<button class="edit-btn-s" type="button">保存</button>
					<button class="edit-btn-s ed-btn-diff" type="button">取消</button>
				</div>
			</div>
		</div>
	</div>
</div>