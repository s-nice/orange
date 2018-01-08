<?php
namespace Classes;
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
use Classes\Translation;
/**
 * Load XML string into translation array
 *
 * @example    $t = new TranslationLoader('../../../localisation/en-US/Global.xml', 'XML');
 *             echo $t->_('STR_SECONDARY_NAVIGATION_GUIDED_MODE'');
 *
 */
class TranslationLoader
{
    /*
     * The translations list.  KeyWord=>TranslationString
     * @var array
     */
    protected $_translations = array();

    /*
     * The translator instance
     * @var object
     */
    protected $translator = null;

    /**
     * Constructor
     * @param string $str language file path or language string content
     * @param string $str The translator class to be loaded
     */
    public function __construct($str='', $loaderType='')
    {
        // 加载并实例化指定的翻译类
        switch(strtolower($loaderType)) {
            case 'xml': // 加载 xml 翻译类
                require_once(dirname(__FILE__) . '/Translation/XmlTranslationLoader.class.php');
                $this->translator = new Translation\XmlTranslationLoader($str);
                break;

            case 'ini': // 加载 ini 翻译类
            default: // 默认加载 ini 翻译类
                require_once(dirname(__FILE__) . '/Translation/IniTranslationLoader.class.php');
                $this->translator = new Translation\IniTranslationLoader($str);
                break;
        }
    }

    /**
     * Merge new translations into translations list
     * @param string $str XML file path or XML content
     */
    public function mergeTranslation($str, $loaderType)
    {
        if($this->translator) {
            $this->translator->mergeTranslation($str);
        }
    }
    /**
     * Merge new translations into translations list
     * @param string $str XML file path
     */
    public function mergeTranslationDir($dir, $loaderType)
    {
    	if($this->translator) {
    	    $dir = rtrim($dir.'/');
    		$str = $dir.'/strings.xml';
    		if(is_file($str)){
    			$this->translator->mergeTranslation($str);
    		}
    		$str = $dir.'/arrays.xml';
    		if(is_file($str)){
    			$this->translator->mergeTranslation($str);
    		}
    		$str = $dir.'/webs.xml'; // 终端没有 云端存在的翻译字段
    		if(is_file($str)){
    			$this->translator->mergeTranslation($str);
    		}
    	}
    }

    /**
     * Get translation by keyworkd
     * @param string $stringName The keyword used to get translation
     *
     * @return string
     */
    public function get($stringName)
    {
        if($this->translator) {
            return $this->translator->_($stringName);
        }

        return null;
    }

    /**
     * Get translation by keyworkd.
     * @param string $stringName The keyword used to get translation
     *
     * @return string
     */
    public function _($stringName)
    {
        if($this->translator) {
            return $this->translator->_($stringName);
        }

        return null;
    }

    /**
     * Get translation by keyworkd.
     * @param string $stringName The keyword used to get translation
     *
     * @return string
     */
    public function __get($stringName)
    {
        if($this->translator) {
            return $this->translator->_($stringName);
        }

        return null;
    }
}

/* EOF */