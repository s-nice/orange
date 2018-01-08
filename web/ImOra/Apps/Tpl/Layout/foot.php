<script language="javascript" type="text/javascript">
	/**
 	 * 文档内容垂直居中
	 */
    function setPosition()
    {
    	var oLogin = document.getElementById('tbposition');
    	if(documentHeight() > oLogin.offsetHeight){
        	// 居中
    		oLogin.style.marginTop=(documentHeight()-oLogin.offsetHeight)/2 + 'px';
    	}else{
    		oLogin.style.marginTop='0px';
    	}
	}
    window.onload = setPosition;
    window.onresize=setPosition;

    function documentHeight(){
    	return Math.max(document.body.offsetHeight , document.documentElement.clientHeight);
    }
    function scrollY(){
    	return document.documentElement.scrollTop || document.body.scrollTop;
    }
</script>