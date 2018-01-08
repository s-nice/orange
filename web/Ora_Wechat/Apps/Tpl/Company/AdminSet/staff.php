<layout name="../Layout/Company/AdminLTE_layout" />

<div class="division-con">
	<div class="staff-nav">
		<div class="vav-s">
			<a class="active-color" href="">在职员工</a>
			<a href="">离职员工</a>
			<a href="">待认证</a>
		</div>
	</div>
	<div class="staff-search">
		<div class="staff-search-if">
			<div class="staff-s-i-menu">
				<div class="sta-m-input">
					<input class="sta-input" type="text" value="Ora" />
					<em class="xiao-icon"><i></i></em>
				</div>
				<div class="stadd-tree">
					<!-- 搜索 -->
					<div class="search-per">
						<input type="text" />
						<b><img src="__PUBLIC__/images/search.png" alt="" /></b>
					</div>
					<!--树形结构-->
					<div class="tree tree-menu-pad">
						<ul class="tree-s">
							<li class="tree-line">
								<div class="tree-fu">
									<em class="add-icon"></em>
									<b class="line-h"></b>
									<span>Ora</span>
								</div>
								<ul class="tree-s tree-bg tree-p-top">
									<li class="tree-line tree-top">
										<div class="tree-fu">
											<div class="line-w">
												<i class="f-bg bg-fff">
													<em class="add-icon add-hide-icon"></em>
												</i>
											</div>
											<span>AI (3)</span>
										</div>
									</li>
									<li class="tree-line tree-top">
										<div class="tree-fu">
											<div class="line-w">
												<i class="f-bg bg-fff">
													<em class="add-icon"></em>
												</i>
											</div>
											<span>Cloud (3)</span>
										</div>
										<ul class="tree-s tree-bg tree-p-top">
											<li class="tree-line tree-top">
												<div class="tree-fu">
													<div class="line-w">
														<i class="f-bg bg-fff">
															<em class="add-icon"></em>
														</i>
													</div>
													<span>AI (3)</span>
												</div>
											</li>
										</ul>
									</li>
									<li class="tree-line tree-top">
										<div class="tree-fu">
											<div class="line-w">
												<i class="f-bg">
													<!--<em class="add-icon"></em>-->
												</i>
											</div>
											<span>AI (3)</span>
										</div>
									</li>
								</ul>
							</li>
						</ul>
					</div>
							
					<!--搜索结构-->
					<ul class="per-menu" style="display:none;">
						<li class="on-bg">
							<label for=""><input type="checkbox" /></label>
							<em>徐蕾</em>
						</li>
						<li>
							<label for=""><input type="checkbox" /></label>
							<em>蒋欣</em>
						</li>
						<li>
							<label for=""><input type="checkbox" /></label>
							<em>段奕宏</em>
						</li>
					</ul>
				</div>
			</div>
			
			<div class="staff-search-right">
				<em class="search-icon"><img src="__PUBLIC__/images/sta-search.png" alt="" /></em>
				<input class="menu-search-r-in" type="text" placeholder="搜索用户" />
			</div>
		</div>
	</div>
	<div class="staff-per-list">
		<table>
			<thead>
				<tr>
					<td>
						<label for=""><input type="checkbox" /></label>
					</td>
					<td>姓名</td>
					<td>手机号</td>
					<td>邮箱</td>
					<td>微信号</td>
					<td>部门</td>
					<td>角色</td>
				</tr>
			</thead>
			<thead>
				<tr>
					<td>
						<label for=""><input type="checkbox" /></label>
					</td>
					<td>徐建</td>
					<td>15423454432</td>
					<td>15423454432@163.com</td>
					<td>xiaotug78</td>
					<td class="vision-td">
						<div class="vision-menu">
							<div class="vision-menu-input">
								<input class="vision-input" type="text" value="研发" />
								<em class="vision-xia"><i></i></em>
							</div>
						</div>
					</td>
					<td>
						<div class="vision-menu">
							<div class="vision-menu-input vision-w">
								<input class="vision-input" type="text" value="研发" />
								<em class="vision-xia"><i></i></em>
							</div>
							<ul class="vision-menu-xl">
								<li>普通用户</li>
								<li>管理员</li>
								<li>超级管理员</li>
							</ul>
						</div>
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>

<!--添加有权查看弹框-->
<div class="qu-dialog">
	<div class="qu-main">
		<div class="add-qu-nav">
			<div class="nav-dia-qu">
				<a class="active-nav" href="">添加有权查看的同事</a>
				<a href="">添加有权查看的部门</a>
			</div>
		</div>
		<div class="dia-content">
			<div class="qu-search">
				<input class="q-input" type="text" placeholder="搜索同事" />
				<em class=q-search-icon><img src="__PUBLIC__/images/q-search.png" alt="" /></em>
			</div>
			<div class="qu-per">
				<ul class="qu-per-list per-list-none">
					<li class="on-active">廖文春</li>
					<li>廖文</li>
					<li>韩冰</li>
					<li>张二峰</li>
					<li>后羿</li>
				</ul>
				<ul class="qu-per-list">
					<li class="li-add">+创建部门</li>
					<li class="on-active">廖文春</li>
					<li>廖文</li>
					<li>韩冰</li>
					<li>张二峰</li>
					<li>后羿</li>
				</ul>
			</div>
		</div>
		<div class="qu-btn-foot">
			<div class="qu-btn-center">
				<div class="qu-look">
					<label for=""><input type="checkbox" /></label>
					<span>只看已选</span>
				</div>
				<div class="qu-btn">
					<button class="btn-cannel" type="button">取消</button>
					<button type="button">确定</button>
				</div>
			</div>
		</div>
	</div>
</div>