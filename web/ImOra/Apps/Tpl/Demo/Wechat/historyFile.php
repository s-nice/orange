<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
	<title>历史生成附件</title>
	<script src="__PUBLIC__/js/oradt/H5/fontSize.js?v={:C('WECHAT_APP_VERSION')}?v={:C('WECHAT_APP_VERSION')}"></script>
	<link rel="stylesheet" href="__PUBLIC__/css/detailOra.css?v={:C('WECHAT_APP_VERSION')}" />
</head>
<body>
	<section class="his-main">
		<section class="his-content">
			<div class="his-text">
				<p>点击“复制链接”按钮，可复制链接并分享该文件，点击“下载”按钮，可将该附件保存到本地</p>
			</div>
			<foreach name="list" item="val">
			<div class="down-item">
				<div class="down-t">
					<span>{:date('Y-m-d H:i:s',$val['create_time'])}</span>
					<button id="js_btn_{$val.create_time}" class="js_copy" data-clipboard-action="copy" data-clipboard-text="{$val.enclosure}" type="button" >复制链接</button>
					<a href="{$val.enclosure}"><em>下载</em></a>
				</div>
				<div class="down-input">
					<span>文件链接</span>
					<div class="v-input">
						<input type="text" value="{$val.enclosure}">
					</div>
				</div>
				<!--成功错误提示-->
				<div class="file-tip">
					<p class="suc-p js_cp_succ" style="display:none;">已成功复制到粘贴板</p>
					<p class="error-p js_cp_fail" style="display:none;">复制失败，请长按文件链接进行复制</p>
				</div>
			</div>
			</foreach>
		</section>
	</section>
	<script src="__PUBLIC__/js/jquery/jquery.js?v={:C('WECHAT_APP_VERSION')}&t=<?php time();?>"></script>
	<script src="__PUBLIC__/js/jsExtend/clipboard.min.js"></script>
	<script>
		function CopyToClipboard (input,oDom) {
            var textToClipboard = input;

            var success = true;
            if (window.clipboardData) { // Internet Explorer
                window.clipboardData.setData ("Text", textToClipboard);
            }else{
                    // create a temporary element for the execCommand method
                var forExecElement = CreateElementForExecCommand (textToClipboard);

                        /* Select the contents of the element 
                            (the execCommand for 'copy' method works on the selection) */
                SelectContent (forExecElement);

                var supported = true;

                    // UniversalXPConnect privilege is required for clipboard access in Firefox
                try {
                    if (window.netscape && netscape.security) {
                        netscape.security.PrivilegeManager.enablePrivilege ("UniversalXPConnect");
                    }

                        // Copy the selected content to the clipboard
                        // Works in Firefox and in Safari before version 5
                    success = document.execCommand ("copy", false, null);
                }
                catch (e) {
                    success = false;
                }

                    // remove the temporary element
                document.body.removeChild (forExecElement);
            }

            if (success) {
                oDom.find('.file-tip p').hide();
                oDom.find('.js_cp_succ').show();
                e.clearSelection();
            }else{
                oDom.find('.file-tip p').hide();
	            oDom.find('.js_cp_fail').show();
            }
        }

	    function CreateElementForExecCommand (textToClipboard) {
	        var forExecElement = document.createElement ("div");
	            // place outside the visible area
	        forExecElement.style.position = "absolute";
	        forExecElement.style.left = "-10000px";
	        forExecElement.style.top = "-10000px";
	            // write the necessary text into the element and append to the document
	        forExecElement.textContent = textToClipboard;
	        document.body.appendChild (forExecElement);
	            // the contentEditable mode is necessary for the  execCommand method in Firefox
	        forExecElement.contentEditable = true;

	        return forExecElement;
	    }

	    function SelectContent (element) {
	        // first create a range
	        var rangeToSelect = document.createRange ();
	        rangeToSelect.selectNodeContents (element);

	            // select the contents
	        var selection = window.getSelection ();
	        selection.removeAllRanges ();
	        selection.addRange (rangeToSelect);
	    }
		$(function(){
	        $('.js_copy').each(function(){
	        	var _this = $(this);
	            var id = $(this).attr('id');
	            var clipboard = new Clipboard('#'+id);
	            var url = $(this).attr('data-clipboard-text');
	            clipboard.on('success', function(e) {
	            	_this.parents('.down-item').find('.file-tip p').hide();
	                _this.parents('.down-item').find('.js_cp_succ').show();
	                e.clearSelection();
	            });

	            clipboard.on('error', function(e) {
	                CopyToClipboard(url,_this.parents('.down-item'));
	            });
	        });
	    });
	</script>
</body>
</html>