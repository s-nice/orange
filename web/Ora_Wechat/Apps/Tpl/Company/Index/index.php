<layout name="../Layout/Company/AdminLTE_layout" />
<include file="@Layout/Company/popup" />
<div class="card-main">
	<!-- 面包屑start -->
	<include file="Common/breadCrumbs"/>
	<!-- 面包屑end -->
	<div class="card-search">
		<div class="search-text">
			<input type="text" ng-model="keyword" placeholder="可根据姓名、公司、职位、邮箱、手机号等搜索" autocomplete='off'/>
			<button type="button" ng-click="doSearchCards(keyword)">搜索</button>
		</div>
		<div class="if-search" ng-click="visibleSearchDetail=!visibleSearchDetail">
			<span>更多筛选条件</span>
			<em class="xia-icon-i"></em>
		</div>
		<div class="if-table">
			<span ng-click="visibleSearchTag=!visibleSearchTag;$event.stopPropagation();">标签搜索</span>
			<em class="xia-icon-i"></em>
			<ul class="if-label-menu" ng-show="visibleSearchTag">
                <li ng-click="doSearchByTag('','标签搜索')">全部标签</li>
                <li ng-repeat="tag in dataTags" title="{{tag.tags}}" ng-click="doSearchByTag(tag.id,tag.tags)">{{tag.tags}}</li>
			</ul>
		</div>
	</div>
	<div class="if-more clear" ng-show="visibleSearchDetail">
		<div class="if-input">
			<div class="if-input-item clear">
				<div class="if-big-m">
					<span>创建人：</span>
					<input type='hidden' ng-model='paramSearchDetail.eid'>
					<input class="more-i-d hand creator" type="text" autocomplete='off' placeholder="创建者" ng-click="visibleAccount=!visibleAccount;$event.stopPropagation();" ng-model="paramSearchDetail.ename"/>
					<em class="xia-s-m"><b></b></em>
					<ul class="more-menu-m" ng-show="visibleAccount">
						<li ng-click="doSelectAccount('','无')">无</li>
						<li ng-repeat='a in dataAccounts' ng-click="doSelectAccount(a.id,a.name)">{{a.name}}</li>
					</ul>
				</div>
				<div class="if-big-m">
					<span>公司：</span>
					<input class="more-i-d" type="text" autocomplete='off' ng-model="paramSearchDetail.org"/>
				</div>
				<div class="if-big-m">
					<span>部门：</span>
					<input class="more-i-d" type="text" autocomplete='off' ng-model="paramSearchDetail.depar"/>
				</div>
			</div>
			<div class="if-input-item clear">
				<div class="if-big-m">
					<span>职位：</span>
					<input class="more-i-d" type="text" autocomplete='off' ng-model="paramSearchDetail.title"/>
				</div>
				<div class="if-big-m">
					<span>地址：</span>
					<input class="more-i-d" type="text" autocomplete='off' ng-model="paramSearchDetail.adr"/>
				</div>
				<div class="if-big-m">
					<span>姓名：</span>
					<input class="more-i-d" type="text" autocomplete='off' ng-model="paramSearchDetail.fn"/>
				</div>
			</div>
			<div class="if-input-item clear">
				<div class="if-big-m">
					<span>邮箱：</span>
					<input class="more-i-d" type="text" autocomplete='off' ng-model="paramSearchDetail.email"/>
				</div>
				<div class="if-big-m">
					<span>交换时间：</span>
					<input id='js_begintime' class="m-time-input" type="text" autocomplete='off' ng-model="paramSearchDetail.stime" />
					<i class="more-line">-</i>
					<input id='js_endtime' class="m-time-input" type="text" autocomplete='off' ng-model="paramSearchDetail.etime" />
				</div>
			</div>
			<div class="more-if-btn">
				<button type="button" ng-click="doSearchDetail()">立即搜索</button>
			</div>
		</div>
		<!--小三角-->
		<div class="sh-s-jiao"></div>
		<!--关闭按钮-->
		<span class="close-more hand" ng-click="visibleSearchDetail=false"></span>
	</div>
	<div class="l_main clear">
		<div class="card_nav tnone">
			<ul>
                <li><a href="javascript:void(0);">搜索结果<em>({{dataSearchedCount}})</em></a></li>
                <li ng-class="{0:'active'}[paramCardType]"><a href="javascript:void(0);" ng-click="doSearchByType(0)">所有名片<em>({{dataSelfcount+dataBindcount}})</em></a></li>
				<li ng-class="{1:'active'}[paramCardType]"><a href="javascript:void(0);" ng-click="doSearchByType(1)">我创建的名片<em>({{dataSelfcount}})</em></a></li>
				<li ng-class="{2:'active'}[paramCardType]"><a href="javascript:void(0);" ng-click="doSearchByType(2)">共享给我的名片<em>({{dataBindcount}})</em></a></li>
			</ul>
			<div class="card-remove">名片回收站</div>
		</div>
		<div class="l-page-content">
			<div class="l-content">
				<div class="l-con-nav">
					<ul class="l-btn">
					    <li class="biao_i btn-hover"><button type="button" ng-click="doShowTagWindow()">标记为</button></li>
					    <li class="enjoy_ch btn-hover"><button type="button" ng-click="doShowShareWindow()">添加共享</button></li>
					    <li class="bian_i btn-hover"><button type="button" ng-click="doShowEditWindow(true)">编辑</button></li>
					    <!-- 
						<li class="fa_i btn-hover"><button type="button">群发邮件</button></li>
						-->
						<li class="remove_i btn-hover"><button type="button" ng-click="doDelCard()">删除</button></li>
						<li class="add_i"><button type="button" ng-click="doShowEditWindow()">+&nbsp添加名片</button></li>
					</ul>
					<div class="page none">
	                    <div>
	                        <span class="nowandall">{{paramNowPage}}/{{paramTotalPage}}</span>
	                        <a ng-hide='paramNowPage==1' class="prev" href="javascript:void(0);" ng-click="doTurnPage(paramNowPage-1)">上一页</a>
	                        <a ng-hide='paramNowPage==paramTotalPage' class="next" href="javascript:void(0);" ng-click="doTurnPage(paramNowPage+1)">下一页</a>
	                        <form class="ng-pristine ng-valid">
	                            <input style="width:25px;" class="jumppage" type="text" ng-model='paramInputP' ng-keyup="doCheckPage()">
	                            <input value="跳转" type='button' ng-click="doTurnPage(paramInputP)">
	                        </form>
	                    </div>
	                </div>
	                <!--名片墙按钮-->
	    			<div class="wall-href">
	    				<div class="wall-menu" ng-class="{true:'wall-menu-bg'}[visibleCardsDisplay]" >
	    					<span ng-click="visibleCardsDisplay=!visibleCardsDisplay;$event.stopPropagation();"></span>
	    				</div>
	    				<div class="wall-img-ex tnone" ng-show="visibleCardsDisplay">
	    					<ul class="ex-list">
	    						<li ng-class="{1:'active'}[paramCardStyle]" ng-click="doChangeCardsStyle(1,$event)" ng-mouseenter="visibleCardStyleTip=1" ng-mouseleave="visibleCardStyleTip=false">
	    							<span class="w-small-icon"></span>
	    							<em ng-show="visibleCardStyleTip==1">小图<i></i></em>
	    						</li>
	    						<li class="m-tip" ng-class="{2:'active'}[paramCardStyle]" ng-click="doChangeCardsStyle(2,$event)" ng-mouseenter="visibleCardStyleTip=2" ng-mouseleave="visibleCardStyleTip=false">
	    							<span class="w-middle-icon"></span>
	    							<em ng-show="visibleCardStyleTip==2">中图<i></i></em>
	    						</li>
	    						<li class="b-tip" ng-class="{3:'active'}[paramCardStyle]" ng-click="doChangeCardsStyle(3,$event)" ng-mouseenter="visibleCardStyleTip=3" ng-mouseleave="visibleCardStyleTip=false">
	    							<span class="w-big-icon"></span>
	    							<em ng-show="visibleCardStyleTip==3">大图<i></i></em>
	    						</li>
	    						<li class="l-tip" ng-class="{0:'active'}[paramCardStyle]" ng-click="doChangeCardsStyle(0,$event)" ng-mouseenter="visibleCardStyleTip=4" ng-mouseleave="visibleCardStyleTip=false">
	    							<span class="list-icon"></span>
	    							<em ng-show="visibleCardStyleTip==4">列表<i></i></em>
	    						</li>
	    					</ul>
	    				</div>
	    			</div>
				</div>
				<div class="table-list" ng-show="!paramCardStyle">
					<table class="card-table">
						<thead class="t-head tnone">
							<tr>
								<td class="col-sm-1 col-md-1">
									<label class="input-th" for=""><input ng-model="paramCardSelectAll" type="checkbox" autocomplete='off' ng-change="doSelectCardAll()"/><em></em></label>
								</td>
								<td class="col-sm-2 col-md-2">
									名片图像
								</td>
								<td class="col-sm-3 col-md-3">姓名/公司</td>
								<td class="col-sm-2 col-md-2">部门/职位</td>
								<td class="col-sm-2 col-md-2">联系方式</td>
								<td class="col-sm-2 col-md-2">创建者</td>
							</tr>
						</thead>
						<tbody class="t-body tnone" ng-hide="loadingCards">
						  <tr ng-repeat="v in dataCards">
						  	<td class="td1 col-sm-1 col-md-1">
						  		<label class="input-th" for="">
	                    			<input aa='{{v.vcardid}}' ng-model="dataCards[$index]['checked']" type="checkbox" autocomplete='off'/>
	                    			<em></em>
	                    		</label>
						  	</td>
	                    	<td class="td1 col-sm-3 col-md-3">
	                    		<img src="{{v.picture}}" alt="" class='hand' ng-click="showInfoWindow($index)"/>
	                    	</td>
	                    	<td class="td2 col-sm-3 col-md-3">
	                    		<h4 class="tit_one" title="{{v['front']['FN'][0]}}">{{v['front']['FN'][0]}}</h4>
	                    		<h4 title="{{v['front']['ORG'][0]}}">{{v['front']['ORG'][0]}}</h4>
	                    		<div class="t_tags">
	                    			<em>Tags:</em>
	                    			<div class="tag-box">
		                    			<span ng-repeat="vv in v.remark" class='hand' title='{{vv.tags}}' ng-click="doSearchByTag(vv.id,vv.tags)">{{vv.tags}}</span>
		                    		</div>
	                    		</div>
	                    	</td>
	                    	<td class="td3 col-sm-2 col-md-2">
	                    		<h3 class="tit_one" title="{{v['front']['DEPAR'][0]}}">{{v['front']['DEPAR'][0]}}</h3>
	                    		<h3 title="{{v['front']['TITLE'][0]}}">{{v['front']['TITLE'][0]}}</h3>
	                    	</td>
	                    	<td class="td4 td4-icon col-sm-2 col-md-2">
	                    		<p class="tel_i tit_one" title="{{v['front']['TEL'][0]}}">{{v['front']['TEL'][0]}}</p>
	                    		<p class="phone_i" title="{{v['front']['CELL'][0]}}">{{v['front']['CELL'][0]}}</p>
	                    		<p class="email_i" title="{{v['front']['EMAIL'][0]}}">{{v['front']['EMAIL'][0]}}</p>
	                    	</td>
	                    	<td class="td4 col-sm-2 col-md-2">
	                    		<p class="name-color hand creator" ng-click="doSelectAccount(v.accountid,v.accountname);doSearchDetail();" title="{{v.accountname}}">{{v.accountname}}</p>
	                    		<p class="time-color">{{v.createdtime}}</p>
	                    	</td>
	                    </tr>
						</tbody>
					</table>
				</div>
				<!--照片墙-->
				<div class="img-wall tnone" ng-hide="!paramCardStyle||loadingCards">
					<!-- <div class="wall-null"></div> -->
					<div class="wall-content">
						<ul class="wall-list" ng-class="{1:'small-img',2:'middle-img',3:'big-img'}[paramCardStyle]">
							<li ng-repeat="v in dataCards">
								<img src="{{v.picture}}" alt="" class='hand' ng-click="showInfoWindow($index)"/>
								<p>创建时间：{{v.createdtime}}</p>
								<label for=""><input class="l-input" type="checkbox" aa='{{v.vcardid}}' ng-model="dataCards[$index]['checked']" autocomplete='off'/><i></i></label>
							</li>
						</ul>
					</div>
				</div>
				<!--加载部分-->
				<div class="i-loading i-loading-height" ng-show="loadingCards">
					<div class="load-content i-margin">
						<dl>
							<dt><img src="__PUBLIC__/images/loading-icon.gif" alt="" /></dt>
							<dd>加载中，请你耐心等待……</dd>
						</dl>
					</div>
				</div>
			</div>
			<!--翻页-->
			<div class="page-box tnone">
				<div class="page page-auto">
	                <div>
	                    <span class="nowandall">{{paramNowPage}}/{{paramTotalPage}}</span>
	                    <a ng-hide='paramNowPage==1' class="prev" href="javascript:void(0);" ng-click="doTurnPage(paramNowPage-1)">上一页</a>
	                    <a ng-hide='paramNowPage==paramTotalPage' class="next" href="javascript:void(0);" ng-click="doTurnPage(paramNowPage+1)">下一页</a>
	                    <form class="ng-pristine ng-valid">
	                        <input style="width:25px;" class="jumppage" type="text" ng-model='paramInputP' ng-keyup="doCheckPage()">
	                        <input value="跳转" type='button' ng-click="doTurnPage(paramInputP)">
	                    </form>
	                </div>
	            </div>
			</div>
		</div>
	</div>
