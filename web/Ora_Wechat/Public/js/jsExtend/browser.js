(function(window){
	window.browser={};
	window.browser.os='windows';
	
	var browser=navigator.appName
	if (browser=="Microsoft Internet Explorer"){
		window.browser.type='IE';
		var b_version=navigator.appVersion
		var version=b_version.split(";");
		var trim_Version=version[1].replace(/[ ]/g,"");
		
		if(trim_Version=="MSIE6.0"){
			window.browser.version='6';
		}
		if(trim_Version=="MSIE7.0"){
			window.browser.version='7';
		}
		if(trim_Version=="MSIE8.0"){
			window.browser.version='8';
		}
		if(trim_Version=="MSIE9.0"){
			window.browser.version='9';
		}
		if(trim_Version=="MSIE10.0"){
			window.browser.version='10';
		}
	} else {
		var agent=navigator.userAgent.toLowerCase();
		if (agent.indexOf('windows nt 10.0')>0 && agent.indexOf('rv:11.0')>0){
			window.browser.type='IE';
			window.browser.version='11';
		}
		if (agent.indexOf('chrome')>0){
			window.browser.type='Chrome';
		}
		if (agent.indexOf('edge')>0){
			window.browser.type='edge';
		}
		if (agent.indexOf('firefox')>0){
			window.browser.type='Firefox';
		}
		if (agent.indexOf('opr')>0){
			window.browser.type='Opera';
		}
		if (agent.indexOf('safari')>0 && agent.indexOf('version')>0){
			window.browser.type='Safari';
		}
	}
})(window);
