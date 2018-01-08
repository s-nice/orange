  <!-- 顶部导航栏 -->
  <header class="main-header">
		<a href="{:U('/','','', true)}"><img class="logo-img" src="__PUBLIC__/images/logo.png"></a>
		<nav class="main-nav">
			<div class="login">
				<dl class="login_img js_user_tips">
					<dt>
						<img src="__PUBLIC__/images/imgLogo@3x.png" alt="" />
					</dt>
					<dd class="">
						<h5 title="{$_SESSION[MODULE_NAME]['username']}">{$_SESSION[MODULE_NAME]['username']|cutstr=6}</h5>
						<h6 data-id="{$_SESSION[MODULE_NAME]['roleid']}">
						<if condition="1 eq $Think.session.Company.roleid ">超级管理员
						<elseif condition="$_SESSION[MODULE_NAME]['roleid'] eq 2"/>管理员<elseif condition="$_SESSION[MODULE_NAME]['roleid'] eq 3"/>员工<else/>错误角色</if></h6>
					</dd>
				</dl>
				<ul class="login-menu hide js_user_tips_pop">
					<li id="js_user_info">用户信息</li>
					<li id="js_setPwd">设置密码</li>
					<a href="{:U(MODULE_NAME.'/Login/logout')}"><li>退出登录</li></a>
				</ul>
			</div>
			<!-- 只有超级管理员和普通管理员才会显示“管理设置”菜单 -->
			<if condition="$Think.session.Company.isAdmin eq 1">
			<a href="{:U('AdminSet/index')}">
			<div class="ora-set">
				<h4>管理设置</h4>
			</div></a>
			</if>
			<div class="ora-worning">
				<h4>消息</h4>
				<em>0</em>
			</div>
			<div class="ora-help">
				<h4>帮助</h4>
			</div>
		</nav>
  </header>
  <!--  修改密码弹框    -->
<div class="ora-dialog" id="js_div_setPwd">
	<div class="vision-dia-mian">
		<div class="dia-add-vis">
			<h4>修改密码</h4>
			<div class="dia-add-vis-menu">
				<h5><em>*</em>当前密码</h5>
				<div class="dia_menu all-width-menu">
					<input class="fu-dia" type="password" name="currentPwd" />
					<p class="error-p">当前密码错误</p>
				</div>
			</div>
			<div class="dia-add-vis-menu">
				<h5><em>*</em>新密码</h5>
				<div class="dia_menu all-width-menu">
					<input class="fu-dia" type="password" name="newPwd" />
					<p class="error-p">当前密码错误</p>
				</div>
			</div>
			<div class="dia-add-vis-menu">
				<h5><em>*</em>确认新密码</h5>
				<div class="dia_menu all-width-menu">
					<input class="fu-dia" type="password" name="renewPwd" />
					
				</div>
			</div>
		</div>
		<div class="dia-add-v-btn clear">
			<button type="button" id="js_setPwd_can">取消</button>
			<button class="bg-di" id="js_setPwd_sub" type="button">确认</button>
		</div>
	</div>
