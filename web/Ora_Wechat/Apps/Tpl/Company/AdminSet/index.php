<layout name="../Layout/Company/AdminLTE_layout" />
<div class="tree-main">
	<!-- 面包屑start -->
	<include file="Common/breadCrumbs"/>
	<!-- 面包屑end -->
	<div class="top-null"></div>
	<div class="division-content">
		<div class="division-nav">
			<span>权限设置</span>
            <a href="{:U(MODULE_NAME.'/Departments/index','','',true)}"><span class="active">部门管理</span></a>
			<span>员工管理</span>
			<span>标签管理</span>
		</div>
		<div class="division-con">
			<div class="divi-right">
				<div class="division-add-menu">
					<button type="button">+&nbsp;添加部门</button>
				</div>
				<div class="tree">
					<ul class="tree-s">
						<li class="tree-line">
							<div class="tree-fu">
								<em class="add-icon"></em>
								<b class="line-h"></b>
								<span>Ora</span>
								<div class="add-child">
									<span class="add-ic">添加子部门</span>
								</div>
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
										<div class="add-child">
											<span class="add-ic">添加子部门</span>
											<span class="exchange-ic">修改</span>
											<span class="remove-ic">删除</span>
										</div>
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
										<div class="add-child">
											<span class="add-ic">添加子部门</span>
											<span class="exchange-ic">修改</span>
											<span class="remove-ic">删除</span>
										</div>
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
												<div class="add-child">
													<span class="add-ic">添加子部门</span>
													<span class="exchange-ic">修改</span>
													<span class="remove-ic">删除</span>
												</div>
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
										<div class="add-child">
											<span class="add-ic">添加子部门</span>
											<span class="exchange-ic">修改</span>
											<span class="remove-ic">删除</span>
										</div>
									</div>
								</li>
							</ul>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<!--添加部门弹框-->
	<div class="ora-dialog">
		<div class="vision-dia-mian">
			<div class="dia-add-vis">
				<h4>添加部门</h4>
				<div class="dia-add-vis-menu">
					<h5><em>*</em>部门名称</h5>
					<div class="dia_menu all-width-menu">
						<input class="fu-dia" type="text" placeholder="必填" />
					</div>
				</div>
				<div class="dia-add-vis-menu clear">
					<h5>部门名称</h5>
					<div class="dia_menu dia-have-bg">
						<input class="fu-dia" type="text" placeholder="必填" readonly="readonly" />
						<b class="m-b"><i></i></b>
						<div class="tree-j-dia">
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
				</div>
				<div class="dia-add-vis-menu clear">
					<h5>部门成员</h5>
					<div class="dia_menu dia-have-bg">
						<input class="fu-dia" type="text" placeholder="选择群成员" readonly="readonly" />
						<b class="m-b"><i></i></b>
						<div class="menu-ch-per">
							<div class="search-per">
								<input type="text" />
								<b><img src="__PUBLIC__/images/search.png" alt="" /></b>
							</div>
							<ul class="per-menu">
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
				</div>
				<div class="dia-add-vis-menu clear">
					<h5>部门内分享名片</h5>
					<div class="dia_menu dia-have-bg">
						<input class="fu-dia" type="text" placeholder="选择群成员" readonly="readonly" />
						<b class="m-b"><i></i></b>
						<ul class="menu-xl">
							<li>是</li>
							<li>否</li>
						</ul>
					</div>
				</div>
			</div>
			<div class="dia-add-v-btn clear">
				<button type="button">取消</button>
				<button type="button" class="bg-di">确定</button>
			</div>
		</div>
	</div>
</div>