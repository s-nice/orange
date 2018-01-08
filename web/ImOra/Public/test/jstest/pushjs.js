/* 
js文件
 */
function clickAlertHellos ()
{
    alert('hello');
}

(function($){
	$.extend({
		pushjs:{

            /*
            * _containerDiv ：绑定事件的父类 div
            * _classname ：绑定事件的节点 class
            * _classnamePrefix ：执行js事件的class前缀
            * */
			inits: function (_containerDiv,_classname,_classnamePrefix) {
                //
				var class_arr = new Array();
				var class_str = '';
				$("."+_classname).each(function(i){
                    var thisclassname = this.className;
					//获取指定（oradt_class）节点 的所有 class 值
					class_arr = $.pushjs.str_handle(thisclassname);

					//获取需要添加时间的当前唯一的class名称
					var eventClass = $.pushjs.arr_handle(class_arr,_classnamePrefix);

                    //截取事件及方法+参数
                    class_arr = $.pushjs.event_handle(eventClass,_classnamePrefix.length);

                    //拼组绑定事件
                    if(class_arr.length == 2){
                        if( typeof eval(class_arr[1]) === 'function' ){
                            class_str = "$('."+_containerDiv+"').on('"+class_arr[0]+"','."+eventClass+"',"+class_arr[1]+")";
                        }
                    }else if(class_arr.length == 3){
                        if( typeof eval("$."+class_arr[1]+"."+class_arr[2]) === 'function' ){
                            class_str = "$('."+_containerDiv+"').on('"+class_arr[0]+"','."+eventClass+"', $."+class_arr[1]+"."+class_arr[2]+")";
                        }
                    }

                    eval(class_str);

				});

                //confirm事件
                function clickConfirmChose(){
                    if(confirm('ok?')){
                        alert('you chose yes')
                    }else{
                        alert('you chose no')
                    }
                }
                function dblclickAlertWord(){
                    alert('dblclick word');
                }

            },
			//获取元素classname,分割为数组
			str_handle:function(_str){
				return $.trim(_str).split(' ');
			},
			//筛选获取 绑定事件的 class name
			arr_handle:function(_arr,_classnamePrefix){
                var str = '';
				$.each(_arr,function(n,i){
                    var res = i.indexOf(_classnamePrefix);
					if(res != -1){
                        str = i;
					}
				});

                return str;
			},
            event_handle:function(_eventClass,_len){
                var res = new Array();
                var funcName = _eventClass.slice(_len);
                var funcArr = funcName.split('_');

                res[0] = funcArr[0];
                funcArr = funcArr[1].split('-');
                $.each(funcArr,function(n,i){
                    res.push(i);
                });
                return res;
            },

			
		},
        container:{
            clickAlertHello : function () {
                alert('Hello');
            },
            dblclickAlertWords : function () {
                alert('there have two words:hehe and hehe !');
            }
        }

	});
	
})(jQuery);


