<layout name="../Layout/Layout" />
<div class="user_order_show">
	<div class="u_o_item">
		<ul>
			<li><span>类型：</span><em><if condition="$info['issue_type'] eq 'bank'">邮件 <else/>网站</if></em></li>
			<li class="clear"><span>单位：</span><em>{$info['host']}</em></li>
			<li class="clear"><span>当前状态：</span><em>
					<if condition="$info['fix_date'] eq '' ">
						异常 <else/> 正常
					</if>
				</em>
			</li>
			<li class="clear"><span>异常时间：</span><em><if condition="$info['report_date'] neq ''">
						{:date("Y-m-d h:i",strtotime($info['report_date']))}</if></em></li>
			<li class="clear"><span>异常内容：</span><em style="width:680px;">
					{$info['err_msg']}
				</em></li>
		</ul>
	</div>
	<div class="u_o_item clear" style="margin-top:25px;">
		<h4>异常历史记录：</h4>
		<div class="specil_list" style="max-height: 600px">
			<ol class="list_o">
						<volist name="historyList" id="val" key="k" empty="NO DATA">
							<li><b>{$k}</b><em>
									<if condition="$val.report_date neq ''">{:date("Y-m-d h:i",strtotime($val['report_date']))}</if></em>
								<if condition="$val['fix_date'] neq '' ">至<em>{$val.fix_date}</em>
								</if>
								<span>{$val.err_msg}</span></li>
						</volist>
				<!--<li><b>1</b><em>2016-09-2</em>至<em>2016-09-2</em><span>网站域名解析错误，无法登陆</span></li>
				<li><b>1</b><em>2016-09-2</em>至<em>2016-09-2</em><span>网站域名解析错误，无法登陆</span></li>-->
			</ol>
		</div>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$('.specil_list').mCustomScrollbar({ //初始化表格滚动条
			theme: "dark", //主题颜色
			autoHideScrollbar: false, //是否自动隐藏滚动条
			scrollInertia: 0,//滚动延迟
			horizontalScroll: false//水平滚动条
		});
	})
</script>