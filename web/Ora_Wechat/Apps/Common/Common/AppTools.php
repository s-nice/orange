<?php

/**
 * AppTools.php
 * @author wangzx <wangzx@oradt.com>
 *
 */

/**
 * The common functions used by apps.
 * @author wangzx
 *
 */
class AppTools
{

    /**
     * Load class file automatically
     * @param string $dir The base dir which including of class files
     *
     * @return void
     */
    static public function autoload($dir = '')
    {

    }

    /**
     * Call WebService and get the response
     * @param string $interfaceName <b><i>The interface name</i></b>
     * @param mixed $parameters The parameters to be transfered
     *
     * @return mixed
     */
    // static public function webService($interfaceName, $parameters)
    // {
    //     $apiResponse = array();
    //     settype($interfaceName, 'string'); // set interface name as string
    //     /*
    //      * try to load the specified API file.
    //      */
    //     try {
    //         // compute the api file path
    //         $apiFilePath = dirname(__FILE__) . '/FakeApi/' . $interfaceName . '.php';
    //         // check if api file existing
    //         if(is_file($apiFilePath)) {
    //             // include the fake api file
    //             $apiResponse = include(dirname(__FILE__) . '/FakeApi/' . $interfaceName . '.php');
    //         } else {
    //             $apiResponse = null;
    //         }
    //     } catch (Exception $e) { // exception happened
    //         // log something here
    //         $apiResponse = null;
    //     }
    //     return $apiResponse;
    // }

    /**
     * 接口调用
     * @param string $interfaceName 接口类名称
     * @param string $method 接口类里的方法名
     * @param array $param $method方法的参数
     * @param mixed
     *
     */
    static function webService($interface, $method, $param = array())
    {
        return self::callModelMethod($interface, $method, $param);
    }

    /* @param string $interfaceName 接口类名称
     * @param string $method 接口类里的方法名
     * @param array $param $method方法的参数
     * @param mixed
     *
     */
    static function callModelMethod($interface, $method, $param = array())
    {
        $apiResponse = null;
        try {
            $pathDir = '';
            $path = explode('_', $interface);
            $count = count($path);
            $arrCount = $count - 1;
            if ($count > 1) {
                $pathDir = implode('/', array_slice($path, 0, $arrCount)) . "/";
            }
            $interfaceName = $path[$arrCount];
            $apiFilePath = APP_PATH . 'Lib' . $pathDir . $path[$arrCount] . '.class.php';
            // 将命名空间分隔符转换成路径分隔符
            $apiFilePath = str_replace('\\', DIRECTORY_SEPARATOR, $apiFilePath);
            if (! is_file($apiFilePath)) {
                return $apiResponse;
            }
            require_once $apiFilePath;

            //反射，执行 $interfaceName类下的$method方法
            $refMethod = new \ReflectionMethod($interfaceName, $method);
            if (! $refMethod->isPublic()) {
                return $apiResponse;
            }

            //查看方法是否有参数
            if ($refMethod->getNumberOfParameters() > 0) {
                $params = $refMethod->getParameters();
                foreach ($params as $p) {
                    $name = $p->getName();
                    if (isset($param[$name])) {
                        $args[] = $param[$name];
                    } else {
                    	if($p->isOptional()){
                    		$args[] = $p->getDefaultValue();
                    	}else{
                    		\Think\log::write('File:'.__FILE__.' LINE:'.__LINE__."invoke model param is missing \r\n".' '.var_export(array($interfaceName,$method,$param,$name),true));
                    	}
                    }
                }
                $apiResponse = $refMethod->invokeArgs(new $interfaceName(), $args);
            } else {
                $apiResponse = $refMethod->invoke(new $interfaceName());
            }

        } catch (Exception $e) {
            //发生异常
            if (APP_DEBUG) {
                echo $e->getMessage();
                exit;
            }
        }

        return $apiResponse;
    }

}