</div>
<style>
	.ge-btn-div {float: left; height: 38px; line-height: 38px; margin-left: 10px; display: none;}
	.ge-btn-div button.edit-btn-s{
		width: 80px;
	    height: 28px;
	    border: 1px solid #fda77a;
	    background-color: #fda77a;
	    border-radius: 4px;
	    color: #fff;
	    font-size: 14px;
	    margin-right: 23px;
	    line-height: 28px;
	}
	.ge-btn-div button.ed-btn-diff{
		color: #666;
	    border: 1px solid #dedede;
	    background-color: #f9f9f9;
	}
	.ge-btn-div button.edit-btn-s:hover {
	    background-color: #ff9859;
	    border: 1px solid #ff9859;
	}
	.ge-btn-div button.ed-btn-diff:hover {
	    background-color: #d4d4d4;
    border: 1px solid #1e262d;
}
</style>
<!--个人信息编辑弹框-->
<div class="bg-op-dialog js_em_edit"></div>
<div class="x-dialog g-edit-dialog js_em_edit js_em_edit_div" data-id="">
    <div class="x-main">
        <div class="x-tit">
        		<h3>个人信息</h3>
            <span class="close-dia js_em_edit_can"></span>
        </div>
        <div class="x-content g-info-h ge-content">
            <div class="edit-form">
                <div class="edit-form-item js_can_edit">
                    <span>姓名</span>
                    <input class="ge-i-input ge-input js_input_name" type="text" />
                    <div class="ge-info-div">
                        <em class="js_em_name">王昕</em>
                        <i></i>
                    </div>
                    <div class="ge-btn-div">
	                    <button class="edit-btn-s js_em_edit_sub" type="button">确定</button>
	                    <button class="edit-btn-s ed-btn-diff js_em_edit_can_btn" type="button">取消</button>
                    </div>
                </div>
                <div class="edit-form-item clear">
                    <span>手机</span>
                    <input class="ge-i-input ge-input" type="text" />
                    <div class="ge-info-div">
                        <em class="js_em_mobile">18501009786</em>
                        <i></i>
                    </div>
                </div>
                <div class="edit-form-item clear">
                    <span>公司</span>
                    <input class="ge-i-input ge-input" type="text" />
                    <div class="ge-info-div">
                        <em class="js_em_bizname">北京橙鑫数据科技有限公司</em>
                        <i></i>
                    </div>
                    
                </div>
                <div class="edit-form-item clear js_can_edit">
                    <span>邮箱</span>
                    <input class="ge-i-input ge-input js_input_email" type="text" />
                    <div class="ge-info-div">
                        <em class="js_em_email">13607895645@163.com</em>
                        <i></i>
                    </div>
                    <div class="ge-btn-div">
	                    <button class="edit-btn-s js_em_edit_sub" type="button">确定</button>
	                    <button class="edit-btn-s ed-btn-diff js_em_edit_can_btn" type="button">取消</button>
                    </div>
                </div>
                <!--<div class="edit-btn-d ge-btn">
                    <button class="edit-btn-s js_em_edit_sub" type="button">保存</button>
                    <button class="edit-btn-s ed-btn-diff js_em_edit_can" type="button">取消</button>
                </div>-->
            </div>
        </div>
    </div>