</div>

<!--  分享二维码弹框  -->
<include file="Common/entQrCode"/>
<!--  修改密码弹框    -->
<div class="ora-dialog js_forget_wrap" >
	<div class="vision-dia-mian">
		<div class="dia-add-vis">
			<h4>修改密码</h4>
			<div class="dia-add-vis-menu">
				<h5><em>*</em>当前密码</h5>
				<div class="dia_menu all-width-menu">
					<input class="fu-dia" type="text" autocomplete='off' />
					<p class="error-p">当前密码错误</p>
				</div>
			</div>
			<div class="dia-add-vis-menu">
				<h5><em>*</em>新密码</h5>
				<div class="dia_menu all-width-menu">
					<input class="fu-dia" type="text" autocomplete='off' />
					<p class="error-p">当前密码错误</p>
				</div>
			</div>
			<div class="dia-add-vis-menu">
				<h5><em>*</em>确认新密码</h5>
				<div class="dia_menu all-width-menu">
					<input class="fu-dia" type="text" autocomplete='off' />

				</div>
			</div>
		</div>
		<div class="dia-add-v-btn clear">
			<button type="button" id="js_forget_cancel">取消</button>
			<button class="bg-di" type="button">确认</button>
		</div>
	</div>
</div>

<!--名片信息-->
<div class="x-dialog info-dialog" ng-show="visibleInfoWindow">
	<div class="x-main">
		<div class="x-tit">
			<h3>{{dataCard.front.FN[0]}}</h3>
			<span class="close-dia" ng-click="hideInfoWindow()"></span>
		</div>
		<div class="tab-qie">
			<span ng-class="{0:'active'}[paramCardInfoTag]" class="hand" ng-click="doSwitchTabInInfoWindow(0)">名片信息<em></em></span>
			<span ng-class="{1:'active'}[paramCardInfoTag]" class='hand' ng-click="doSwitchTabInInfoWindow(1)">权限设置<em></em></span>
		</div>
		<!--信息部分-->
		<div class="x-content" ng-show='paramCardInfoTag==0'>
			<div class="x-edit">
				<div class="edit-icon">
					<a class="edit-i-x" ng-click="doShowEditWindow(dataCard.vcardid)"><span></span><em>编辑</em></a>
					<a class="remove-i-x" ng-click="doDelCard(dataCard.vcardid)"><span></span><em>删除</em></a>
				</div>
			</div>
			<div class="x-info clear">
				<div class="x-info-l">
					<div class="l-img">
						<ul>
							<li>
    							<img ng-show="paramCardTurnInInfoWindow!=2" src="{{dataCard.picpatha}}" alt="正面" class='hand' ng-click="doCardEnlarge($event)"/>
    							<img ng-show="paramCardTurnInInfoWindow==2" src="{{dataCard.picpathb}}" alt="反面" class='hand' ng-click="doCardEnlarge($event)"/>
							</li>
						</ul>
					</div>
					<span class="left-btn-i btn-img" ng-class="{1:'dsb'}[paramCardTurnInInfoWindow]" ng-hide="paramCardTurnInInfoWindow==false" ng-click="doSwitchCardInInfoWindow(1)"></span>
					<span class="right-btn-i btn-img" ng-class="{2:'dsb'}[paramCardTurnInInfoWindow]" ng-hide="paramCardTurnInInfoWindow==false" ng-click="doSwitchCardInInfoWindow(2)" ></span>
				</div>
				<div class="x-info-r">
					<div class="r-conent">
						<h4>{{dataCardInfo.FN[0] || '(空)'}}</h4>
						<p>{{dataCardInfo.DEPAR[0]?dataCardInfo.DEPAR[0]+' '+dataCardInfo.TITLE[0]:dataCardInfo.TITLE[0]}}</p>
						<p>{{dataCardInfo.ORG[0]}}</p>
						<div class="x-per-info">
							<span>创建者：</span><em class="x-name">{{dataCard.accountname}}</em><span>创建时间：</span><em class="x-time">{{dataCard.createdtime}}</em>
						</div>
						<div class="x-label">
						    <span>Tags：</span>
						    <div class="tag_dia">
                                <em class="label-em" ng-repeat="vv in dataCard.remark" style='display: inline;' ng-mouseover="vv.visibleDelBtn=true" ng-mouseout="vv.visibleDelBtn=false">
                                    <aa>{{vv.tags}}</aa><i style='display:block;' ng-show="vv.visibleDelBtn" ng-click="doDelTagInInfoWindow(vv.id)"></i>
                                </em>
						    	<button type="button" ng-click="doShowTagWindow(true)"><b></b>添加标签</button>
						    </div>
						</div>
					</div>
				</div>
			</div>
			<div class="x-oer-info">
				<h3>名片信息</h3>
				<div class="x-info-list">
					<div class="x-info-item clear">
						<i class="x-phone-i i-icon"></i>
						<div class="x-i-l">
							<dl class="x-i-dl" ng-repeat="vv in dataCardInfo.CELL">
								<dt>手机</dt>
								<dd>{{vv}}</dd>
							</dl>
						</div>
					</div>
					<div class="x-info-item clear">
						<i class="x-mobile-i i-icon"></i>
						<div class="x-i-l">
							<dl class="x-i-dl" ng-repeat="vv in dataCardInfo.TEL">
								<dt>工作电话</dt>
								<dd>{{vv}}</dd>
							</dl>
						</div>
					</div>
					<div class="x-info-item clear">
						<i class="x-email-i i-icon"></i>
						<div class="x-i-l">
							<dl class="x-i-dl" ng-repeat="vv in dataCardInfo.EMAIL">
								<dt>邮箱</dt>
								<dd>{{vv}}</dd>
							</dl>
						</div>
					</div>
					<div class="x-info-item clear">
						<i class="x-map-i i-icon"></i>
						<div class="x-i-l">
							<dl class="x-i-dl" ng-repeat="vv in dataCardInfo.ADR">
								<dt>地址</dt>
								<dd>{{vv}}</dd>
							</dl>
						</div>
					</div>
					<div class="x-info-item clear">
						<i class="x-inte-i i-icon"></i>
						<div class="x-i-l">
							<dl class="x-i-dl" ng-repeat="vv in dataCardInfo.URL">
								<dt>网址</dt>
								<dd>{{vv}}</dd>
							</dl>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!--权限选择-->
		<div class="x-content x-qu-height"  ng-show='paramCardInfoTag==1'>
			<div class="qu-item-x clear" ng-hide="loadingInfo">	
				<div class="tit-ch">
					<h3>有权查看的同事</h3>
					<button type="button" ng-click="doShowShareWindow('emp',true)">添加</button>
				</div>
				<ul class="look-list">
					<li>
						<span><aa>{{dataCard.accountname}}</aa><b>(创)</b></span>
						<em></em>
					</li>
					<li type='1' ng-hide="v.id==dataCard.accountid" ng-class="{true:'active'}[v.visibleShareDelBtn]" ng-repeat="v in dataEmpDept.emps|filter:{checked:true}" ng-mouseover="v.visibleShareDelBtn=true" ng-mouseout="v.visibleShareDelBtn=false">
						<span><aa>{{v.name}}</aa></span>
						<em ng-click="doDelShareInInfoWindow(v.id, 1)"></em>
					</li>
				</ul>
			</div>
			<div class="qu-item-x clear" ng-hide="loadingInfo">	
				<div class="tit-ch">
					<h3>有权查看的部门</h3>
					<button type="button" ng-click="doShowShareWindow('dept',true)">添加</button>
				</div>
				<ul class="look-list">
					<li type='2' ng-class="{true:'active'}[v.visibleShareDelBtn]" ng-repeat="v in dataEmpDept.depts|filter:{checked:true}" ng-mouseover="v.visibleShareDelBtn=true" ng-mouseout="v.visibleShareDelBtn=false">
						<span>{{v.name}}</span>
						<em ng-click="doDelShareInInfoWindow(v.id, 2)"></em>
					</li>
				</ul>
			</div>
			<!--加载部分-->
			<div class="i-loading" ng-show="loadingInfo">
				<div class="load-content dia-i-margin">
					<dl>
						<dt><img src="__PUBLIC__/images/loading-icon.gif" alt="" /></dt>
						<dd>加载中，请你耐心等待……</dd>
					</dl>
				</div>
			</div>
		</div>
	</div>
