<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>target-input</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <!-- 1. Define some markup -->
    <div class="down-item">
        <div class="down-t">
            <span>导出名片2017-11-03</span>
            <button id="js_btn_1509677270" class="js_copy" data-clipboard-action="copy" data-clipboard-text="https://oradtdev.s3.cn-north-1.amazonaws.com.cn/wxmail/ZYhBYAhDYg20171103104750.xlsx">复制链接</button>
            <a href="https://oradtdev.s3.cn-north-1.amazonaws.com.cn/wxmail/ZYhBYAhDYg20171103104750.xlsx"><em>下载</em></a>
        </div>
        <div class="down-input">
            <span>文件链接</span>
            <input type="text" value="https://oradtdev.s3.cn-north-1.amazonaws.com.cn/wxmail/ZYhBYAhDYg20171103104750.xlsx">
        </div>
        <!--成功错误提示-->
        <div class="file-tip">
            <p class="suc-p js_cp_succ" style="display:none;">已成功复制到粘贴板</p>
            <p class="error-p js_cp_fail" style="display:none;">复制失败，请长按文件链接进行复制</p>
        </div>
    </div>

    <div class="down-item">
        <div class="down-t">
            <span>导出名片2017-11-03</span>
            <button id="js_btn_1509676846" class="js_copy" data-clipboard-action="copy" data-clipboard-text="https://oradtdev.s3.cn-north-1.amazonaws.com.cn/wxmail/t0cBhb8x9J20171103104046.xlsx">复制链接</button>
            <a href="https://oradtdev.s3.cn-north-1.amazonaws.com.cn/wxmail/t0cBhb8x9J20171103104046.xlsx"><em>下载</em></a>
        </div>
        <div class="down-input">
            <span>文件链接</span>
            <input type="text" value="https://oradtdev.s3.cn-north-1.amazonaws.com.cn/wxmail/t0cBhb8x9J20171103104046.xlsx">
        </div>
        <!--成功错误提示-->
        <div class="file-tip">
            <p class="suc-p js_cp_succ" style="display:none;">已成功复制到粘贴板</p>
            <p class="error-p js_cp_fail" style="display:none;">复制失败，请长按文件链接进行复制</p>
        </div>
    </div>

    <!-- 2. Include library -->
    <script src="__PUBLIC__/js/jquery/jquery.js"></script>
    <script src="__PUBLIC__/js/jsExtend/clipboard.min.js"></script>

    <!-- 3. Instantiate clipboard -->
    <script>
        function CopyToClipboard (input) {
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
                alert ("The text is on the clipboard, try to paste it!");
            }else{
                alert ("Your browser doesn't allow clipboard access!");
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