</div>

  <script>
  	var updatePwdUrl = "{:U(MODULE_NAME.'/Login/updatePwd')}";
  	var getEmInfoUrl = "{:U(MODULE_NAME.'/AdminSet/getEmInfo')}";
    var setEmInfoUrl = "{:U(MODULE_NAME.'/AdminSet/setEmInfo')}";
   //显示提示层
	$('.js_user_tips').on('click',function(){
		$('.js_user_tips_pop').toggleClass('hide');
	});
	//点击任何区域关闭右上角弹出层(若果弹出层已经打开的情况)
	$(document).click(function(e){
		var parent = $(e.target).parents('.js_user_tips') || $(e.target).filter('.js_user_tips'); //,.js_user_tips_pop
		    parent = parent.length ==0 ? $(e.target).filter('.js_user_tips') : parent;
		//console.log(parent,parent.length == 0,!$('.js_user_tips_pop').hasClass('hide'))
		if(parent.length == 0 && !$('.js_user_tips_pop').hasClass('hide')){
			$('.js_user_tips_pop').addClass('hide');
		}
	});
	$(function(){

		
		$('#js_setPwd').on('click',function(){
			$('#js_div_setPwd').show();
		});
		$('#js_setPwd_can').on('click',function(){
			$('#js_div_setPwd').hide();
		});
		$('#js_setPwd_sub').on('click',function(){
			var currentPwd = $.trim($('#js_div_setPwd input[name=currentPwd]').val());
			if(!currentPwd){
				$.selfTip($('input[name=currentPwd]'),"请填写原密码",'right');  
				return false; 
			}
			var newPwd = $.trim($('#js_div_setPwd input[name=newPwd]').val());
			if(!newPwd){
				$.selfTip($('input[name=newPwd]'),"请填写新密码",'right');  
				return false; 
			}
			if(newPwd.length<6){
				$.selfTip($('input[name=newPwd]'),"新密码不能少于6位",'right');  
				return false; 
			}
			var renewPwd = $.trim($('#js_div_setPwd input[name=renewPwd]').val());
			if(newPwd!=renewPwd){
				$.selfTip($('input[name=renewPwd]'),"两次密码不一致",'right');  
				return false; 
			}
			$.post(updatePwdUrl,{currentPwd:currentPwd,newPwd:newPwd},function(re){
				if(re.status==0){
					$('.js_user_tips_pop').addClass('hide');
					$('#js_div_setPwd').hide();
					$.dialog.alert({content:re.msg});
				}else{
					$.selfTip($('input[name=currentPwd]'),re.msg,'right');  
					return false; 
				}
			});
		});

		//点击用户信息
		$('#js_user_info').on('click',function(){
			//var emid = $(this).parents('.js_staff_data_tr').attr('data-sid');
            $.get(getEmInfoUrl,{},function(re){
                if(re.status==0){
                    $('.js_can_edit input').hide();
                    $('.js_em_edit_div .js_em_name').text(re.data.name);
                    $('.js_em_edit_div .js_em_mobile').text(re.data.mobile);
                    $('.js_em_edit_div .js_em_bizname').text(re.data.bizname);
                    $('.js_em_edit_div .js_em_email').text(re.data.email);
                    $('.js_em_edit_div .js_input_name').val(re.data.name);
                    $('.js_em_edit_div .js_input_email').val(re.data.email);
                    $('.js_can_edit').each(function(){
						var val = $(this).find('input').val();
						if(!val){
							$(this).find('.ge-info-div i').css('display','inline-block');
						}
					});
                    $('.js_em_edit').show();
                }
            })
		});

  		//关闭用户编辑弹框
        $('.js_em_edit_div').on('click','.js_em_edit_can',function(){
            $('.js_em_edit').hide();
        });

        //鼠标滑过
        $('.js_em_edit_div').on('mouseover','.js_can_edit',function(){
            //var val = $(this).find('em').text();
            $(this).find('.ge-info-div i').css('display','inline-block');
        });

        //鼠标移除
        $('.js_em_edit_div').on('mouseout','.js_can_edit',function(){
        	var val = $(this).find('input').val();
        	if(val){
        		$(this).find('.ge-info-div i').css('display','none');
        	}
            /*var oInput = $(this).find('input');
            var val = $.trim(oInput.val());
            $(this).find('em').text(val);
            oInput.hide();*/
        });

        //点击编辑图标
        $('.ge-info-div').on('click','i',function(){
        	$(this).parents('.ge-info-div').hide();
        	$(this).parents('.js_can_edit').find('input,.ge-btn-div').show();
        });

        //取消编辑
        $('.ge-btn-div').on('click','.js_em_edit_can_btn',function(){
        	var val = $(this).parents('.js_can_edit').find('.ge-info-div em').text();
        	$(this).parents('.js_can_edit').find('.ge-info-div').show();
        	$(this).parents('.js_can_edit').find('input').val(val);
        	$(this).parents('.js_can_edit').find('input,.ge-btn-div').hide();
        });

        //保存用户编辑信息
        $('.js_em_edit_div').on('click','.js_em_edit_sub',function(){
            //var id = $('.js_em_edit_div').attr('data-id');
            var _this = $(this);
            var isEmail = $(this).parents('.js_can_edit').find('.js_input_email').length;
            console.log(isEmail);
            if(isEmail==1){
            	var val = $('.js_input_email').val();
            	var key = 'email';
            	if(!val){
	                $.dialog.alert({content:'邮箱不能为空'});
	                return false;
	            }
            	var reg = /^[\.a-zA-Z0-9_-]+@[a-zA-Z0-9_-]+(\.[a-zA-Z0-9_-]+)+$/;
	            if(!reg.test(val)){
	                $.dialog.alert({content:'邮箱格式不正确'});
	                return false;
	            }
            }else{
            	var val = $('.js_input_name').val();
            	var key = 'name';
            	if(!val){
	                $.dialog.alert({content:'姓名不能为空'});
	                return false;
	            }
            }
            
            $.post(setEmInfoUrl,{key:key,val:val},function(re){
                if(re.status==0){
                	_this.parents('.js_can_edit').find('.ge-info-div em').text(val);
                	_this.parents('.js_can_edit').find('.ge-info-div').show();
		        	_this.parents('.js_can_edit').find('input').val(val);
		        	_this.parents('.js_can_edit').find('input,.ge-btn-div').hide();
                    $.dialog.alert({content:re.msg,callback:function(){
                        //window.location.reload();
                    }});
                }else{
                    $.dialog.alert({content:re.msg});
                }
            })
        });
	});
  </script>