<layout name="../Layout/Layout" />
<div class="content_global">
    <div class="content_hieght">
        <div class="content_c">
        	<span id="printId" class="qrcode_pic"><img src="{:U('ScannerManager/qrcodeSrc',array('qrcode'=>$qrcode),'',true)}" /></span>
        	<div class="qrcode_button">
        		<input type="button" onclick="printQrcode($('#printId'));" value="打印" />
        		<input type="button" value="另存为" onclick="qrcodeDownload();"/>
        		<input type="button" value="取消" onclick="back();" />
        	</div>
         </div>
    </div>
    {$scanid}
</div>
<script>
	// 下载二维码
	function qrcodeDownload(){
		window.location.href = "{:U('ScannerManager/qrcodeDownload',array('scanid'=>$scanId,'qrcode'=>$qrcode),'',true)}";
	}
	// 返回
	function back(){
		window.location.href = "{:U('ScannerManager/index','','',true)}";
	}
	// 打印二维码
	function printQrcode(obj){
	    var newWindow = window.open("打印窗口","_blank","height=279, width=279");
	    var docStr = obj.html();
	    docStr = '<style>img{width:259;height:259;}</style>'+docStr;
	    newWindow.document.write(docStr);
	    newWindow.document.close();
	    newWindow.print();
	    newWindow.close();
	}
</script>