var page = require('webpage').create();
page.settings.userAgent = 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/37.0.2062.120 Safari/537.36';
page.settings.loadImages = true;
//page.navigationLocked = true;

page.onLoadStarted =function() {
    loadInProgress =true;
    console.log("load started");
};
 
page.onLoadFinished = function() {
    loadInProgress = false;
    console.log("load finished");
    setTimeout(function(){
    	phantom.exit();
    },10000);
};

var system = require('system');
var url = system.args[1];

page.open(url, function (s) {
	if (s=='fail'){
		console.log('load failed');
		phantom.exit();
	}
	
	var it = setInterval(function(){
		var title = page.evaluate(function() {
			return document.title;
		});
		if (title == 'ok'){
			phantom.exit();
		}
	},100);
});
