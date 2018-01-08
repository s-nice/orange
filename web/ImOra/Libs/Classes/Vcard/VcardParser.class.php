<?php
class VcardParser extends File_IMC_Parse_Vcard
{
    protected function _parseGENDER($text)
    {
        return array($this->_splitBySemi($text));
    }

}

/* EOF */