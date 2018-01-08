$.extend({
	cart:{
		arr_cookie:null,//cookie数组
		init:function(){
			var _this = this;
			var array =[1,2,3];
			//$.cookie('oradt',JSON.stringify(array));
			var cart_cookie = array;
			this.arr_cookie = array;
			$.each(this.arr_cookie,function(k,v){
				if(parseInt(v)>0){
					var showDom = $('.shoppingcart_list_c').eq(k);
					showDom.show().find('span.input_check input').prop('checked',true);
					showDom.find('.span_jis b').text(v);
				}
			});		
			//checkbox变化
			$('span.input_check input').change(function(){
				_this.reCompute();
				_this.checkAllCheck();
			});
			//点击全选
			$('#check_all').change(function(){
				if($(this).is(':checked')){
					$('.input_check input').prop('checked','checked');
				}else{
					$('.input_check input').prop('checked',false);
				}
				_this.reCompute();
			});
			//加减数量
			$('.span_jis i,.span_jis em').click(function(){
				var tagName = $(this)[0].tagName.toLowerCase();
				var numDom = $(this).parents('.span_jis').find('b');
				var num = parseInt(numDom.text());
				var index = $(this).parents('.shoppingcart_list_c').index();
				if(tagName =='i'){
					if(num>1){
						_this.upCookie(index,parseInt(num-1));
						numDom.text(parseInt(num-1));
					}
				}
				if(tagName =='em'){
					console.log(index,num+1);
						_this.upCookie(index,parseInt(num+1));
						numDom.text(parseInt(num+1));
				}
				_this.reCompute();
			});
			//删除
			$('.span_del').click(function(){
				var hideDom = $(this).parents('.shoppingcart_list_c');
				var index = hideDom.index();
				_this.upCookie(index,parseInt(0));
				hideDom.hide().find('span.input_check input').prop('checked',false);
				_this.reCompute();
			});
			_this.reCompute();
			_this.checkAllCheck();
		},
		//检测是否全选
		checkAllCheck:function(){
			var isAllCheck = true;
			$('.input_check input').each(function(){
				if(!$(this).is(':checked')){
					isAllCheck = false;
					return false;
				}
			});
			$('#check_all').prop('checked',isAllCheck);
		},
		//更改cookie
		upCookie:function(k,v){
			this.arr_cookie[k] = v;
//			$.cookie('oradt',JSON.stringify(this.arr_cookie));
		},
		//价格和数量的计算
		reCompute:function(){
			this.getTotalPrice();
			this.getTotalNum();
		},
		//计算价格
		getTotalPrice:function(){
			var totalPrice = 0;
			$('.shoppingcart_list_c').each(function(){
				var unit_price = $(this).find('i.unit_price').text();
				var unit_num =  $(this).find('.span_jis b').text();
				var sub_total_price = parseInt(unit_price)*parseInt(unit_num);
				$(this).find('.sub_total_price').text(sub_total_price);
				if($(this).find('.input_check input').is(':checked')){
					totalPrice += sub_total_price;
				}
			});
			$('#total_price').text(totalPrice);
		},
		//计算数量
		getTotalNum:function(){
			var totalNum = 0;
			$('.input_check input:checked').each(function(){
				totalNum += parseInt($(this).parents('.shoppingcart_list_c').find('.span_jis b').text());
			});
			$('#total_num').text(totalNum);
		}
	}
});
$(function(){
	$.cart.init();
});