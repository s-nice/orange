//名片列表相关
function mainController($scope, $http, $filter){
	var VCARDKEYS=['FN','ORG','DEPAR','TITLE','CELL','TEL','ADR','EMAIL','URL'];
	var CKEY_CARDSTYLE='CKEY_CARDSTYLE';
	
	var $EDITDIALOG      = $('.edit-card-dialog');//添加/编辑名片窗口
	var $CARDDIALOG      = $('.look-card-dialog');//名片图片查看窗口
	var $TAGSEARCHDIALOG = $('.if-table');        //标签搜索下拉
	
	var CANVAS   = document.getElementById("cardEditor");//canvas元素
	var CANVASBG = new Image();                          //canvas背景
	CANVASBG.src = $CARDDIALOG.find('img').attr('bgsrc');//名片图片查看窗口初始化
	
	$scope.dataCards;        //名片列表-数据
	$scope.paramCardType = 0;//名片列表-当前选中页签
	$scope.paramCardSelectAll=false;//名片列表-全选
	$scope.visibleCardsDisplay=false;//名片列表-样式显示
	$scope.paramCardStyle = $.cookie(CKEY_CARDSTYLE)-'' || 0;//名片列表-样式
	$scope.loadingCards = false;//名片列表-加载中
	
	$scope.dataAccounts;               //高级搜索-创建人数据
	$scope.paramSearchDetail = {};     //高级搜索-条件
	$scope.visibleSearchDetail = false;//高级搜索-显示面板
	$scope.visibleAccount = false;     //高级搜索-创建人下拉列表
	
	$scope.dataTags;                //标签搜索-数据
	$scope.paramSearchByTag = {};   //标签搜索-条件
	$scope.visibleSearchTag = false;//标签搜索-下拉显示
	
	$scope.dataSearchedCount = 0;//搜索结果数量
	$scope.dataSelfcount = 0;    //我创建的名片数量
	$scope.dataBindcount = 0;    //共享给我的名片数量
	
	$scope.paramNowPage   = 1; //当前页码
	$scope.paramTotalPage = 1; //总页码
	$scope.lastParams     = {};//最后查询的参数
	$scope.lastIsReset;        //最后查询的是否重置查询
	
	$scope.paramTagKeyword        ='';    //标签窗口-关键字
	$scope.dataTagsCopy           =[];    //标签窗口-数据
	$scope.visibleTagWindow       = false;//标签窗口-显示
	$scope.visibleSelectedTagOnly = false;//标签窗口-只看已选
	
	$scope.dataEmpDept;               //名片共享-员工部门数据
	$scope.visibleShareWindow = false;//名片共享-共享窗口
	$scope.visibleFirstTag = true;    //添加共享窗口-员工面板显示
	$scope.paramEmpKeyword = '';      //名片共享-员工关键字
	$scope.paramDeptKeyword = '';     //名片共享-部门关键字
	$scope.visibleSelectedShareOnly = false;//标签窗口-只看已选
	$scope.loadingShare=false; //标签窗口-加载中
	
	$scope.dataCard;                 //名片详情-数据
	$scope.dataCardInfo;             //名片详情-vcard数据（展示用）
	$scope.visibleInfoWindow = false;//名片详情-窗口
	$scope.paramCardTurnInInfoWindow=false;//名片详情-翻页显示
	$scope.loadingInfo = false;//名片详情-加载中
	
	$scope.dataFront = {};           //名片操作-正面数据
	$scope.dataBack  = {};           //名片操作-反面数据
	$scope.visibleEditWindow = false;//名片操作-窗口
	$scope.paramCardInfoTag = 0;     //名片操作-当前页签
	$scope.paramCardTurnInEditWindow=false;//名片操作-翻页显示
	$scope.visibleFrontInEditWindow=true;//名片操作-显示正面
	$scope.paramImgSrcInEditWindow='';//名片操作-图片src
	$scope.paramStrEditWindow=['添加名片','修改名片'];//名片操作-标题
	$scope.paramStrIndex=0;//名片操作-标题索引
	
	$scope.visibleCardEnlarge = false;//名片放大
	
	//点击页面，取消一些下拉菜单
	$scope.doHideSome = function(){
		$scope.visibleSearchTag = false;
		$scope.visibleCardsDisplay = false;
		$scope.visibleAccount = false;
	}
	
	//名片搜索-查询
	$scope.doSearchCards = function(keyword){
		$scope.paramNowPage = 1;
		_reloadCards({keyword:keyword}, !keyword);
	}
	
	//高级搜索-查询
	$scope.doSearchDetail = function(){
		$scope.paramNowPage = 1;
		$scope.paramSearchDetail.searchType=1;
		$scope.paramSearchDetail.stime=$('#js_begintime').val();
		$scope.paramSearchDetail.etime=$('#js_endtime').val();
		_reloadCards($scope.paramSearchDetail);
	}
	
	//高级搜索-创建人数据
	$http({method:'POST',url:URL_EMPLOYEES}).success(function(data) {
		$scope.dataAccounts = data;
	});
	
	//高级搜索-选择创建人
	$scope.doSelectAccount = function(id,name){
		$scope.paramSearchDetail.eid=id;
		$scope.paramSearchDetail.ename=name;
		$scope.visibleAccount = false;
		$scope.visibleSearchDetail = true;
	}
	
	//高级搜索-交换时间
	$.dataTimeLoad.init({minDate:{start:false,end:false},maxDate:{start:false,end:false}});
	
	//标签搜索-查询
	$scope.doSearchByTag = function(id,name){
		$scope.paramNowPage = 1;
		$scope.paramSearchByTag.tags=id;
		$scope.paramSearchByTag.tagname=name;
		$scope.paramSearchByTag.searchType=2;
		_reloadCards($scope.paramSearchByTag, !$scope.paramSearchByTag.tags);
		$TAGSEARCHDIALOG.find('span:first').html(name);
		$scope.visibleSearchTag	 = false;
	}
	
	//标签搜索-获取数据
	$http({method:'POST',url:URL_TAGS}).success(function(data) {
		$scope.dataTags = data;
		_setValueInData($scope.dataTags, {hidden:false,checked:false});
	});
	
	//名片列表-切换标签
	$scope.doSearchByType=function(type){
		$scope.paramCardType = type;
		$scope.paramNowPage = 1;
		_reloadCards({type:type==0?'':type}, true);
	}
	
	//名片列表-页码输入控制
	$scope.doCheckPage = function(p){
		$scope.paramInputP=parseInt($scope.paramInputP);
		if($scope.paramInputP>$scope.paramTotalPage){
			$scope.paramInputP=$scope.paramTotalPage;
		}else if($scope.paramInputP<1){
			$scope.paramInputP=1;
		}else if(isNaN($scope.paramInputP)){
			$scope.paramInputP=1;
		}
	}
	
	//名片列表-翻页
	$scope.doTurnPage = function(p){
		if ($scope.loadingCards) return;
		$(document).scrollTop(0);
		$scope.paramNowPage=p;
		_reloadCards();
	}
	
	//名片列表-全选
	$scope.doSelectCardAll = function(){
		_setValueInData($scope.dataCards, {checked:$scope.paramCardSelectAll});
	}
	
	//名片列表-切换样式
	$scope.doChangeCardsStyle = function(num,$event){
		$event.stopPropagation();
		$scope.paramCardStyle = num;
		//$cookieStore.put("cardstyle", num);
		$.cookie(CKEY_CARDSTYLE, num);
	}
	
	//名片列表-删除
	$scope.doDelCard = function(id){
		var ids=[];
		if (id){
			ids.push(id);
		} else {
			ids=_getSpecialData($scope.dataCards,{checked:true},'vcardid').vals;
		}
		
		$.dialog.confirm({content:"你确定要删除吗",callback:function(){
			var params={cards:ids.join(',')};
			$.post(URL_ADD_DEL,params,function(data){
				$.dialog.alert({content:data.msg});
				if (data.status==0){
					$scope.hideInfoWindow();
					_reloadCards();
				}
			},'json');
		}});
	}
	
	//标签窗口-显示
	$scope.doShowTagWindow = function(isScopeCard){
		var list = [$scope.dataCard];
		if (!isScopeCard){
			list=_getSpecialData($scope.dataCards,{checked:true},'vcardid').list;
		}
		
		if (list.length==0){
			$.dialog.alert({content:'请选择名片'});
			return;
		}
		if (_auth('13', list)) return;
		var _tags=angular.copy($scope.dataTags);
		if (list.length==1){
			_setValueToDataByRref(_tags, list[0].remark, 'id', 'id', 'checked', true);
		}
		
		$scope.dataTagsCopy=$filter('orderBy')(_tags, 'checked');
		$scope.doMaskConf();
		$scope.visibleTagWindow = true;
	}
	
	//标签窗口-隐藏
	$scope.doHideTagWindow = function(){
		$scope.visibleTagWindow=false;
		$scope.visibleSelectedTagOnly=false;
		$scope.doHideMask();
	}
	
	//标签窗口-标签过滤
	$scope.doFilterInTagWindow = function(){
		$scope.visibleSelectedTagOnly = false;
		_setValueInData($scope.dataTagsCopy, {hidden:false});
		for(var i=0;i<$scope.dataTagsCopy.length;i++){
			var tmp=$scope.dataTagsCopy[i];
			if ($scope.paramTagKeyword==''){
				continue;
			}
			if (!tmp.checked && tmp.tags.indexOf($scope.paramTagKeyword)===-1){
				tmp['hidden']=true;
			}
		}
	}
	
	//标签窗口-只看已选
	$scope.doOnlyInTagWindow = function(){
		if ($scope.visibleSelectedTagOnly){
			_setValueInData($scope.dataTagsCopy, {hidden:true}, {checked:false});
		} else {
			$scope.doFilterInTagWindow();
		}
	}
	
	//标签窗口-保存
	$scope.submitTagWindow = function(){
		var tags=_getSpecialData($scope.dataTagsCopy,{checked:true},'id');
		if (tags.vals.length>MAXTAGNUM){
			$.dialog.alert({content:'标签最多添加6个'});
			return;
		}
		
		var ids=_getSpecialData($scope.dataCards,{checked:true},'vcardid').vals
		ids.length==0 && (ids=[$scope.dataCard.vcardid]);
		
		$.post(URL_ADD_TAG,{cards:ids.join(','),tags:tags.vals.join(',')},function(data){
			$.dialog.alert({content:data.msg});
			if (data.status==0){
				_reloadCards();
				if ($scope.dataCard){
					$scope.dataCard.remark=tags.list;
				}
				$scope.doHideTagWindow();
				$scope.$apply();
			}
		},'json');
	}
	
	//名片共享-窗口显示
	$scope.doShowShareWindow = function(type,isFromInfo){
		var id;
		if (type=='emp'){
			id=$scope.dataCard.vcardid;
			$scope.visibleFirstTag=true;
		} else if (type=='dept'){
			id=$scope.dataCard.vcardid;
			$scope.visibleFirstTag=false;
		} else {
			var obj=_getSpecialData($scope.dataCards,{checked:true},'vcardid');
			if (obj.vals.length==0){
				$.dialog.alert({content:'请选择名片'});
				return;
			}
			if (obj.vals.length==1){
				id=obj.vals[0];
			} else {
				$scope.dataEmpDept && _setValueInData($scope.dataEmpDept.emps, {checked:false,hidden:false,dft:false});
				$scope.dataEmpDept && _setValueInData($scope.dataEmpDept.depts, {checked:false,hidden:false,dft:false});
			}
			if (_auth('213', obj.list)) return;
		}
		
		$scope.doLoadShareInfo(id,isFromInfo);
		$scope.doMaskConf();
		$scope.visibleShareWindow = true;
	}
	
	//名片共享-数据更新
	$scope.doLoadShareInfo = function(id,isFromInfo){
		if (isFromInfo || $scope.loadingShare) return;
		$scope.loadingShare = true;
		$scope.loadingInfo = true;
		
		if (!$scope.dataEmpDept){
			$.post(URL_LOAD_EMPDEPT,{},function(data){
				_setValueInData(data.emps, {hidden:false,checked:false});
				_setValueInData(data.depts, {hidden:false,checked:false});
				$scope.dataEmpDept=data;
				$scope.loadingShare = false;
				$scope.loadingInfo = false;
				$scope.$apply();
			},'json');
		}
		
		if (!id){
			if ($scope.dataEmpDept){
				$scope.loadingShare = false;
				$scope.loadingInfo = false;
				$scope.dataEmpDept.emps = $filter('orderBy')($scope.dataEmpDept.emps, 'name');
				$scope.dataEmpDept.depts = $filter('orderBy')($scope.dataEmpDept.depts, 'name');
			}
			return;
		}
		
		$.post(URL_LOAD_SHARE,{card:id},function(data){
			var it=setInterval(function(){
				if (!$scope.dataEmpDept){
					return;
				}
				clearInterval(it);
				
				_setValueInData($scope.dataEmpDept.emps, {checked:false,hidden:false,dft:false});
				_setValueInData($scope.dataEmpDept.depts, {checked:false,hidden:false,dft:false});
				$scope.dataEmpDept.emps = $filter('orderBy')($scope.dataEmpDept.emps, 'name');
				$scope.dataEmpDept.depts = $filter('orderBy')($scope.dataEmpDept.depts, 'name');
				
				_setValueToDataByRref($scope.dataEmpDept.emps, data.emps, 'id', 'moduleid', 'checked', true);
				_setValueToDataByRref($scope.dataEmpDept.depts, data.depts, 'id', 'moduleid', 'checked', true);
				_setValueInData($scope.dataEmpDept.emps, {dft:true}, {checked:true});
				_setValueInData($scope.dataEmpDept.depts, {dft:true},{checked:true});
				
				$scope.dataEmpDept.emps=$filter('orderBy')($scope.dataEmpDept.emps, 'checked');
				$scope.dataEmpDept.depts=$filter('orderBy')($scope.dataEmpDept.depts, 'checked');
				
				$scope.loadingShare = false;
				$scope.loadingInfo = false;
				$scope.$apply();
			},500);
		},'json');
	}
	
	//名片共享-关闭窗口
	$scope.hideShareWindow = function(){
		$scope.visibleShareWindow = false;
		$scope.visibleSelectedShareOnly = false;
		$scope.doHideMask();
	}
	
	//名片共享-关键字过滤
	$scope.doFilterInShareWindow = function(keyword,type){
		$scope.visibleSelectedShareOnly=false;
		_setValueInData($scope.dataEmpDept.emps, {hidden:false});
		_setValueInData($scope.dataEmpDept.depts, {hidden:false});
		for(var i=0;i<$scope.dataEmpDept[type].length;i++){
			var tmp=$scope.dataEmpDept[type][i];
			if (keyword==''){
				continue;
			}
			if (!tmp.checked && tmp.name.indexOf(keyword)===-1){
				tmp['hidden']=true;
			}
		}
	}
	
	//名片共享-只看已选
	$scope.doOnlyInShareWindow = function(bool){
		if ($scope.visibleSelectedShareOnly){
			_setValueInData($scope.dataEmpDept.emps, {hidden:true}, {checked:false});
			_setValueInData($scope.dataEmpDept.depts, {hidden:true}, {checked:false});
		} else {
			$scope.doFilterInShareWindow($scope.paramEmpKeyword, 'emps');
			$scope.doFilterInShareWindow($scope.paramDeptKeyword, 'depts');
		}
	}
	
	//名片共享-保存
	$scope.submitShareWindow = function(){
		var ids={};
		if ($scope.visibleInfoWindow){
			ids.vals=[$scope.dataCard.vcardid];
			ids.list=[$scope.dataCard];
		} else {
			ids=_getSpecialData($scope.dataCards,{checked:true},'vcardid');
		}
		
		var emps=_getSpecialData($scope.dataEmpDept.emps,{checked:true},'id');
		var depts=_getSpecialData($scope.dataEmpDept.depts,{checked:true},'id');
		
		//判断是否共享给了创建人
		if (emps.list.length==1){
			var selfcount=0;
			var eid=emps.list[0].id;
			for(var i=0;i<ids.list.length;i++){
				if (ids.list[i].accountid==emps.list[0].id){
					selfcount++;					
				}
			}
			if (selfcount==ids.list.length){
				$.dialog.alert({content:'分享人是名片创建者'});
				return;
			}
		}
		
		$.post(URL_CARD_AUTH,{cards:ids.vals.join(','),emps:emps.vals.join(','),depts:depts.vals.join(',')},function(data){
			$.dialog.alert({content:data.msg});
			if (data.status==0){
				$scope.hideShareWindow();
				$scope.$apply();
			}
		},'json');
	}
	
	//名片详情-窗口显示
	$scope.showInfoWindow = function(index){
		$scope.dataCard = $scope.dataCards[index];
		$scope.dataCardInfo = $scope.dataCard.front;
		$scope.doMaskConf();
		
		if ($scope.dataCard.picpathb){
			$scope.paramCardTurnInInfoWindow = 1;
		}
		$scope.visibleInfoWindow = true;
	}
	
	//名片详情-关闭窗口
	$scope.hideInfoWindow = function(){
		$scope.visibleInfoWindow = false;
		$scope.paramCardInfoTag=0;
		$scope.paramCardTurnInInfoWindow=false;
		$scope.doHideMask();
	}
	
	//名片详情-顶部标签切换
	$scope.doSwitchTabInInfoWindow = function(tab,isFromInfo){
		if ($scope.paramCardInfoTag==tab) return;
		if (tab==1){
			if (_auth('213', [$scope.dataCard])) return;
			$scope.doLoadShareInfo($scope.dataCard.vcardid);
		}
		
		$scope.paramCardInfoTag=tab;
	}
	
	//名片详情-正反面切换
	$scope.doSwitchCardInInfoWindow = function(val){
		$scope.paramCardTurnInInfoWindow=val;
		if (val==1){
			$scope.dataCardInfo=$scope.dataCard.front;
		} else {
			$scope.dataCardInfo=$scope.dataCard.back;
		}
	}
	
	//名片详情-删除标签
	$scope.doDelTagInInfoWindow = function(id){
		if (_auth('13', [$scope.dataCard])) return;
		$.dialog.confirm({content:"你确定要删除吗",callback:function(){
			var tags=$filter('filter')($scope.dataCard.remark, {id: '!'+id});
			tags=_getSpecialData(tags,false,'id');
			
    		$.post(URL_ADD_TAG,{cards:$scope.dataCard.vcardid,tags:tags.vals.join(',')},function(data){
    			$.dialog.alert({content:data.msg});
    			if (data.status==0){
    				$scope.dataCard.remark=tags.list;
    				$scope.$apply();
    			}
    		},'json');
		}});
	}

	//名片详情-删除分享
	$scope.doDelShareInInfoWindow = function(id, type){
		$.dialog.confirm({content:"你确定要删除吗",callback:function(){
			$.post(URL_CARD_DEL_AUTH,{card:$scope.dataCard.vcardid,type:type,module:id},function(data){
				$.dialog.alert({content:data.msg1});
				if (data.status==0){
					if (type==1){
						_setValueInData($scope.dataEmpDept.emps, {checked:false}, {id:id});
					} else {
						_setValueInData($scope.dataEmpDept.depts, {checked:false}, {id:id});
					}
					$scope.$apply();
				}
			},'json');
		}});
	}
	
	//名片操作-显示窗口
	$scope.doShowEditWindow = function(param){
		if (param===true){//列表点击【编辑】按钮
			$scope.paramStrIndex=1;
			var obj=_getSpecialData($scope.dataCards,{checked:true},'vcardid');
			if (obj.list.length!=1){
				$.dialog.alert({content:'请选择一张名片'});
				return;
			}
			if (_auth('13', obj.list)) return;
			$scope.dataCard  = obj.list[0];
			$scope.dataFront = angular.copy(obj.list[0].front);
			$scope.dataBack  = angular.copy(obj.list[0].back);
		} else if(param===undefined) {//添加名片
			$scope.paramStrIndex=0;
			$scope.dataCard  = null;
			$scope.dataFront = {};
			$scope.dataBack  = {};
		} else {//修改名片
			$scope.paramStrIndex=1;
			$scope.dataFront = angular.copy($scope.dataCard.front);
			$scope.dataBack  = angular.copy($scope.dataCard.back);
			
			if (_auth('13', [$scope.dataCard])) return;
		}
		
		_addEmptyToVCardData($scope.dataFront);
		_addEmptyToVCardData($scope.dataBack);
		
		$scope.doMaskConf();
		if ($scope.dataCard){
			$scope.paramImgSrcInEditWindow = $scope.dataCard.picpatha;
			if ($scope.dataCard.picpathb){
				$scope.doSwitchCardInEditWindow($scope.paramCardTurnInInfoWindow);
			}
		}
		
		$scope.visibleEditWindow = true;
		_drawCard();
	}
	
	//名片操作-隐藏窗口
	$scope.doHideEditWindow = function(){
		$scope.visibleEditWindow = false;
		$scope.paramCardTurnInEditWindow = false;
		$scope.visibleFrontInEditWindow = true;
		$scope.paramImgSrcInEditWindow='';
		$scope.dataFront={};
		$scope.dataBack={};
		$scope.doHideMask();
	}
	
	//名片操作-正反面切换
	$scope.doSwitchCardInEditWindow = function(val){
		$scope.paramCardTurnInEditWindow=val;
		if (val==1){
			$scope.paramImgSrcInEditWindow=$scope.dataCard.picpatha;
			$scope.visibleFrontInEditWindow = true;
		} else {
			$scope.paramImgSrcInEditWindow=$scope.dataCard.picpathb;
			$scope.visibleFrontInEditWindow = false;
		}
	}
	
	//名片操作-添加子信息
	$scope.doAddItemInEditWindow = function(key,side){
		$scope[side][key].push('');
	}
	
	//名片操作-删除子信息
	$scope.doRemoveItemInEditWindow = function(key,side,index){
		$.dialog.confirm({content:"你确定要删除吗",callback:function(){
			$scope[side][key].splice(index,1);
			$scope.$apply();
		}});
	}
	
	//名片操作-更改数据
	$scope.doChangeValueInEditWindow = function($event, side, index){
		_validate($($event.target));
		var value=$event.target.value;
		var name=$event.target.name;
		$scope[side][name][index] = value;
		_drawCard();
	}
	
	//名片操作-保存
	$scope.submitEditWindow = function(){
		var _front=_removeEmptyToVCardData(angular.copy($scope.dataFront));
		var _back=_removeEmptyToVCardData(angular.copy($scope.dataBack));
		var params={
			front:_front,
			back:_back,
			cardtype:'',
			cardid:'',
			image:''
		};
		
		if (_validate()) return;
		if ($scope.dataCard){//编辑
			params.cardid=$scope.dataCard.vcardid;
		}
		if (!$scope.dataCard || $scope.dataCard.cardtype=='custom'){//添加或自定义名片操作
			params.image=CANVAS.toDataURL("image/png");
			params.cardtype='custom';
		}
		
		$.post(URL_CARD_SAVE,params,function(data){
			$.dialog.alert({content:data.msg1});
			if (data.status==0){
				$scope.doHideEditWindow();
				$EDITDIALOG.scrollTop(0);
				if ($scope.dataCard){
					$scope.dataCard.front = _front;
					$scope.dataCard.back = _back;
					$scope.dataCardInfo = !$scope.paramCardTurnInInfoWindow?$scope.dataCard.front:$scope.dataCard.back;
					if ($scope.dataCard.cardtype=='custom'){
						$scope.dataCard.picpatha = CANVAS.toDataURL("image/png");
					} 
					$scope.$apply();
				} else {
					_reloadCards();
				}
				$scope.$apply();
			}
		},'json');
	}

	//名片放大查看
	$scope.doCardEnlarge = function($event){
		var src=$event.target.src;
		$CARDDIALOG.find('img').attr('src', src);
		$scope.visibleCardEnlarge = true;
	}
	
	//编辑名片-画名片
	function _drawCard(){
		if ($scope.dataCard && $scope.dataCard.cardtype!='custom'){
			return;
		}
		var context=CANVAS.getContext("2d");
		context.clearRect(0,0,CANVAS.width,CANVAS.height);
		context.drawImage(CANVASBG,0,0,1200,720);
		context.textBaseline = 'middle';
		context.fillStyle = '#333';
		
		for (var key in $scope.dataFront){
			if (!$scope.dataFront[key] || $scope.dataFront[key].length==0){
				continue;
			}
			_drawEach(key, $scope.dataFront[key][0], context);
		}
		
		$scope.paramImgSrcInEditWindow=CANVAS.toDataURL("image/png");
	}
	
	function _drawEach(name, txt, context){
		var x,y;
		context.textAlign = 'left';
		switch(name){
		case 'FN':
			context.textAlign = 'center';
			context.font = _getFont(16);
			x=212;
			y=278;
			_canvasTextAutoLine(txt, CANVAS, x, y, 76, 400);
			break;
		case 'DEPAR':
			context.textAlign = 'center';
			context.font = _getFont(8);
			x=212;
			y=380;
			_canvasTextAutoLine(txt, CANVAS, x, y, 48, 400);
			break;
		case 'TITLE':
			context.textAlign = 'center';
			context.font = _getFont(8);
			x=212;
			y=420;
			_canvasTextAutoLine(txt, CANVAS, x, y, 48, 400);
			break;
		case 'ORG':
			context.font = _getFont(10);
			x=562;
			y=168;
			_canvasTextAutoLine(txt, CANVAS, x, y, 48);
			break;
		case 'CELL':
			context.font = _getFont(8);
			txt='手机：'+txt;
			x=562;
			y=268;
			_canvasTextAutoLine(txt, CANVAS, x, y, 48);
			break;
		case 'TEL':
			context.font = _getFont(8);
			txt='座机：'+txt;
			x=562;
			y=(268+54*1);
			_canvasTextAutoLine(txt, CANVAS, x, y, 48);
			break;
		case 'EMAIL':
			context.font = _getFont(8);
			txt='邮箱：'+txt;
			x=562;
			y=(268+54*2);
			_canvasTextAutoLine(txt, CANVAS, x, y, 48);
			break;
		case 'URL':
			context.font = _getFont(8);
			txt='网址：'+txt;
			x=562;
			y=(268+54*3);
			_canvasTextAutoLine(txt, CANVAS, x, y, 48);
			break;
		case 'ADR':
			context.font = _getFont(8);
			txt='工作地址：'+txt;
			x=562;
			y=(268+54*4);
			_canvasTextAutoLine(txt, CANVAS, x, y, 48);
			break;
		}
	}
	
	/*
	str:要绘制的字符串
	canvas:canvas对象
	initX:绘制字符串起始x坐标
	initY:绘制字符串起始y坐标
	lineHeight:字行高
	maxWidth:最大宽度
	*/
	function _canvasTextAutoLine(str,canvas,initX,initY,lineHeight,maxWidth){
	    var ctx=canvas.getContext("2d"); 
	    var lineWidth=0;
	    var canvasWidth=canvas.width; 
	    var lastSubStrIndex=0; 
	    var arr=[];
	    for(var i=0;i<str.length;i++){
	    	var _width=ctx.measureText(str[i]).width;
	        lineWidth+=_width;
	        arr.push(lineWidth);
	        if((maxWidth && lineWidth > maxWidth) || lineWidth>canvasWidth-initX){//减去initX,防止边界出现的问题
	            ctx.fillText(str.substring(lastSubStrIndex,i),initX,initY);
	            initY+=lineHeight;
	            lineWidth=_width;
	            lastSubStrIndex=i;
	        } 
	        if(i==str.length-1){
	            ctx.fillText(str.substring(lastSubStrIndex,i+1),initX,initY);
	        }
	    }
	    //maxWidth && console.log(arr.join(','));
	  }
	
	function _getFont(size, face, weight, style){
		var fontSize='32px';
		size && (fontSize=(size*4)+'px');
		
		var fontFace='Microsoft-Yahei';
		face && (fontFace=face);
		
		var fontWeight='normal';
		weight && (fontWeight=weight);
		
		var fontStyle='normal';
		style && (fontStyle=style);
		return fontWeight + " " + fontStyle + " " + fontSize + ' ' + fontFace;
	}
	
	//编辑名片-名片表单验证
	function _validate($obj){
		$obj = $obj || $EDITDIALOG.find('.edit-form-item input'); 
		var flag=false;
		var isCheckMax=true;
		var showWrongSide;
		if ($scope.dataCard && $scope.dataCard.cardtype=='scan'){
			isCheckMax=false;
		}
		$obj.each(function(){
			if (_validateDetail($(this),isCheckMax)){
				flag=true;
				if (!showWrongSide){
					$scope.visibleFrontInEditWindow=$(this).parents('.edit-form').hasClass('front');
				} 
			}
		});
		return flag;
	}
	
	//编辑名片-名片表单详细验证
	function _validateDetail($obj,isCheckMax){
		_validateClear($obj);
		var v=$.trim($obj.val());
		var required=$obj.attr('required_');
		var max=$obj.attr('max');
		var type=$obj.attr('type');
		
		if (required==='' && v==''){
			return _validateFail($obj, '不能为空');
		}
		
		if (isCheckMax && max && v.length>parseInt(max)){
			return _validateFail($obj, '长度不能大于'+max+'个字符');
		}
		
		switch(type){
			case 'phone_':
				if (v!='' && !v.isPhone()){
					//return _validateFail($obj, '请输入座机格式');
				}
				break;
			case 'mobile_':
				if (v!='' && !v.isMobile()){
					return _validateFail($obj, '请输入手机格式');
				}
				break;
			case 'email_':
				if (v!='' && !v.isEmail()){
					return _validateFail($obj, '请输入邮箱格式');
				}
				break;
		}
		return false;
	}
	
	//编辑名片-名片表单验证结果清空
	function _validateClear($obj){
		$obj.removeAttr('fail').removeClass('dis-bg').siblings('p').hide();
	}
	
	//编辑名片-名片表单验证失败
	function _validateFail($obj, msg){
		$obj.attr('fail',1).addClass('dis-bg').siblings('p').show().html(msg);
		return true;
	}
	
	$('.if-more, .more-menu-m, .if-label-menu, .qu-dialog, .i-label-dailog, .info-dialog, .bg-op-dialog:last, .edit-card-dialog, .look-card-dialog').css('display','block');
	

	//名片操作-添加VCARD空数据
	function _addEmptyToVCardData(data){
		for (var i=0;i<VCARDKEYS.length;i++){
			key=VCARDKEYS[i];
			if (!data[key] || data[key].length==0){
				data[key]=[''];
			}
		}
	}
	
	//名片操作-删除VCARD空数据
	function _removeEmptyToVCardData(data){
		for (var i=0;i<VCARDKEYS.length;i++){
			key=VCARDKEYS[i];
			if (!data[key]){
				continue;
			}
			for (var j=0;j<data[key].length;j++){
				if (data[key][j]==''){
					data[key].splice(j,1);
					j++;
				}
			}
		}
		return data;
	}
	
	//隐藏遮罩
	$scope.doHideMask = function (){
		if (!$scope.visibleInfoWindow && !$scope.visibleEditWindow && !$scope.visibleTagWindow && !$scope.visibleShareWindow){
			$('body').removeAttr('style');
		}
	}
	
	//显示遮罩遮罩
	$scope.doMaskConf = function (){
		$('body').css('overflow','hidden');
		var info=navigator.userAgent.toLowerCase();
		if (info.indexOf('windows')>=0){
			$('body').css('paddingRight','17px');
		}
	}
	
	//根据参数判断并给数组赋值
	function _setValueToDataByRref(data, reflist, refkey1, refkey2, setkey, value){
		for(var i=0;i<data.length;i++){
			for(var j=0;j<reflist.length;j++){
				if (data[i][refkey1]==reflist[j][refkey2]){
					data[i][setkey] = value;
				}
			}
		}
	}
	
	//给数组赋值
	function _setValueInData(data,param,condition){
		for(var i=0;i<data.length;i++){
			if (condition){
				var flag=false;
				for(var k in condition){
					if (condition[k] != data[i][k]){
						flag=true;
					}
				}
				if (flag){
					continue;
				}
			}
			for (var key in param){
				data[i][key]=param[key];
			}
		}
	}
	
	//判断并删除数据
	function _removeFromDataByRref(data,key,value){
		for(var i=0;i<data.length;i++){
			if (data[i][key]==value){
				data.splice(i,1);
			}
		}
	}
	
	//获取数据
	function _getSpecialData(list,condition,key){
		var _vals=[];
		var _list=[];
		for(var i=0;i<list.length;i++){
			if (condition){
				var flag=false;
				for(var k in condition){
					if (condition[k] != list[i][k]){
						flag=true;
					}
				}
				if (flag){
					continue;
				}
			}
			
			_list.push(list[i]);
			key && _vals.push(list[i][key]);
		}
		return {vals:_vals,list:_list};
	}
	
	//判断权限
	function _auth(cons,cards){
		cons+='';
		!cards && (cards=[]);
		for(var i=0;i<cons.length;i++){
			switch(cons[i]){
			case '1'://super
				if (ROLE==1) return false;
				break;
			case '2'://!allshare
				if (ISOPEN==1){
					$.dialog.alert({content:"已开启全部共享（ 所有员工都可以访问公司的所有名片）"});
					return true;
				}
				break;
			case '3'://self
				for(var j=0;j<cards.length;j++){
					if (cards[j].accountid!=ACCOUNT){
						$.dialog.alert({content:"没有权限（只能操作自己创建的名片）"});
						return true;
					}
				}
				break;
			}
		}
		
		return false;
	} 
	
	//名片列表-查询数量
	function _reloadCardsCount(){
		$http({method:'POST',url:URL_CARD_COUNT}).success(function(data) {
			$scope.dataSelfcount = data.selfcount-'';
			$scope.dataBindcount = data.bindcount-'';
		});
	}
	
	//名片加载
	function _reloadCards(params,isReset){
		if ($scope.loadingCards) return;
		$scope.loadingCards = true;
		if (!params && !isReset){
			params = $scope.lastParams;
			isReset = $scope.lastIsReset;
		}
		
		$scope.lastParams = params;
		$scope.lastIsReset = isReset;
		params.p=$scope.paramNowPage;
		_reloadCardsCount();
		$scope.paramCardSelectAll=false;
		$.post(URL_CARDS,params,function(data){
			var it=setInterval(function(){
				//处理tag数据
				if (!$scope.dataTags){
					return;
				}
				clearInterval(it);
				
				$scope.dataCards = data.list;
				var tags={};
				for (var i = 0; i < $scope.dataTags.length; i++) {
		            var tmp = $scope.dataTags[i];
		            tags[tmp['id']] = tmp;
		        }
				
				for(var i=0;i<$scope.dataCards.length;i++){
					var arr=$scope.dataCards[i].remark.split(',');
					$scope.dataCards[i].remark = [];
					for(var j=0;j<arr.length;j++){
						tags[arr[j]] && $scope.dataCards[i].remark.push(tags[arr[j]]);
					}
				}
				
				$scope.dataSearchedCount = data.numfound;
				if ($scope.dataSearchedCount==0){
					$scope.paramNowPage = 0;
				} else {
					if ($scope.paramNowPage == 0){
						$scope.paramNowPage = 1;
					}
				}
				
				$scope.paramTotalPage = data.totalpage;
				if (isReset){
					var $lis=$('.card_nav li:first').hide().siblings().show();
					if (!params.type){
						$lis.removeClass('active').eq('0').addClass('active');
					}
				} else {
					$('.card_nav li:first').addClass('active').show().siblings().hide();
				}
				$('.tnone').removeClass('tnone');
				$scope.loadingCards = false;
				$scope.$apply();
			},500);
			
			
		},'json');
	}
	_reloadCards({},true);
}