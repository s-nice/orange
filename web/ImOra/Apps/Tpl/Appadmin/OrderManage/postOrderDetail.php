<layout name="../Layout/Layout" />
<div class="user_order_show">
	<div class="u_o_item">
		<h4>订单基本信息</h4>
		<ul>
			<li><span>订单号：</span><em>{$list.ordernum}</em></li>
			<!-- <li class="clear"><span>生成时间：</span><em>
					<if condition="isset($list['createtime'])">{$list.createtime}<else/>--</if></if>
					</em></li> -->
			<li class="clear"><span>下单时间：</span><em>{$list.createtime}</em></li>
			<li class="clear"><span>用户ID：</span><em>{$list.userid}</em></li>
			<!-- <li class="clear"><span>用户名称：</span><em>
					<if condition="isset($list['username'])">{$list.username}<else/>--</if></if>
				</em></li>
			<li class="clear">
				<p><span>数量：</span><em>
						<if condition="isset($list['number'])">{$list.number}<else/>--</if></if>
					</em></p>
			</li>
			<li class="clear">
				<p><span>完成录入：</span><em>
						<if condition="isset($list['complete_number'])">{$list.complete_number}<else/>--</if></if>
						张
					</em></p>
				<p><span>未能录入：</span><em>
						<if condition="isset($list['fail_number'])">{$list.fail_number}<else/>--</if></if>
						元
					</em></p>
			</li> -->
		</ul>
	</div>
	<div class="u_o_item">
		<h4>订单状态</h4>
		<p class="status_p"><span class="time_w">{$list.updatetime}</span>
			<em>
				<php>
				switch($list['status']){
					case 1:
						echo '待邮寄';
						break;
					case 2:
						echo '服务中';
						break;
					case 3:
						echo '已完成';
						break;
					case 4:
						echo '已取消';
						break;
					default:
						echo '--';
				}
					</php>
			</em>
		</p>
		<!-- <p class="status_p"><span>2016-08-22 10:3:45</span><em>已完成</em></p>
		<p class="status_p"><span>2016-08-22 10:3:45</span><em>已完成</em></p> -->
	</div>
	<div class="u_o_item">
		<h4>服务清单</h4>
		<ul class="order_left left">
			<li class="clear">
				<span>快递公司：</span><em>{$list.express_name}</em>
			</li>
			<li>
				<span>快递单号：</span><em>{$list.express_no}</em>
			</li>
			<li>
				<span>收到名片时间：</span><em>{$list.receipt_time}</em>
			</li>
			<li>
				<span>收到名片数量：</span><em>{$list.number}</em>
			</li>
			<li>
				<span>完成录入：</span><em>{$list.complete_number}</em>
			</li>
			<li>
				<span>未能录入：</span><em>{$list.fail_number}</em>
			</li>
			<li>
				<span>服务完成时间：</span><em>{$list.serviceend_time}</em>
			</li>
		</ul>
		<ul class="order_right right">
			<li class="clear">
				<span>回寄名片：</span><em><if condition="$list['is_return']=='true'">是<else/>否</if></em>
			</li>
			<li>
				<span>收件人：</span><em>{$list.to_name}</em>
			</li>
			<li>
				<span>联系电话：</span><em>{$list.mobile_phone}</em>
			</li>
			<li>
				<span>详细地址：</span><em>{$list.address}</em>
			</li>
			<li>
				<span>数据共享：</span><em><if condition="$list['is_share']=='true'">是<else/>否</if></em>
			</li>
			<li>
				<span style="text-overflow:ellipsis">共享账号：</span><em title="{$list.share_ids}">{$list.share_ids}</em>
			</li>

		</ul>
	</div>
</div>