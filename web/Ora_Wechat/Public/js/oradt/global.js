(function ($) {
    $.extend({
        dataTimeLoad: {
            format: 'Y-m-d',
            timepicker: false,
            idArr: [{start: 'js_begintime', end: 'js_endtime'}],
            minDate: {},
            maxDate: {},
            init: function (settings) {
                //初始化最大最小值
                var _this = this;
                _this.initMinMax();
                /* 初始化 */
                if (typeof settings == 'object') {
                    if (typeof settings.format == 'string') {
                        this.format = settings.format;
                    } else {
                        this.format = 'Y-m-d';
                    }
                    if (typeof settings.timepicker == 'boolean') {
                        this.timepicker = settings.timepicker;
                    } else {
                        this.timepicker = false;
                    }
                    if (typeof settings.idArr == 'object') {
                        this.idArr = settings.idArr;
                    } else {
                        this.idArr = [{start: 'js_begintime', end: 'js_endtime'}];
                    }
                    if (typeof settings.minDate == 'object') {
                        $.extend(this.minDate, settings.minDate);
                    }
                    if (typeof settings.maxDate == 'object') {
                        $.extend(this.maxDate, settings.maxDate);
                    }
                    this.statistic = false;
                    if (settings.statistic) {
                        this.statistic = settings.statistic;
                    }
                }
                // 删除
                $('.select_time_c').on('click', '.js_delTimeStr', function () {
                    var $this = $(this).parents('.time_c').find('input');
                    $this.val('');
                    $.dataTimeLoad.timeClassFn($this);
                    var se_type = $this.attr('se_type'), obj;
                    if (se_type == 'start') {
                        obj = {'maxDate': _this.maxDate.end, 'minDate': _this.minDate.end};
                    } else {
                        obj = {'maxDate': _this.maxDate.start, 'minDate': _this.minDate.start};
                    }
                    $('#' + $this.attr('idClass')).datetimepicker(obj);
                });
                // 选择时间
                $('.select_time_c').on('click', '.js_selectTimeStr', function () {
                    $(this).parents('.time_c').find('input').focus();
                });
                var x;
                for (x in this.idArr) {
                    $.dataTimeLoad.timeLoad(this.idArr[x], this.format);
                }
            },
            // 非用户统计页面的初始化
            timeLoad: function (option, format) {
                var _this = this;
                var beginObj = $('#' + option.start);
                var endObj = $('#' + option.end);
                beginObj.attr('idClass', option.end);
                beginObj.attr('se_type', 'start'),
                    endObj.attr('idClass', option.start);
                endObj.attr('se_type', 'end');

                // 删除|选择class判断
                $.dataTimeLoad.timeClassFn(beginObj);
                $.dataTimeLoad.timeClassFn(endObj);
                // 开始时间参数
                var beginOption;
                if (this.statistic) {
                    var maxDate = new Date();

                    switch (this.statistic) {
                        case 'm':
                            maxDate = maxDate.firstDayOfMonth().addDate(-1).clearTime().format();
                            break;
                        case 'w':
                            maxDate = maxDate.mondayOfWeek().addDate(-1).clearTime().format();
                            break;
                        default:
                            maxDate = maxDate.addDate(-1).clearTime().format();
                            break;
                    }
                    beginOption = {
                        maxDate: maxDate,
                        format: format,
                        lang: 'ch',
                        showWeak: true,
                        formatDate: format,
                        timepicker: _this.timepicker,
                        validateOnBlur: false,
                        onSelectDate: function (d, obj) {
                            var date = _this.getSearchDate(obj.val(), true, _this.statistic);
                            endObj.datetimepicker({'maxDate': date.format(), 'minDate': obj.val()}).val('');
                        },
                        onClose: function () {
                            $.dataTimeLoad.timeClassFn(beginObj);
                        },
                        onGenerate: function (d, obj) {
                            var date = _this.getSearchDate(obj.val(), true, _this.statistic);
                            endObj.datetimepicker({'maxDate': date.format(), 'minDate': obj.val()});
                        }
                    };
                } else {

                    beginOption = {
                        minDate: _this.minDate.start,
                        maxDate: _this.maxDate.start,
                        format: format,
                        lang: 'ch',
                        showWeak: true,
                        formatDate: format,
                        timepicker: _this.timepicker,
                        validateOnBlur: false,
                        onSelectDate: function () {
                            var starttime = beginObj.val();
                            endObj.datetimepicker({'minDate': _this.getMaxDate(starttime, _this.minDate.end)});
                        },
                        onClose: function () {
                            $.dataTimeLoad.timeClassFn(beginObj);
                        }
                    };
                    if (endObj.val() != '') {
                        beginOption.maxDate = _this.getMinDate(endObj.val(), _this.maxDate.start);
                    }
                }
                beginObj.datetimepicker(beginOption);

                // 结束时间参数,
                var endOption;
                if (this.statistic) {
                    endOption = {
                        format: format,
                        lang: 'ch',
                        showWeak: true,
                        formatDate: format,
                        timepicker: _this.timepicker,
                        validateOnBlur: false
                    };
                } else {
                    endOption = {
                        maxDate: _this.maxDate.end,
                        minDate: _this.minDate.end,
                        format: format,
                        lang: 'ch',
                        showWeak: true,
                        formatDate: format,
                        timepicker: _this.timepicker,
                        validateOnBlur: false,
                        onSelectDate: function () {
                            var endtime = endObj.val();
                            beginObj.datetimepicker({'maxDate': _this.getMinDate(endtime, _this.maxDate.start)});
                        },
                        onClose: function () {
                            $.dataTimeLoad.timeClassFn(endObj);
                        }
                    };
                }

                if (beginObj.val() != '') {
                    endOption.minDate = _this.getMaxDate(beginObj.val(), _this.minDate.end);
                }
                endObj.datetimepicker(endOption);
            },
            // 选择|删除class判断
            timeClassFn: function (obj) {
                if (obj.val() != '') {
                    obj.parents('.time_c').find('i').removeClass('js_selectTimeStr').addClass('js_delTimeStr').find('img').remove();
                } else {
                    obj.parents('.time_c').find('i').removeClass('js_delTimeStr').addClass('js_selectTimeStr').find('img').remove();
                }
            },
            /**
             * 传入开始时间或者结束时间返回结果时间
             * @param str date 时间（字符串或者DATE类型）
             * @param bool isStartDate （开始时间传true，结束时间传false）
             * @param str type （m月统计，w周统计，d日统计）
             * return date
             */
            getSearchDate: function (date, isStartDate, type) {
                if (typeof(date) == 'string') {
                    date = date.toDate();
                }
                date.clearTime();
                var rdate = new Date(date.getTime()).clearTime();
                var today = new Date().clearTime();

                //传过来的是开始时间，求结束时间
                if (isStartDate) {
                    switch (type) {
                        case 'w':
                            rdate.addDate(7 * 12 - rdate.getDay());

                            //如果结束日期比今天还要大，则是上周日
                            var today = new Date();
                            if (rdate.getTime() >= today.getTime()) {
                                rdate = today.addDate(-today.getDay());
                            }
                            break;
                        case 'm':
                            rdate.addFullYear(1).firstDayOfMonth().addDate(-1);

                            //如果结束日期比今天还要大，则是上个月底
                            today.firstDayOfMonth();
                            if (rdate.getTime() > today.getTime()) {
                                rdate = today.addDate(-1);
                            }
                            break;
                        case 'd3':
                            rdate.addDate(90);
                            if (rdate.getTime() >= today.getTime()) {
                                rdate = today.addDate(-1);
                            }
                            break;
                        default:
                            rdate.addDate(30);
                            if (rdate.getTime() >= today.getTime()) {
                                rdate = today.addDate(-1);
                            }
                    }
                }

                //传过来的是结束时间，求开始时间
                if (!isStartDate) {
                    switch (type) {
                        case 'w':
                            rdate.addDate(-7 * 12 - rdate.getDay() + 1);
                            break;
                        case 'm':
                            rdate.addFullYear(-1).firstDayOfMonth().addMonth(1);
                            if (date.getFullYear() == today.getFullYear() && date.getMonth() == today.getMonth()) {
                                rdate.addMonth(-1)
                            }
                            break;
                        case 'd3':
                            rdate.addDate(-90);
                            break;
                        default:
                            rdate.addDate(-30);
                    }
                }
                return rdate;
            },

            //默认最大值为今天，最小值无
            initMinMax: function () {
                this.minDate.start = false;
                this.minDate.end = false;
                this.maxDate.start = Date();
                this.maxDate.end = Date();
            },

            //获取两个时间中的小的时间
            getMinDate: function (a, b) {
                if (a === false) {
                    return b;
                }
                if (b === false) {
                    return a;
                }
                if (new Date(a) > new Date(b)) {
                    return b;
                } else {
                    return a;
                }
            },
            //获取两个时间中大的时间
            getMaxDate: function (a, b) {
                if (a === false) {
                    return b;
                }
                if (b === false) {
                    return a;
                }
                if (new Date(a) < new Date(b)) {
                    return b;
                } else {
                    return a;
                }
            },
        }
    });
})(jQuery);

