<?php
namespace Hooks;

class PrintDevInfo
{
    public function app_end ()
    {
    	// 查看php环境信息， 隐藏显示
    	if(I('get.__DEV_CHECK_PHP__',null)) {
    	    echo '<!-- ';
    	    phpinfo();
    	    echo '-->';
    	}

    	// 查看Log信息
    	if(I('get.__DEV_CHECK_LOG__',null)) {
    	    $logFile = C('LOG_PATH').date('y_m_d').'.log';
    	    echo '<!-- ';
    	    echo @file_get_contents($logFile);
    	    echo '-->';
    	}

    	// 查看API版本
    	if(I('get.__DEV_CHECK_API_VERSION__',null)) {
    	    $response = \AppTools::webService('\Model\Common\Common',
    	                          'callApi',
    	                          array('url'        => C('API_VERSION'),
    	                                'params'     => array(),
    	                                'crudMethod' => 'R',
    	                                'doParseApi' => false
    	                          )
    	                );
    	    echo '<!-- ';
    	    echo print_r($response, true);
    	    echo '-->';
    	}
    }
}