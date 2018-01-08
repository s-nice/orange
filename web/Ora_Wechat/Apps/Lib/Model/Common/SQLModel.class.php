<?php
namespace Model\Common;
use \Think\Model;
class SQLModel extends Model
{
    protected function setLog($sql){
    	$logMessage = array();
		$logMessage['sql'] = $sql;
		$_SESSION['logInfo']['content'][] = $logMessage;
    }
}