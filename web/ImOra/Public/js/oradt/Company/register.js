/**
 * 企业账号注册JS
 * */
/*上传插件*/
function ajaxFileUpload(id, ImgWrap) {
    $.ajaxFileUpload({
        url: gUploadUrl, //用于文件上传的服务器端请求地址
        secureuri: false, //是否需要安全协议，一般设置为false
        fileElementId: id, //文件上传域的ID
        dataType: 'json', //返回值类型 一般设置为json
        data: {name: id}, //另外提交的参数标记用
        success: function (data, status) {  //服务器成功响应处理函数
            if (data.status == 0) {
                ImgWrap.find('.js_start_upload').hide();
                //ImgWrap.find('.js_remove_img').show();
                ImgWrap.find('.js_uploadImg_single_img').attr('src',data.path).show();
                ImgWrap.find('[type=hidden]').val(data.path);//隐藏域图片
            } else {
            	 $.global_msg.init({msg : data.msg ,btns : true,icon: 2});
            }
        },
        error: function (data, status, e){//服务器响应失败处理函数
            console && console(data, status, e);
        }
    });
}
//删除数组中的元素
Array.prototype.remove = function(val) {
	var index = this.indexOf(val);
	if (index > -1) {
		this.splice(index, 1);
	}
};
;(function ($) {
    $.extend({
    	/**
    	 * 在页面中生成隐藏的iframe
    	 * @param frameName 隐藏的iframe id和name的名称，可不传递，默认为hidden_frame
    	 */
    	genFrame:function(frameName){
    		var frameName = frameName || 'hidden_frame';
    		if(typeof($('#'+frameName).attr('src')) == 'undefined'){
    			var iframeHtml ='<iframe id="'+frameName+'" name="'+frameName+'"  style="display:none;" id="hidden_frame" width="100%" height="100%"></iframe>';
    			$('body').append(iframeHtml);
    		}
    		return frameName;
    	},
    	/*行业选择弹出层插件 start*/
    	industryPlug: {
    		maxLen: 6,
    		chooseData:[],
    		openPopSelector:'', //打开行业弹出层的选择器
    		setValSelector:'',  //点击弹出层中确定按钮后接收值的选择器
    		init: function(openPopSelector, setValSelector){
    			if($(openPopSelector).length == 0 || $(setValSelector).length==0){
    				return ;//console && console.log(openPopSelector,setValSelector,$(openPopSelector),$(setValSelector))
    			}
    			this.openPopSelector = openPopSelector;//打开行业弹出层的选择器
    			this.setValSelector = setValSelector;//点击弹出层中确定按钮后接收值的选择器
    			this.bindEvtInd();
    			this.initInputCacheData();
    		},
    		initInputCacheData: function(){
    			var str = $.trim($(this.setValSelector).val());
    			if(str){
        			var data = str.split(',');
        			this.setVal(data);
    			}
    		},
    		bindEvtInd: function(){
    			var that = this;
    			//打开行业选择弹出层
    			$(that.openPopSelector).click(function(){
    				 that.setIndActive();
    				 $('.js_industry_pop,.js_industry_pop_mask').show();
    				 return false;
    			});
                //点击行业子对象
                $('.js_industry_child').click(function(){
                	var obj = $(this);
                	var id = obj.attr('data-cid');
                	if(obj.hasClass('active')){
                		obj.removeClass('active');
                		that.chooseData.remove(id); //删除数组中的元素                		
                	}else{
                		if(that.chooseData.length>= that.maxLen){
                			$.global_msg.init({msg : '最多可选择'+that.maxLen+'项',btns : true,icon: 2});
                		}else{
                    		obj.addClass('active');
                    		that.chooseData.push(id);
                		}
                	}
                });
                //行业弹出层-->取消按钮
                $('.js_industry_pop').on('click','.js_industry_cancel',function(){
            			$('.js_industry_pop,.js_industry_pop_mask').hide();
                });
                //行业弹出层-->确定按钮
                $('.js_industry_pop').on('click','.js_industry_ok',function(){
                	if(that.chooseData.length ==  0){
            			$.global_msg.init({msg : '请选择行业',btns : true,icon: 2});
            		}else{
            			 $(that.setValSelector).val(that.chooseData.join(','));
            			 $('.js_industry_pop,.js_industry_pop_mask').hide();
            			 that.setVal();
            		}
                });
                //点击x删除数据
                $('.js_ind_show_area').on('click','.js_remove',function(){
                	var id = $(this).parent().attr('data-id');
                	that.chooseData.remove(id); //删除数组中的元素            
                	var hideVal =  $(that.setValSelector).val();
                	var regId = new RegExp(id+"[,]{0,1}",'g');//id的正则表达式
                		hideVal = hideVal.replace(regId,'').replace(/([,]{0,1}$)/g,"");
                	$(that.setValSelector).val(hideVal);
                	$(this).parent().remove();
                });
    		},
    		//对隐藏域中输入框进行赋值操作
    		setVal: function(data){
    			var that = this;
    			var html = '';
    			if(typeof(data) == 'undefined'){
    				data = that.chooseData;
    			}else{
    				that.chooseData = data;
    			}
    			$.each(data,function(i,id){
    				var name = $('.js_industry_child[data-cid="'+id+'"]').text();
    				html += '<p class="p_box" data-id="'+id+'"><i class="remove_w" title="'+name+'">'+name+'</i><em class="js_remove hand">x</em></p>';
    			});
    			$('.js_ind_show_area').html(html);
    		},
    		//打开弹出层时，设置选中效果
    		setIndActive: function(){
    			var that = this;
    			if($.trim($('.js_ind_show_area').text()) == ''){
    				$(that.setValSelector).val('');
    			}
    			var hideVal =  $(that.setValSelector).val();
    			var hideValArr = hideVal.split(',');
    			$('.js_industry_child').removeClass('active');
    			$.each(hideValArr,function(i,id){
    				if(!$('.js_industry_child[data-cid="'+id+'"]').hasClass('active')){
    					$('.js_industry_child[data-cid="'+id+'"]').addClass('active');
    				}
    			});
    		}
    	},
    	/*行业选择弹出层插件  end*/
    	
        register: {
            init: function () {
                this.certificationEvent();//认证事件
                this.certificationSubmit();//认证提交事件
                this.getAddressList();//获取地址省市区列表
            },
            initStepOne: function(){
                this.basicEvent();//基本信息表单点击事件
                this.basicSubmit();//基本信息下一步提交事件
        		$("#size").select2();
                //iCheck for checkbox and radio inputs
                $('#js_protocol_check').iCheck({
                  checkboxClass: 'icheckbox_minimal-blue'
                  //radioClass: 'iradio_minimal-blue'
                });
            },
            certifyInit: function(){
                this.certificationEvent();//认证事件
                this.certificationSubmit();//认证提交事件
                this.getAddressList();//获取地址省市区列表
                $("#province").select2();
                $("#city").select2();
            },
            basicEvent: function (){ //基本信息表单点击事件
                var that = this;
                var Type = {};
                Type.id = new Array();
                Type.name = new Array();

                $('.js_company_password img').on('click', function () { //密码显示明文 切换
                    var type = $('.js_company_password input').attr('type');
                    if (type == 'password') {
                        $('.js_company_password input,.js_company_password2 input').attr('type', 'text');
                    } else {
                        $('.js_company_password input,.js_company_password2 input').attr('type', 'password');
                    }
                });

                $('.js_protocol_click').on('click', function () { //服务协议弹出
                    $('#preview_window').modal('show'); //$('.js_protocol_wrap').show();
                });

               /* $('.js_protocol_off').on('click', function () { //服务协议关闭
                	$('#preview_window').modal('hide'); //$('.js_protocol_wrap').hide();
                });*/

                $("#js_protocol_check").on('click', function () { //服务协议不勾选 下一步按钮置灰
                    if (!$(this).prop('checked')) {
                        $('#js_basicSubmit').attr({'disabled': 'disabled'});
                    } else {
                        $('#js_basicSubmit').removeAttr('disabled')
                    }
                });
                $.industryPlug.init('.js_open_indus_pop','#industry');//调用行业弹出层插件
            },

            basicSubmit: function () { //基本信息下一步提交事件
                var that = this;
                $('#form1').on('submit', function (e) {
                    var name = $.trim($("input[name='name']").val()); //企业名称
                    var type = $.trim($("input[name='type']").val()); //所属行业
                    var mail = $.trim($("input[name='mail']").val()); //邮箱
                    var password = $.trim($("input[name='password']").val());
                    var password2 = $.trim($("input[name='password2']").val());
                    var size = $.trim($("input[name='size']").val()); //企业规模
                    var website = $.trim($("input[name='website']").val()); //官网URL
                    var checkArr = {}; //定义规则
                    var msg = '';//定义错误信息

                    /* val:值 required:true必填 max:最大长度 reg:正则*/
                    checkArr['name'] = {val: name, required: true, max: 255,url:gUrlExistName};
                    checkArr['type'] = {val: type, required: true};
                    checkArr['mail'] = {
                        val: mail, required: true, max: 64,
                        reg: /\w+([-+.]\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*/,
                        url: gUrlExistMail
                    };
                    checkArr['password'] = {val: password, required: true, max: 16};
                    checkArr['password2'] = {val: password2, required: true, max: 16};
                    checkArr['website'] = {
                        val: website, max: 255,
                        reg: /^(http(s)?:\/\/)?([\w-]+\.)+[\w-]+(\/[\w\-\.\/?%&=]*)?$/
                    };
                    
                    var validObj = that.checkFormPlug.valid(checkArr);
                    if(validObj){
                    	var msg = '';
                    	switch(validObj.type){
                    		case 1://验证为空
                    			msg = that.msg.key.empty + eval("that.msg.key." + validObj.key);
                    			break;
                    		case 2://验证长度
                    			 msg = eval("that.msg.key." + validObj.key) + that.msg.key.max + eval("checkArr." + validObj.key + ".max");
                    			break;
                    		case 3://规则验证
                    			msg = that.msg.key.reg + eval("that.msg.key." + validObj.key);
                    			break;
                    		case 4://ajax验证
                    			msg = validObj.key;
                    			break;
                    		default:
                    	}
                        $.global_msg.init({msg : msg,btns : true,icon: 2});
                    	return false;
                    }
                    
                    if (password != password2) { //两次密码一致
                        msg = that.msg.key.doublePassword;
                        $.global_msg.init({msg : msg,btns : true,icon: 2});
                        return false;
                    } else if (!gVerifyBool) {
                        msg = that.msg.key.VerifyBool;
                        $.global_msg.init({msg : msg,btns : true,icon: 2});
                        return false;
                    }else if(!$('#js_protocol_check').prop('checked')){
                    	$.global_msg.init({msg : '请先同意企业平台服务协议',btns : true,icon: 2});
                        return false;
                    }
                });
            },

            certificationEvent: function () { //认证步骤事件
                //上传切换,顶部按钮选中效果及上传图片切换
                $('.js_upload_type').on('click', function () {
                    $('.uploadImgWrap:gt(0)').toggle($(this).index('.js_upload_type') == 0); //控制上传图片的显示隐藏
                    $(this).addClass('active').siblings('.active').removeClass('active');
                });

                $('.js_start_upload').on('click', function () { //加号选择文件
                    var $fileInput = $(this).prev('input');
                    $fileInput.click();//触发对应的file input
                });

                $("input[type='file']").on('change', function () { //选择上传文件 值改变自动上传
                    var id = $(this).attr('id');//上传file input id
                    var ImgWrap = $(this).closest('.js_uploadImg_single'); // 对应的包裹层，显示图片
                    ajaxFileUpload(id, ImgWrap)
                });

                $('.js_remove_img').on('click', function () { //上传图片后点X删除图片事件
                    $(this).parent().find('.js_uploadImg_single_img').attr('src', '').hide();
                    $(this).hide();
                    $(this).siblings('.js_start_upload').show();
                });
                //添加iframe
                $('#form2').attr('target',function(){
                	return $.genFrame();
                });

            },

            certificationSubmit: function () { //认证提交事件
                var that=this;
                $('#form2').on('submit', function () {
                    var uploadImgType=1;//上传类型 三证未合一（默认） 三证合一
                    var imgPath=new Array();
                    if ($('.js_upload_type').eq(1).hasClass('active')) { //判断执照上传类型 三证合一
                        if( $('.js_uploadImg_single').eq(0).find('.js_uploadImg_single_img').attr('src')==''){ //三证合一 未上传图片
                        	$('.js_uploadImg_single').eq(0).addClass('check_red');
                            $.global_msg.init({msg : that.msg.key.uploadimgText,btns : true,icon: 2});
                            return false;
                        }
                        uploadImgType = 2;
                        $('#js_img_path1').val($('.js_uploadImg_single').eq(0).find('input[name="img_copy"]').val());
                        $('#licentype').val(2);
                    } else {//三证未合一
                        var imgStatus=true;
                        $('.js_uploadImg_single_img').each(function(index){
                            if($(this).attr('src')==''){ // 三证未合一 未上传图片
                            	$('.js_uploadImg_single').eq(index).addClass('check_red');
                                var msg = that.msg.key.plsUpload+that.msg.key.uploadCreds[index];
                                $.global_msg.init({msg : msg,btns : true,icon: 2});
                                imgStatus=false;
                                return false ;//跳出循环
                            }
                        	 $('#js_img_path'+(index+1)).val($(this).parent().find('input[name="img_copy"]').val());
                        });
                        if(!imgStatus){
                            return false;
                        }
                        $('#licentype').val(1);
                    }
                    $('.js_uploadImg_single').removeClass('check_red');
                    
                    $("#js_img_path").val(imgPath);
                    var contact = $.trim($("input[name='contact']").val());// 联系人
                    var phone = $.trim($("input[name='phone']").val()); //联系电话
                    var address = $.trim($("input[name='address']").val()); //详细地址 输入部分
                    var province =$('#province').val();//详细地址 省份
                    var city =$('#city').val();//详细地址 市
                    var region =$('#region').val();//详细地址 区
                    var checkArr={};//规则
                    checkArr['contact'] = {val: contact, required: true, max: 32}; //必填 长度32
                    checkArr['phone'] = {val: phone, required: true, max: 32};
                    checkArr['province']={val: province, required: true};
                    checkArr['city']={val: city, required: true};
                    checkArr['address']={val: address, required: true, max: 255};
                    
                    var validObj = that.checkFormPlug.valid(checkArr);
                    //取消红色边框
                    $.each(checkArr,function(key,val){
                    	if(validObj.key != key){
                    		$('#'+key).removeClass('check_red');
                    	}                		
                	});
                    if(validObj){
                    	var msg = '';
                    	switch(validObj.type){
                    		case 1://验证为空
                    			msg = that.msg.key.empty + eval("that.msg.key." + validObj.key);
                    			break;
                    		case 2://验证长度
                    			 msg = eval("that.msg.key." + validObj.key) + that.msg.key.max + eval("checkArr." + validObj.key + ".max");
                    			break;
                    		case 3: //规则验证
                    			msg = that.msg.key.reg + eval("that.msg.key." + validObj.key);
                    			break;
                    		case 4://ajax验证
                    			msg = validObj.key;
                    			break;
                    		default:
                    	}
                    	$('#'+validObj.key).addClass('check_red');
                        $.global_msg.init({msg : msg,btns : true,icon: 2});
                    	return false;
                    }         
                    //console && console.log($('#form2').serializeArray())
                });
            },
            /*js form验证插件 start*/
            checkFormPlug: {
            	valid: function(arr){
                    for (var i in arr) {
                    	key = i;
                    	var type = 0; //1：表示为空，2：表示超过最大长度,3:表示正则表达式,4:异步请求
                        if (arr[i].required && arr[i].val == ''){//必填项非空
                        	type = 1;
                        }else if (typeof (arr[i].max) != 'undefined' && arr[i].val.length > arr[i].max){//最大长度
                        	type = 2;
                        }else if (arr[i].val != '' && typeof (arr[i].reg) != 'undefined' && !arr[i].reg.test(arr[i].val)){
                        	type = 3;
                        }else if(typeof (arr[i].url) != 'undefined'){
                    		msg = $.register.ajaxFn(arr[i],i);
                    		if(msg != i){
                    			type = 4;
                    			key = msg;
                    		}
                    	}
                        if(type){
                        	return {key:key,type:type};
                        }
                    }
                    return false;
            	},
            },/*js form验证插件 end*/
            
            ajaxFn: function(obj,i){
            	var flag = i;
            	$.ajax({
            		  type: "POST",
            		  url: obj.url,
            		  data: {val: obj.val},
            		  dataType: "json",
            		  async: false,
            		  success: function(rtn){
            			  if(rtn.status != 0){
            				  flag = rtn.msg;
            			  }
            		  },
            		  error: function(){}
              	});
            	return flag;
            },
            loop: 0,//循环初始值
            getAddressList: function () { //更改省份城市列表时刷新城市和区列表
                var that = this;
                $("#province").on('change', function () { //更改省份事件
                    var provinceId = $(this).val();
                    that.initCacheCity(provinceId);
                });
                that.initCacheCity($("#province").val());
            },
            //级联市数据
            initCacheCity: function(provinceId){
                if(provinceId != ''){
                	$("#region option").not($("#region option").eq(0)).remove();
                	this.getCityList(provinceId); //刷新城市列表
                }
            },

            getCityList: function (id) { //通过省份ID 获取省份的城市列表
                var that = this;
                $.ajax({
                    url: gGetAddressUrl,
                    type: "get",
                    data: {id: id},
                    async: false,
                    success: function (response) {
                        $("#city option").not($("#city option").eq(0)).remove();
                        $.each(response, function () {
                            $("#city").append("<option></option>");
                            $("#city option:last").html(this.city);
                            $("#city option:last").val(this.prefecturecode).attr('title',this.city);
                        });
                        var cityId = $("#city").val();
                        that.loop = 0;
                    },
                    error: function () { //获取失败最多重复提交3次
                        if (that.loop != 3) {
                            that.loop += 1;
                            that.getCityList(id)
                        } else {
                            $.global_msg.init({msg : '获取城市列表失败',btns : true,icon: 2});
                        }
                    }
                })
            },

            msg: {
                key: {
                    empty: "请输入",
                    max: "超过最大长度",
                    name: "企业名称",
                    type: "所属行业",
                    maxType: '最多选择6个行业',
                    mail: "邮箱",
                    password: "密码",
                    password2: "确认密码",
                    website: "官网URL",
                    doublePassword: '两次输入的密码不一致，请重新输入',
                    reg: '请输入正确的',
                    VerifyBool: '验证码错误',
                    ajaxFail: '提交失败',
                    uploadimgText:'请提交资质证件',
                    contact:'联系人',
                    phone:'联系电话',
                    address:'完整地址',
                    province:'省份',
                    city:'市',
                    region:'区',
                    plsUpload: '请上传',
                    uploadCreds:[ '营业执照','组织机构代码证','税务登记证']
                }

            }
        }
    });
})(jQuery);
