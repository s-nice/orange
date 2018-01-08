<layout name="../Layout/Layout" />
<div class="showorad">
	<div class="showorad_title">订单基本信息</div>
	<div class="showorad_c">
		<div class="showorad_list">
			<span>订单号：</span>
			<p>{$arr['info']['order_id']}</p>
		</div>
		<div class="showorad_list">
			<span>出售ID：</span>
			<p>{$arr['info']['to_user_account']}</p>
		</div>
		<div class="showorad_list">
			<span>出售名称：</span>
			<p>{$arr['info']['to_user_name']}</p>
		</div>
		<div class="showorad_list">
			<span>购买ID：</span>
			<p>{$arr['info']['user_account']}</p>
		</div>
		<div class="showorad_list">
			<span>购买名称：</span>
			<p>{$arr['info']['user_name']}</p>
		</div>
		<div class="showorad_list">
			<span>订单评价：</span>
			<p><if condition="$arr['info']['type'] eq 1">好评<elseif condition="$arr['info']['type'] eq 2"/>差评<else />---</if></p>
		</div>
		<div class="clear"></div>
		<div class="showorad_card">
			<span>被交易名片：</span>
			<div class="card_text">
				<div class="card_pic"><img src="<if condition="$arr['info']['picture'] != ''">{$arr['info']['picture']}<else />{: "__PUBLIC__/images/ysg_yjz_pic.png"}</if>" /></div>
				<div class="card_dl">
					<if condition="$arr['info']['name'] neq ''">
					<div class="showorad_dllist">
						<span>姓名：</span>
						<div class="name_right_l">
							<p>{: str_replace(',','</p><p>',$arr['info']['name'])}</p>
						</div>
					</div>
					</if>
					<if condition="$arr['info']['mobile'] neq ''">
					<div class="showorad_dllist">
						<span>手机：</span>
						<p>{: str_replace(',','</p><p>',$arr['info']['mobile'])}</p>
					</div>
					</if>
					<if condition="$arr['info']['telephone'] neq ''">
					<div class="showorad_dllist">
						<span>电话：</span>
						<p>{: str_replace(',','</p><p>',$arr['info']['telephone'])}</p>
					</div>
					</if>
					<if condition="$arr['info']['job'] neq ''">
					<div class="showorad_dllist">
						<span>职位：</span>
						<p>{: str_replace(',','</p><p>',$arr['info']['job'])}</p>
					</div>
					</if>
					<if condition="$arr['info']['department'] neq ''">
					<div class="showorad_dllist">
						<span>部门：</span>
						<p>{: str_replace(',','</p><p>',$arr['info']['department'])}</p>
					</div>
					</if>
					<if condition="$arr['info']['company_name'] neq ''">
					<div class="showorad_dllist">
						<span>公司：</span>
						<p>{: str_replace(',','</p><p>',$arr['info']['company_name'])}</p>
					</div>
					</if>
					<if condition="$arr['info']['address'] neq ''">
					<div class="showorad_dllist">
						<span>地址：</span>
						<p>{: str_replace(',','</p><p>',$arr['info']['address'])}</p>
					</div>
					</if>
					<if condition="$arr['info']['email'] neq ''">
					<div class="showorad_dllist">
						<span>E-mail：</span>
						<p>{: str_replace(',','</p><p>',$arr['info']['email'])}</p>
					</div>
					</if>
					<if condition="$arr['info']['fax'] neq ''">
					<div class="showorad_dllist">
						<span>传真：</span>
						<p>{: str_replace(',','</p><p>',$arr['info']['fax'])}</p>
					</div>
					</if>
					<if condition="$arr['info']['web'] neq ''">
					<div class="showorad_dllist">
						<span>网址：</span>
						<p>{: str_replace(',','</p><p>',$arr['info']['web'])}</p>
					</div>
					</if>
				</div>
			</div>
		</div>
	</div>
	<div class="showorad_zttitle">订单状态</div>
	<div class="showorad_ddzt">
	<foreach name="arr['status']" item="status">
		<div class="showorad_ddztlist">
			<span>{$status['created_time']|date="Y-m-d H:i:s",###+$timezone}</span>
			<p>{: isset($actType[$status['action']])?$actType[$status['action']]:'---'}</p>
		</div>
	</foreach>
	</div>
	<div class="showorad_zttitle">支付信息</div>
	<div class="showorad_ddzt">
		<div class="showorad_zftlist">
			<span>订单金额：</span>
			<p>{: isset($arr['payinfo']['total'])?$arr['payinfo']['total']:'---'}</p>
		</div>
		<div class="showorad_zftlist">
			<span>支付类型：</span>
			<p>个人</p>
		</div>
		<div class="showorad_zftlist">
			<span>支付方式：</span>
			<p>{: isset($arr['payinfo']['payment'])?$payType[$arr['payinfo']['payment']]:'---'}</p>
		</div>
		<div class="showorad_zftlist">
			<span>支付流水号：</span>
			<p>{: (isset($arr['payinfo']['code']) && !empty($arr['payinfo']['code']))?$arr['payinfo']['code']:'---'}</p>
		</div>
	</div>
	<div class="showorad_zttitle">售后信息</div>
	<div class="showorad_shmanager">
	<if condition="empty($arr['after'])">
	<div class="showorad_manager">
			<span></span>
			<p>暂无</p>
		</div>
	<else />
		<div class="showorad_manager">
			<span>责任人：</span>
			
			<if condition="$arr['after']['status'] eq '1' ">
			<p>{:'定责处理中...'}</p>
			<else />
			<p>{: (isset($arr['after']['person_liable']) && !empty($arr['after']['person_liable']))?$liable[$arr['after']['person_liable']]:'---'}</p>
			</if>
			
		</div>
		<div class="showorad_manager">
			<span>购买方描述：</span>
			<p>{: (isset($arr['after']['buyer']) && !empty($arr['after']['buyer']))?$arr['after']['buyer']:'---'}</p>
		</div>
		<div class="showorad_manager">
			<span>出售方描述：</span>
			<p>{: (isset($arr['after']['saler']) && !empty($arr['after']['saler']))?$arr['after']['saler']:'---'}</p>
		</div>
		<div class="showorad_manager">
			<span>客服描述：</span>
			<p>{: (isset($arr['after']['customer']) && !empty($arr['after']['customer']))?$arr['after']['customer']:'---'}</p>
		</div>
	</if>
	</div>
</div>