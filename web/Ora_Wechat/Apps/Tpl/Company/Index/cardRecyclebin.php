<layout name="../Layout/Company/AdminLTE_layout" />
<include file="@Layout/Company/popup" />
<div class="card-main">
	<div class="card-search">
		<div class="search-text">
			<input type="text" placeholder="可根据姓名、公司、职位、邮箱、手机号等搜索" autocomplete='off' value="{$get.keyword}"/>
			<button type="button">搜索</button>
		</div>
		<div class="if-search">
			<label for="">
				<input type="radio" />
			</label>
			<span>高级搜索</span>
		</div>
		<div class="if-table">
			<span>标签搜索</span>
		</div>
	</div>
	<div class="l_main">
		<div class="card_nav">
			<ul>
				<li <if condition="$get['type'] eq ''">class="active"</if>><a href="javascript:void(0);" type=''>名片回收站<em>(<?php echo $counts['selfcount']+$counts['bindcount']?>)</em></a></li>
			</ul>
		</div>
		<div class="l-content">
			<div class="l-con-nav">
				<ul class="l-btn l-btn-remove">
					<li class="li-remove btn-hover">
						<button type="button">立即删除</button>
					</li>
					<li class="fu-i btn-hover"><button type="button">恢复</button></li>
				</ul>
				<include file="@Layout/pagemain" />
			</div>
			<div class="table-list">
				<table class="card-table">
					<thead class="t-head">
						<tr>
							<td>
								<label for=""><input type="checkbox" autocomplete='off'/></label>
								名片图像
							</td>
							<td>姓名</td>
							<td>公司</td>
							<td>职位</td>
							<td>删除者</td>
							<td>联系方式</td>
						</tr>
					</thead>
					<tbody class="t-body">
					  <tr>
                    	<td class="td1">
                    		<label for="">
                    			<input type="checkbox" vcardid="{$v.vcardid}" autocomplete='off'/>
                    		</label>
                    		<img src="__PUBLIC__/images/mobile_img_card.png" alt="" />
                    	</td>
                    	<td class="td2">
                    		<h4 class="tit_one">和珅</h4>
                    	</td>
                    	<td class="td2">
                    		<h4 class="tit_one">北京橙鑫数据科技有限公司</h4>
                    	</td>
                    	<td class="td3">
                    		<h3 class="tit_one">总裁</h3>
                    	</td>
                    	<td class="td3">
                    		<h3 class="tit_one">嘉庆</h3>
                    	</td>
                    	<td class="td4 td4-re-icon">
                    		<p class="remove_i tit_one">立即删除</p>
                    		<p class="fu_i">恢复</p>
                    	</td>
                   </tr>
					</tbody>
				</table>
			</div>
		</div>
		<div class="page-box">
			<include file="@Layout/pagemain" />
		</div>
	</div>
</div>
