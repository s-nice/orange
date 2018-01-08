<link href="__PUBLIC__/css/jplayer/css/jplayer.blue.monday.css?v={:C('APP_VERSION')}" rel="stylesheet" type="text/css">
<script src="__PUBLIC__/js/jsExtend/jplayer/jquery.jplayer.min.js?v={:C('APP_VERSION')}"></script>
<script type="text/javascript">
$(function(){
	var options = {
			swfPath: gPublic+"js/jsExtend/jplayer",
			supplied: "m4a, oga",
			wmode: "window",
			noVolume:true,
			globalVolume: true,
			useStateClassSkin: true,
			autoBlur: false,
			smoothPlayBar: true,
			keyEnabled: true
		};
	var audioArr = $('audio');
	for(var i=0;i<audioArr.length;i++)
	{
		var url = $(audioArr[i]).attr('src');
		var j=i+1;
		options.cssSelectorAncestor='#jp_container_'+j;
		var htmlStr ='<div id="jquery_jplayer_'+j+'" class="jp-jplayer"></div>\
		<div id="jp_container_'+j+'" class="jp-audio" role="application" aria-label="media player">\
			<div class="jp-type-single">\
				<div class="jp-gui jp-interface">\
					<div class="jp-controls">\
						<button class="jp-play" role="button" tabindex="0">play</button>\
						<button class="jp-stop" role="button" tabindex="0">stop</button>\
					</div>\
				</div>\
				<div class="jp-no-solution">\
					<span>Update Required</span>\
					To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.\
				</div>\
			</div>\
		</div>';
		$(audioArr[i]).replaceWith(htmlStr);
		$("#jquery_jplayer_"+j).jPlayer(options);
		$("#jquery_jplayer_"+j).jPlayer("setMedia", {m4a: url}); 
	}
});
</script>