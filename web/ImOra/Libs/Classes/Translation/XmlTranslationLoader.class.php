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
 * Load XML string into translation array
 *
 * @example    $t = new XmlTranslationLoader('../../../localisation/en-US/Global.xml');
 *             echo $t->_('STR_SECONDARY_NAVIGATION_GUIDED_MODE'');
 *
 */
class XmlTranslationLoader implements Translator
{
    /*
     * The translations list.  KeyWord=>TranslationString
     * @var array
     */
    protected $_translations = array();

    /**
     * Constructor
     * @param string $str XML file path or XML content
     */
    public function __construct($str='')
    {
        if('' != $str) {
            $this->_translations = $this->_parseTranslation($str);
        }
    }

    /**
     * Parse XML into translations list
     * @param string $str XML file path or XML content
     *
     * @return array
     */
    protected function _parseTranslation($str)
    {
    	$strings = array(); // 翻译容器

        if(is_file($str)) { // 载入文件
            //$translations = @simplexml_load_file($str);
            $xmlData = file_get_contents($str);
            $translations = @simplexml_load_string($xmlData);
        } else { // 载入字符串
            //$translations = @simplexml_load_string($str);
            $xmlData = file_get_contents($str);
            $translations = @simplexml_load_string($xmlData);
        }
        // 解析成功后， 逐个处理翻译
        if($translations) {
            foreach($translations as $_stringInfo) {
                $_stringArr = (array)$_stringInfo->attributes();
                if(count($_stringInfo->item) == 0){
                	$strings[$_stringArr['@attributes']['name']] = isset($_stringArr['@attributes']['value'])?$_stringArr['@attributes']['value']:(string)$_stringInfo;
                }else{
                	$strings[$_stringArr['@attributes']['name']] = (array)$_stringInfo->item;
                }
            }
        }
        return $strings;
    }

    /**
     * Merge new translations into translations list
     * @param string $str XML file path or XML content
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