<?php
$str = '08612345';
echo strlen($str);
echo preg_match("/^\\d{7}$/", $str)?111:222;