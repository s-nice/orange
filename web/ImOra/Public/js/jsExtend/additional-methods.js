$.validator.addMethod("isPhoneNum", function(value, element) {
    return this.optional(element) || (/^1[3|4|5|7|8][0-9]{9}$/.test(value));
}, "请输入正确的手机号码");