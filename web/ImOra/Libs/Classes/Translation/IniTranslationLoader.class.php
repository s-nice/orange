<?php
namespace Classes\Translation;
/**
 * $Id$
 * $Revision$
 * $Author$
 * $LastChangedDate$
 *
 * @package
 * @version
 * @author Kilin WANG <wangzx@oradt.com>
 */
require_once(dirname(__FILE__) . '/Translator.interface.php');
/**
 * Load ini string into translation array
 *
 * @example    $t = new IniTranslationLoader('../../../localisation/en-US/Global.ini');
 *             echo $t->_('STR_SECONDARY_NAVIGATION_GUIDED_MODE'');
 *
 */
class IniTranslationLoader implements Translator
{
    /*
     * The translations list.  KeyWord=>TranslationString
     * @var array
     */
    protected $_translations = array();

    /**
     * Constructor
     * @param string $str Ini format language file path or ini format content
     */
    public function __construct($str='')
    {
        if('' != $str) {
            $this->_translations = $this->_parseTranslation($str);
        }
    }

    /**
     * Parse file/string into translations list
     * @param string $str ini file path or ini content
     *
     * @return array
     */
    protected function _parseTranslation($str)
    {
        $strings = array(); // 翻译结果容器

        // 载入翻译内容
        if(is_file($str)) { // 解析文件内容
            $strings = @parse_ini_file($str);
        } else { // 解析字符串内容
            $strings = @parse_ini_string($str);
        }

        return $strings;
    }

    /**
     * Merge new translations into translations list
     * @param string $str ini file path or ini content
     */
    public function mergeTranslation($str)
    {
        $strings = $this->_parseTranslation($str);

        $this->_translations = array_merge($this->_translations, $strings);
    }

    /**
     * Get translation by keyworkd
     * @param string $stringName The keyword used to get translation
     *
     * @return string
     */
    public function get($stringName)
    {
        // 如果字符串已翻译， 返回翻译后的字符串；否则返回待翻译的字符串
        $translation = isset($this->_translations[$stringName])
                           ? $this->_translations[$stringName] : $stringName;

        return $translation;
    }

    /**
     * Get translation by keyworkd.
     * @param string $stringName The keyword used to get translation
     *
     * @return string
     */
    public function _($stringName)
    {
        return $this->get($stringName);
    }
}

/* EOF */