// 除去两边空白
String.prototype.trim = function(s){
	return this.replace(/(^\s*)|(\s*$)/g, "");
}
// 判断手机号
String.prototype.isMobile = function(){
    return /^1[3,4,5,7,8]\d{9}$/.test(this);
}
// 判断座机
String.prototype.isPhone = function(){
    return /^(0[0-9]{2,3}-?)?[0-9]{7,8}$/.test(this);
}
// 判断邮箱
String.prototype.isEmail = function(){
    return /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/.test(this);
}
// 判断int
String.prototype.isInt = function(){
	if(this=="NaN") return false;
    return this==parseInt(this).toString(); 
}
// 判断中文
String.prototype.isChinese = function(){
    return /^[\u4e00-\u9fa5]$/.test(this); 
}
// 判断日期格式(2009-02-02, 2001/02/01)只判断格式，不验证有效性
String.prototype.isDate = function(){
    return /^\d{4}[\/\-](0?[1-9]|1[012])[\/\-](0?[1-9]|[12][0-9]|3[01])$/.test(this); 
}
// 判断身份证
String.prototype.isIDCard = function(){
	if(this.length != 18){
		return false;
	}
	var id_number = this.toLowerCase();
	var va = [7,9,10,5,8,4,2,1,6,3,7,9,10,5,8,4,2];
	var ra = [1,0,'x',9,8,7,6,5,4,3,2];
	var size = va.length;
	var sum = 0;
	for(var i=0;i<size;i++){
		sum += parseInt(id_number[i]) * va[i];
	}
	return id_number[17] == ra[(sum % 11)];
}

//数据去重
Array.prototype.unique = function(isStrict){
	if (!this.length)
		return [];
	if (this.length < 2)
		return [this[0]] || [];
	var tempObj = {}, newArr = [];
	for (var i = 0; i < this.length; i++) {
		var v = this[i];
		var condition = isStrict ? (typeof tempObj[v] != typeof v) : false;
		if ((typeof tempObj[v] == "undefined") || condition) {
			tempObj[v] = v;
			newArr.push(v);
		}
	}
	return newArr;
}

//空值删除
Array.prototype.trim = function(){
	for (var i=0;i<this.length;i++){
		if (!this[i] || (this[i]+'').trim()==''){
			this.splice(i,1);
			i--;
		}
	}
	return this;
}

//数据去重+空值删除
Array.prototype.uniqueTrim = function(isStrict){
	var arr=this.unique(isStrict);
	return arr.trim();
}