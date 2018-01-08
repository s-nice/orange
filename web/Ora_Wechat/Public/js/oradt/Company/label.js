$.extend({
	label:{
		index:function(){
			var _this = this;
			//鼠标滑过
			$('.js_label_ul').on('mouseover','.js_label_deal',function(){
				$(this).find('em').css('display','inline-block');
			});

			//鼠标移除
			$('.js_label_ul').on('mouseout','.js_label_deal',function(){
				$(this).find('em').css('display','none');
			});

			//点击编辑图标
			$('.js_label_ul').on('click','.js_label_edit',function(){
				var oLi = $(this).parents('li');
				var oDeal = oLi.find('.js_label_deal');
				var oBtn = oLi.find('.js_label_btn');
				var tags = oDeal.find('.js_label').text();
				oDeal.hide();
				oBtn.find('input').val(tags);
				oBtn.show();
			});

			//点击取消图标
			$('.js_label_ul').on('click','.js_label_can',function(){
				var oLi = $(this).parents('li');
				var tag = oLi.attr('tagid');
				if(tag){	
					oLi.find('.js_label_btn').hide();
					oLi.find('.js_label_deal').show();
				}else{
					oLi.remove();
				}
			});

			//点击确定图标
			$('.js_label_ul').on('click','.js_label_sub',function(){
				var oLi = $(this).parents('li');
				var oInput = $(this).parents('.js_label_btn').find('input');
				var tag = $.trim(oInput.val());
				var oldTag = oLi.find('.js_label').text();
				if(!tag){
					$.selfTip(oInput,"请输入标签");  
					return false; 
				}
				if(tag==oldTag){
					oLi.find('.js_label_can').trigger('click');
					return false; 
				}
				var id = oLi.attr('tagid');
				$.post(editLabelUrl,{id:id,tag:tag},function(re){
					if(re.status==0){
						oLi.find('.js_label').text(tag);
						oLi.find('.js_label_deal').show();
						oLi.find('.js_label_btn').hide();
						if(re.id){
							oLi.attr('tagid',re.id);
						}
					}else{
						$.selfTip(oInput,re.msg);  
						return false; 
					}
				});
			});

			//点击增加标签
			$('.js_label_add').on('click',function(){
				var html = '<li tagid=""><div class="label-ch js_label_deal" style="display:none;"><label for=""><input type="checkbox" /></label><span class="js_label"></span><em class="label-w-i label-edit-i js_label_edit"></em><em class="label-w-i label-remove-i js_label_del"></em></div><div class="label-ch label-none js_label_btn" style="display:block;"><input class="label-edit" type="text" /><button class="label-edit-btn js_label_sub" type="button">确定</button><button class="label-edit-btn label-btn-cancel js_label_can" type="button">取消</button></div></li>';
				$('.js_label_ul').append(html);
			});

			//点击单个删除图标
			$('.js_label_ul').on('click','.js_label_del',function(){
				var oLi = $(this).parents('li');
				var tagid = oLi.attr('tagid');
				$.dialog.confirm({content:'确定要删除吗？',callback:function(){
					_this._delLabel(tagid);
				}});
				//$.
			});

			//多个删除
			$('.js_labels_del').on('click',function(){
				var id = _this._getIds();
				if(id){		
					$.dialog.confirm({content:'确定要删除吗？',callback:function(){
						_this._delLabel(id);
					}});
				}
				//$.
			});
		},

		//删除标签
		_delLabel:function(id){
			$.post(delLabelUrl,{id:id},function(re){
				if(re.status==0){
					window.location.reload();
				}else{
					$.dialog.alert({content:re.msg});
					return false;
				}
			})
		},

		//获取选中ID
		_getIds:function(){
			var ids = [];
			$('.js_label_ul input[type=checkbox]:checked').each(function(){
				var id = $(this).parents('li').attr('tagid');
				ids.push(id);
			});
			return ids.join(',');
		}
	}
});
