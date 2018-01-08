(function(win,$){
	function cards(opt){
		this.init(opt);
	}
	$.extend(cards.prototype,{
		init:function(opt){
			this.opt = {
				p:1,
			};
			$.extend(true,this.opt,opt||{});
			this._initDomEvent();
		},
		_initDomEvent:function(){
			$('#js-all-check').on('click',function(){
				if($('.cards-list-noscroll').length){
					$('.cards-list-block').addClass('active');
				}else{
					$('.cards_list_c input[type=checkbox]').prop('checked',true);
				}
			});
			$('.cards-list-block').on('click',function(){
				$(this).toggleClass('active');
			});
			$('.js-sle-btn').on('click',function(){
				$('#myForm').submit();
			})
		}
	});
	win.cards = cards;
})(window,jQuery);

