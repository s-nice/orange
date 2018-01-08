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
/**
 * Translator class interface
 *
 * defines the common methods used in derived class
 *
 */
interface Translator
{

    /**
     * Constructor
     * @param string $str languuage file path or language string content
     */
    public function __construct($str='');

    /**
     * Merge new translations into translations list
     * @param string $str language file path or language content
     */
    public function mergeTranslation($str);

    /**
     * Get translation by keyworkd
     * @param string $stringName The keyword used to get translation
     *
     * @return string
     */
    public function get($stringName);

    /**
     * Get translation by keyworkd.
     * @param string $stringName The keyword used to get translation
     *
     * @return string
     */
    public function _($stringName);
}

/* EOF */