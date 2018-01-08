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
                $row_num = $currentSheet->getHighestRow();// 当前页行数
                $col_max = $currentSheet->getHighestColumn(); // 当前页最大列号
                $arr_s = array();
                $labelTypes = array();
                $labels = array();
                $list = array();
                $k = 0;
                for ($i=1; $i <= $row_num ; $i++) { 
                    $arr_i = array();
                    $name = $currentSheet->getCell('A'.$i)->getFormattedValue();
                    $name2= $currentSheet->getCell('B'.$i)->getFormattedValue();
                    if($name=='卡标签'){
                        if(sizeof($list)>0){
                            $arr_s['labelTypes'] = $labelTypes;
                            $arr_s['labels'] = $labels;
                            $arr_s['list'] = $list;
                            $arr_total[] = $arr_s;
                            $arr_s = array();
                            $labelTypes = array();
                            $labels = array();
                            $list = array();
                            $k = 0;
                        }
                        $arr_s['cardType'] = $currentSheet->getCell('A'.($i-1))->getFormattedValue();
                        for ($j='A'; $j <= $col_max; $j++) {
                            $address = $j . $i; // 单元格坐标 
                            $cell_value = $currentSheet->getCell($address)->getFormattedValue();
                            if($cell_value){
                                array_push($labelTypes,$cell_value);
                            }
                        }
                        continue 1;
                    }
                    if(isset($arr_s['cardType'])){
                        //标签数据行
                        if($name=='标签数据'){
                            for ($j='A',$n=0; $j <= $col_max; $j++,$n++) {
                                if(isset($labelTypes[$n])){
                                    $address = $j . $i; // 单元格坐标 
                                    $cell_value = $currentSheet->getCell($address)->getFormattedValue();
                                    $cell_value_arr = explode('/',$cell_value);
                                    $labels[$labelTypes[$n]] = explode('/',$cell_value);
                                }
                            }
                            $k=1;
                            continue 1;
                        }
                        //过滤示例行
                        if($name=='示例'){
                            continue 1;
                        }
                        //过滤示例行，空行
                        if($name==''){
                            continue 1;
                        }
                        //过滤掉卡名称
                        if(strpos($name,'卡')!==false){
                            continue 1;
                        }
                        if($k>0){
                            for ($j='A',$m=0; $j <= $col_max; $j++,$m++) { 
                                if(isset($labelTypes[$m])){
                                    $address = $j . $i; // 单元格坐标 
                                    $cell_value = $currentSheet->getCell($address)->getFormattedValue();
                                    $cell_value_arr = explode('/',$cell_value);
                                    $arr_i[$labelTypes[$m]] = $cell_value_arr;
                                }
                            }
                            $list[$k-1] = $arr_i;
                            $k++;
                        }
                    }else{
                        continue 1;
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

?>