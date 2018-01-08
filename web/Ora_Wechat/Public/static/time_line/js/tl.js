/**
 * 渲染
 */
function load(list){
	var ds = list
	var dl = $("#tl_dl")
	var n = 0
	for(d in ds){
	    var dt = ds[d]["date"]
	    var dcs = ds[d]["cards"]
	    //添加时间节点
	    if ($('dt[date="'+dt+'"]').length==0){
	    	dl.append($("<dt date='"+dt+"'>"+ dt +"</dt>"));
	    }
	    for(c in dcs){
	        var name = dcs[c]["name"]
	        var company = dcs[c]["company"]
	        var create_time = dcs[c]["create_time"]
	        var mobile = dcs[c]["mobile"]
	        var position = dcs[c]["position"]
	        var picture = dcs[c]["picture"]
	        var cardId = dcs[c]["card_id"]
	        
	        var ev = $('<dd class="pos-'+ ((n++%2==0)?"left":"right") +' clearfix" ><div class="circ">' +
	            '</div><div class="circ"></div>' +
	            '<div class="time">'+create_time.substring(10,create_time.length)+'</div>' +
	            '<div class="events">' +
	            '<div class="events-header">'+name+' '+str_360_join_to+'</div>' +
	            '<div class="events-body">' +
	            '<div class="row">' +
	            '<div class="col-md-6 pull-left">' +
	            '<a href="'+cardDetailUrl+'?cardid='+cardId+'">' +
	            '<img class="events-object img-responsive img-rounded" src="'+picture+'" />' +
	            '</a>' +
	            '</div>' +
	            '<div class="events-desc events-text">' +
	            str_360_company+'：'+company+
	            '</br>' +
	            str_360_job+'：'+position+
	            '</br>' +
	            str_360_phone+'：'+mobile+
	            '</div></div></div><div class="events-footer">&nbsp</div></div></div></dd>')
	        dl.append(ev)
	    }
	}
	$('.VivaTimeline').vivaTimeline();
}