/**
 * 日期格式化
 * @param string format
 */
Date.prototype.format = function (format) {
    format = format || 'Y-m-d';
    var y = this.getFullYear();
    var m = this.getMonth() + 1;
    var d = this.getDate();
    var h = this.getHours();
    var i = this.getMinutes();
    var s = this.getSeconds();
    // 不足两位， 前面补0
    m = m < 10 ? ('0' + m) : m;
    d = d < 10 ? ('0' + d) : d;
    h = h < 10 ? ('0' + h) : h;
    i = i < 10 ? ('0' + i) : i;
    s = s < 10 ? ('0' + m) : s;

    return format.replace('Y', y).replace('m', m).replace('d', d)
        .replace(/h/i, h).replace('i', i).replace('s', s)

        ;
};

/**
 * 日期加减
 * @param int num
 */
Date.prototype.addDate = function (num) {
    this.setDate(this.getDate() + num);
    return this;
};

/**
 * 月份加减
 * @param int num
 */
Date.prototype.addMonth = function (num) {
    this.setMonth(this.getMonth() + num);
    return this;
};

/**
 * 年加减
 * @param int num
 */
Date.prototype.addFullYear = function (num) {
    this.setFullYear(this.getFullYear() + num);
    return this;
};

/**
 * 时分秒清零
 */
