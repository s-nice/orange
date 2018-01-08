<layout name="../Layout/Layout" />
<div class="app_price">
	<div class="app_free">
		<h5>免费体验：</h5>
		<div class="app_num">
			<span>橙子伴侣免费体验：<input value="{$arr.daynum}" name="daynum" class="js_time js_time_val" type="text" placeholder="请输入整数"><i style="margin-left:5px;">天</i></span>
			<button class="js_save_time" type="button">保存</button>
		</div>
		<div class="app_num">
			<span>橙子伴侣容量限制：<input value="{$arr.stocknum}" name="stocknum" class="js_time js_time_val" type="text" placeholder="请输入整数"><i style="margin-left:5px;">张</i></span>
			<button class="js_save_time" type="button">保存</button>
		</div>
		<div class="app_num">
			<span style="margin-left:28px;">橙子赠送时长：<input value="{$arr.timenum}" name="timenum" class="js_time js_time_val" type="text" placeholder="请输入整数"><i style="margin-left:5px;">天</i></span>
			<button class="js_save_time" type="button">保存</button>
		</div>
	</div>
	<div class="app_free">
		<h5 class="left">会员权益：</h5>
	</div>
	<div class="vip_item_p">
		<p>苹果价格查询链接：https://itunesconnect.apple.com/WebObjects/iTunesConnect.woa/ra/ng/pricingMatrix/recurring</p>
		<p style="color:red">※ 请同时在苹果系统及运营后台设置价格！并且将两系统价格进行统一！</p>
		<div class="apple">
			<span>查询苹果定价表</span>&rarr;<span>在苹果系统进行填写</span>&rarr;<span>记录苹果收款码</span>&rarr;<span>提交</span>
		</div>
	</div>
	<div class="push_item">
		<button class="app_save_btn js_add_vip" type="button">新增</button>
		<div class="vip_item js_push js_scroll" style="width:738px;max-height:740px;overflow-y:auto;">
			<if condition="!sizeof($list)">
			<div class="app_vip clear js_vips">
				<div class="vip_tit">
					<span>权益标题：</span>
					<input class="js_vip_tit js_val" type="text" maxlength="32" value="">
					<button type="button" class="js_delete">删除</button>
				</div>
				<div class="vip_tit">
					<span>苹果收款码：</span>
					<input class="js_vip_num js_val" type="text" value="">
				</div>
				<div class="vip_tit">
					<span>权益时间：</span>
					<input class="js_time js_vip_time js_val" type="text" placeholder="请输入整数">
					<em>月</em>
					<!-- <span>权益容量：</span>
					<input class="js_time js_vip_piece js_val" type="text" placeholder="请输入整数">
					<em>张</em> -->
					<span>权益价格：</span>
					<input class="js_vip_price js_val" type="text" value="">
					<em>元</em>
				</div>
				<div class="vip_tit">
					<span class="left">权益说明：</span>
					<textarea class="left js_val js_vip_info" name="" id="" cols="30" rows="10"></textarea>
				</div>
			</div>
			<else />
				<foreach name="list" item="val">
					<div class="app_vip clear js_vips" val="{$val.id}">
						<div class="vip_tit">
							<span>权益标题：</span>
							<input class="js_vip_tit js_val" type="text" maxlength="32" value="{$val.title}">
							<button type="button" class="js_delete">删除</button>
						</div>
						<div class="vip_tit">
							<span>苹果收款码：</span>
							<input class="js_vip_num js_val" type="text" value="{$val.appid}">
						</div>
						<div class="vip_tit">
							<span>权益时间：</span>
							<input class="js_time js_vip_time js_val" type="text" placeholder="请输入整数" value="{$val.equitytime}" />
							<em>月</em>
							<!-- <span>权益容量：</span>
							<input class="js_time js_vip_piece js_val" type="text" placeholder="请输入整数"  value="{$val.equitycapacity}" />
							<em>张</em> -->
							<span>权益价格：</span>
							<input class="js_vip_price js_val" type="text" value="{$val.price}">
							<em>元</em>
						</div>
						<div class="vip_tit">
							<span class="left">权益说明：</span>
							<textarea class="left js_val js_vip_info" name="" id="" cols="30" rows="10">{$val.info}</textarea>
						</div>
					</div>
				</foreach>
			</if>
		</div>
	</div>
	<div class="app_save">
		<button class="big_button js_save_vip" type="button">保存</button>
	</div>
</div>
<script type="text/javascript">
	var saveUrl = "__URL__/save";
	var saveJsonUrl = "__URL__/saveJson";
	var delUrl = "__URL__/del";
	$(function(){
		$.appprice.priceJs();
	});
</script>