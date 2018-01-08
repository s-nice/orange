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
    $inputFileType = \PHPExcel_IOFactory::identify($unituploadfile);
    if (in_array($inputFileType, array('Excel2007', 'Excel5'))) {
        $objReader = \PHPExcel_IOFactory::createReader($inputFileType);

        $objPHPExcel = $objReader->load($unituploadfile);

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
            $list = array();
            for ($i=1; $i <= $row_num ; $i++) {
                $arr_i = array();
                if($i==1){
                    for ($j='A'; $j <= $col_max; $j++) {
                        $address = $j . $i; // 单元格坐标
                        $cell_value = $currentSheet->getCell($address)->getFormattedValue();
                        if($cell_value){
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
                    $list[] = $arr_i;
                }

            }
            $arr_s['labelTypes'] = $labelTypes;
            $arr_s['list'] = $list;
            $arr_total[] = $arr_s;
        }
        return $arr_total;
    }else{
        die('文件格式不正确');
    }
}

//卡模板名称excel表
function exceltplname($unituploadfile){
	$inputFileType = \PHPExcel_IOFactory::identify($unituploadfile);
	if (in_array($inputFileType, array('Excel2007', 'Excel5'))) {
		$objReader = \PHPExcel_IOFactory::createReader($inputFileType);

		$objPHPExcel = $objReader->load($unituploadfile);

		$sheet_count = $objPHPExcel->getSheetCount();

		$arr_total = array();
		for ($s=0; $s < $sheet_count ; $s++) {
			$currentSheet = $objPHPExcel->getSheet($s);
			$title = $currentSheet->getTitle(); //excel底部栏目名称
			$row_num = $currentSheet->getHighestRow();// 当前页行数
			$col_max = $currentSheet->getHighestColumn(); // 当前页最大列号
			$arr_s = array();
			$arr_s['cardType'] = $title;
			$labelTypes = array();
			$list = array();
			for ($i=1; $i <= $row_num ; $i++) {
				$arr_i = array();
				if($i==1){
					for ($j='A'; $j <= $col_max; $j++) {
						$address = $j . $i; // 单元格坐标
						$cell_value = $currentSheet->getCell($address)->getFormattedValue();
						if($cell_value){
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
							$arr_i[] = $cell_value; //$labelTypes[$m]
						}
					}
					$list[] = $arr_i;
				}

			}
			$arr_s['labelTypes'] = $labelTypes;
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