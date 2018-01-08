<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no, viewport-fit=contain"  />
	<title>测试</title>
	<style>
		*{
			margin:0;
			padding:0;
		}
		html,body{
			width:100%;
			height:100%;
			background:#6c6768;
		}
		body{
			padding-top: constant(safe-area-inset-top);
		    padding-left: constant(safe-area-inset-left);
		    padding-right: constant(safe-area-inset-right);
		    padding-bottom: constant(safe-area-inset-bottom);
		}
		footer{
			width:100%;
			height:30px;
			background:#fff;
			font-size:16px;
			position:fixed;
			bottom:0;
			left:0;
			text-align:center;
		}
		@media only screen and (device-width: 375px) and (device-height:812px) and (-webkit-device-pixel-ratio:3) {
		    html,body{
		    	background:#00edee;
		    }
		}
	</style>
</head>
<body>
	<footer>
			123
	</footer>
</body>
</html>