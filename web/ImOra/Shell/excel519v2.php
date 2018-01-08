<?php
    header('Content-Type:text/html;charset=utf-8');
	//ini_set('memory_limit', '-1'); 
	//set_time_limit (0);
	set_include_path('../libs/3rdParty/PHPExcel/');
	include 'PHPExcel.php';
    include 'PHPExcel/IOFactory.php';
    if (!class_exists('PHPExcel_IOFactory')) {
    	die('引入文件错误');
    }
    function excelToLabels($uploadfile){
        $inputFileType = \PHPExcel_IOFactory::identify($uploadfile);
        if (in_array($inputFileType, array('Excel2007', 'Excel5'))) {
            $objReader = \PHPExcel_IOFactory::createReader($inputFileType);

            $objPHPExcel = $objReader->load($uploadfile);

            $sheet_count = $objPHPExcel->getSheetCount();

            $arr_total = array();
            for ($s=0; $s < $sheet_count ; $s++) { 
                $currentSheet = $objPHPExcel->getSheet($s);
                $title = $currentSheet->getTitle();
                $row_num = $currentSheet->getHighestRow();// 当前页行数 
                $col_max = $currentSheet->getHighestColumn(); // 当前页最大列号 
                $arr_s = array();
                $arr_s['cardType'] = $title;
                $labelTypes = array();
                $labels = array();
                $list = array();
                $k = 0;
                for ($i=1; $i <= $row_num ; $i++) { 
                    $arr_i = array();
                    $name = $currentSheet->getCell('A'.$i)->getFormattedValue();
                    $name2= $currentSheet->getCell('B'.$i)->getFormattedValue();
                    if($i==1){
                        for ($j='A'; $j <= $col_max; $j++) {
                            $address = $j . $i; // 单元格坐标 
                            $cell_value = $currentSheet->getCell($address)->getFormattedValue();
                            if($cell_value){
                                array_push($labelTypes,$cell_value);
                            }
                        }
                    }
                    if($i==2){
                        for ($j='A',$n=0; $j <= $col_max; $j++,$n++) {
                            if(isset($labelTypes[$n])){
                                $address = $j . $i; // 单元格坐标 
                                $cell_value = $currentSheet->getCell($address)->getFormattedValue();
                                $cell_value_arr = explode('/',$cell_value);
                                $labels[$labelTypes[$n]] = explode('/',$cell_value);
                            }
                        }
                    }
                    if($i>=3){
                        for ($j='A',$m=0; $j <= $col_max; $j++,$m++) { 
                                if(isset($labelTypes[$m])){
                                    $address = $j . $i; // 单元格坐标 
                                    $cell_value = $currentSheet->getCell($address)->getFormattedValue();
                                    $cell_value_arr = explode('/',$cell_value);
                                    $arr_i[$labelTypes[$m]] = $cell_value_arr;
                                }
                            }
                            $list[] = $arr_i;
                    }
                    
                }
                $arr_s['labelTypes'] = $labelTypes;
                $arr_s['labels'] = $labels;
                $arr_s['list'] = $list;
                $arr_total[] = $arr_s;
            } 
            return $arr_total;
        }else{
            die('文件格式不正确');
        }
    }


function excelunit($unituploadfile){
    $inputFileType = \PHPExcel_IOFactory::identify($unituploadfile); //输出 Excel2007
    if (in_array($inputFileType, array('Excel2007', 'Excel5'))) {
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);

        $objPHPExcel = $objReader->load($unituploadfile);

        $sheet_count = $objPHPExcel->getSheetCount(); //返回底部标签数量个数

        $arr_total = array();
        for ($s=0; $s < $sheet_count ; $s++) {
            $currentSheet = $objPHPExcel->getSheet($s);
            $title = $currentSheet->getTitle(); //底部标签页名称
            $row_num = $currentSheet->getHighestRow();// 当前页行数 (当前标签页中数据数量)
            $col_max = $currentSheet->getHighestColumn(); // 当前页最大列号
           // echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r(array($title,$row_num,$col_max),1);
            $arr_s = array();
            $arr_s['cardType'] = $title;  //底部标签页名称
            $labelTypes = array();
            $list = array();
            for ($i=1; $i <= $row_num ; $i++) {
                $arr_i = array();
                if($i==1){
                    for ($j='A'; $j <= $col_max; $j++) {
                        $address = $j . $i; // 单元格坐标
                        $cell_value = $currentSheet->getCell($address)->getFormattedValue();
                       // echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($j, $cell_value);
                        if($cell_value){
                        	//echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',var_dump($j, $cell_value);
                            array_push($labelTypes,$cell_value);
                        }
                    }
                }
                if($i>=2){
                    for ($j='A',$m=0; $j <= $col_max; $j++,$m++) {
                        if(isset($labelTypes[$m])){
                            $address = $j . $i; // 单元格坐标
                            $cell_value = $currentSheet->getCell($address)->getFormattedValue();
                            //$cell_value_arr = explode('/',$cell_value);
                            $arr_i[$labelTypes[$m]] = $cell_value;
                        }
                    }
/*                     $arr_i = array_map($arr_i); //想要去除数组中空数据,若果数组中的数据全部为空，就不添加数据到结果集中,需要百度一下继续修改
                    if($s == 1){
                    	echo __FILE__.' LINE:'.__LINE__."\r\n".'<pre>',print_r($arr_i,1);
                    } */
                    $list[] = $arr_i;
                }

            }
            $arr_s['labelTypes'] = $labelTypes; //标签页头部栏目
            $arr_s['list'] = $list;
            $arr_total[] = $arr_s;
        }
        return $arr_total;
    }else{
        die('文件格式不正确');
    }
}



    /*$a = excelToLabels('./newexcel.xlsx');
    echo '<pre>';
    print_r($a);*/

?>