Date.prototype.clearTime = function () {
    this.setHours(0);
    this.setMinutes(0);
    this.setSeconds(0);
    this.setMilliseconds(0);
    return this;
};

/**
 * 当前月的第一天
 */
Date.prototype.firstDayOfMonth = function () {
    this.setDate(1);
    return this;
};

/**
 * 当前周的星期一
 */
Date.prototype.mondayOfWeek = function () {
    var day = this.getDay();
    if (day == 1) {
        return this;
    }

    if (day == 0) {
        return this.addDate(-6);
    }
    return this.addDate(-(day - 1));
};

/**
 * 字符串转时间
 * @param string format
 */
String.prototype.toDate = function (format) {
    var date = new Date();
    format = format || 'Y-m-d';
    var separator = this.match(/[/-]/);
    var strList = this.split(separator);
    var formatList = format.split(separator);
    for (var i = 0; i < formatList.length; i++) {
        switch (formatList[i]) {
            case 'Y':
                date.setFullYear(parseInt(strList[i]));
                break;
            case 'm':
                date.setMonth(parseInt(strList[i]) - 1);
                break;
            case 'd':
                date.setDate(parseInt(strList[i]));
                break;
            case 'H':
                date.setHours(parseInt(strList[i]));
                break;
            case 'i':
                date.setMinutes(parseInt(strList[i]));
                break;
            case 's':
                date.setSeconds(parseInt(strList[i]));
                break;
        }
    }
    return date;
};