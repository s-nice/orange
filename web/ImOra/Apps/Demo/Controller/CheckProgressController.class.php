<?php
namespace Demo\Controller;

use Think\Controller;

class CheckProgressController extends Controller
{
    private $_unCallMethods = array (
            2 => '__construct',
            11 => '__set',
            12 => 'get',
            13 => '__get',
            14 => '__isset',
            15 => '__call',
            20 => '__destruct',
            20 => '_initialize',
    );

    protected function getMethods($object)
    {
        return (get_class_methods($object));
    }

    protected function _initialize()
    {
        return;
        $methods = $this->getMethods($this);
        $reflectionClass = new ReflectionClass($this);
        $methods = $reflectionClass->getMethods(ReflectionMethod::IS_PUBLIC);

        $hasLink = true;
        $links = '';
        foreach ($methods as $_method) {
            $methodName = $_method->getName();
            if (in_array($methodName, $this->_unCallMethods)) {
                continue;
            }
            $methodComment = $_method->getDocComment();
            preg_match('/\/\*([^@]*)@/us', (string)$methodComment, $match);
            if (!$match) {
                preg_match('/\/\*(.*)\*\//us', (string)$methodComment, $match);
            }

            if (strtolower($methodName)==strtolower(ACTION_NAME)) {
                $hasLink = $hasLink && strpos($methodComment, '@noLink')===false;
            }

            if ($match && isset($match[1])) {
                $methodComment = $match[1];
            } else {
                $methodComment = $methodName;
            }

            $links .= '<a href="'.U(GROUP_NAME.'/'.MODULE_NAME.'/'.$methodName).'">' . trim($methodComment, " \r\n*"). '</a>' . "<br/>\n";

        }

        if ($hasLink) {
            echo $links;
            echo '<hr/>';
        }
    }

    public function index ()
    {
        $do = I('do', 'controller');
        switch (strtolower($do)) {
            case 'action':
                $this->listActions();
                break;

            case 'call':
                $this->callAction();
                break;

            case 'controller':
            default :
                $this->listControllers();
                break;
        }
    }

    protected function getControllersInDir ($dir)
    {
        $controllers = array();
        if (! is_dir($dir)) {
            return $controllers;
        }

        $controllers = glob($dir . '*.class.php');

        return $controllers;
    }

    /**
     * 获取控制器列表
     */
    protected function listControllers ()
    {
        $app = I('app', 'Appadmin');
        $path = APP_PATH . $app . '/Controller/';
        $controllers = $this->getControllersInDir($path);

        foreach ($controllers as $_file) {
            $filename = basename($_file, '.class.php');
            echo '<a href="'
               . U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME, array('do'=>'action','app'=>$app, 'controller'=>$filename))
               . '">'
               . $filename
               . "</a><br/>\r\n";
        }
    }

    /**
     * 根据指点控制器， 其中的所有actions
     */
    protected function listActions ()
    {
        $app = I('app', 'Appadmin');
        $controller = I('controller');

        $class = $app . '\\Controller\\'. $controller;
        $file = APP_PATH . $app . '/Controller/' . $controller . '.class.php';
        if (! file_exists($file)) {
            continue;
        }
        include($file);
        $reflectionClass = new \ReflectionClass($class);
        $methods = $reflectionClass->getMethods(\ReflectionMethod::IS_PUBLIC);


        echo '<a href="'
                . U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME, array('do'=>'controller','app'=>$app))
                . '">..</a>'
                . "<br/>\r\n";
        foreach ($methods as $_methodInfo) {
            if (in_array($_methodInfo->name, $this->_unCallMethods)) {
                continue;
            }
            if ($_methodInfo->class != $class) {
                continue;
            }

            $methodComment = $_methodInfo->getDocComment();
            preg_match('/\/\*([^@]*)@/us', (string)$methodComment, $match);
            if (!$match) {
                preg_match('/\/\*(.*)\*\//us', (string)$methodComment, $match);
            }

            if ($match && isset($match[1])) {
                $methodComment = $_methodInfo->name . '(' . trim($match[1], "* \r\n") . ')';
            } else {
                $methodComment = $_methodInfo->name;
            }

            echo '<a href="'
               . U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME, array(
                       'do'=>'call',
                       'app'=>$app,
                       'controller'=>$controller,
                       'method'=>$_methodInfo->name))
               . '">'
               . $methodComment
               . '</a>' . "<br/>\r\n";
        }
    }

    /**
     * 调用指点action
     */
    protected function callAction ()
    {
        $app = I('app', 'Appadmin');
        $controller = I('controller');
        $method = I('method');
        $response = '';

        $class = $app . '\\Controller\\'. $controller;
        $file = APP_PATH . $app . '/Controller/' . $controller . '.class.php';
        echo '<a href="'
                . U(MODULE_NAME.'/'.CONTROLLER_NAME.'/'.ACTION_NAME, array('do'=>'action','app'=>$app, 'controller'=>$controller))
                . '">..</a>'
                . "<br/>\r\n";

        if (! file_exists($file)) {
            return;
        }
        include($file);
        //反射，执行 $interfaceName类下的$method方法
        $refMethod = new \ReflectionMethod($class, $method);
        if (! $refMethod->isPublic()) {
            return $response;
        }

        //查看方法是否有参数
        $response = $refMethod->invoke(new $class());
    }
}

/* EOF */