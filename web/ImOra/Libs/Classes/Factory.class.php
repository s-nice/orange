<?php
namespace Classes;
/**
 * Factory.class.php
 */
class Factory
{
    /*
     * 翻译类实例
     * @var Translator
     */
    static private $_translator;

    static private $_errorDesc;

    /**
     * 获取翻译类实例
     * @param string $str language file path or language string content
     * @param string $str The translator class to be loaded
     *
     * @return TranslationLoader
     */
    static public function getTranslator($str='', $loaderType='')
    {
        require_once(dirname(__FILE__).'/Translation/Translator.interface.php');

        // 初始化翻译类实例
        if(! (self::$_translator instanceof TranslationLoader)) {
            // 如果参数均为空， 载入默认翻译类和全局翻译语言
            $str = (''==$str && ''==$loaderType) ? (APP_PATH . 'Lang/zh-cn/global.ini') : $str;
            require_once(dirname(__FILE__).'/TranslationLoader.class.php');
            self::$_translator = new TranslationLoader($str, $loaderType);
        }

        return self::$_translator;
    }

    static public function getErrorCoder()
    {

    }
}