</div>

<!--编辑名片信息弹框-->
<div class="x-dialog edit-card-dialog" ng-show="visibleEditWindow">
	<div class="x-main">
		<div class="x-tit">
			<h3>{{paramStrEditWindow[paramStrIndex]}}</h3>
			<span class="close-dia" ng-click="doHideEditWindow()"></span>
		</div>
		<div class="x-content">
			<div class="edit-c-img">
				<div class="card-img-ed">
					<img class='hand' src="{{paramImgSrcInEditWindow}}" alt="" ng-click="doCardEnlarge($event)"/>
					<canvas id="cardEditor" width="1200" height="720" style='cursor:default;display:none;background:url(/images/canvasbg.png);'></canvas>
					<span class="left-btn-i btn-img" ng-class="{1:'dsb'}[paramCardTurnInEditWindow]" ng-hide="paramCardTurnInEditWindow==false" ng-click="doSwitchCardInEditWindow(1)"></span>
					<span class="right-btn-i btn-img" ng-class="{2:'dsb'}[paramCardTurnInEditWindow]" ng-hide="paramCardTurnInEditWindow==false" ng-click="doSwitchCardInEditWindow(2)"></span>
				</div>
				<div class="x-per-info edit-ch">
					<span>创建者：</span><em class="x-name">{{dataCard.accountname}}</em><span>创建时间：</span><em class="x-time">{{dataCard.createdtime}}</em>
				</div>
			</div>
			<div class="edit-form front" ng-show="visibleFrontInEditWindow">
				<div class="edit-form-item" ng-repeat="v in dataFront.FN track by $index">
					<span>姓名</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='FN' required_ max='6' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataFront', $index)" ng-blur="doChangeValueInEditWindow($event,'dataFront', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('FN','dataFront')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('FN','dataFront',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataFront.ORG track by $index">
					<span>公司</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='ORG' required_ max='30' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataFront', $index)" ng-blur="doChangeValueInEditWindow($event,'dataFront', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('ORG','dataFront')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('ORG','dataFront',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataFront.DEPAR track by $index">
					<span>部门</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='DEPAR' max='12' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataFront', $index)" ng-blur="doChangeValueInEditWindow($event,'dataFront', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('DEPAR','dataFront')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('DEPAR','dataFront',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataFront.TITLE track by $index">
					<span>职位</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='TITLE' required_ max='12' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataFront', $index)" ng-blur="doChangeValueInEditWindow($event,'dataFront', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('TITLE','dataFront')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('TITLE','dataFront',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataFront.CELL track by $index">
					<span>手机</span>
					<input class="ed-i-input" type="mobile_" autocomplete='off' name='CELL' required_ value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataFront', $index)" ng-blur="doChangeValueInEditWindow($event,'dataFront', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('CELL','dataFront')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('CELL','dataFront',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataFront.TEL track by $index">
					<span>工作电话</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='TEL' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataFront', $index)" ng-blur="doChangeValueInEditWindow($event,'dataFront', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('TEL','dataFront')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('TEL','dataFront',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataFront.EMAIL track by $index">
					<span>邮箱</span>
					<input class="ed-i-input" type="email_" autocomplete='off' name='EMAIL' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataFront', $index)" ng-blur="doChangeValueInEditWindow($event,'dataFront', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('EMAIL','dataFront')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('EMAIL','dataFront',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataFront.ADR track by $index">
					<span>地址</span>
					<input class="ed-i-input" type="text" autocomplete='off' required_ name='ADR' max='70' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataFront', $index)" ng-blur="doChangeValueInEditWindow($event,'dataFront', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('ADR','dataFront')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('ADR','dataFront',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataFront.URL track by $index">
					<span>网址</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='URL' max='25' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataFront', $index)" ng-blur="doChangeValueInEditWindow($event,'dataFront', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('URL','dataFront')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('URL','dataFront',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
			</div>
			<div class="edit-form back" ng-show="!visibleFrontInEditWindow">
				<div class="edit-form-item" ng-repeat="v in dataBack.FN track by $index">
					<span>姓名</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='FN' max='6' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataBack', $index)" ng-blur="doChangeValueInEditWindow($event,'dataBack', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('FN','dataBack')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('FN','dataBack',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataBack.ORG track by $index">
					<span>公司</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='ORG' max='30' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataBack', $index)" ng-blur="doChangeValueInEditWindow($event,'dataBack', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('ORG','dataBack')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('ORG','dataBack',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataBack.DEPAR track by $index">
					<span>部门</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='DEPAR' max='12' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataBack', $index)" ng-blur="doChangeValueInEditWindow($event,'dataBack', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('DEPAR','dataBack')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('DEPAR','dataBack',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataBack.TITLE track by $index">
					<span>职位</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='TITLE' max='12' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataBack', $index)" ng-blur="doChangeValueInEditWindow($event,'dataBack', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('TITLE','dataBack')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('TITLE','dataBack',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataBack.CELL track by $index">
					<span>手机</span>
					<input class="ed-i-input" type="mobile_" autocomplete='off' name='CELL' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataBack', $index)" ng-blur="doChangeValueInEditWindow($event,'dataBack', $index)" />
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('CELL','dataBack')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('CELL','dataBack',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataBack.TEL track by $index">
					<span>工作电话</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='TEL' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataBack', $index)" ng-blur="doChangeValueInEditWindow($event,'dataBack', $index)" />
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('TEL','dataBack')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('TEL','dataBack',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataBack.EMAIL track by $index">
					<span>邮箱</span>
					<input class="ed-i-input" type="email_" autocomplete='off' name='EMAIL' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataBack', $index)" ng-blur="doChangeValueInEditWindow($event,'dataBack', $index)" />
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('EMAIL','dataBack')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('EMAIL','dataBack',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataBack.ADR track by $index">
					<span>地址</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='ADR' max='70' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataBack', $index)" ng-blur="doChangeValueInEditWindow($event,'dataBack', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('ADR','dataBack')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('ADR','dataBack',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
				<div class="edit-form-item clear" ng-repeat="v in dataBack.URL track by $index">
					<span>网址</span>
					<input class="ed-i-input" type="text" autocomplete='off' name='URL' max='25' value='{{v}}' ng-keyup="doChangeValueInEditWindow($event,'dataBack', $index)" ng-blur="doChangeValueInEditWindow($event,'dataBack', $index)"/>
					<em class="add-i-ed icon-edit" ng-click="doAddItemInEditWindow('URL','dataBack')"></em>
					<em class="remove-i-ed icon-edit" ng-click="doRemoveItemInEditWindow('URL','dataBack',$index)" ng-hide="$index==0"></em>
					<p class="error-p clear none"></p>
				</div>
			</div>
			<div class="edit-btn-d right-edit">
				<button class="edit-btn-s" type="button" ng-click="submitEditWindow()">保存</button>
				<button class="edit-btn-s ed-btn-diff" type="button" ng-click="doHideEditWindow()">取消</button>
			</div>
		</div>
	</div>
</div>

<!--标签管理弹框-->
<div class="i-label-dailog" ng-show="visibleTagWindow">
	<div class="label_main">
		<h4>编辑名片标签</h4>
		<div class="label-s-input">
			<div class="qu-search">
				<input class="q-input" ng-model="paramTagKeyword" type="text" placeholder="请输入标签名(搜素结果包含选中标签)" autocomplete='off'/>
				<em class=q-search-icon><img ng-click="doFilterInTagWindow()" src="__PUBLIC__/images/q-search.png" alt="" /></em>
			</div>
		</div>
		<div class="ilabel-list">
			<ul class="la-list">
                <li ng-repeat="v in dataTagsCopy" ng-hide="dataTagsCopy[$index]['hidden']">
					<label class="input-th" for=""><input ng-model="dataTagsCopy[$index]['checked']" type="checkbox" autocomplete='off'/><em></em></label>
					<span title="{{v.tags}}">{{v.tags}}</span>
				</li>
			</ul>
		</div>
		<div class="i-label-btn">
			<div class="i-btn-left i-l-btn">
				<label class="lab-in" for=""><input ng-model="visibleSelectedTagOnly" type="checkbox" autocomplete='off' ng-change="doOnlyInTagWindow()"/><i></i><em>只看已选</em></label>
				<if condition="($Think.session.Company.roleid eq 1) OR ($Think.session.Company.roleid eq 2)">
				<button type="button" href="{:U('Company/Label/index')}">公司标签管理</button>
				</if>
			</div>
			<div class="i-btn-right i-l-btn">
				<button type="button" ng-click="doHideTagWindow()">取消</button>
				<button class="i-l-di" type="button" ng-click="submitTagWindow()">确定</button>
			</div>
		</div>
	</div>
</div>
<!--遮罩-->
<div class="bg-op-dialog" ng-show="visibleInfoWindow || visibleEditWindow"></div>
<!--预览图片弹框-->
<div class="look-card-dialog" ng-show="visibleCardEnlarge">
	<div class="l-card">
		<span class="hand img-colose" ng-click="visibleCardEnlarge=false"></span>
		<img src="/images/canvasbg.png" bgsrc="/images/canvasbg.png" alt="" />
	</div>
</div>
<link href="__PUBLIC__/js/jsExtend/datetimepicker/datetimepicker.css" rel="stylesheet" text="text/css">
<script src="__PUBLIC__/js/jsExtend/datetimepicker/datetimepicker.js"></script>
<script>
var URL_CARDS="{:U('Company/Index/cards')}";
var URL_TAGS="{:U('Company/Index/tags')}";
var URL_EMPLOYEES="{:U('Company/Index/getEmployees')}";
var URL_CARD_COUNT="{:U('Company/Index/cardCount')}";
var URL_ADD_DEL="{:U('Company/Index/delCard')}";
var URL_ADD_TAG="{:U('Company/Index/addTag')}";
var URL_CARD_AUTH="{:U('Company/Index/cardAuth')}";
var URL_CARD_SAVE="{:U('Company/Index/cardSave')}";
var URL_CARD_DEL_AUTH="{:U('Company/Index/delCardAuth')}";
var URL_CARD_TRASH="{:U('Company/recovers/index')}";

var ISOPEN="{$isopen}";//全部共享
var MAXTAGNUM="{$maxtagnum}"//最大标签数量
var ROLE="{$Think.session.Company.roleid}";//角色
var ACCOUNT="{$Think.session.Company.clientid}";//当前用户

$(function(){
	//名片回收站
	$('.card-remove').on('click', function(){
		location.href=URL_CARD_TRASH;
	});

	//添加标签-确定
	$('.i-label-dailog .i-btn-left button').on('click', function(){
		location.href=$(this).attr('href');
	});
});
</script>
