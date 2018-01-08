<?php
$arr = array(
    'str'=>'root',
    'value'=>'root_value',
    'list'=>array(
        array('str'=>'str1', 'value'=>'value1', 'list'=>array(
            array('str'=>'str11', 'value'=>'value11', 'list'=>array(
                array('str'=>'str111', 'value'=>'value111'),
                array('str'=>'str112', 'value'=>'value112'),
            )),
            array('str'=>'str12', 'value'=>'value12', 'list'=>array(
                array('str'=>'str121', 'value'=>'value121'),
                array('str'=>'str122', 'value'=>'value122'),
            )),
            array('str'=>'str13', 'value'=>'value13', 'list'=>array(
                array('str'=>'str131', 'value'=>'value131'),
                array('str'=>'str132', 'value'=>'value132'),
            )),
        )),
        array('str'=>'str2', 'value'=>'value2', 'list'=>array(
            array('str'=>'str21', 'value'=>'value21', 'list'=>array(
                array('str'=>'str211', 'value'=>'value211'),
                array('str'=>'str212', 'value'=>'value212'),
            )),
            array('str'=>'str22', 'value'=>'value22'),
        )),
        array('str'=>'str3', 'value'=>'value3'),
    )    
);
$json = json_encode($arr);
$callback = $_REQUEST['callback'];
echo "$callback($json)";

//echo json_encode($arr);