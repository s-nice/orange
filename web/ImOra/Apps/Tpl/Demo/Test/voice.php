<!DOCTYPE html>
<html>
	<head>
	<meta charset="utf-8">
	<title>Audio Example</title>
	<script type="text/javascript">
// 扩展API加载完毕后调用onPlusReady回调函数 
document.addEventListener( "plusready", onPlusReady, false );
var r = null; 
// 扩展API加载完毕，现在可以正常调用扩展API 
function onPlusReady() { 
	r = plus.audio.getRecorder(); 
}
function startRecord() {
	if ( r == null ) {
		alert( "Device not ready!" );
		return; 
	} 
	r.record( {filename:"_doc/audio/"}, function () {
		alert( "Audio record success!" );
	}, function ( e ) {
		alert( "Audio record failed: " + e.message );
	} );
}
function stopRecord() {
	r.stop(); 
}
	</script>
	</head>
	<body>
		<input type="button" value="Start Record" onclick="startRecord();"/> 
		<br/>
		<input type="button" value="Stop Record" onclick="stopRecord();"/>
	</body>
</html>