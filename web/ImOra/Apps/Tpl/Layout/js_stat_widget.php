
/**
 * 返回表格最大值，步伐
 * @param max
 * @return object
 */
function paramsForGrid(max){
	max = max-'';
	var interval=1, splitNumber = 6;
	if (max <= 5){
		max = 5;
	}
	
	interval = Math.ceil(max/5);
    max = interval*6;
    return {max:max, interval:interval, splitNumber:splitNumber};
}
