<layout name="../Layout/Company/AdminLTE_layout"/>
<div class="tree-main">
    <div class="top-null"></div>
    <div class="division-content">
        <div class="division-nav">
            <a href="{:U(MODULE_NAME.'/AdminSet/index','','',true)}"><span>权限设置</span></a>
            <a href="{:U(MODULE_NAME.'/Departments/index','','',true)}"><span>部门管理</span></a>
            <a href="{:U(MODULE_NAME.'/Staff/index','','',true)}"><span>员工管理</span></a>
            <a href="{:U(MODULE_NAME.'/Label/index','','',true)}"><span>标签管理</span></a>
            <a href="{:U(MODULE_NAME.'/Payment/index','','',true)}"><span class="active">套餐管理</span></a>
        </div>
        <div class="division-con js_contents">
            <div class="divi-right">
                <div class="main">
                    <style>
                        @charset "utf-8";
                        html
                        .iu_none {
                            display: none
                        }

                        html
                        .iu_hidden {
                            visibility: hidden
                        }

                        html
                        .iu_overflow_hidden {
                            overflow: hidden
                        }

                        html
                        .iu_absolute {
                            position: absolute
                        }

                        html
                        .iu_relative {
                            position: relative
                        }

                        html
                        .iu_align_left {
                            text-align: left
                        }

                        html
                        .iu_align_center {
                            text-align: center
                        }

                        html
                        .iu_align_right {
                            text-align: right
                        }

                        html
                        .iu_clear {
                            clear: both
                        }

                        html
                        .iu_float_left {
                            float: left
                        }

                        html
                        .iu_float_right {
                            float: right
                        }

                        html
                        .iu_nowrap {
                            white-space: nowrap
                        }

                        html
                        .iu_icon {
                            display: inline-block;
                            background-repeat: no-repeat;
                            background-position: 50% 50%
                        }

                        .iu_autocomplete {
                            display: none;
                            position: absolute;
                            background-color: #fff;
                            height: auto;
                            border: 1px solid #ddd;
                            margin-top: -1px;
                            width: 162px !important;
                            padding-left: 0
                        }

                        .iu_autocomplete
                        li {
                            overflow: hidden;
                            padding-top: 3px;
                            padding-bottom: 3px;
                            padding-left: 10px;
                            color: #666;
                            font-size: 12px;
                            text-align: left;
                            height: 15px;
                            cursor: pointer
                        }

                        .iu_autocomplete_li_selected {
                            background-color: #E6E6E6
                        }

                        .iu_autocomplete_li_hightlight {
                            font-weight: bold;
                            color: black
                        }

                        .clear_fd {
                            display: block;
                            height: 0px;
                            overflow: hidden;
                            clear: both
                        }

                        .iu_datepicker {
                            border: 1px solid #c2c2c2;
                            position: absolute;
                            background-color: white;
                            z-index: 99999992;
                            font-size: 16px;
                            display: none;
                            overflow: hidden;
                            box-shadow: 0 2px 5px rgba(51, 51, 51, .3);
                            box-shadow: 0 0 0 \9;
                            border-radius: 2px
                        }

                        .iu_datepicker_title {
                            display: block
                        }

                        .iu_datepicker_inline {
                            position: relative;
                            display: inline-block;
                            *display: inline;
                            *zoom: 1
                        }

                        .iu_datepicker
                        i {
                            font-style: normal
                        }

                        .iu_datepicker_prev, .iu_datepicker_next {
                            position: absolute;
                            width: 30px;
                            height: 30px;
                            z-index: 1;
                            top: 10px;
                            cursor: pointer
                        }

                        .iu_datepicker_prev {
                            left: 8px;
                            background: url(../../images/iu_datepicker_prev_201409041730.png) 50% 50% no-repeat
                        }

                        .iu_datepicker_next {
                            right: 9px;
                            background: url(../../images/iu_datepicker_next_201409041730.png) 50% 50% no-repeat
                        }

                        .iu_datepicker_header {
                            text-align: center;
                            border-bottom: 1px solid #e5e5e5;
                            height: 50px;
                            line-height: 50px;
                            margin-bottom: 3px
                        }

                        .iu_datepicker_header, .iu_datepicker_body {
                            margin-left: 10px;
                            margin-right: 10px
                        }

                        .iu_datepicker_body
                        td {
                            display: inline-block;
                            float: left;
                            width: 40px;
                            height: auto;
                            min-height: 2px
                        }

                        .iu_datepicker_year, .iu_datepicker_month {
                            position: relative;
                            cursor: pointer;
                            color: #333;
                            font-size: 12px;
                            font-weight: bold
                        }

                        .iu_datepicker_month {
                            margin-left: 4px
                        }

                        .iu_datepicker_calendars {
                            position: relative;
                            overflow: hidden;
                            border-radius: 2px
                        }

                        .iu_datepicker_calendars .iu_datepicker_border_left
                        .iu_datepicker_header {
                        }

                        .iu_datepicker_calendars .iu_datepicker_border_left
                        .iu_datepicker_body {
                        }

                        .iu_datepicker_calendar {
                            display: inline-block;
                            position: relative;
                            float: left
                        }

                        .iu_datepicker_calendar
                        .iu_datepicker_body {
                            border-collapse: collapse;
                            display: block
                        }

                        .iu_datepicker_others .iu_datepicker_body
                        td {
                            height: 20px
                        }

                        .iu_datepicker_calendar .iu_datepicker_body
                        td {
                            padding: 0px;
                            vertical-align: middle;
                            text-align: center;
                            font-size: 13px;
                            color: #6E6E6E
                        }

                        .iu_datepicker_calendar .iu_datepicker_body .iu_datepicker_title
                        td {
                            color: #acacac
                        }

                        .iu_datepicker_calendar .iu_datepicker_title
                        td {
                            padding-top: 5px;
                            padding-bottom: 5px
                        }

                        .iu_datepicker_calendar .iu_datepicker_body td:hover {
                            background: none
                        }

                        .iu_datepicker_calendar .iu_datepicker_weekend, .iu_datepicker_calendar .iu_datepicker_weekend
                        a {
                            color: #F93
                        }

                        .iu_datepicker_calendar .iu_datepicker_selected
                        a {
                            color: #fff
                        }

                        .iu_datepicker_calendar .iu_datepicker_body
                        a {
                            display: block;
                            text-align: right;
                            cursor: pointer;
                            transition-duration: 0.2s;
                            transition-property: background-color, color
                        }

                        .iu_datepicker_dateview .iu_datepicker_body
                        a {
                            width: 40px;
                            height: 40px;
                            line-height: 40px;
                            text-align: center;
                            color: #333
                        }

                        .iu_datepicker_dateview .iu_datepicker_today
                        a {
                            width: 36px;
                            height: 36px;
                            line-height: 36px;
                            border: 2px solid #e5e5e5
                        }

                        .iu_datepicker_dateview .iu_datepicker_selected
                        a {
                            width: 40px;
                            height: 40px;
                            line-height: 40px;
                            color: #fff;
                            background-color: #F93
                        }

                        .iu_datepicker_monthview .iu_datepicker_body
                        td {
                            padding: 0px 15px 20px
                        }

                        .iu_datepicker_monthview .iu_datepicker_body
                        a {
                            width: 40px;
                            height: 40px;
                            line-height: 40px;
                            text-align: center
                        }

                        .iu_datepicker_monthview
                        .iu_datepicker_month {
                            display: none
                        }

                        .iu_datepicker_yearview .iu_datepicker_body
                        td {
                            padding: 0px 15px 20px
                        }

                        .iu_datepicker_yearview .iu_datepicker_body
                        a {
                            width: 40px;
                            height: 40px;
                            line-height: 40px;
                            text-align: center
                        }

                        .iu_datepicker_yearview
                        .iu_datepicker_year {
                            cursor: default
                        }

                        .iu_datepicker_yearview
                        .iu_datepicker_body {
                        }

                        .iu_datepicker_calendar .iu_datepicker_disabled, .iu_datepicker_calendar .iu_datepicker_disabled a, .iu_datepicker_calendar .iu_datepicker_disabled a:hover {
                            cursor: not-allowed;
                            background-color: transparent;
                            color: #aaa
                        }

                        .iu_datepicker_calendar .iu_datepicker_other
                        a {
                            color: #ccc
                        }

                        .iu_datepicker_calendar .iu_datepicker_other.iu_datepicker_disabled a:hover {
                            color: #ccc
                        }

                        .iu_datepicker_dateview td.iu_datepicker_today:hover, .iu_datepicker_dateview td.iu_datepicker_selected:hover {
                            background-color: #f5f5f5
                        }

                        .iu_datepicker_calendar td a:hover {
                            background-color: #f5f5f5
                        }

                        .iu_datepicker_calendar td.iu_datepicker_selected a, .iu_datepicker_dateview td.iu_datepicker_selected
                        a {
                            background-color: #F93;
                            color: #fff;
                            width: 40px;
                            height: 40px;
                            line-height: 40px;
                            border: 0px solid #F93
                        }

                        .iu_datepicker_thumb {
                            position: absolute;
                            left: 0;
                            top: 42px;
                            width: 100%;
                            text-align: center;
                            font-size: 7em;
                            color: #eee;
                            z-index: -1;
                            display: none
                        }

                        .iu_datepicker_others
                        .iu_datepicker_thumb {
                            top: 53px
                        }

                        .iu_datepicker_buttons {
                            border-top: 1px solid #ccc;
                            background-color: #f5f5f5;
                            height: auto;
                            min-height: 45px;
                            line-height: 45px;
                            padding: 0px;
                            margin: 0px
                        }

                        .iu_align_left .iu_datepicker_button:first-child {
                            margin-left: 0
                        }

                        .iu_align_right .iu_datepicker_button:last-child {
                            margin-right: 0
                        }

                        .iu_datepicker_button {
                            display: inline-block;
                            margin: 0 8px;
                            cursor: pointer;
                            text-align: center;
                            padding: 4px 0px;
                            background-repeat: no-repeat;
                            font-size: 14px;
                            border-radius: 2px
                        }

                        .iu_datepicker_button, .iu_datepicker_button:hover {
                            text-decoration: none
                        }

                        .iu_datepicker_button_0 {
                            color: #272727;
                            background-color: #B5B5B5;
                            border-bottom: 1px solid #3b3b3b
                        }

                        .iu_datepicker_button_0:hover {
                            background-color: #949494
                        }

                        .iu_datepicker_button_1 {
                            color: #222;
                            background-color: #E2E2E2;
                            border-bottom: 1px solid #888
                        }

                        .iu_datepicker_button_1:hover {
                            background-color: #D8D8D8
                        }

                        .iu_datepicker_button_0, .iu_datepicker_button_1, .iu_datepicker_button_2, .iu_datepicker_button_3, .iu_datepicker_button_4, .iu_datepicker_button_5, .iu_datepicker_button_6 {
                            background: none;
                            border-bottom: 0px;
                            color: #707070
                        }

                        .iu_datepicker_button_0:hover, .iu_datepicker_button_1:hover, .iu_datepicker_button_2:hover, .iu_datepicker_button_3:hover, .iu_datepicker_button_4:hover, .iu_datepicker_button_5:hover, .iu_datepicker_button_6:hover {
                            background: none
                        }

                        .iu_datepicker_button_1, .iu_datepicker_button_3, .iu_datepicker_button_5 {
                            margin: 0px
                        }

                        .iu_datepicker_button_line {
                            color: #acacac;
                            margin-left: 10px;
                            margin-right: 10px
                        }

                        .iu_datepicker_button_text {
                            font-size: 12px;
                            font-weight: bold;
                            color: #707070
                        }

                        .iu_datepicker_select {
                            position: relative;
                            height: 24px;
                            background: white;
                            margin: 13px 0;
                            border: 1px solid #ccc;
                            border-radius: 2px;
                            vertical-align: top;
                            display: inline-block;
                            margin-left: 10px
                        }

                        .iu_datepicker_select:nth-child(2) {
                            margin-left: 4px
                        }

                        .iu_datepicker_hour, .iu_datepicker_minute {
                            display: block;
                            min-width: 90px;
                            font-size: 14px;
                            padding: 0 8px 0 10px;
                            line-height: 24px;
                            cursor: pointer
                        }

                        .iu_datepicker_select_triangle {
                            position: absolute;
                            width: 0;
                            height: 0;
                            border: 4px solid transparent;
                            border-top-color: black;
                            top: 50%;
                            margin-top: -2px;
                            right: 4px
                        }

                        .iu_datepicker_hours, .iu_datepicker_minutes {
                            display: none;
                            position: absolute;
                            margin: 0;
                            padding: 0;
                            bottom: 26px;
                            width: 106px;
                            border: 1px solid #ccc;
                            border-radius: 2px;
                            background-color: white;
                            max-height: 243px;
                            overflow: auto;
                            z-index: 2;
                            list-style: inside;
                            font-size: 0.9em
                        }

                        .iu_datepicker_hours li, .iu_datepicker_minutes
                        li {
                            cursor: pointer;
                            padding: 2px 4px;
                            margin: 0 1px;
                            list-style: none;
                            line-height: 24px
                        }

                        .iu_datepicker_hours li:hover, .iu_datepicker_minutes li:hover {
                            background-color: #f5f5f5;
                            color: #333
                        }

                        .iu_datepicker_hours li.iu_datepicker_hour_selected:hover {
                            background-color: #F93;
                            color: #fff
                        }

                        .iu_datepicker_hours .iu_datepicker_hour_selected,
                        .iu_datepicker_minutes .iu_datepicker_minute_selected, .iu_datepicker_period {
                            background-color: #F93;
                            color: #fff
                        }

                        .iu_datepicker_calendar td.iu_datepicker_period
                        a {
                            background-color: #F93;
                            color: #fff
                        }

                        .iu_datepicker_dateview .iu_datepicker_selected a:hover,
                        .iu_datepicker_period a:hover {
                            background-color: #F93;
                            color: #fff
                        }

                        .iu_dialog_panel {
                            position: fixed;
                            top: 0px;
                            left: 0px;
                            width: 100%;
                            height: 100%;
                            z-index: 10001
                        }

                        .iu_dialog_mask {
                            position: absolute;
                            top: 0;
                            left: 0;
                            width: 100%;
                            height: 100%;
                            background-color: #000;
                            opacity: 0.3;
                            filter: alpha(opacity=30)
                        }

                        .iu_dialog {
                            position: absolute;
                            background-color: white;
                            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
                            box-shadow: 0 0 0 \9;
                            min-height: 40px;
                            min-width: 350px;
                            border-radius: 5px
                        }

                        .iu_dialog_title {
                            font-size: 16px;
                            padding: 10px 20px;
                            border-bottom: 1px solid #B8B8B8;
                            background-color: #D8D8D8
                        }

                        .iu_dialog_close {
                            position: absolute;
                            width: 30px;
                            height: 30px;
                            top: 11px;
                            right: 11px;
                            cursor: pointer;
                            background-position: 50% 50%;
                            background-repeat: no-repeat;
                            background: url(../../images/ico/cc_btn_ico_20141229160000.png) no-repeat;
                            background-position: 9px -221px
                        }

                        .iu_dialog_close:hover {
                            background-position: 9px -264px
                        }

                        .iu_dialog_close_text {
                            display: none;
                            font-weight: bold
                        }

                        .iu_dialog_close_text:hover {
                            text-shadow: 0 0 4px #232
                        }

                        .iu_dialog_content {
                            padding: 30px 20px 15px 20px;
                            border-radius: 5px
                        }

                        .iu_dialog_buttons {
                            padding: 10px 20px;
                            background-color: #f5f5f5;
                            border-top: 1px solid #D5D9DC;
                            border-bottom-left-radius: 5px;
                            border-bottom-right-radius: 5px
                        }

                        .iu_align_left .iu_dialog_button:first-child {
                            margin-left: 0
                        }

                        .iu_align_right .iu_dialog_button:last-child {
                            margin-right: 0
                        }

                        .iu_dialog_button {
                            display: inline-block;
                            margin: 0px 5px;
                            cursor: pointer;
                            text-align: center;
                            min-width: 50px;
                            height: 28px;
                            padding: 0 15px;
                            line-height: 28px;
                            background-repeat: no-repeat;
                            border-radius: 3px
                        }

                        .iu_dialog_button, .iu_dialog_button:hover {
                            text-decoration: none
                        }

                        .iu_dialog_button_text {
                            font-size: 12px;
                            font-weight: bold
                        }

                        .iu_dialog_button_0 {
                            color: #707070;
                            background-color: white;
                            border: 1px solid #ccc;
                            cursor: pointer;
                            background-image: url(about:blank);
                            background: -moz-linear-gradient(top, #ffffff, #f5f5f5);
                            background: -webkit-linear-gradient(top, #ffffff, #f5f5f5);
                            background: -o-linear-gradient(top, #ffffff, #f5f5f5);
                            background: -ms-linear-gradient(top, #ffffff, #f5f5f5);
                            -ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0,startColorstr=#ffffff,endColorstr=#f5f5f5)";
                            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#ffffff, endColorstr=#f5f5f5)
                        }

                        .iu_dialog_button_0:hover {
                            border: 1px solid #c2c2c2;
                            box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.1)
                        }

                        .iu_dialog_button_0:active {
                        }

                        .iu_dialog_small
                        .iu_dialog_button_0 {
                            background: none;
                            color: #707070;
                            background-color: white;
                            border: 1px solid #ccc
                        }

                        .iu_dialog_button_1 {
                            color: white;
                            background: #2D4051;
                            border: 1px solid #2D4051;
                            box-shadow: 0 1px 2px rgba(0, 0, 0, .1)
                        }

                        .iu_dialog_button_1:hover {
                            background: #243341;
                            border-color: #243341;
                            color: #fff;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, .15);
                            box-shadow: 0px 2px 1px #d9d9d9 \0
                        }

                        .iu_dialog_button_1.iu_dialog_button_disable {
                            background-color: #abb3b9;
                            border-color: #abb3b9;
                            box-shadow: none
                        }

                        .corp
                        .iu_dialog_button_danger {
                            background-color: #f26c4f;
                            color: white;
                            border: 1px solid #f26c4f
                        }

                        .corp .iu_dialog_button_danger:hover {
                            background-color: #eb6042;
                            border: 1px solid #eb6042;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.15);
                            box-shadow: 0px 2px 1px #d9d9d9 \0
                        }

                        .iu_dialog_button_disable {
                            cursor: default;
                            border: 1px solid #A4CEE0;
                            box-shadow: 0 1px #A4CEE0
                        }

                        .iu_dialogalert
                        .iu_dialog_content {
                            text-align: center
                        }

                        .iu_icon_dialog_alert {
                            width: 23px;
                            height: 21px;
                            background-image: url(../../images/dialog_alert_icon.png);
                            position: relative;
                            top: 4px;
                            margin-right: 10px;
                            display: none !important
                        }

                        .iu_icon_dialog_confirm {
                            width: 23px;
                            height: 21px;
                            background-image: url(../../images/dialog_alert_icon.png);
                            position: relative;
                            top: 4px;
                            margin-right: 10px
                        }

                        .iu_dialogprompt
                        .iu_dialog_content {
                            text-align: center
                        }

                        .iu_dialogprompt_title {
                            margin-right: 10px
                        }

                        .iu_dialog_button_orange {
                            background-color: #f26c4f;
                            color: white;
                            border: 1px solid #f26c4f
                        }

                        .iu_dialog_button_orange:hover {
                            background-color: #eb6042;
                            border: 1px solid #eb6042;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.15);
                            box-shadow: 0 2px 1px rgb(0, 0, 0) \0
                        }

                        .iu_dialog_button_deepblue {
                            color: white;
                            background-color: #2D4051;
                            border: 1px solid #2D4051;
                            box-shadow: 0 1px 2px rgba(0, 0, 0, .1)
                        }

                        .iu_dialog_button_deepblue:hover {
                            background-color: #243341;
                            border-color: #243341;
                            color: #fff;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, .15)
                        }

                        .iu_dialog_button_deepblue.iu_dialog_button_disable {
                            background-color: #abb3b9;
                            border-color: #abb3b9;
                            box-shadow: none
                        }

                        .iu_dialogconfirm
                        .iu_dialog {
                            background-color: #fff;
                            color: #333;
                            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.2);
                            box-shadow: 0 0 0 \9;
                            width: 550px;
                            height: 300px;
                            border-radius: 5px;
                            position: relative;
                            text-align: center
                        }

                        .iu_dialogconfirm
                        .iu_dialog_title {
                            width: 450px;
                            padding: 55px 50px 0px;
                            font-size: 18px;
                            border: 0px solid #fff;
                            background-color: #fff;
                            margin-top: 0px;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            word-wrap: normal;
                            font-weight: bold;
                            border-radius: 5px
                        }

                        .iu_dialogconfirm
                        .iu_dialog_content {
                            width: 450px;
                            max-height: 120px;
                            padding: 40px 50px 0px;
                            font-size: 12px;
                            margin-top: 0px;
                            line-height: 20px;
                            word-wrap: break-word;
                            overflow: hidden
                        }

                        .iu_dialogconfirm
                        .iu_icon_dialog_confirm {
                            display: none
                        }

                        .iu_dialogconfirm
                        .iu_dialog_buttons {
                            width: 510px;
                            position: absolute;
                            bottom: 0px
                        }

                        .iu_dialogconfirm_notitle
                        .iu_dialog_content {
                            font-size: 16px;
                            margin-top: 59px;
                            color: #333;
                            line-height: normal;
                            padding-top: 0px
                        }

                        .iu_dialogconfirm_notitle .iu_dialog_content
                        a {
                            color: #1b84b2;
                            cursor: pointer;
                            display: inline-block
                        }

                        .corp .iu_dialog_danger
                        .iu_dialog_button_1 {
                            background-color: #f26c4f;
                            color: white;
                            border: 1px solid #f26c4f
                        }

                        .corp .iu_dialog_danger .iu_dialog_button_1:hover {
                            background-color: #eb6042;
                            border: 1px solid #eb6042;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.15);
                            box-shadow: none \0
                        }

                        .iu_dialog_small
                        .iu_dialog {
                            width: 400px;
                            height: 250px;
                            position: relative
                        }

                        .iu_dialog_small
                        .iu_dialog_content {
                            padding: 60px 50px 0px;
                            border-radius: 5px;
                            height: 80px;
                            line-height: 80px;
                            font-size: 12px;
                            overflow: hidden
                        }

                        .iu_dialog_small_content {
                            display: inline-block;
                            height: 20px;
                            line-height: 20px
                        }

                        .iu_dialog_small
                        .iu_dialog_buttons {
                            position: absolute;
                            bottom: 0px;
                            width: 360px
                        }

                        .iu_dialog_small
                        .iu_dialog_button_0 {
                            color: white;
                            background-color: #2D4051;
                            border: 1px solid #2D4051;
                            box-shadow: 0 1px 2px rgba(0, 0, 0, .1)
                        }

                        .iu_dialog_small .iu_dialog_button_0:hover {
                            background-color: #243341;
                            border-color: #243341;
                            color: #fff;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, .15)
                        }

                        .iu_dialog_small
                        .iu_dialog_button_0.iu_dialog_button_disable {
                            background-color: #abb3b9;
                            border-color: #abb3b9;
                            box-shadow: none
                        }

                        .iu_dialog_mastlarge
                        .iu_dialog {
                            width: 700px;
                            height: 550px;
                            overflow: hidden
                        }

                        .iu_dialog_mastlarge
                        .iu_dialog_content {
                            padding: 60px 50px 0px;
                            height: 439px
                        }

                        .iu_dialog_loading
                        .iu_dialog {
                            min-width: 300px;
                            width: 300px;
                            height: 200px;
                            overflow: hidden
                        }

                        .iu_dialog_loading
                        .iu_dialog_buttons {
                            display: none
                        }

                        .iu_dialog_loading
                        .iu_dialog_content {
                            padding: 0px;
                            width: 100%;
                            height: 65px;
                            margin: 76px auto 0px;
                            text-align: center
                        }

                        .iu_dialog_loading
                        .loading_gif {
                            background: url(../../images/loading/login_loading_company.gif) no-repeat scroll 0px 0px transparent;
                            width: 48px;
                            height: 48px;
                            position: static;
                            margin: 0px auto 0px
                        }

                        .iu_dialog_loading
                        .loading_msg {
                            color: #707070;
                            margin-top: 10px
                        }

                        @media (max-width: 800px) {
                            .iu_dialogconfirm .iu_dialog, .iu_dialog_small
                            .iu_dialog {
                                width: 95%;
                                min-width: 0px;
                                overflow: hidden
                            }

                            .iu_dialogconfirm .iu_dialog_title, .iu_dialogconfirm .iu_dialog_content, .iu_dialog_small .iu_dialog_title, .iu_dialog_small
                            .iu_dialog_content {
                                width: auto
                            }

                            .iu_dialogconfirm .iu_dialog_buttons, .iu_dialog_small
                            .iu_dialog_buttons {
                                width: 100%;
                                padding-left: 0px;
                                padding-right: 0px
                            }

                            .iu_align_right .iu_dialog_button:last-child {
                                margin-right: 20px
                            }

                            .iu_dialogconfirm .iu_align_right .iu_dialog_button:last-child, .iu_dialog_small .iu_align_right .iu_dialog_button:last-child {
                                margin-right: 30px
                            }

                            .iu_dialogconfirm
                            .iu_dialog_title {
                                padding-top: 30px
                            }

                            .iu_dialogconfirm
                            .iu_dialog_content {
                                padding-top: 20px
                            }

                            .iu_dialogconfirm
                            .iu_dialog {
                                height: 230px
                            }

                            .iu_dialog_small
                            .iu_dialog {
                                height: auto;
                                min-height: 150px;
                                padding-bottom: 40px
                            }

                            .iu_dialog_small
                            .iu_dialog_content {
                                height: auto;
                                line-height: normal
                            }
                        }

                        .iu_menu {
                            display: none;
                            position: absolute;
                            border: 1px solid #acacac;
                            padding: 7px 0px;
                            margin: 2px 0px 0px;
                            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
                            box-shadow: 0px 4px 10px #ddd \0;
                            font-size: 12px;
                            background-color: white;
                            color: #333;
                            z-index: 1;
                            border-radius: 2px
                        }

                        .iu_menu_icon {
                            display: inline-block;
                            position: relative;
                            top: 3px;
                            width: 16px;
                            height: 16px;
                            background-position: 50% 50%;
                            background-repeat: no-repeat;
                            margin-right: 10px
                        }

                        .iu_menu_left .iu_menu_li
                        .iu_menu {
                            left: auto;
                            right: 100%
                        }

                        .iu_menu
                        li {
                            margin: 0px;
                            padding: 0px 20px;
                            height: 30px;
                            line-height: 30px;
                            position: relative;
                            list-style: none;
                            cursor: pointer;
                            background-repeat: no-repeat;
                            text-align: left
                        }

                        .iu_menu_li:hover {
                            background-color: #f5f5f5
                        }

                        .iu_menu_li
                        .iu_menu {
                            position: absolute;
                            display: none;
                            left: 100%;
                            top: 0
                        }

                        .iu_menu_li:hover > .iu_menu {
                            display: block
                        }

                        .iu_menu_li .iu_menu
                        .iu_menu_li {
                            white-space: nowrap
                        }

                        .iu_menu_li
                        a {
                            display: block;
                            text-decoration: none
                        }

                        .iu_menu_li.page_selected {
                            background-color: #f5f5f5
                        }

                        .iu_menu_li a[href]:hover {
                            text-decoration: underline
                        }

                        .iu_menu_sep {
                            height: 1px;
                            background-color: #CCC;
                            margin: 4px 10px
                        }

                        .iu_menu_icon_sub {
                            position: absolute;
                            right: 10px;
                            top: 14px;
                            width: 0;
                            height: 0;
                            border-right: none;
                            border-left: 6px solid black;
                            border-top: 4px solid transparent;
                            border-bottom: 4px solid transparent
                        }

                        .iu_menu_li:hover > .iu_menu_icon_sub {
                            border-left: 6px solid white
                        }

                        .ib .iu_menu, .ib .iu_menu_li
                        a {
                            letter-spacing: normal
                        }

                        .iu_notice {
                            position: absolute;
                            top: 5px;
                            left: 0;
                            min-width: 180px;
                            padding: 3px 30px;
                            height: 34px;
                            line-height: 34px;
                            text-align: center;
                            color: #897A53;
                            background-color: #F9EDBE;
                            border-radius: 2px;
                            font-size: 14px;
                            z-index: 10002;
                            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.3)
                        }

                        .iu_notice_level_1 {
                            background-color: #F26C4F
                        }

                        .iu_notice_level_0
                        .iu_notice_icon {
                            display: none
                        }

                        .iu_notice_icon {
                            display: inline-block;
                            background-repeat: no-repeat;
                            background-position: 50% 50%;
                            vertical-align: top
                        }

                        .iu_notice_icon_1 {
                            width: 4px;
                            height: 15px;
                            position: relative;
                            top: 8px;
                            background-image: url(../../images/notice/notice_icon_1_201503051800.png)
                        }

                        .iu_notice_icon_2 {
                            width: 13px;
                            height: 10px;
                            position: relative;
                            top: 12px;
                            background-image: url(../../images/notice/notice_icon_2_201503051800.png)
                        }

                        .iu_notice_level_3 {
                        }

                        .iu_notice_icon_3 {
                            border: 6px solid black;
                            border-right: none;
                            border-top-color: transparent;
                            border-bottom-color: transparent;
                            position: relative;
                            top: 9px
                        }

                        .iu_notice_text {
                            display: inline-block;
                            margin-left: 10px;
                            margin-right: 16px;
                            font-size: 12px;
                            font-weight: bold;
                            color: #333;
                            vertical-align: top
                        }

                        .iu_notice_level_1
                        .iu_notice_text {
                            color: #441119
                        }

                        .iu_notice_level_0
                        .iu_notice_text {
                            margin-left: 16px;
                            margin-right: 36px
                        }

                        .iu_notice_level_0
                        .iu_notice_close {
                            display: block
                        }

                        .iu_notice_close {
                            display: none;
                            position: absolute;
                            top: 16px;
                            right: 12px;
                            width: 12px;
                            height: 12px;
                            background: url(../../images/notice/notice_icon_close_yellow.png) no-repeat;
                            cursor: pointer
                        }

                        .iu_notice_close:hover {
                            background-image: url(../../images/notice/notice_icon_close_yellow_hover.png)
                        }

                        .iu_notice_level_0
                        .iu_notice_close {
                            background: url(../../images/notice/notice_icon_close_yellow.png) no-repeat
                        }

                        .iu_notice_level_0 .iu_notice_close:hover {
                            background-image: url(../../images/notice/notice_icon_close_yellow_hover.png)
                        }

                        .iu_notice_level_1
                        .iu_notice_close {
                            background: url(../../images/notice/notice_icon_close_red.png) no-repeat
                        }

                        .iu_notice_level_1 .iu_notice_close:hover {
                            background-image: url(../../images/notice/notice_icon_close_red_hover.png)
                        }

                        .iu_notice_left_title, .iu_notice_right_link {
                            display: inline-block;
                            vertical-align: top
                        }

                        .iu_notice_right_link {
                            text-decoration: none;
                            color: #1b84b2;
                            cursor: pointer
                        }

                        .iu_notice_level_1
                        .iu_notice_right_link {
                            color: #fffae6
                        }

                        .iu_notice_right_link:hover {
                            text-decoration: underline
                        }

                        .iu_notice_level_1
                        .iu_notice_text {
                        }

                        @media (max-width: 800px) {
                            .iu_notice {
                                height: auto
                            }

                            .iu_notice_text {
                                line-height: 20px;
                                vertical-align: top;
                                text-align: left;
                                margin: 6px 0px 0px 25px
                            }

                            .iu_notice_icon_0, .iu_notice_icon_1, .iu_notice_icon_2 {
                                position: absolute;
                                top: 14px
                            }

                            .iu_notice_close {
                                right: 20px
                            }
                        }

                        .iu_mselect_system_select {
                            display: inline-block;
                            position: relative;
                            border: 1px solid #ddd;
                            font-weight: normal;
                            color: #555;
                            cursor: default;
                            height: 100%;
                            line-height: 30px
                        }

                        .iu_mselect_system_select
                        option {
                            height: 20px;
                            line-height: 20px
                        }

                        .iu_mselect_frame {
                            position: relative;
                            display: inline-block
                        }

                        .iu_mselect_button {
                            height: 28px;
                            line-height: 28px;
                            border: 1px solid #ccc;
                            color: #333;
                            padding: 0 5px 0 10px;
                            cursor: pointer;
                            position: relative;
                            border-radius: 3px;
                            background-image: url(about:blank);
                            background: -moz-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -webkit-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -o-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -ms-linear-gradient(top, #ffffff, #F8F8F8);
                            -ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0,startColorstr=#ffffff,endColorstr=#F8F8F8)";
                            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#ffffff, endColorstr=#F8F8F8)
                        }

                        .iu_mselect_button:hover {
                            border-color: #c2c2c2;
                            background: -moz-linear-gradient(top, #ffffff, #F6F6F6);
                            background: -webkit-linear-gradient(top, #ffffff, #F6F6F6);
                            background: -o-linear-gradient(top, #ffffff, #F6F6F6);
                            background: -ms-linear-gradient(top, #ffffff, #F6F6F6);
                            -ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=#ffffff, endColorstr=#F6F6F6)";
                            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#ffffff, endColorstr=#F6F6F6);
                            box-shadow: 0 1px 2px rgba(0, 0, 0, .1)
                        }

                        .iu_mselect_text {
                            display: inline-block;
                            word-break: break-all;
                            text-align: left;
                            font-weight: bold
                        }

                        .iu_mselect_triangle_down {
                            border-style: solid;
                            border-left-width: 4px;
                            border-right-width: 4px;
                            border-top-width: 4px;
                            border-left-color: transparent;
                            border-right-color: transparent;
                            border-bottom-color: transparent;
                            border-bottom-width: 0;
                            display: inline-block;
                            cursor: pointer;
                            position: absolute;
                            top: 40%;
                            right: 8px
                        }

                        .iu_mselect_triangle_up {
                            border-style: solid;
                            border-left-width: 4px;
                            border-right-width: 4px;
                            border-bottom-width: 4px;
                            border-left-color: transparent;
                            border-right-color: transparent;
                            border-top-color: transparent;
                            border-top-width: 0;
                            display: inline-block;
                            cursor: pointer;
                            position: absolute;
                            top: 40%;
                            right: 8px
                        }

                        .iu_mselect_select {
                            max-height: 200px;
                            border: 1px solid #acacac;
                            display: none;
                            overflow: auto;
                            background-color: #fff;
                            position: absolute;
                            top: 100%;
                            z-index: 1;
                            border-radius: 2px;
                            box-shadow: 0 5px 10px rgba(0, 0, 0, .3);
                            box-shadow: 0 0 0 \9;
                            padding: 7px 0;
                            margin-top: 2px
                        }

                        .iu_mselect_select.iu_mselect_check_select {
                            max-height: 251px;
                            padding-bottom: 0
                        }

                        .iu_mselect_list {
                            max-height: 200px;
                            overflow: auto
                        }

                        .iu_mselect_option {
                            font-size: 12px;
                            height: 30px;
                            line-height: 30px;
                            padding: 0 18px;
                            color: #333;
                            cursor: pointer
                        }

                        .iu_mselect_option input[type=checkbox] {
                            margin: 2px 10px 2px 0;
                            vertical-align: middle
                        }

                        .iu_mselect_option_selected {
                            background-color: #f5f5f5
                        }

                        .iu_mselect_option_hover {
                            background-color: #f5f5f5
                        }

                        .iu_mselect_selected
                        .iu_mselect_select {
                            display: block
                        }

                        .iu_mselect_selected
                        .iu_mselect_button {
                            background-color: #fff;
                            color: #555
                        }

                        .iu_mselect_area_btn {
                            padding: 10px;
                            text-align: right;
                            background-color: #f5f5f5;
                            border-top: 1px solid #D5D9DC
                        }

                        .iu_tip {
                            display: none;
                            position: absolute;
                            min-width: 80px;
                            text-align: center;
                            z-index: 9999999;
                            font-weight: normal
                        }

                        .ib
                        .iu_tip {
                            display: none
                        }

                        .iu_tip_inner {
                            width: auto;
                            height: 30px;
                            line-height: 30px;
                            display: block;
                            overflow: hidden;
                            margin: 0px auto;
                            padding: 0px 10px;
                            font-size: 12px;
                            color: #CCC;
                            background-color: #333;
                            border-radius: 3px;
                            filter: alpha(opacity=90);
                            -moz-opacity: 0.9;
                            -khtml-opacity: 0.9;
                            opacity: 0.9
                        }

                        .iu_tip_text {
                            min-width: 50px;
                            font-weight: bold;
                            font-size: 12px;
                            color: #e1e1e1;
                            display: block;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            word-wrap: normal
                        }

                        .iu_tip_triangle {
                            position: absolute;
                            border-color: #333
                        }

                        .iu_tip_triangle_top {
                            height: 0px;
                            width: 0px;
                            display: block;
                            overflow: hidden;
                            margin: 0px auto;
                            border-style: solid;
                            border-left-color: transparent;
                            border-right-color: transparent;
                            border-top-color: transparent;
                            border-top-width: 0px;
                            border-left-width: 6px;
                            border-right-width: 6px;
                            border-bottom-width: 4px;
                            left: 50%;
                            top: 0px;
                            margin-top: -4px;
                            margin-left: -6px
                        }

                        .iu_tip_triangle_right {
                            height: 0px;
                            width: 0px;
                            display: block;
                            overflow: hidden;
                            margin: 0px auto;
                            border-style: solid;
                            border-top-color: transparent;
                            border-bottom-color: transparent;
                            border-right-color: transparent;
                            border-right-width: 0px;
                            border-top-width: 6px;
                            border-bottom-width: 6px;
                            border-left-width: 4px;
                            left: 100%;
                            top: 50%;
                            margin-top: -6px
                        }

                        .iu_tip_triangle_bottom {
                            height: 0px;
                            width: 0px;
                            display: block;
                            overflow: hidden;
                            margin: 0px auto;
                            border-style: solid;
                            border-left-color: transparent;
                            border-right-color: transparent;
                            border-bottom-color: transparent;
                            border-top-width: 4px;
                            border-left-width: 6px;
                            border-right-width: 6px;
                            border-bottom-width: 0px;
                            left: 50%;
                            top: 100%;
                            margin-left: -6px
                        }

                        .iu_tip_triangle_left {
                            height: 0px;
                            width: 0px;
                            display: block;
                            overflow: hidden;
                            margin: 0px auto;
                            border-style: solid;
                            border-left-color: transparent;
                            border-bottom-color: transparent;
                            border-top-color: transparent;
                            border-left-width: 0px;
                            border-top-width: 6px;
                            border-bottom-width: 6px;
                            border-right-width: 4px;
                            left: 0px;
                            top: 50%;
                            margin-top: -6px;
                            margin-left: -4px
                        }

                        .iu_tip_help {
                            position: absolute;
                            left: 0px;
                            top: 0px;
                            background-color: #fff;
                            border-radius: 3px;
                            border: 1px solid #acacac;
                            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
                            font-size: 12px;
                            color: #333;
                            text-align: left;
                            padding: 20px;
                            min-width: 0px
                        }

                        .iu_tip_help
                        .iu_tip_triangle_top {
                            display: none
                        }

                        .iu_tip_help
                        .iu_tip_inner {
                            width: auto;
                            height: auto;
                            line-height: 30px;
                            display: block;
                            overflow: hidden;
                            margin: 0px;
                            padding: 0px;
                            font-size: 12px;
                            color: #333;
                            background-color: #fff;
                            border-radius: 0px;
                            filter: alpha(opacity=100);
                            -moz-opacity: 1;
                            -khtml-opacity: 1;
                            opacity: 1
                        }

                        .iu_tip_help
                        .iu_tip_text {
                            min-width: 0px
                        }

                        .iu_tip_help
                        .iu_tip_text {
                            color: #333
                        }

                        .iu_tip_multiple {
                            text-align: left
                        }

                        .iu_tip_multiple
                        .iu_tip_inner {
                            height: auto
                        }

                        .iu_tip_multiple
                        .iu_tip_text {
                            white-space: normal;
                            word-break: break-all;
                            word-wrap: break-word
                        }

                        .iu_radio_button {
                            width: auto;
                            height: 30px;
                            line-height: 30px;
                            padding: 0px 10px;
                            border-radius: 3px;
                            cursor: pointer;
                            margin-bottom: 10px;
                            position: relative;
                            padding: 0px 25px 0px 10px;
                            border: #fff solid 3px
                        }

                        .iu_radio_select {
                            font-weight: bold
                        }

                        .iu_radio_input {
                            width: 12px;
                            height: 12px;
                            margin-right: 10px;
                            margin-top: 9px;
                            background: url(../../images/iu_radio_button.png) no-repeat;
                            background-position: 0 0;
                            vertical-align: 6px
                        }

                        .iu_radio_text {
                            color: #333;
                            vertical-align: top
                        }

                        .iu_radio_input:hover {
                            background-position: -12px 0
                        }

                        .iu_radio_select .iu_radio_input, .iu_radio_select .iu_radio_input:hover {
                            background-position: -24px 0
                        }

                        .tag_num_plusone {
                            width: 18px;
                            height: 15px;
                            background: url(../../images/tag_num_plusone.png) center no-repeat;
                            background-size: 100%;
                            position: absolute;
                            left: 5px;
                            top: 3px
                        }

                        .iu_radio_frame {
                            position: relative;
                            display: inline-block;
                            font-size: 12px
                        }

                        .iu_radio_button {
                            width: auto;
                            height: 30px;
                            line-height: 30px;
                            padding: 0px 10px;
                            border-radius: 3px;
                            cursor: pointer;
                            margin-bottom: 10px
                        }

                        .iu_radio_button:hover {
                            background-color: #f5f5f5
                        }

                        .iu_radio_input, .com_radio_input {
                            display: inline;
                            float: left;
                            width: 12px;
                            height: 12px;
                            margin-right: 10px;
                            margin-top: 9px;
                            background: url(../../images/iu_radio_button.png) no-repeat;
                            background-position: 0px 0px
                        }

                        .com_radio_input {
                            margin: 0px
                        }

                        .iu_radio_button:hover .iu_radio_input, .iu_radio_input:hover, .com_radio_input:hover {
                            background: url(../../images/iu_radio_button.png) no-repeat;
                            background-position: -12px 0px
                        }

                        .iu_radio_text {
                            display: inline;
                            float: left;
                            color: #333
                        }

                        .iu_radio_select .iu_radio_input, .iu_radio_select:hover .iu_radio_input, .iu_radio_input.radio_input_select, .com_radio_input.select, .iu_radio_selected, .iu_radio_selected:hover {
                            background: url(../../images/iu_radio_button.png) no-repeat;
                            background-position: -24px 0px
                        }

                        .iu_radio_select .iu_radio_text, .iu_radio_select:hover
                        .iu_radio_text {
                            color: #333
                        }

                        .iu_radio_button.disable, .iu_radio_button.disable:hover {
                            background-color: #fff;
                            cursor: default
                        }

                        .iu_radio_button.disable
                        .iu_radio_text {
                            color: #e1e1e1
                        }

                        .disable .iu_radio_input, .disable:hover
                        .iu_radio_input {
                            background: url(../../images/iu_radio_button.png) no-repeat;
                            background-position: -36px 0px
                        }

                        .vertical .iu_checkbox_button, .vertical
                        .iu_radio_button {
                            min-width: 180px
                        }

                        .iu_horizontal_button {
                            display: inline-block;
                            float: left;
                            margin-right: 20px
                        }

                        .iu_checkbox_input {
                            width: 12px;
                            height: 12px;
                            margin-right: 10px;
                            margin-top: 9px;
                            background-image: url(../../images/iu/iu_checkbox_button_201506171800.png);
                            background-position: 0px 0px;
                            background-repeat: no-repeat;
                            cursor: pointer;
                            display: block
                        }

                        .iu_checkbox_input:hover {
                            background-position: -12px 0px
                        }

                        .iu_checkbox_check, .iu_checkbox_check:hover {
                            background-position: -24px 0px
                        }

                        .iu_checkbox_input.disabled, .iu_checkbox_input.disabled:hover {
                            background-position: -36px 0px
                        }

                        .iu_checkbox_frame {
                            position: relative;
                            display: inline-block;
                            font-size: 12px
                        }

                        .iu_checkbox_button {
                            width: auto;
                            height: 30px;
                            line-height: 30px;
                            padding: 0px 10px;
                            border-radius: 3px;
                            cursor: pointer;
                            margin-bottom: 10px
                        }

                        .iu_checkbox_button:hover {
                            background-color: #f5f5f5
                        }

                        .iu_checkbox_input, .com_checkbox_input {
                            display: inline;
                            float: left;
                            width: 12px;
                            height: 12px;
                            margin-right: 10px;
                            margin-top: 9px;
                            background: url(../../images/iu/iu_checkbox_button_201506171800.png) no-repeat;
                            background-position: 0px 0px;
                            cursor: pointer
                        }

                        .com_checkbox_input {
                            margin: 0px
                        }

                        .iu_checkbox_button:hover .iu_checkbox_input, .iu_checkbox_input:hover, .com_checkbox_input:hover {
                            background: url(../../images/iu/iu_checkbox_button_201506171800.png) no-repeat;
                            background-position: -12px 0px
                        }

                        .iu_checkbox_text {
                            display: inline;
                            float: left;
                            height: 30px;
                            line-height: 30px;
                            color: #333
                        }

                        .iu_checkbox_select, .iu_checkbox_select:hover {
                            background-color: #2d4051
                        }

                        .iu_checkbox_select .iu_checkbox_input, .iu_checkbox_select:hover .iu_checkbox_input, .com_checkbox_input.select {
                            background: url(../../images/iu/iu_checkbox_button_201506171800.png) no-repeat;
                            background-position: -24px 0px
                        }

                        .iu_checkbox_select
                        .iu_checkbox_text {
                            color: #fff
                        }

                        .iu_checkbox_button.disable, .iu_checkbox_button.disable:hover {
                            background-color: #fff;
                            cursor: default
                        }

                        .iu_checkbox_button.disable
                        .iu_checkbox_text {
                            color: #e1e1e1
                        }

                        .disable .iu_checkbox_input, .disable:hover .iu_checkbox_input, .iu_checkbox_input.disabled, .iu_checkbox_input.disabled:hover {
                            background: url(../../images/iu/iu_checkbox_button_201506171800.png) no-repeat;
                            background-position: -36px 0px
                        }

                        .iu_checkbox_check, .iu_checkbox_check:hover {
                            background: url(../../images/iu/iu_checkbox_button_201506171800.png) no-repeat;
                            background-position: -24px 0px
                        }

                        .iu_checkbox_check.readonly, .iu_checkbox_check.readonly:hover {
                            background: url(../../images/iu/iu_checkbox_button_201506171800.png) no-repeat;
                            background-position: -48px 0px
                        }

                        .iu_checkbox_select.readonly .iu_checkbox_input, .iu_checkbox_select.readonly:hover .iu_checkbox_input, .com_checkbox_input.select {
                            background: url(../../images/iu/iu_checkbox_button_201506171800.png) no-repeat;
                            background-position: -48px 0px
                        }

                        body {
                            margin: 0;
                            padding: 0;
                            font-size: 12px;
                            background-color: #F9F9F9;
                            min-width: 985px
                        }

                        body, input, textarea, pre {
                            font-family: 'Helvetica Neue', Helvetica, Arial, 'Microsoft YaHei', sans-serif
                        }

                        .ko_kr, .ko_kr input, .ko_kr textarea, .ko_kr
                        pre {
                            font-family: Arial, 돋움, 'Malgun Gothic', AppleGothic, sans-serif
                        }

                        .ja_jp, .ja_jp input, .ja_jp textarea, .ja_jp
                        pre {
                            font-family: Arial, 'MS PGothic', sans-serif
                        }

                        .safari, .safari input, .safari textarea, .safari
                        pre {
                            font-family: Arial, sans-serif
                        }

                        ol, ul {
                            list-style: none;
                            margin: 0;
                            padding: 0
                        }

                        textarea {
                            resize: none
                        }

                        input {
                            outline: none
                        }

                        input::-ms-clear {
                            display: none
                        }

                        *:focus {
                            outline: none
                        }

                        input::-webkit-search-cancel-button {
                            display: none
                        }

                        input::-ms-reveal {
                            display: none
                        }

                        a, a:link, a:hover, a:visited {
                            text-decoration: none;
                            outline: none
                        }

                        img {
                            border: 0
                        }

                        .ib, .ib
                        .ib {
                            letter-spacing: -4px;
                            font-size: 0
                        }

                        @-moz-document url-prefix() {
                            .ib, .ib
                            .ib {
                                letter-spacing: 0;
                                font-size: 0
                            }
                        }

                        .ib > div, .ib > label, .ib > a, .ib > span, .ib > li, .ib > input {
                            letter-spacing: 0;
                            font-size: 12px;
                            display: inline-block;
                            *zoom: 1;
                            *display: inline
                        }

                        .triangle {
                            width: 0;
                            height: 0;
                            font-size: 0;
                            line-height: 0;
                            display: inline-block;
                            *zoom: 1;
                            *display: inline;
                            border-width: 5px;
                            border-style: solid
                        }

                        .triangle.up {
                            border-left-color: transparent;
                            border-right-color: transparent;
                            border-top-color: transparent;
                            border-top-width: 0
                        }

                        .triangle.left {
                            border-top-color: transparent;
                            border-bottom-color: transparent;
                            border-left-color: transparent;
                            border-left-width: 0
                        }

                        .triangle.down {
                            border-left-color: transparent;
                            border-right-color: transparent;
                            border-bottom-color: transparent;
                            border-bottom-width: 0
                        }

                        .triangle.right {
                            border-top-color: transparent;
                            border-bottom-color: transparent;
                            border-right-color: transparent;
                            border-right-width: 0
                        }

                        .com_triangle_ico_up, .com_triangle_ico_down {
                            position: absolute;
                            background: url(../../images/arrow_down_201501201500.png) no-repeat;
                            height: 5px;
                            width: 9px;
                            right: 7px;
                            top: 12px;
                            cursor: pointer
                        }

                        .com_triangle_ico_up {
                            background: url(../../images/arrow_up_201501201500.png) no-repeat
                        }

                        .hidelong {
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            word-wrap: normal
                        }

                        .clear_fd, .ib .clear_fd, .ib .ib
                        .clear_fd {
                            display: block;
                            height: 0px;
                            overflow: hidden;
                            clear: both
                        }

                        .owner {
                            background-color: #e1e1e1
                        }

                        .head, .foot {
                            min-width: 1250px
                        }

                        .main {
                            min-width: 1230px
                        }

                        .inner {
                            margin: 0 auto;
                            position: relative
                        }

                        .owner
                        .main {
                            margin: 4px 10px;
                            padding: 0px;
                            color: #333
                        }

                        .main
                        .inner {
                            min-height: 463px
                        }

                        .col_main, .col_left, .col_right {
                            vertical-align: top
                        }

                        .col_main {
                            width: 800px
                        }

                        .col_main.edit {
                            background-color: #fff
                        }

                        .col_main_box {
                            margin: 10px;
                            border: 1px solid #ccc
                        }

                        .col_left {
                            position: absolute;
                            left: 0;
                            top: 0;
                            width: 270px;
                            text-align: left;
                            background-color: #fff;
                            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.05)
                        }

                        .col_right {
                            min-height: 300px;
                            margin-left: 274px;
                            text-align: left;
                            background-color: #fff;
                            border: 1px solid #ccc;
                            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.05);
                            border-radius: 2px
                        }

                        .col_right_topbox {
                            height: 50px;
                            line-height: 50px;
                            position: relative;
                            border-bottom: 1px solid #ccc;
                            background-color: #fff;
                            border-top-left-radius: 2px;
                            border-top-right-radius: 2px;
                            padding: 0 20px
                        }

                        .col_right_toptitle {
                            font-size: 16px;
                            font-weight: bold;
                            color: #333;
                            text-align: left;
                            vertical-align: top;
                            max-width: 200px
                        }

                        .ib
                        .col_right_toptitle {
                            font-size: 16px
                        }

                        .col_right_topbox
                        .btns {
                            position: absolute;
                            top: 10px;
                            right: 20px;
                            line-height: normal
                        }

                        .info_default_color {
                            color: #ccc
                        }

                        .box_shadow {
                            box-shadow: 0 2px 0 rgba(0, 0, 0, 0.05)
                        }

                        .header_left_box1 {
                            width: auto;
                            height: 40px
                        }

                        .logo {
                            width: 241px;
                            height: 40px;
                            position: relative;
                            left: -7px;
                            top: 0;
                            background: url(../../images/site/ccb_logo_en_20160705.png) no-repeat center;
                            padding: 0 10px
                        }

                        .logo:hover {
                            background-color: #1f2d39
                        }

                        .logo.l_zh_cn {
                            width: 194px;
                            background-image: url(../../images/site/ccb_logo_cn_20160705.png)
                        }

                        .zh_tw
                        .logo.l_zh_cn {
                            width: 194px;
                            background-image: url(../../images/site/ccb_logo_cn_20160705.png)
                        }

                        .sign
                        .mt {
                            font-size: 24px;
                            color: #333;
                            text-align: center
                        }

                        .sign
                        .mc {
                            margin-top: 60px;
                            font-size: 12px;
                            position: relative
                        }

                        .tip_input {
                            margin-top: 12px;
                            font-size: 12px;
                            color: #333;
                            font-weight: bold
                        }

                        .tip_input.first {
                            margin-top: 0
                        }

                        .input_outer {
                            padding: 0 11px;
                            position: relative;
                            margin-top: 8px
                        }

                        .input_text, .di_input_text {
                            border: 1px solid #ccc;
                            padding: 0 10px;
                            display: block;
                            width: 100%;
                            margin-left: -11px;
                            height: 28px;
                            line-height: 28px \0;
                            outline: none;
                            border-radius: 3px;
                            font-size: 14px
                        }

                        .input_text.remember {
                            background-color: #fffbbd
                        }

                        .input_text:focus, .di_input_text:focus {
                            border-color: #333;
                            box-shadow: 0 0 5px rgba(45, 64, 81, .2)
                        }

                        .link {
                            color: #1B84B2;
                            text-decoration: none
                        }

                        .link:hover {
                            text-decoration: underline
                        }

                        .show_error {
                            cursor: pointer
                        }

                        .error {
                            display: none;
                            font-size: 12px;
                            margin: 20px 0px 28px -11px;
                            color: #f06364
                        }

                        .err_com {
                            top: -30px;
                            position: absolute;
                            margin-left: 0;
                            -moz-box-sizing: border-box;
                            -webkit-box-sizing: border-box;
                            -ms-box-sizing: border-box;
                            -o-box-sizing: border-box;
                            box-sizing: border-box
                        }

                        .foot {
                            font-size: 12px;
                            line-height: 26px;
                            border-top: 1px solid #e8e8e8;
                            color: #707070;
                            background-color: #fff;
                            text-align: center
                        }

                        .foot
                        .inner {
                            position: relative;
                            padding: 27px 10px 12px
                        }

                        .ccb_foot_link {
                            color: #707070;
                            text-decoration: none
                        }

                        .ccb_foot_link:hover {
                            text-decoration: underline
                        }

                        .foot_linespacing {
                            margin: 0 10px;
                            width: 1px;
                            height: 12px;
                            background: #B7B7B7;
                            position: relative;
                            top: 2px
                        }

                        .language_switch {
                            vertical-align: top
                        }

                        .ls_handle {
                            cursor: pointer
                        }

                        .ls_handle_text {
                            padding-right: 1px;
                            vertical-align: middle
                        }

                        .ls_handle_triangle {
                            width: 9px;
                            height: 5px;
                            background-image: url(../../images/ls_handle_triangle.png);
                            vertical-align: middle;
                            margin-left: 5px
                        }

                        .ls_menu {
                            position: absolute;
                            bottom: 42px;
                            right: 0;
                            padding: 10px 0;
                            width: 150px;
                            border: 1px solid #CECECE;
                            background-color: #fff;
                            border-radius: 2px;
                            box-shadow: 0 4px 8px #CECECE;
                            display: none
                        }

                        .ls_item {
                            margin-top: 5px;
                            line-height: 28px;
                            height: 28px;
                            padding: 0 15px;
                            cursor: pointer
                        }

                        .ls_item:hover {
                            background-color: #2488B4;
                            color: #fff
                        }

                        .ls_item.first {
                            margin-top: 0
                        }

                        .ls_menu
                        .triangle {
                            position: absolute;
                            color: #CECECE;
                            border-width: 12px;
                            border-bottom-width: 0;
                            bottom: -14px;
                            right: 25px
                        }

                        .ls_menu .triangle
                        .triangle {
                            color: #fff;
                            left: -12px;
                            top: -14px
                        }

                        .ls_menu
                        .l_zh_cn {
                            font-family: 'Microsoft YaHei', Arial, sans-serif
                        }

                        .ls_menu
                        .l_en_us {
                            font-family: Arial, sans-serif
                        }

                        .ls_menu
                        .l_ja_jp {
                            font-family: 'MS PGothic', Arial, sans-serif
                        }

                        .ls_menu
                        .l_ko_kr {
                            font-family: 돋움, Arial, sans-serif
                        }

                        .head_top {
                            padding: 0;
                            background-color: #2d4051
                        }

                        .head_top
                        .inner {
                            height: 40px;
                            position: relative;
                            text-align: center;
                            width: auto
                        }

                        .head_top
                        .align_left {
                            text-align: left
                        }

                        .ht_btn {
                            color: #c8cace;
                            font-size: 13px !important;
                            height: 40px;
                            line-height: 40px;
                            vertical-align: top;
                            padding: 0 15px;
                            width: auto;
                            cursor: pointer;
                            position: relative
                        }

                        .ht_btn
                        .arrow {
                            width: 5px;
                            height: 5px;
                            background: url(../../images/head_arrow.png) no-repeat;
                            display: block;
                            position: absolute;
                            bottom: 3px;
                            right: 3px
                        }

                        .ht_btn.last_admin
                        .triangle.down {
                            position: absolute;
                            right: 0px;
                            top: 10px
                        }

                        .ht_btn.last_user {
                            padding-right: 0;
                            max-width: 200px
                        }

                        .ht_btn
                        .triangle.down {
                            margin-left: 5px;
                            top: 2px;
                            position: relative;
                            border-width: 4px
                        }

                        .ht_btn:hover, .ht_btn.selected {
                            background-color: #1f2d39;
                            color: #fff
                        }

                        .ht_btn
                        .notelist_menu {
                            position: absolute;
                            display: none;
                            left: 0;
                            width: 125px;
                            padding: 10px 0;
                            background-color: #2d4051;
                            z-index: 11
                        }

                        .ht_btn
                        .notelist_item {
                            display: block;
                            line-height: 34px;
                            color: #c8cace;
                            padding: 0 15px
                        }

                        .ib > .icon_ellipsis {
                            display: none
                        }

                        .ht_btn.icon_ellipsis:hover
                        .notelist_menu {
                            display: block
                        }

                        .ht_btn .notelist_item:hover {
                            background-color: #1f2d39;
                            color: #FFF
                        }

                        .ht_btn
                        .notelist_item.selected {
                            background-color: #1f2d39;
                            color: #FFF
                        }

                        .ht_btn
                        .notelist_more_icon {
                            height: 40px;
                            width: 18px
                        }

                        .ht_btn
                        .more_icon_hl {
                            background: url(../../images/more_hl.png) no-repeat center
                        }

                        .ht_btn
                        .more_icon_normal {
                            background: url(../../images/more_normal.png) no-repeat center
                        }

                        .ht_btn:hover
                        .more_icon_normal {
                            background: url(../../images/more_hl.png) no-repeat center
                        }

                        .ht_btn.last_admin {
                            max-width: 150px;
                            min-width: 30px;
                            width: auto;
                            line-height: 60px;
                            padding: 0
                        }

                        .ht_btn.last_admin:hover {
                            background-color: #243341;
                            color: #fff
                        }

                        .ht_btn_outer {
                            text-align: center;
                            position: relative;
                            vertical-align: top
                        }

                        .hb_btn_outer
                        .hb_btn {
                            line-height: 50px;
                            padding: 0 80px 0px 17px;
                            font-size: 14px;
                            color: #2D4051;
                            text-decoration: none
                        }

                        .hb_btn_outer {
                            position: relative;
                            vertical-align: top
                        }

                        .hb_btn_outer.select {
                            background-color: #e1e1e1;
                            height: 51px;
                            font-weight: bold;
                            border-left: 1px solid #D5D9DC;
                            border-right: 1px solid #D5D9DC
                        }

                        .icon_plus {
                            display: inline-block;
                            width: 8px;
                            height: 8px;
                            background: url(../../images/icon_plus.png?201405121517) center no-repeat;
                            margin-right: 5px
                        }

                        .icon_mergecard {
                            display: inline-block;
                            width: 13px;
                            height: 8px;
                            background: url(../../images/icon_mergecard.png) center no-repeat;
                            margin-right: 5px
                        }

                        .icon_share {
                            display: inline-block;
                            width: 11px;
                            height: 10px;
                            background-image: url(../../images/icon_share.png?20140526);
                            margin-right: 5px
                        }

                        .user_nav {
                            position: absolute;
                            right: 0;
                            top: 0
                        }

                        .account_nav {
                            position: absolute;
                            right: 10px;
                            top: 0;
                            line-height: 40px
                        }

                        .input_search {
                            margin: 0;
                            width: 85px;
                            padding: 0 10px 0 25px;
                            height: 24px;
                            line-height: 24px \9;
                            border: 0;
                            border-radius: 15px;
                            background-color: transparent;
                            outline: none;
                            position: relative;
                            z-index: 1;
                            color: #fff;
                            font-size: 12px
                        }

                        .input_search:active, .input_search:focus, .search_input:hover .input_search:active, .search_input:hover .input_search:focus {
                            border-color: #999;
                            color: #333
                        }

                        .prompt {
                            position: absolute;
                            top: -1px;
                            left: 10px;
                            line-height: 30px;
                            color: #c2c2c2;
                            z-index: 1
                        }

                        .head_menu {
                            display: none;
                            position: absolute;
                            list-style: none;
                            right: 0;
                            top: 40px;
                            margin: 0;
                            padding: 10px 0;
                            width: 180px;
                            text-align: left;
                            background-color: white;
                            z-index: 100;
                            box-shadow: 0 2px 5px rgba(51, 51, 51, 0.3);
                            border: 1px solid #c2c2c2;
                            border-radius: 2px
                        }

                        .head_menu.message_menu {
                            right: 0px;
                            width: 215px;
                            height: auto
                        }

                        .ko_kr
                        .head_menu.message_menu {
                            width: 230px
                        }

                        .head_menu.message_menu
                        li {
                            cursor: pointer
                        }

                        .message_menu_item {
                            display: block
                        }

                        .head_menu.helps_menu {
                            right: 0;
                            width: 215px
                        }

                        .ja_jp
                        .head_menu.helps_menu {
                            width: 225px
                        }

                        .head_menu
                        .msg_text {
                            height: 30px;
                            line-height: 30px;
                            margin-left: 10px;
                            font-size: 12px;
                            color: #333;
                            vertical-align: middle
                        }

                        .message_menu {
                            right: -75px;
                            font-size: 12px;
                            width: 250px;
                            padding-bottom: 10px;
                            vertical-align: top;
                            top: 40px;
                            height: 65px;
                            border-radius: 0px
                        }

                        .message_menu
                        .msg_icon {
                            background: url(../../images/message/menu_received_cards.png) no-repeat;
                            width: 25px;
                            height: 20px;
                            margin-left: 20px;
                            vertical-align: middle;
                            display: inline-block
                        }

                        .message_menu
                        .task_icon {
                            background: url(../../images/message/menu_task.png) no-repeat;
                            width: 25px;
                            height: 20px;
                            margin-left: 20px;
                            vertical-align: middle;
                            display: inline-block
                        }

                        .message_menu
                        .invitation {
                            background: url(../../images/message/menu_application.png) no-repeat;
                            width: 25px;
                            height: 20px;
                            margin-left: 20px;
                            vertical-align: middle;
                            display: inline-block
                        }

                        .message_menu
                        .hrchange_icon {
                            background: url(../../images/message/menu_hrchange.png) no-repeat;
                            width: 25px;
                            height: 20px;
                            margin-left: 20px;
                            vertical-align: middle;
                            display: inline-block
                        }

                        .message_menu li:hover a, .message_menu li:hover a:hover {
                            cursor: pointer;
                            color: #333
                        }

                        .helps_menu {
                            right: -75px;
                            font-size: 12px;
                            width: 250px;
                            vertical-align: top;
                            top: 40px;
                            border-radius: 0px;
                            padding: 20px 0
                        }

                        .helps_menu li:hover {
                            background-color: #fff
                        }

                        .helps_menu
                        .first_nav {
                            font-size: 14px;
                            color: #707070;
                            font-weight: bold;
                            margin-bottom: 14px;
                            padding: 0 20px;
                            text-transform: uppercase
                        }

                        .helps_menu
                        .nav_phone {
                            padding: 0 20px 0 40px;
                            color: #fc8824;
                            font-weight: bold;
                            line-height: 24px;
                            background-image: url(../../images/icon_headnav_help_phone.png);
                            background-repeat: no-repeat;
                            background-position: 20px center
                        }

                        .helps_menu
                        .second_item {
                            line-height: 24px;
                            padding: 0 20px;
                            display: block
                        }

                        .helps_menu
                        .first_nav_download {
                            margin-top: 24px
                        }

                        .message_alert, .set_alert {
                            display: none;
                            position: absolute;
                            width: 10px;
                            height: 10px;
                            top: 6px;
                            right: 6px;
                            background: url(../../images/notification_new_company.png) no-repeat center
                        }

                        .msg_num {
                            float: right;
                            margin-right: 20px
                        }

                        .link_ums {
                            color: #333;
                            font-size: 12px;
                            height: 30px;
                            line-height: 30px;
                            margin: 0 15px;
                            text-decoration: none;
                            vertical-align: top;
                            display: block
                        }

                        .head_menu li:hover, .head_menu li:hover
                        .link_ums {
                            background-color: #f5f5f5
                        }

                        .helps_menu li:hover {
                            background-color: #fff
                        }

                        .head_menu .icon_profile, .head_menu .icon_toolbox, .head_menu
                        .icon_exit {
                            display: inline-block;
                            width: 20px;
                            height: 20px;
                            background-repeat: no-repeat;
                            background-position: center;
                            margin-right: 10px;
                            position: relative;
                            top: 5px
                        }

                        .head_menu
                        .icon_profile {
                            color: #707070;
                            margin: 0 8px 0 2px;
                            top: 2px;
                            display: inline-block;
                            font-size: 16px
                        }

                        .head_menu
                        .icon_toolbox {
                            background-image: url(../../images/icon_toolbox.png)
                        }

                        .head_menu
                        .icon_exit {
                            background-image: url(../../images/icon_exit.png)
                        }

                        #_ui_toast {
                            display: none !important
                        }

                        .dialog_expircy {
                            position: fixed;
                            min-width: 240px;
                            top: 5px;
                            z-index: 3
                        }

                        .dialog_expircy
                        .di_main {
                            min-width: 240px;
                            margin: 0 auto
                        }

                        .dialog_expircy .di_main
                        .item {
                            height: 40px;
                            color: #441119;
                            line-height: 40px;
                            background-color: #f26c4f;
                            margin-bottom: 5px;
                            border-radius: 3px;
                            position: relative;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.15);
                            box-shadow: none \0;
                            padding-right: 44px
                        }

                        .dialog_expircy .di_main
                        .item.yellow {
                            background-color: #F9EDBE
                        }

                        .dialog_expircy .di_main .item.yellow
                        .btn_cancel {
                            background: url(../../images/expricy_close.png) no-repeat;
                            background-position: center center
                        }

                        .dialog_expircy .di_main .item.yellow .btn_cancel:hover {
                            background: url(../../images/expricy_close_hover.png) no-repeat;
                            background-position: center center;
                            border: none
                        }

                        .dialog_expircy .item.yellow
                        .di_input_tip {
                            color: #441119
                        }

                        .dialog_expircy .item.yellow
                        .a_contactus {
                            display: inline-block;
                            vertical-align: top;
                            color: #1b84b2
                        }

                        .dialog_expircy
                        .btn_cancel {
                            width: 20px;
                            height: 20px;
                            background: url(../../images/expricy_close_alert.png) no-repeat;
                            background-position: center center;
                            cursor: pointer;
                            border: none;
                            margin-top: 10px;
                            margin-left: 14px;
                            display: inline-block;
                            vertical-align: top;
                            position: absolute;
                            right: 14px
                        }

                        .dialog_expircy
                        .di_title {
                            padding: 5px 0px 20px;
                            text-align: left
                        }

                        .dialog_expircy
                        .di_input_tip {
                            color: #441119;
                            font-size: 12px;
                            font-weight: bold;
                            padding-left: 20px
                        }

                        .dialog_expircy
                        .a_contactus {
                            color: #fffae6;
                            font-size: 12px;
                            font-weight: bold;
                            margin-left: 10px;
                            text-decoration: none;
                            vertical-align: top
                        }

                        .switch_menu {
                            padding: 0 10px;
                            border-left: solid 0 #fff;
                            height: 40px;
                            line-height: 40px;
                            margin-left: -7px;
                            cursor: pointer;
                            background: url(../../images/task/left_unfold_arrow.png) no-repeat center center
                        }

                        .switch_menu:hover {
                            background-color: #1f2d39
                        }

                        .main_nav_current {
                            width: 0;
                            height: 0;
                            font-size: 0;
                            line-height: 0;
                            display: inline-block;
                            *zoom: 1;
                            *display: inline;
                            border-style: solid;
                            border-color: #e1e1e1;
                            border-left-color: transparent;
                            border-right-color: transparent;
                            border-top-color: transparent;
                            border-top-width: 0;
                            border-left-width: 6px;
                            border-right-width: 6px;
                            border-bottom-width: 4px;
                            position: absolute;
                            left: 50%;
                            bottom: 0;
                            margin-left: -6px
                        }

                        .head_left_btns {
                            margin-left: 20px;
                            color: #707070;
                            vertical-align: top
                        }

                        .user_photo {
                            width: 40px;
                            height: 40px;
                            line-height: 40px;
                            font-size: 12px;
                            display: block;
                            border-radius: 3px
                        }

                        .ht_btn_outer
                        .user_photo {
                            border-radius: 0
                        }

                        .bg_color_0 {
                            background-color: #f24e4e
                        }

                        .bg_color_1 {
                            background-color: #fd8603
                        }

                        .bg_color_2 {
                            background-color: #fc0
                        }

                        .bg_color_3 {
                            background-color: #8ed82e
                        }

                        .bg_color_4 {
                            background-color: #00a67b
                        }

                        .bg_color_5 {
                            background-color: #0fc3e8
                        }

                        .bg_color_6 {
                            background-color: #009aff
                        }

                        .bg_color_7 {
                            background-color: #0e4ead
                        }

                        .bg_color_8 {
                            background-color: #662d91
                        }

                        .bg_color_9 {
                            background-color: #7467c7
                        }

                        .bg_color_a {
                            background-color: #f06eaa
                        }

                        .bg_color_b {
                            background-color: #9e0758
                        }

                        .bg_color_c {
                            background-color: #8e7b88
                        }

                        .bg_color_d {
                            background-color: #827b00
                        }

                        .bg_color_e {
                            background-color: #754c24
                        }

                        .bg_color_f {
                            background-color: #337174
                        }

                        .font_color {
                            color: #fff
                        }

                        .colleague_jp_pic {
                            width: 40px;
                            height: 40px;
                            background-repeat: no-repeat;
                            background-position: center center
                        }

                        .bg_color_0
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_0.png)
                        }

                        .bg_color_1
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_1.png)
                        }

                        .bg_color_2
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_2.png)
                        }

                        .bg_color_3
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_3.png)
                        }

                        .bg_color_4
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_4.png)
                        }

                        .bg_color_5
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_5.png)
                        }

                        .bg_color_6
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_6.png)
                        }

                        .bg_color_7
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_7.png)
                        }

                        .bg_color_8
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_8.png)
                        }

                        .bg_color_9
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_9.png)
                        }

                        .bg_color_a
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_a.png)
                        }

                        .bg_color_b
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_b.png)
                        }

                        .bg_color_c
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_c.png)
                        }

                        .bg_color_d
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_d.png)
                        }

                        .bg_color_e
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_e.png)
                        }

                        .bg_color_f
                        .colleague_jp_pic {
                            background-image: url(../../images/colleague/avatar_32px_f.png)
                        }

                        .colleague_jp_pic.px_40 {
                            width: 40px;
                            height: 40px;
                            background-repeat: no-repeat
                        }

                        .bg_color_0
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_0.png)
                        }

                        .bg_color_1
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_1.png)
                        }

                        .bg_color_2
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_2.png)
                        }

                        .bg_color_3
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_3.png)
                        }

                        .bg_color_4
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_4.png)
                        }

                        .bg_color_5
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_5.png)
                        }

                        .bg_color_6
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_6.png)
                        }

                        .bg_color_7
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_7.png)
                        }

                        .bg_color_8
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_8.png)
                        }

                        .bg_color_9
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_9.png)
                        }

                        .bg_color_a
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_a.png)
                        }

                        .bg_color_b
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_b.png)
                        }

                        .bg_color_c
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_c.png)
                        }

                        .bg_color_d
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_d.png)
                        }

                        .bg_color_e
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_e.png)
                        }

                        .bg_color_f
                        .colleague_jp_pic.px_40 {
                            background-image: url(../../images/colleague/avatar_40px_f.png)
                        }

                        .colleague_jp_pic.px_20 {
                            width: 20px;
                            height: 20px;
                            background-repeat: no-repeat
                        }

                        .bg_color_0
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_0.png)
                        }

                        .bg_color_1
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_1.png)
                        }

                        .bg_color_2
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_2.png)
                        }

                        .bg_color_3
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_3.png)
                        }

                        .bg_color_4
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_4.png)
                        }

                        .bg_color_5
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_5.png)
                        }

                        .bg_color_6
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_6.png)
                        }

                        .bg_color_7
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_7.png)
                        }

                        .bg_color_8
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_8.png)
                        }

                        .bg_color_9
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_9.png)
                        }

                        .bg_color_a
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_a.png)
                        }

                        .bg_color_b
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_b.png)
                        }

                        .bg_color_c
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_c.png)
                        }

                        .bg_color_d
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_d.png)
                        }

                        .bg_color_e
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_e.png)
                        }

                        .bg_color_f
                        .colleague_jp_pic.px_20 {
                            background-image: url(../../images/colleague/avatar_20px_f.png)
                        }

                        .colleague_jp_pic.px_80 {
                            width: 80px;
                            height: 80px;
                            background-repeat: no-repeat
                        }

                        .bg_color_0
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_0.png)
                        }

                        .bg_color_1
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_1.png)
                        }

                        .bg_color_2
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_2.png)
                        }

                        .bg_color_3
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_3.png)
                        }

                        .bg_color_4
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_4.png)
                        }

                        .bg_color_5
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_5.png)
                        }

                        .bg_color_6
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_6.png)
                        }

                        .bg_color_7
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_7.png)
                        }

                        .bg_color_8
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_8.png)
                        }

                        .bg_color_9
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_9.png)
                        }

                        .bg_color_a
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_a.png)
                        }

                        .bg_color_b
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_b.png)
                        }

                        .bg_color_c
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_c.png)
                        }

                        .bg_color_d
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_d.png)
                        }

                        .bg_color_e
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_e.png)
                        }

                        .bg_color_f
                        .colleague_jp_pic.px_80 {
                            background-image: url(../../images/colleague/avatar_80px_f.png)
                        }

                        .colleague_jp_pic.px_60 {
                            width: 60px;
                            height: 60px;
                            background-repeat: no-repeat
                        }

                        .bg_color_0
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_0_201409181500.png)
                        }

                        .bg_color_1
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_1_201409181500.png)
                        }

                        .bg_color_2
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_2_201409181500.png)
                        }

                        .bg_color_3
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_3_201409181500.png)
                        }

                        .bg_color_4
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_4_201409181500.png)
                        }

                        .bg_color_5
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_5_201409181500.png)
                        }

                        .bg_color_6
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_6_201409181500.png)
                        }

                        .bg_color_7
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_7_201409181500.png)
                        }

                        .bg_color_8
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_8_201409181500.png)
                        }

                        .bg_color_9
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_9_201409181500.png)
                        }

                        .bg_color_a
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_a_201409181500.png)
                        }

                        .bg_color_b
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_b_201409181500.png)
                        }

                        .bg_color_c
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_c_201409181500.png)
                        }

                        .bg_color_d
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_d_201409181500.png)
                        }

                        .bg_color_e
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_e_201409181500.png)
                        }

                        .bg_color_f
                        .colleague_jp_pic.px_60 {
                            background-image: url(../../images/colleague/avatar_60px_f_201409181500.png)
                        }

                        .btn_login_black, .btn_login_orange {
                            display: inline-block;
                            width: 100%;
                            height: 38px;
                            cursor: pointer;
                            line-height: 38px;
                            text-align: center;
                            color: white;
                            font-size: 12px;
                            font-weight: bold;
                            border-radius: 3px;
                            background-color: #2D4051;
                            border: 1px solid #2D4051;
                            box-shadow: 0 1px 2px rgba(0, 0, 0, .1)
                        }

                        .btn_login_black:hover, .btn_login_orange:hover, .btn_login_black:active, .btn_login_orange:active {
                            background-color: #243341;
                            border-color: #243341;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, .15)
                        }

                        .btn_login_orange {
                            background-color: #f93;
                            border: 1px solid #f93;
                            color: #fff
                        }

                        .btn_login_orange:hover, .btn_login_orange:active {
                            border-color: #fc8824;
                            background-color: #fc8824;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.1);
                            box-shadow: 0 2px 1px #d9d9d9 \0
                        }

                        .btn_crm_blue_disable, .btn_crm_blue_disable:hover, .btn_login_black.disable, .btn_login_black.disable:hover {
                            background-color: #abb3b9;
                            cursor: default;
                            box-shadow: none
                        }

                        #dialog_check_mycard_box
                        .iu_dialog_content {
                            height: 150px;
                            max-height: 150px;
                            color: #333;
                            text-align: left
                        }

                        #dialog_check_mycard_box
                        .iu_dialog_button_0 {
                            display: none
                        }

                        #dialog_check_mycard_box
                        .error {
                            margin: 10px 0 0 -11px
                        }

                        .dcme_title {
                            font-size: 18px;
                            font-weight: bold;
                            text-align: center
                        }

                        .dcme_tip {
                            margin-top: 35px
                        }

                        .dialog_check_mycard_exists
                        .input_outer {
                            margin-top: 10px
                        }

                        .dialog_expircy .a_contactus:hover {
                            color: #fffae6;
                            text-decoration: underline
                        }

                        #home_dl_app {
                            display: block;
                            position: fixed;
                            left: 0;
                            bottom: 0;
                            z-index: 888;
                            width: 100%
                        }

                        .iu_notice {
                            position: fixed !important
                        }

                        .dialog_services_body {
                            width: 560px;
                            height: 270px;
                            display: block;
                            overflow: hidden;
                            padding: 45px 45px 60px 55px
                        }

                        .dialog_services_li, .services_li_corp {
                            width: 260px;
                            height: 260px;
                            display: inline;
                            float: left;
                            margin-left: 0;
                            cursor: pointer;
                            border: 5px solid #fff;
                            background: url(../../images/switch_cc_201603281700.png) center center no-repeat
                        }

                        .dialog_services_li:hover {
                            width: 260px;
                            height: 260px;
                            border: 5px solid #18b8f3
                        }

                        .services_li_corp {
                            margin-left: 10px;
                            background: url(../../images/switch_ccb_20160705.png) center center no-repeat
                        }

                        .services_li_corp:hover {
                            width: 260px;
                            height: 260px;
                            border: 5px solid #2d4051
                        }

                        .zh_cn .dialog_services_li, .zh_cn .services_li_corp, .zh_tw .dialog_services_li, .zh_tw
                        .services_li_corp {
                            background: url(../../images/switch_cc_201603281700_cn.png) center center no-repeat
                        }

                        .zh_cn .services_li_corp, .zh_tw
                        .services_li_corp {
                            background: url(../../images/switch_ccb_20160705_cn.png) center center no-repeat
                        }

                        .com_left_line {
                            width: 5px;
                            height: 37px;
                            overflow: hidden;
                            cursor: pointer;
                            position: absolute;
                            z-index: 2;
                            background-color: #2d4051;
                            display: none
                        }

                        .m_cur2 .com_left_line, .com_nav_cur .com_left_line, .l_nav_cur
                        .com_left_line {
                            display: block
                        }

                        .m_cur2
                        .link.select {
                            border-top: 1px solid #ccc
                        }

                        .hbr_btn_new {
                            height: 28px;
                            line-height: 28px;
                            padding: 0 20px;
                            cursor: pointer;
                            margin-left: 10px;
                            position: relative;
                            text-decoration: none;
                            font-size: 12px;
                            font-weight: bold;
                            color: #707070;
                            text-align: center;
                            border-radius: 3px;
                            background-color: #fff;
                            border: 1px solid #ccc;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            word-wrap: normal;
                            background-image: url(about:blank);
                            background: -moz-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -webkit-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -o-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -ms-linear-gradient(top, #ffffff, #F8F8F8);
                            -ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0,startColorstr=#ffffff,endColorstr=#F8F8F8)";
                            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#ffffff, endColorstr=#F8F8F8)
                        }

                        .hbr_btn_new:hover {
                            border: 1px solid #c2c2c2;
                            box-shadow: 0px 2px 1px rgba(225, 225, 225, 1);
                            box-shadow: 0px 2px 1px #e1e1e1 \0
                        }

                        .hbr_btn_orangle_new {
                            height: 28px;
                            line-height: 28px;
                            padding: 0 20px;
                            font-size: 12px;
                            font-weight: bold;
                            color: #fff;
                            cursor: pointer;
                            margin-left: 10px;
                            position: relative;
                            text-decoration: none;
                            text-align: center;
                            border-radius: 3px;
                            background-color: #f93;
                            border: 1px solid #f93;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            word-wrap: normal
                        }

                        .hbr_btn_orangle_new:hover {
                            border: 1px solid #fc8f30;
                            background-color: #fc8f30;
                            box-shadow: 0px 2px 1px rgba(115, 66, 30, 0.15);
                            box-shadow: 0px 2px 1px #d9d9d9 \0
                        }

                        .icon_plus_new {
                            display: inline-block;
                            width: 16px;
                            height: 16px;
                            background: url(../../images/ch_sprite_151223.png) 0 0 no-repeat;
                            vertical-align: middle;
                            margin-right: 5px
                        }

                        .com_btn_orange {
                            line-height: 28px;
                            text-align: center;
                            border-radius: 3px;
                            background-color: #f93;
                            border: 1px solid #f93;
                            color: #fff;
                            cursor: pointer;
                            font-weight: bold;
                            padding: 0px 20px;
                            display: inline-block;
                            vertical-align: top;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            word-wrap: normal
                        }

                        .com_btn_orange:hover, .com_btn_orange:active {
                            border-color: #fc8824;
                            background-color: #fc8824;
                            box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.1);
                            box-shadow: 0px 2px 1px #d9d9d9 \0
                        }

                        .com_btn_orange.disable, .com_btn_orange.disable:hover {
                            border: 1px solid #ffd6ad;
                            background-color: #ffd6ad;
                            box-shadow: none;
                            cursor: default
                        }

                        .com_btn_darkblue, .com_btn_red {
                            padding: 0 20px;
                            min-width: 58px;
                            text-align: center;
                            font-size: 12px;
                            font-weight: bold;
                            border-radius: 3px;
                            cursor: pointer;
                            text-decoration: none;
                            line-height: 28px;
                            color: #fff;
                            border: 1px solid #2d4051;
                            background-color: #2d4051;
                            display: inline-block;
                            vertical-align: top
                        }

                        .com_btn_darkblue:hover, .com_btn_darkblue:active {
                            border: 1px solid #243341;
                            background-color: #243341;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.2)
                        }

                        .com_btn_darkblue.disable, .com_btn_darkblue.disable:hover {
                            border: 1px solid #abb3b9;
                            background-color: #abb3b9;
                            box-shadow: none;
                            cursor: default
                        }

                        .com_btn_red {
                            color: #fff;
                            border: 1px solid #f26c4f;
                            background-color: #f26c4f
                        }

                        .com_btn_red:hover, .com_btn_red:active {
                            border: 1px solid #eb6042;
                            background-color: #eb6042;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.15);
                            box-shadow: 0px 2px 1px #d9d9d9 \0
                        }

                        .com_btn_red.disable, .com_btn_red.disable:hover {
                            border: 1px solid #f9c1c1;
                            background-color: #f9c1c1;
                            cursor: default;
                            box-shadow: none
                        }

                        .com_btn_white {
                            padding: 0 20px;
                            min-width: 58px;
                            height: 28px;
                            line-height: 28px;
                            text-align: center;
                            border-radius: 3px;
                            font-size: 12px;
                            color: #707070;
                            font-weight: bold;
                            background-color: #f5f5f5;
                            border: 1px solid #ccc;
                            display: inline-block;
                            vertical-align: top;
                            cursor: pointer;
                            background-image: url(about:blank);
                            background: -moz-linear-gradient(top, #ffffff, #f5f5f5);
                            background: -webkit-linear-gradient(top, #ffffff, #f5f5f5);
                            background: -o-linear-gradient(top, #ffffff, #f5f5f5);
                            background: -ms-linear-gradient(top, #ffffff, #f5f5f5);
                            -ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0,startColorstr=#ffffff,endColorstr=#f5f5f5)";
                            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#ffffff, endColorstr=#f5f5f5)
                        }

                        .com_btn_white:hover, .com_btn_white:active {
                            border: 1px solid #c2c2c2;
                            box-shadow: 0 2px 1px rgba(0, 0, 0, 0.1);
                            box-shadow: 0 2px 1px #d9d9d9 \0
                        }

                        .com_btn_white.disable, .com_btn_white.disable:hover {
                            color: #c2c2c2;
                            box-shadow: none;
                            cursor: default
                        }

                        .b_top_1 {
                            border-top: 1px solid #ccc
                        }

                        .bottom_gradient {
                            background-color: #E5E5E5;
                            background-image: url(about:blank);
                            height: 4px;
                            background: -moz-linear-gradient(top, #E5E5E5, #ffffff);
                            background: -webkit-linear-gradient(top, #E5E5E5, #ffffff);
                            background: -o-linear-gradient(top, #E5E5E5, #ffffff);
                            background: -ms-linear-gradient(top, #E5E5E5, #ffffff);
                            -ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0,startColorstr=#E5E5E5,endColorstr=#ffffff)";
                            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#E5E5E5, endColorstr=#ffffff)
                        }

                        #dialog_ajax_loading {
                            padding: 0
                        }

                        .no_dialog_min_limit {
                            min-width: 100px !important;
                            min-height: 100px !important
                        }

                        .loading_video_ff {
                            margin: 26px;
                            width: 48px;
                            height: 48px
                        }

                        .loading_gif, .loading_gif:hover {
                            background: url(../../images/loading/login_loading_company.gif) 0 0 no-repeat;
                            width: 48px;
                            height: 48px;
                            position: relative;
                            display: block
                        }

                        .btn_loading_gif, .iu_dialog_button.btn_loading_gif, .btn_loading_gif_orange {
                            text-indent: -1000em;
                            background-color: #abb3b9 !important;
                            border-color: #abb3b9 !important;
                            background-position: center center !important;
                            cursor: default !important;
                            box-shadow: none !important;
                            background-image: url(../../images/loading/company_btn_loading.gif);
                            background-repeat: no-repeat !important
                        }

                        .btn_loading_gif:hover, .iu_dialog_button.btn_loading_gif:hover {
                            background-repeat: no-repeat !important;
                            background-image: url(../../images/loading/company_btn_loading.gif)
                        }

                        .com_btn_white.btn_loading_gif, .com_btn_white.btn_loading_gif:hover {
                            background-color: #f5f5f5 !important;
                            border-color: #cccccc !important;
                            background-image: url(../../images/loading/cancel_btn_loading.gif)
                        }

                        .iu_dialog_button_orange_note.btn_loading_gif, .iu_dialog_button_orange_note.btn_loading_gif:hover, .btn_login_orange.btn_loading_gif, .btn_login_orange.btn_loading_gif:hover, .com_btn_orange.btn_loading_gif, .com_btn_orange.btn_loading_gif:hover {
                            background-color: #ffd6ad !important;
                            border: 1px solid #ffd6ad !important;
                            background-image: url(../../images/loading/create_btn_loading.gif)
                        }

                        .iu_dialog_danger .iu_dialog_button_1.btn_loading_gif, .iu_dialog_danger .iu_dialog_button_1.btn_loading_gif:hover {
                            background-color: #fac4b9 !important;
                            border: 1px solid #fac4b9 !important;
                            background-image: url(../../images/loading/delete_btn_loading.gif)
                        }

                        .loaddata_gif, .loaddata_gif:hover {
                            background: url(../../images/loading/default_loading_bg_white.gif) no-repeat;
                            width: 48px;
                            height: 48px;
                            margin: 0 auto;
                            position: relative;
                            top: 32%;
                            display: block
                        }

                        .btn_loading_gif_orange, .btn_loading_gif_orange:hover {
                            background-color: #ffd6ad !important;
                            border-color: #ffd6ad !important;
                            background-image: url(../../images/loading/create_btn_loading.gif)
                        }

                        .com_loading_box {
                            width: 50px;
                            height: 50px;
                            position: absolute;
                            z-index: 9990;
                            left: 50%;
                            top: 50%;
                            margin-left: -25px;
                            margin-top: -25px;
                            display: none
                        }

                        .loadingdata_gif, .loadingdata_gif:hover {
                            background: url(../../images/loading/default_loading_bg_white.gif) no-repeat;
                            width: 48px;
                            height: 48px;
                            margin: 0 auto;
                            position: relative;
                            top: 32%;
                            display: block
                        }

                        .di_menu_handle, .menu_handle, .eci_handle, .menu_super
                        .btn_down {
                            border: 1px solid #ccc;
                            border-radius: 3px;
                            color: #333;
                            cursor: pointer;
                            width: 95px;
                            height: 28px;
                            line-height: 28px;
                            padding: 0 15px 0 8px;
                            position: relative;
                            background-image: url(about:blank);
                            background: -moz-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -webkit-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -o-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -ms-linear-gradient(top, #ffffff, #F8F8F8);
                            -ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=#ffffff, endColorstr=#F8F8F8)";
                            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#ffffff, endColorstr=#F8F8F8)
                        }

                        .di_menu_handle:hover, .menu_handle:hover, .eci_handle:hover, .menu_super .btn_down:hover {
                            border-color: #c2c2c2;
                            background: -moz-linear-gradient(top, #ffffff, #F6F6F6);
                            background: -webkit-linear-gradient(top, #ffffff, #F6F6F6);
                            background: -o-linear-gradient(top, #ffffff, #F6F6F6);
                            background: -ms-linear-gradient(top, #ffffff, #F6F6F6);
                            -ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=#ffffff, endColorstr=#F6F6F6)";
                            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#ffffff, endColorstr=#F6F6F6);
                            box-shadow: 0 1px 2px rgba(0, 0, 0, .1)
                        }

                        .di_menu_handle.disable, .menu_handle.disable, .eci_handle.disable {
                            color: #ccc;
                            cursor: default;
                            background: -moz-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -webkit-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -o-linear-gradient(top, #ffffff, #F8F8F8);
                            background: -ms-linear-gradient(top, #ffffff, #F8F8F8);
                            -ms-filter: "progid:DXImageTransform.Microsoft.gradient (GradientType=0, startColorstr=#ffffff, endColorstr=#F8F8F8)";
                            filter: progid:DXImageTransform.Microsoft.gradient(GradientType=0, startColorstr=#ffffff, endColorstr=#F8F8F8);
                            box-shadow: none
                        }

                        .di_menu_handle .triangle, .menu_handle .triangle, .eci_handle
                        .triangle {
                            border-width: 4px;
                            border-bottom-width: 0;
                            top: 40%;
                            right: 8px;
                            position: absolute
                        }

                        .btn_complex_orange {
                            height: 28px;
                            line-height: 28px;
                            text-align: center
                        }

                        .btn_orange_text, .btn_orange_button {
                            background-color: #f93;
                            color: #fff;
                            cursor: pointer;
                            display: inline-block;
                            vertical-align: top
                        }

                        .btn_orange_text {
                            border-top-left-radius: 3px;
                            border-bottom-left-radius: 3px;
                            border: 1px solid #f93;
                            border-right: 1px solid #fdb777;
                            padding: 0px 15px;
                            vertical-align: top;
                            white-space: nowrap;
                            overflow: hidden;
                            text-overflow: ellipsis;
                            word-wrap: normal
                        }

                        .btn_orange_button {
                            width: 20px;
                            text-align: center;
                            border-top-right-radius: 3px;
                            border-bottom-right-radius: 3px;
                            border: 1px solid #f93;
                            vertical-align: top
                        }

                        .btn_orange_text:hover, .btn_orange_button:hover {
                            border-color: #fc8824;
                            background-color: #fc8824;
                            box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.1);
                            box-shadow: 0px 2px 1px #d9d9d9 \0
                        }

                        .btn_orange_text:hover {
                            border-right: 1px solid #fdb777
                        }

                        .btn_orange_button:hover, .btn_orange_button:active {
                        }

                        .btn_white_triangle_down {
                            width: 0;
                            height: 0;
                            font-size: 0;
                            line-height: 0;
                            display: inline-block;
                            *zoom: 1;
                            *display: inline;
                            border-width: 4px;
                            border-style: solid;
                            border-left-color: transparent;
                            border-right-color: transparent;
                            border-bottom-color: transparent;
                            border-bottom-width: 0;
                            vertical-align: top;
                            margin-top: 11px
                        }

                        .head_menu .official_version, .official_version, .official_version:hover {
                            color: #f93
                        }

                        @media (min-width: 1050px) {
                            .head_bottom {
                                padding: 0 20px
                            }

                            .hb_btn_outer
                            .hb_btn {
                                padding: 0 80px 0 17px
                            }
                        }

                        @media (max-width: 1350px) {
                            .icon_ellipsis {
                                display: inline-block !important
                            }

                            .icon_task, .icon_colleague {
                                display: none !important
                            }
                        }

                        @media (min-width: 1351px) {
                            .icon_ellipsis {
                                display: none !important
                            }

                            .icon_task, .icon_colleague {
                                display: inline-block
                            }
                        }

                        #user_menu_default_avatar {
                            background-image: url('../../images/default_avatar_web21.png')
                        }

                        a.link_orange {
                            color: #f93
                        }

                        .widget_menu, .eci_menu, .widget_page_menu, .menu, .di_menu, .ecard_menu {
                            background-color: #fff;
                            padding: 7px 0;
                            position: absolute;
                            right: 0;
                            top: 26px;
                            border-radius: 2px;
                            box-shadow: 0 2px 5px rgba(51, 51, 51, 0.3);
                            box-shadow: 0 0 0 \9;
                            border: 1px solid #c2c2c2;
                            display: none;
                            z-index: 3
                        }

                        .widget_menu, .eci_menu, .widget_page_menu, .menu, .di_menu {
                            width: 110px
                        }

                        .option
                        .widget_menu {
                            top: 30px;
                            white-space: nowrap
                        }

                        .widget_menu_item, .eci_menu_item, .widget_page_menu_item, .menu_item, .di_menu_item, .ecard_menu_item {
                            font-size: 12px;
                            height: 30px;
                            line-height: 30px;
                            padding: 0 18px;
                            color: #333;
                            cursor: pointer;
                            display: block
                        }

                        .widget_menu_item {
                            font-weight: bold
                        }

                        .widget_menu_item:hover, .eci_menu_item:hover, .widget_page_menu_item:hover, .menu_item:hover, .di_menu_item:hover, .ecard_menu_item:hover {
                            background-color: #f5f5f5
                        }

                        .ecard_menu {
                            min-width: 100%;
                            left: 0
                        }

                        .ecard_menu_item {
                            text-align: center;
                            font-weight: normal
                        }

                        .dialog_modify_crm_pwd {
                            padding: 60px 100px;
                            color: #333;
                            width: 350px
                        }

                        .dmcp_title {
                            font-size: 18px;
                            text-align: center;
                            font-weight: bold
                        }

                        .dmcp_tip {
                            margin: 10px 0 30px;
                            text-align: center
                        }

                        .dmcp_input_tip {
                            margin-top: 18px
                        }

                        .dialog_modify_crm_pwd
                        .input_outer {
                            width: 328px;
                            margin-top: 10px
                        }

                        .dialog_modify_crm_pwd
                        .error {
                            margin: 10px -11px
                        }

                        .dialog_mo {
                            min-width: 0
                        }

                        .dialog_mo
                        .dialog_modify_crm_pwd {
                            padding: 20px 15px;
                            width: 250px
                        }

                        .dialog_mo
                        .input_outer {
                            width: 100%;
                            box-sizing: border-box
                        }

                        .dialog_mo
                        .dmcp_tip {
                            margin-bottom: 0
                        }

                        .left_nav {
                            background-color: #fff;
                            border: 1px solid #ccc
                        }

                        .left_nav_item {
                            font-size: 12px;
                            height: 36px;
                            line-height: 36px;
                            color: #333;
                            padding-left: 20px;
                            padding-right: 10px;
                            box-sizing: border-box;
                            background-color: #fff;
                            border-top: 1px solid #F5F5F5
                        }

                        .left_nav_item:first-child {
                            border-top: none !important
                        }

                        .left_nav_item.has_right {
                            padding-right: 0
                        }

                        .left_nav_item.has_right
                        .nav_item_text {
                            float: left
                        }

                        .left_nav_item.has_right
                        .nav_item_right {
                            float: right;
                            padding-right: 20px;
                            height: 36px
                        }

                        .left_nav_item.has_right
                        .submenu {
                            width: 9px;
                            height: 7px;
                            margin-top: 15px;
                            background: url(../../images/ico/cc_btn_ico_20141229160000.png) 0 -408px no-repeat
                        }

                        .left_nav_item.has_right.open
                        .submenu {
                            background: url(../../images/task/left_fold_arrow.png) no-repeat scroll left top transparent
                        }

                        .left_nav_item.has_right .submenu:hover {
                            background: url(../../images/ico/cc_btn_ico_20141229160000.png) 0 -445px no-repeat
                        }

                        .left_nav_item.has_right.open .submenu:hover {
                            background: url(../../images/task/left_fold_arrow_hover.png) no-repeat scroll left top transparent
                        }

                        .left_nav_item.has_icon {
                            padding-left: 45px
                        }

                        .left_nav_item.selected {
                            border-left: 5px solid #2d4051;
                            border-top: 1px solid #ccc;
                            font-weight: bold;
                            background-color: #F5F5F5;
                            padding-left: 15px
                        }

                        .left_nav_item.has_icon.selected {
                            padding-left: 40px
                        }

                        .edm_com_tab_head, .edm_com_tab_body {
                            width: 100%
                        }

                        .edm_com_tab {
                            height: 30px;
                            padding: 0 10px;
                            color: #919AA3;
                            background-color: #F2F2F2
                        }

                        .edm_com_tab_body
                        .edm_com_tab {
                            padding: 10px;
                            border-bottom: 1px solid #F2F2F2;
                            background-color: #fff
                        }

                        .edm_com_tab_body
                        tr {
                            height: 50px
                        }

                        .edm_com_tab_head .edm_com_tab ~ .edm_com_tab,
                        .edm_com_tab_body .edm_com_tab ~ .edm_com_tab {
                            padding-left: 0
                        }

                        @font-face {
                            font-family: 'icomoon';
                            src: url('../../fonts/icomoon.eot?96prbs');
                            src: url('../../fonts/icomoon.eot?96prbs#iefix') format('embedded-opentype'),
                            url('../../fonts/icomoon.ttf?96prbs') format('truetype'),
                            url('../../fonts/icomoon.woff?96prbs') format('woff'),
                            url('../../fonts/icomoon.svg?96prbs#icomoon') format('svg');
                            font-weight: normal;
                            font-style: normal
                        }

                        [class^="icon-"], [class*=" icon-"] {
                            font-family: 'icomoon' !important;
                            speak: none;
                            font-style: normal;
                            font-weight: normal;
                            font-variant: normal;
                            text-transform: none;
                            line-height: 1;
                            -webkit-font-smoothing: antialiased;
                            -moz-osx-font-smoothing: grayscale
                        }

                        .icon-copy:before {
                            content: "\e928"
                        }

                        .icon-smile:before {
                            content: "\e927"
                        }

                        .icon-star_stroke:before {
                            content: "\e926"
                        }

                        .icon-info_write:before {
                            content: "\e925"
                        }

                        .icon-star:before {
                            content: "\e902"
                        }

                        .icon-success:before {
                            content: "\e900"
                        }

                        .icon-allmember:before {
                            content: "\e903"
                        }

                        .icon-account_circle:before {
                            content: "\e904"
                        }

                        .icon-alert:before {
                            content: "\e905"
                        }

                        .icon-arrowdown:before {
                            content: "\e906"
                        }

                        .icon-arrowright:before {
                            content: "\e907"
                        }

                        .icon-back:before {
                            content: "\e908"
                        }

                        .icon-backtotop:before {
                            content: "\e909"
                        }

                        .icon-call:before {
                            content: "\e90a"
                        }

                        .icon-camera_alt:before {
                            content: "\e90b"
                        }

                        .icon-cancel:before {
                            content: "\e90c"
                        }

                        .icon-chevron_left:before {
                            content: "\e90d"
                        }

                        .icon-chevron_right:before {
                            content: "\e90e"
                        }

                        .icon-fail:before {
                            content: "\e901"
                        }

                        .icon-delete:before {
                            content: "\e90f"
                        }

                        .icon-domain:before {
                            content: "\e910"
                        }

                        .icon-edit:before {
                            content: "\e911"
                        }

                        .icon-email:before {
                            content: "\e912"
                        }

                        .icon-error:before {
                            content: "\e913"
                        }

                        .icon-expand_less:before {
                            content: "\e914"
                        }

                        .icon-expand_more:before {
                            content: "\e915"
                        }

                        .icon-gps_fixed:before {
                            content: "\e916"
                        }

                        .icon-home_menu:before {
                            content: "\e917"
                        }

                        .icon-info:before {
                            content: "\e918"
                        }

                        .icon-invite:before {
                            content: "\e919"
                        }

                        .icon-legal_person:before {
                            content: "\e91a"
                        }

                        .icon-list:before {
                            content: "\e91b"
                        }

                        .icon-location:before {
                            content: "\e91c"
                        }

                        .icon-member:before {
                            content: "\e91d"
                        }

                        .icon-minus:before {
                            content: "\e91e"
                        }

                        .icon-no_interested:before {
                            content: "\e91f"
                        }

                        .icon-no_permisssion:before {
                            content: "\e920"
                        }

                        .icon-plus:before {
                            content: "\e921"
                        }

                        .icon-search:before {
                            content: "\e922"
                        }

                        .icon-share:before {
                            content: "\e923"
                        }

                        .icon-tag:before {
                            content: "\e924"
                        }
                    </style>
                    <style>
                        @charset "utf-8";
                        .zh_tw, .zh_tw input, .zh_tw
                        textarea {
                            font-family: 'Microsoft YaHei', Arial, sans-serif
                        }

                        .head_login_ago2 {
                            width: 100%;
                            height: 120px;
                            display: block;
                            background: url('../../images/site/home_top_201503181400_5050.png') #1f2f3d center center
                        }

                        .head_login_ago2
                        .inner {
                            margin: 0px auto;
                            display: block;
                            width: 1000px;
                            height: 120px;
                            position: relative
                        }

                        .head_login_ago .head_top, .head_login_ago2
                        .head_top {
                            width: 100%;
                            height: 80px;
                            display: block;
                            position: relative;
                            background-color: inherit
                        }

                        .logo_login_ago {
                            width: 266px;
                            height: 30px;
                            padding: 0;
                            vertical-align: top;
                            background: url(../../images/site/ccb_logo_en_20160705a.png) 0px 0px no-repeat;
                            float: none;
                            position: absolute;
                            left: 50px;
                            top: 25px
                        }

                        .logo_login_ago:hover {
                            background-color: inherit
                        }

                        .zh_cn
                        .logo_login_ago {
                            width: 194px;
                            height: 30px;
                            vertical-align: top;
                            background: url(../../images/site/ccb_logo_cn_20160705a.png) 0px 0px no-repeat
                        }

                        .head_logo_handler_outer {
                            position: absolute;
                            left: 320px;
                            top: 23px
                        }

                        .zh_cn
                        .head_logo_handler_outer {
                            left: 247px
                        }

                        .head_logo_handler {
                            cursor: pointer
                        }

                        .head_logo_triangle {
                            width: 9px;
                            height: 7px;
                            vertical-align: top;
                            margin: 14px 0px 0px 10px;
                            background: url(../../images/site/head_logo_down_201411212020.png) 0px 0px no-repeat
                        }

                        .btn_hr_outer {
                            position: relative
                        }

                        .head_login_ago .head_language_menu_new20140926, .head_login_ago .head_logo_menu_new20140926, .head_login_ago2 .head_language_menu_new20140926, .head_login_ago2
                        .head_logo_menu_new20140926 {
                            position: absolute;
                            background-color: #EBEBEB;
                            border-radius: 2px;
                            padding: 5px 0;
                            display: none;
                            z-index: 10;
                            box-shadow: 0 0px 2px #999;
                            width: auto
                        }

                        .head_logo_menu_new20140926 {
                            top: 65px;
                            left: 50px;
                            width: 186px
                        }

                        .head_language_menu_new20140926 {
                            left: 0px;
                            top: 33px;
                            width: 144px
                        }

                        .is {
                            background: url(../../images/intsig_logo.png) 10px center no-repeat
                        }

                        .is:hover {
                            color: #ea7604
                        }

                        .sc {
                            background: url(../../images/cs_logo.png) 10px center no-repeat
                        }

                        .sc:hover {
                            color: #2ab593
                        }

                        .head_login_ago .hm_item, .head_login_ago2
                        .hm_item {
                            text-align: left;
                            line-height: 35px;
                            cursor: pointer;
                            display: block;
                            text-decoration: none;
                            color: #333;
                            padding-left: 45px;
                            padding-right: 15px;
                            min-width: 125px
                        }

                        .head_login_ago .hm_item:hover, .head_login_ago2 .hm_item:hover {
                            background-color: #fff;
                            color: #008bd3
                        }

                        .head_login_ago .hm_item.select, .head_login_ago2
                        .hm_item.select {
                            background-image: url(../../images/cc_language_select_icon.png);
                            background-repeat: no-repeat;
                            background-position: 90% center
                        }

                        .btns_head_right {
                            float: right;
                            margin-top: 30px;
                            margin-right: 50px
                        }

                        .btn_hr {
                            color: #fff;
                            margin-left: 30px;
                            text-decoration: none;
                            cursor: pointer
                        }

                        .select
                        .btn_hr {
                            opacity: 0.8;
                            -webkit-transition: opacity 400ms ease, margin-top 400ms ease, padding-bottom 300ms ease, background-color 200ms ease
                        }

                        .head_login_ago .nav_last, .head_login_ago2
                        .nav_last {
                            margin-left: 70px
                        }

                        .btn_hr:hover, .btn_hr.checked {
                            border-bottom: 2px solid #fff;
                            padding-bottom: 5px;
                            opacity: 1
                        }

                        .transition_ease {
                            letter-spacing: 1px;
                            font-size: 12px;
                            font-weight: bold;
                            color: #fff;
                            text-transform: uppercase
                        }

                        .head_nav_box {
                            width: auto;
                            height: auto;
                            display: block;
                            position: relative;
                            background-color: inherit;
                            top: 0px;
                            left: 50px
                        }

                        a.head_nav_link, a.head_nav_link:link, a.head_nav_link:visited {
                            letter-spacing: 1px;
                            font-size: 12px;
                            font-weight: bold;
                            color: #fff;
                            opacity: 0.8;
                            -webkit-transition: opacity 400ms ease, margin-top 400ms ease, padding-bottom 300ms ease;
                            text-transform: uppercase;
                            text-decoration: none;
                            display: inline-block
                        }

                        a.head_nav_link:hover {
                            text-decoration: underline
                        }

                        .head_nav_arrow {
                            width: 5px;
                            height: 7px;
                            margin: 0px 10px 0px;
                            background: url(../../images/site/head_nav_arrow.png) left top no-repeat;
                            display: inline-block
                        }

                        .btn_hr_login {
                            border: 1px solid rgba(255, 255, 255, .6);
                            border: 1px solid #f5f5f5 \9;
                            height: 25px;
                            line-height: 25px;
                            width: 76px;
                            text-align: center;
                            border-radius: 3px;
                            color: #fff;
                            text-decoration: none;
                            margin-left: 70px;
                            transition: background-color 200ms ease;
                            -moz-transition: background-color 200ms ease;
                            -webkit-transition: background-color 200ms ease
                        }

                        .btn_hr_login:hover {
                            font-weight: bold;
                            border-width: 1px;
                            padding-bottom: 0px;
                            background-color: #fff;
                            color: #24303E
                        }

                        .version {
                            margin-left: 20px
                        }

                        .foot_new {
                            width: 100%;
                            height: auto;
                            display: block;
                            background-color: #313131;
                            text-align: center;
                            border-top: 0px solid #313131
                        }

                        .foot_new
                        .inner {
                            width: 1000px;
                            height: auto;
                            display: block;
                            margin: 0px auto
                        }

                        .foot_link_box1 {
                            width: 100%;
                            height: 20px;
                            line-height: 20px;
                            display: block;
                            overflow: hidden;
                            margin-top: 23px
                        }

                        .b_link {
                            font-size: 12px;
                            color: #ccc;
                            text-decoration: none;
                            overflow: hidden;
                            text-transform: uppercase
                        }

                        .b_link:hover {
                            text-decoration: underline
                        }

                        .b_link.no_hover {
                            text-decoration: none
                        }

                        .b_dline {
                            width: 1px;
                            height: 20px;
                            overflow: hidden;
                            border-left: 1px solid #464646;
                            margin-left: 20px;
                            margin-right: 20px
                        }

                        .foot_copyright {
                            width: 100%;
                            height: auto;
                            display: block;
                            overflow: hidden;
                            color: #707070;
                            margin-bottom: 30px
                        }

                        .copy_info {
                            text-transform: uppercase
                        }

                        .btn_ftr {
                            width: 44px;
                            height: 44px;
                            line-height: 44px;
                            margin: 0 18px;
                            cursor: pointer
                        }

                        .foot_icon
                        .btn_ftr.first {
                            margin-left: 0;
                            border-width: 0px
                        }

                        .foot_bottom {
                            text-transform: uppercase
                        }

                        .foot_icon {
                            margin: 47px 0px 44px;
                            position: relative
                        }

                        .btn_ftr.facebook {
                            background-image: url(../../images/sns/sns_fb.png)
                        }

                        .btn_ftr.googleplus {
                            background-image: url(../../images/sns/sns_gplus.png)
                        }

                        .btn_ftr.twitter {
                            background-image: url(../../images/sns/sns_twitter_201409291300.png)
                        }

                        .btn_ftr.youtube {
                            background-image: url(../../images/sns/sns_youtube.png)
                        }

                        .btn_ftr.sina {
                            background-image: url(../../images/sns/sns_weibo_201409291300.png)
                        }

                        .btn_ftr.wechat {
                            background-image: url(../../images/sns/sns_wechat.png)
                        }

                        .btn_ftr.youku {
                            background-image: url(../../images/sns/sns_youku.png)
                        }

                        .price_bottom_h {
                            width: 100%;
                            height: 35px;
                            display: block;
                            overflow: hidden;
                            clear: both
                        }

                        .wx_dialog
                        .iu_dialog {
                            box-shadow: none;
                            background-color: inherit;
                            min-width: 0;
                            min-height: 0
                        }

                        .wx_dialog
                        .iu_dialog_mask {
                            background-color: inherit
                        }

                        .download_show_wx {
                            display: block;
                            position: absolute;
                            width: 320px;
                            height: 336px;
                            padding: 0;
                            left: 50%;
                            margin-left: -160px;
                            bottom: 100%
                        }

                        .boxwx {
                            height: 316px
                        }

                        .download_show_wx
                        .showbox {
                            position: relative
                        }

                        .download_show_wx
                        .bgwx {
                            background: #000;
                            filter: alpha(opacity=75);
                            -moz-opacity: 0.75;
                            opacity: 0.75;
                            position: absolute;
                            width: 320px;
                            height: 336px;
                            top: 0;
                            z-index: 9999;
                            border-radius: 4px
                        }

                        .download_show_wx
                        .codeimg {
                            position: relative;
                            z-index: 10001;
                            width: 164px;
                            height: 164px;
                            margin: 0 auto;
                            padding-top: 70px
                        }

                        .download_show_wx
                        .desc {
                            position: relative;
                            color: #fff;
                            z-index: 10001;
                            padding: 44px 58px 0;
                            font-size: 16px
                        }

                        .download_wxqrcode {
                            width: 164px;
                            height: 164px;
                            background: url(../../images/cc_wxcode_201603281700.png) center bottom no-repeat;
                            background-size: 100%
                        }

                        .download_qrcode_title {
                            font-weight: bold;
                            text-align: center
                        }

                        .download_qrcode_content {
                            margin-top: 5px;
                            line-height: 20px;
                            text-align: center
                        }

                        .head_topbox80, .head_topbox80
                        .htop80 {
                            height: 80px
                        }

                        .head_topbox80 {
                            background: url('../../images/site/home_top_201503181400.png') repeat scroll center bottom #1F2F3D
                        }

                        .head_language_ico {
                            background: url(../../images/site/head_language_ico.png) left top no-repeat;
                            padding-left: 32px;
                            line-height: 18px
                        }

                        .tip_input {
                            margin-top: 23px;
                            font-size: 12px;
                            color: #333;
                            font-weight: bold;
                            overflow: hidden
                        }

                        .input_outer {
                            padding: 0px
                        }

                        .input_text, .di_input_text {
                            margin-left: 0px
                        }

                        .foot_v16_1
                        .inner {
                            margin: 0px auto;
                            display: block;
                            width: 1000px;
                            height: 120px
                        }

                        .foot_link_box_v16 {
                            border-top: 1px solid #e1e1e1;
                            height: 70px;
                            margin-top: 35px;
                            padding-top: 25px;
                            text-align: center
                        }

                        .foot_link_box_v16 a.b_link, .foot_link_box_v16 a.b_link:link, .foot_link_box_v16 a.b_link:visited {
                            color: #acacac
                        }

                        .foot_link_box_v16 a.b_link:hover {
                            color: #707070
                        }

                        .foot_link_box_v16
                        .b_dline {
                            border-left: 1px solid #e1e1e1
                        }

                        .ccb_or_box {
                            margin: 0px;
                            display: block;
                            position: relative;
                            z-index: 1;
                            height: 20px;
                            margin-bottom: 20px
                        }

                        .ccb_or_line {
                            width: 100%;
                            height: 0px;
                            display: block;
                            overflow: hidden;
                            border-bottom: 1px dotted #ccc;
                            position: absolute;
                            z-index: 2;
                            top: 9px;
                            left: 0px
                        }

                        .ccb_or_over {
                            width: 100%;
                            height: 20px;
                            position: absolute;
                            z-index: 99;
                            text-align: center
                        }

                        .ccb_or_txt {
                            padding-left: 6px;
                            padding-right: 6px;
                            color: #acacac;
                            font-size: 12px;
                            margin: 0px auto;
                            display: inline-block;
                            background-color: #fff
                        }

                        .korea_show_box {
                            width: 600px;
                            height: 377px;
                            display: block;
                            overflow: hidden;
                            background: url(../../images/site/korea_show_201504271800.png) no-repeat;
                            position: fixed;
                            right: 10px;
                            bottom: 10px;
                            z-index: 900
                        }

                        .korea_show_box
                        .iu_dialog_close {
                            top: 10px;
                            right: 10px
                        }

                        .link_app_store, .link_google_pany {
                            position: absolute;
                            width: 105px;
                            height: 30px;
                            bottom: 17px;
                            right: 25px;
                            cursor: pointer;
                            z-index: 10
                        }

                        .link_app_store {
                            right: 135px
                        }

                        .link_email {
                            position: absolute;
                            width: 600px;
                            height: 377px;
                            top: 28px;
                            left: 0px;
                            cursor: pointer;
                            z-index: 1
                        }

                        .register_old {
                            margin: 0px;
                            text-align: center;
                            padding-top: 5px;
                            padding-bottom: 5px;
                            height: 30px;
                            line-height: 30px;
                            border-radius: 3px;
                            width: 350px;
                            position: relative;
                            font-size: 12px;
                            font-weight: bold;
                            color: #FFF;
                            background-color: #21a9ed;
                            text-decoration: none
                        }

                        .register_old:hover, .register_old:active {
                            background-color: #1d9de0;
                            box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.1);
                            box-shadow: 0 2px 1px #d9d9d9 \0;
                            text-decoration: none
                        }

                        .register_old_img {
                            background: url(../../images/user/signin_with_cc_account_logo_201503231800.png) left top no-repeat;
                            height: 26px;
                            width: 26px;
                            position: absolute;
                            left: 7px;
                            top: 7px
                        }

                        .register_old_line2 {
                            width: 1px;
                            height: 30px;
                            position: absolute;
                            left: 40px;
                            top: 5px;
                            background-color: rgba(255, 255, 255, 0.3);
                            background-color: #63c2f1 \9
                        }

                        .register_old_signtitle {
                            display: inline-block;
                            margin: 0px auto;
                            padding-left: 42px
                        }

                        .invitation_link_bar:hover
                        .register_old_signtitle {
                            text-decoration: none
                        }

                        .register_or {
                            width: 350px;
                            height: 30px;
                            line-height: 30px;
                            position: relative;
                            text-align: center;
                            margin-top: 10px
                        }

                        .register_or_line {
                            width: 350px;
                            height: 0px;
                            overflow: hidden;
                            border-bottom: 1px dotted #d5d9dc;
                            position: absolute;
                            top: 15px;
                            left: 0px;
                            z-index: 1
                        }

                        .register_or_inner {
                            width: 100%;
                            height: 30px;
                            position: absolute;
                            top: 0px;
                            left: 0px;
                            z-index: 2;
                            text-align: center
                        }

                        .register_or_text {
                            background-color: #fff;
                            display: inline-block;
                            height: 30px;
                            line-height: 30px;
                            color: #acacac;
                            margin: 0px auto;
                            padding: 0px 5px
                        }

                        .en_us
                        .register_or_text {
                            font-style: italic
                        }

                        .complete_nav {
                            text-align: center;
                            height: 20px;
                            line-height: 20px;
                            margin-top: 18px
                        }

                        .complete_nav
                        .complete_btn {
                            font-size: 12px;
                            font-weight: bold;
                            color: #1b84b2;
                            cursor: pointer;
                            vertical-align: top;
                            color: #999;
                            border-bottom: 2px solid #e1e1e1;
                            width: 104px
                        }

                        .en_us .complete_nav
                        .complete_btn {
                        }

                        .complete_nav
                        .nav_select {
                            border-bottom-color: #f93;
                            color: #333
                        }

                        .complete_nav
                        .nav_line {
                            width: 0px;
                            overflow: hidden;
                            border-left: 1px solid #CCC;
                            margin: 0px 15px
                        }

                        a.link_no_line, a.link_no_line:link, a.link_no_line:hover, a.link_no_line:visited {
                            text-decoration: none;
                            outline: medium none
                        }

                        .complete_title, .user_complete_title {
                            display: block;
                            overflow: hidden;
                            text-align: center;
                            font-size: 24px;
                            color: #333;
                            line-height: 36px;
                            word-wrap: break-word
                        }

                        .complete_title2, .user_complete_title2 {
                            display: block;
                            overflow: hidden;
                            text-align: center;
                            font-size: 12px;
                            color: #707070;
                            margin-top: 20px;
                            line-height: 24px;
                            word-wrap: break-word
                        }

                        .complete_t_mtop {
                            margin-top: 23px
                        }

                        .sign_r_explanation {
                            width: 440px;
                            height: auto;
                            min-height: 498px;
                            text-align: left
                        }

                        .exp_title {
                            width: 360px;
                            height: auto;
                            line-height: 30px;
                            display: block;
                            overflow: hidden;
                            margin-top: 30px;
                            margin-left: 40px;
                            font-size: 18px
                        }

                        .ja_jp .exp_title, .ko_kr
                        .exp_title {
                            font-weight: bold
                        }

                        .exp_liBox {
                            width: 440px;
                            height: 80px;
                            overflow: hidden;
                            margin-bottom: 10px
                        }

                        .exp_liBox_first {
                            margin-top: 20px
                        }

                        .exp_liBox
                        .imgs {
                            width: 80px;
                            height: 80px;
                            display: inline;
                            float: left
                        }

                        .exp_liBox
                        .img01 {
                            background: url(../../images/user/sign_img_exp01_20141120.png) left top no-repeat
                        }

                        .exp_liBox
                        .img02 {
                            background: url(../../images/user/sign_img_exp02_20141120.png) left top no-repeat
                        }

                        .exp_liBox
                        .img03 {
                            background: url(../../images/user/sign_img_exp03_20141120.png) left top no-repeat
                        }

                        .exp_liBox
                        .img04 {
                            background: url(../../images/user/sign_img_exp04_20141120.png) left top no-repeat
                        }

                        .exp_right {
                            width: 330px;
                            height: 80px;
                            line-height: 80px;
                            display: inline;
                            float: left;
                            margin-left: 30px
                        }

                        .exp_r_inner {
                            display: inline-block;
                            vertical-align: middle
                        }

                        .exp_liBox .exp_txt1, .exp_liBox
                        .exp_txt2 {
                            width: 330px;
                            line-height: 20px;
                            font-weight: bold;
                            font-size: 12px
                        }

                        .ko_kr .exp_liBox
                        .exp_txt1 {
                            height: 40px
                        }

                        .exp_liBox
                        .exp_txt2 {
                            font-weight: normal
                        }

                        .btn_register {
                            display: inline-block;
                            width: 350px;
                            height: 40px;
                            cursor: pointer;
                            line-height: 40px;
                            text-align: center;
                            background-color: #F93;
                            color: #FFF;
                            font-size: 12px;
                            font-weight: bold;
                            border-radius: 3px
                        }

                        .btn_register:hover, .btn_register:active {
                            background-color: #fc8f30;
                            box-shadow: 0px 2px 1px rgba(115, 66, 30, 0.15);
                            box-shadow: 0px 2px 1px #d9d9d9 \0
                        }

                        .tip_input {
                            margin-top: 17px;
                            font-size: 12px;
                            color: #333;
                            font-weight: bold;
                            overflow: hidden
                        }

                        .input_first_top {
                            margin-top: 0px
                        }

                        .register_tab {
                            list-style-type: none;
                            padding: 0;
                            width: 350px;
                            text-align: center;
                            margin: 0
                        }

                        .register_tab
                        li {
                            display: inline-block;
                            width: 175px;
                            padding: 20px 0;
                            background-color: #dadada;
                            cursor: pointer
                        }

                        .register_tab
                        li.selected {
                            background-color: #fff
                        }

                        .reg_by_mobile {
                            display: none
                        }

                        .input_mobile {
                            margin-left: 90px !important;
                            width: 237px !important;
                            padding-left: 10px !important
                        }

                        .btn_register_by_mobile {
                            display: none
                        }

                        .input_verifycode {
                            width: 148px;
                            display: inline-block;
                            float: left
                        }

                        .resend_vcode {
                            width: 128px;
                            float: left;
                            margin-left: 10px
                        }

                        .register_middle_line {
                            width: 8px;
                            height: 447px;
                            display: inline;
                            float: left;
                            background: url('../../images/user/signup_rightarrow.png') center center;
                            margin: 7px 40px 0px 40px
                        }

                        .signBox
                        .tip {
                            font-size: 30px;
                            color: #333;
                            text-align: center;
                            text-transform: uppercase;
                            margin-bottom: 55px
                        }

                        .register_line2 {
                            width: 0px;
                            height: 30px;
                            overflow: hidden;
                            display: inline;
                            float: left;
                            border-left: 1px solid #38b2ef;
                            border-right: 1px solid #1e98d5
                        }

                        .check_email_title {
                            display: block;
                            overflow: hidden;
                            text-align: center;
                            font-size: 24px;
                            color: #333;
                            padding-top: 54px
                        }

                        .check_email_subtitle {
                            display: block;
                            overflow: hidden;
                            text-align: center;
                            font-size: 12px;
                            color: #333;
                            margin-top: 50px;
                            line-height: 24px
                        }

                        .check_email_subtitle
                        a {
                            color: #1B84B2;
                            text-decoration: none
                        }

                        .check_email_btn {
                            width: 300px;
                            height: 30px;
                            line-height: 30px;
                            text-align: center;
                            border-radius: 3px;
                            font-size: 12px;
                            color: #FFF;
                            font-weight: bold;
                            background-color: #2D4051;
                            display: inline-block;
                            cursor: pointer;
                            margin: 30px auto 0px
                        }

                        .check_email_btn:hover {
                            background-color: #243341;
                            box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.2)
                        }

                        .check_email_line {
                            text-align: left;
                            margin-bottom: 30px;
                            border-bottom: 1px solid #e1e1e1;
                            padding-bottom: 50px
                        }

                        .check_email_topic {
                            font-size: 12px;
                            font-weight: bold;
                            color: #333;
                            text-align: left;
                            vertical-align: top
                        }

                        .check_email_item {
                            font-size: 12px;
                            color: #333;
                            line-height: 24px;
                            text-align: left;
                            position: relative
                        }

                        .showemail {
                            text-decoration: none
                        }

                        .btn_crm_blue_disable, .btn_crm_blue_disable:hover {
                            color: #a4cee0;
                            cursor: default;
                            text-decoration: none;
                            background: none
                        }

                        .reg_by_mobile
                        .iu_mselect_frame {
                            left: 0 !important;
                            border-radius: 3px
                        }

                        .reg_by_mobile
                        .iu_mselect_button {
                            height: 28px !important;
                            line-height: 28px !important
                        }

                        .link_no_line:hover {
                            text-decoration: none
                        }

                        .error {
                            margin: 7px 0px 0px;
                            display: none;
                            position: static
                        }

                        .input_text.disabled {
                            color: #A67C52;
                            font-size: 12px;
                            font-weight: bold;
                            border: 1px solid #EADBA7;
                            background-color: #FFFAE6
                        }

                        .check_email_title {
                            padding-top: 0px
                        }

                        .check_email_line {
                            margin-bottom: 0px
                        }

                        .check_email_topic {
                            margin-top: 27px;
                            margin-bottom: 12px
                        }

                        .btn_login_black, .btn_login_orange {
                            font-size: 12px;
                            font-weight: bold;
                            box-shadow: none
                        }

                        .signBox .register_left_title, .signBox
                        .register_right_title {
                            margin-bottom: 0px;
                            text-align: left
                        }

                        .register_right_subtitle {
                            margin-top: 20px
                        }

                        @media (max-width: 1000px) {
                            .korea_show_box {
                                display: none
                            }
                        }

                        body {
                            background: #fff;
                            color: #333
                        }

                        .clear_fd {
                            display: block;
                            height: 0px;
                            overflow: hidden;
                            clear: both
                        }

                        .owner
                        .main {
                            margin: 0px;
                            padding: 0px
                        }

                        .main
                        .inner {
                            width: 100%;
                            height: auto;
                            display: block;
                            padding-bottom: 70px;
                            background-color: #fff
                        }

                        .payment_inner {
                            width: 960px;
                            margin: auto;
                            text-align: left;
                            padding-left: 5px
                        }

                        @font-face {
                            font-family: 'helveticaneue_thin';
                            src: url('//s.intsig.net/webintsig/fonts/helvetica_neue_light.eot');
                            src: url('//s.intsig.net/webintsig/fonts/helvetica_neue_light.eot?#iefix') format('embedded-opentype'), url('//s.intsig.net/webintsig/fonts/helvetica_neue_light.woff') format('woff'), url('//s.intsig.net/webintsig/fonts/helvetica_neue_light.ttf') format('truetype')
                        }

                        .payment_title {
                            height: auto;
                            font-size: 24px;
                            color: #333;
                            text-align: center;
                            margin-top: 35px
                        }

                        .plan_left {
                            width: 696px;
                            float: left;
                            padding-top: 26px
                        }

                        .plan_right {
                            width: 240px;
                            float: left;
                            margin-left: 24px
                        }

                        .plan_left
                        .p_l_title {
                            display: block;
                            overflow: hidden;
                            height: 25px;
                            line-height: 25px;
                            margin: 22px 0px 17px;
                            font-size: 16px;
                            font-weight: bold;
                            vertical-align: top
                        }

                        .en_us .p_l_title, .ja_jp .p_l_title, .ko_kr
                        .p_l_title {
                            margin-bottom: 14px
                        }

                        .plan_left .p_l_title
                        .plan_unit_price {
                            font-size: 16px;
                            font-weight: bold
                        }

                        .plan_left .p_l_title
                        .plan_unit_user {
                            font-size: 12px;
                            font-weight: bold;
                            margin-left: 5px
                        }

                        .plan_left .p_l_title
                        .plan_unit_month {
                            font-size: 12px;
                            font-weight: bold;
                            margin-left: 5px
                        }

                        .plan_left .p_l_title
                        .plan_delimiter {
                            font-size: 12px;
                            font-weight: bold;
                            margin-left: 5px
                        }

                        .switch_plan {
                            font-size: 14px;
                            font-weight: bold;
                            color: #09f;
                            text-decoration: none;
                            margin-left: 10px;
                            vertical-align: baseline;
                            display: inline-block;
                            margin-top: 3px
                        }

                        .switch_plan:hover {
                            text-decoration: underline
                        }

                        .calculate {
                            display: block;
                            height: auto;
                            padding: 20px;
                            border: 1px solid #CCC;
                            border-radius: 5px;
                            position: relative;
                            z-index: 10;
                            margin-bottom: 22px
                        }

                        .calculate
                        .calculate_top {
                            display: block;
                            height: 70px;
                            overflow: hidden
                        }

                        .calculate
                        .calculate_buyshujubao {
                            display: block;
                            height: 70px;
                            overflow: hidden
                        }

                        .yonghushuBox, .yonghushuBox2 {
                            height: 70px;
                            display: inline;
                            float: left;
                            overflow: hidden
                        }

                        .yonghushuBox {
                            width: 86px
                        }

                        .yhsTop {
                            width: 86px;
                            height: 40px;
                            display: block;
                            overflow: hidden
                        }

                        .yhsTopFix {
                            height: 40px;
                            display: block;
                            overflow: hidden;
                            text-align: center
                        }

                        .yueshuBox {
                            width: 86px;
                            height: 70px;
                            display: inline;
                            float: left;
                            overflow: hidden
                        }

                        .yueshuBoxFix {
                            height: 70px;
                            display: inline;
                            float: left;
                            overflow: hidden
                        }

                        .meirenmeiyueBox {
                            width: auto;
                            height: 75px;
                            display: inline;
                            float: left;
                            overflow: hidden
                        }

                        .mrmyTop {
                            width: auto;
                            height: 40px;
                            display: block;
                            overflow: hidden
                        }

                        .c_t_btn01_L, .c_t_btn01_R, .c_t_btn02_L, .c_t_btn02_R {
                            width: 15px;
                            height: 38px;
                            display: inline;
                            float: left;
                            border: 1px solid #ccc;
                            cursor: pointer
                        }

                        .calculate_top_txt1 {
                            width: 100%;
                            height: 35px;
                            line-height: 35px;
                            display: inline;
                            float: left;
                            font-size: 12px;
                            font-weight: bold;
                            color: #707070;
                            text-align: center
                        }

                        .calculate_top_txt_mrmy {
                            width: 100%;
                            height: 35px;
                            line-height: 35px;
                            display: inline;
                            float: left;
                            font-size: 12px;
                            font-weight: bold;
                            color: #707070;
                            text-align: center
                        }

                        .minus_yes {
                            background: url(../../images/payment_buy_subtraction.jpg) left top no-repeat;
                            background-position: 0px 0px
                        }

                        .minus_no {
                            background: url(../../images/payment_buy_subtraction.jpg) left top no-repeat;
                            background-position: 0px -38px
                        }

                        .plus_yes {
                            background: url(../../images/payment_buy_subtraction.jpg) left top no-repeat;
                            background-position: -15px 0px
                        }

                        .plus_no {
                            background: url(../../images/payment_buy_subtraction.jpg) left top no-repeat;
                            background-position: -15px -38px
                        }

                        .c_t_text01, .c_t_text02 {
                            width: 52px;
                            height: 38px;
                            display: inline;
                            float: left;
                            border-top: 1px solid #ccc;
                            border-bottom: 1px solid #ccc
                        }

                        .calculate_txt {
                            width: 52px;
                            height: 36px;
                            line-height: 36px;
                            display: block;
                            text-align: center;
                            border: 0px solid #CCC;
                            font-size: 14px
                        }

                        .c_t_multiply {
                            width: 10px;
                            height: 40px;
                            display: inline;
                            float: left;
                            margin: 0px 20px;
                            background: url(../../images/payment_multiply.jpg) left top no-repeat
                        }

                        .c_t_amount {
                            width: 10px;
                            height: 40px;
                            display: inline;
                            float: left;
                            margin: 0px 10px;
                            background: url(../../images/payment_amount.jpg) left top no-repeat
                        }

                        .c_t_text03 {
                            width: auto;
                            height: 40px;
                            line-height: 40px;
                            display: block;
                            overflow: hidden;
                            font-size: 12px;
                            color: #707070
                        }

                        .c_t_text03
                        p {
                            width: auto;
                            height: 40px;
                            line-height: 40px;
                            overflow: hidden;
                            display: inline;
                            font-size: 44px;
                            color: #707070;
                            font-family: "helveticaneue_thin";
                            text-align: center
                        }

                        .c_t_text03
                        span {
                            width: 10px;
                            height: 20px;
                            line-height: 20px;
                            display: inline;
                            margin-right: 5px;
                            float: left;
                            font-size: 10px
                        }

                        .c_t_totalprice {
                            width: auto;
                            height: 40px;
                            line-height: 40px;
                            display: inline;
                            float: left;
                            color: #f93;
                            overflow: hidden
                        }

                        .c_t_totalprice
                        p {
                            width: auto;
                            height: 40px;
                            line-height: 40px;
                            display: inline;
                            font-size: 44px;
                            color: #f93;
                            font-family: "helveticaneue_thin"
                        }

                        .c_t_totalprice
                        span {
                            width: 10px;
                            height: 20px;
                            line-height: 20px;
                            display: inline;
                            margin-right: 5px;
                            float: left;
                            font-size: 10px
                        }

                        .c_t_Percent {
                            width: auto;
                            height: 40px;
                            line-height: 40px;
                            float: left;
                            font-size: 14px;
                            color: #3cb878;
                            overflow: hidden;
                            margin-left: 20px;
                            display: none
                        }

                        .ghide {
                            display: none
                        }

                        .calculate_prompt {
                            display: block;
                            height: 35px;
                            line-height: 35px;
                            overflow: hidden;
                            font-size: 12px;
                            font-weight: bold;
                            color: #707070
                        }

                        .calculate_prompt
                        span {
                            display: inline;
                            float: left;
                            height: 35px;
                            line-height: 35px;
                            font-size: 12px;
                            font-weight: bold;
                            color: #707070;
                            text-align: center
                        }

                        .prompt1 {
                            width: 85px
                        }

                        .prompt2 {
                            width: 85px;
                            margin-left: 50px
                        }

                        .prompt3 {
                            width: 85px;
                            margin-left: 70px
                        }

                        .prompt4 {
                            width: 85px;
                            margin-left: 100px
                        }

                        .buy_check {
                            display: block;
                            height: 18px;
                            overflow: hidden;
                            margin-top: 32px;
                            font-size: 12px;
                            font-weight: bold
                        }

                        .buy_check
                        input {
                            vertical-align: middle
                        }

                        .buy_check
                        label {
                            vertical-align: top;
                            cursor: pointer
                        }

                        .tabWrap {
                            width: 225px;
                            position: relative;
                            margin-right: 10px;
                            float: left
                        }

                        .tabWrap.tabLast {
                            margin-right: 0
                        }

                        .tabLi {
                            position: absolute;
                            left: 67px;
                            vertical-align: middle;
                            height: 72px;
                            margin: 0;
                            padding: 0
                        }

                        .en_us .tabLi, .ja_jp .tabLi, .ko_kr
                        .tabLi {
                            left: 56px
                        }

                        .en_us .payment_paypal input, .ja_jp .payment_paypal input, .ko_kr .payment_paypal
                        input {
                            left: 40px
                        }

                        .en_us .payment_paypal .iu_radio_input, .ja_jp .payment_paypal .iu_radio_input, .ko_kr .payment_paypal
                        .iu_radio_input {
                            left: 40px
                        }

                        .tablabel {
                            width: 133px;
                            height: 70px;
                            line-height: 70px;
                            display: block;
                            overflow: hidden;
                            border: 1px solid #CCC;
                            border-radius: 5px;
                            cursor: pointer;
                            padding-left: 88px
                        }

                        .tablabel:hover, .tabLi:checked + label, .tablabel_active {
                            border: 1px solid #2d6491;
                            -webkit-border-radius: 5px;
                            -moz-border-radius: 5px;
                            border-radius: 5px;
                            -webkit-box-shadow: rgba(45, 100, 145, 0.4) 0px 0px 5px;
                            -moz-box-shadow: rgba(45, 100, 145, 0.4) 0px 0px 5px;
                            box-shadow: rgba(45, 100, 145, 0.4) 0px 0px 5px
                        }

                        .en_us .tablabel, .ja_jp .tablabel, .ko_kr
                        .tablabel {
                            padding-left: 78px
                        }

                        .en_us .payment_other .tablabel, .ko_kr .payment_other
                        .tablabel {
                            width: 409px
                        }

                        .ja_jp .payment_other
                        .tablabel {
                            width: 425px
                        }

                        .payment_paypal {
                            width: 197px;
                            position: relative;
                            margin-right: 10px;
                            float: left
                        }

                        .payment_paypal input, .payment_paypal
                        .iu_radio_input {
                            left: 40px
                        }

                        .payment_paypal
                        .tablabel {
                            width: auto;
                            padding-left: 62px
                        }

                        .plan_left .mode_tab
                        .payment_kokr {
                            margin-right: 10px
                        }

                        .plan_left .mode_tab
                        .payment_kokr {
                            width: 265px
                        }

                        .plan_left .mode_tab .payment_kokr
                        .tablabel {
                            width: 167px
                        }

                        .plan_left .mode_tab .payment_kokr
                        .orderlist_radio {
                            position: absolute;
                            left: 20px;
                            top: 30px;
                            margin: 0px
                        }

                        .pay_title_kokr {
                            position: absolute;
                            left: 42px;
                            top: 20px;
                            color: #333;
                            font-size: 14px;
                            line-height: 16px
                        }

                        .pay_tip_kokr {
                            position: absolute;
                            left: 42px;
                            top: 38px;
                            color: #ACACAC;
                            font-size: 12px;
                            line-height: 14px
                        }

                        .payment_other {
                            width: 464px;
                            position: relative;
                            float: left
                        }

                        .payment_other
                        .tablabel {
                            width: 399px
                        }

                        .payment_alipay
                        .alipay_img {
                            display: inline;
                            float: left;
                            width: 100px;
                            height: 30px;
                            background: url(../../images/payment_pay01.png) left top no-repeat;
                            margin-top: 20px
                        }

                        .payment_alipay
                        input {
                            left: 56px
                        }

                        .payment_alipay
                        .tablabel {
                            width: 145px;
                            padding-left: 78px
                        }

                        .payment_paypal
                        .alipay_img {
                            display: inline;
                            float: left;
                            width: 100px;
                            height: 36px;
                            background: url(../../images/payment_pay01_paypal.png) left top no-repeat;
                            margin-top: 22px
                        }

                        .payment_other
                        .other_img {
                            display: inline;
                            float: left;
                            width: 355px;
                            height: 30px;
                            background: url(../../images/payment_pay02.jpg) left top no-repeat;
                            margin-top: 20px
                        }

                        .payment_other
                        .kgmobilian_img {
                            display: inline;
                            float: left;
                            width: 355px;
                            height: 30px;
                            background: url(../../images/payment_pay02_kgmobilians.png) left top no-repeat;
                            margin-top: 15px
                        }

                        .jp_payment_tips {
                            margin-top: 45px;
                            color: #707070
                        }

                        .ja_jp .payment_other
                        .other_img {
                            margin-left: 0px;
                            margin-top: 10px
                        }

                        .payment_alipay {
                            width: 225px;
                            position: relative;
                            margin-right: 10px;
                            float: left
                        }

                        .payment_yinlian {
                            width: 225px;
                            position: relative;
                            float: left
                        }

                        .payment_yinlian
                        input {
                            left: 32px
                        }

                        .payment_yinlian
                        .tablabel {
                            width: 175px;
                            padding-left: 48px
                        }

                        .payment_yinlian
                        .other_img_china {
                            display: inline;
                            float: left;
                            width: 160px;
                            height: 30px;
                            background: url(../../images/china_unionpay.png) center center no-repeat;
                            margin-top: 20px
                        }

                        .plan_left
                        .invoice_body {
                            display: block;
                            height: auto;
                            margin-top: 5px
                        }

                        .invoice_body
                        .invoice_form {
                            width: 706px;
                            height: auto;
                            display: block;
                            font-size: 14px;
                            color: #707070
                        }

                        .ja_jp
                        .invoice_form {
                            margin-top: 21px
                        }

                        .invoice_txt1 {
                            width: 100%;
                            line-height: 24px;
                            display: block;
                            overflow: hidden;
                            margin: 20px 0;
                            color: #707070;
                            font-size: 12px
                        }

                        .invoice_txt2 {
                            width: 344px;
                            height: auto;
                            display: inline;
                            float: left;
                            margin-right: 8px;
                            position: relative;
                            z-index: 10;
                            margin-bottom: 18px
                        }

                        .invoice_txt2
                        .txt2_title {
                            width: 345px;
                            height: 25px;
                            line-height: 25px;
                            display: block;
                            overflow: hidden;
                            font-size: 12px;
                            color: #333;
                            font-weight: bold;
                            margin-bottom: 1px;
                            margin-left: 1px
                        }

                        .invoice_txt2
                        .txt2_input {
                            width: 319px;
                            padding: 4px 10px;
                            height: 20px;
                            line-height: 20px;
                            display: block;
                            border: 1px solid #CCC;
                            margin-left: 1px;
                            color: #333;
                            border-radius: 3px
                        }

                        .invoice_txt2
                        .input_addres_w {
                            width: 673px
                        }

                        .invoice_txt2
                        .input_error {
                            border: 1px solid #f26c4f
                        }

                        .invoice_txt2 .txt2_input:focus {
                            border: 1px solid #2d4051;
                            border-color: #333;
                            box-shadow: 0 0 4px rgba(45, 64, 81, 0.2)
                        }

                        .input_error_msg {
                            color: #f26c4f;
                            font-size: 12px;
                            line-height: 20px;
                            margin-top: 5px;
                            margin-bottom: 10px
                        }

                        .invoice_txt2
                        .prompt {
                            left: 10px;
                            height: 38px;
                            line-height: 38px;
                            top: 25px;
                            display: none
                        }

                        .invoice_txt2
                        .prompt_taitou {
                            display: block;
                            color: #dcdcdc
                        }

                        .invoice_step {
                            display: block;
                            color: #333;
                            margin-bottom: 30px;
                            margin-top: 50px
                        }

                        .invoice_step.invoice_step_1 {
                            margin-top: 0
                        }

                        .invoice_txt2
                        .input_line {
                            display: inline;
                            float: left
                        }

                        .invoice_txt2
                        .horizontal {
                            display: inline;
                            float: left;
                            text-align: center;
                            width: 18px;
                            height: 38px;
                            line-height: 38px
                        }

                        .invoice_step1, .invoice_step2, .invoice_step3 {
                            display: block;
                            height: auto;
                            overflow: hidden
                        }

                        .invoice_img_list {
                            width: 343px;
                            height: 270px;
                            display: inline;
                            float: left;
                            margin-right: 10px;
                            margin-bottom: 30px
                        }

                        .invoice_img_list
                        .invoice_img {
                            width: 341px;
                            height: 218px;
                            display: block;
                            overflow: hidden;
                            border: 1px dashed #ccc;
                            margin-bottom: 10px;
                            background: url(../../images/payment_img05.jpg) #f9f9f9 center center no-repeat
                        }

                        .invoice_img_list
                        .invoice_botton {
                            width: 341px;
                            height: 38px;
                            line-height: 38px;
                            display: block;
                            overflow: hidden;
                            background: url(../../images/payment_img04.jpg) left top repeat-x;
                            cursor: pointer;
                            border: 1px solid #ccc;
                            font-size: 12px;
                            color: #333;
                            text-align: center
                        }

                        .invoice_img
                        img {
                            width: 341px;
                            height: 218px;
                            display: block;
                            overflow: hidden
                        }

                        .upgrade {
                            display: block;
                            height: 35px;
                            line-height: 35px;
                            font-size: 12px;
                            font-weight: bold;
                            color: #09f;
                            text-align: right;
                            margin-bottom: 10px;
                            margin-top: 44px
                        }

                        .upgrade a, .upgrade a:link, .upgrade a:hover, .upgrade a:visited {
                            height: 35px;
                            line-height: 35px;
                            font-size: 14px;
                            font-weight: bold;
                            color: #09f;
                            text-decoration: none
                        }

                        .settlement {
                            width: 238px;
                            display: block;
                            height: auto;
                            border: 1px solid #CCC;
                            border-radius: 5px;
                            background-color: #f5f5f5;
                            text-align: center
                        }

                        .settlement
                        .jiesuan_inner {
                            width: 206px;
                            display: block;
                            height: auto;
                            margin: 15px auto 20px;
                            text-align: left
                        }

                        .jiesuan_inner
                        .js_title {
                            width: 100%;
                            display: block;
                            height: 30px;
                            line-height: 30px;
                            font-size: 12px;
                            font-weight: bold
                        }

                        .js_line {
                            width: 100%;
                            display: block;
                            height: 1px;
                            overflow: hidden;
                            background-color: #dbdddf;
                            margin-top: 10px;
                            margin-bottom: 10px
                        }

                        .js_line_b {
                            width: 100%;
                            display: block;
                            height: 1px;
                            overflow: hidden;
                            background-color: #e5d8b5;
                            margin-top: 10px;
                            margin-bottom: 10px
                        }

                        .jiesuan_inner
                        .js_box1 {
                            width: 100%;
                            height: auto;
                            display: block;
                            overflow: hidden;
                            color: #707070
                        }

                        .zh_cn .jiesuan_inner
                        .js_box2 {
                            width: 100%;
                            height: 100px;
                            display: block;
                            overflow: hidden
                        }

                        .total_sum, .js_box1
                        .total_sum {
                            width: 100%;
                            height: 14px;
                            line-height: 14px;
                            display: block;
                            overflow: hidden;
                            font-weight: bold;
                            font-size: 12px;
                            color: #707070;
                            text-align: right;
                            margin-bottom: 2px
                        }

                        .js_box1
                        .js_b1_title {
                            width: 100%;
                            height: 20px;
                            line-height: 14px;
                            display: block;
                            overflow: hidden;
                            font-weight: bold;
                            font-size: 12px;
                            color: #707070;
                            margin-top: 2px;
                            margin-bottom: 2px
                        }

                        .js_box1
                        .js_b1_txt {
                            width: 100%;
                            height: 14px;
                            line-height: 14px;
                            display: block;
                            overflow: hidden;
                            color: #707070;
                            margin-top: 5px;
                            margin-bottom: 5px
                        }

                        .js_box1
                        .js_b1_txt_sum {
                            width: 100%;
                            height: 14px;
                            line-height: 14px;
                            display: block;
                            overflow: hidden;
                            color: #707070;
                            margin-top: 5px;
                            margin-bottom: 2px
                        }

                        .js_b1_txt
                        .txt_left {
                            width: auto;
                            height: 14px;
                            line-height: 14px;
                            display: inline;
                            float: left;
                            overflow: hidden
                        }

                        .js_b1_txt .txt_right, .js_b1_txt_sum
                        .txt_right {
                            width: auto;
                            height: 14px;
                            line-height: 14px;
                            display: inline;
                            float: right;
                            overflow: hidden;
                            font-weight: bold;
                            font-size: 12px
                        }

                        .js_box2
                        .js_b2_title {
                            width: 100%;
                            height: 20px;
                            line-height: 14px;
                            display: block;
                            overflow: hidden;
                            font-size: 12px;
                            font-weight: bold
                        }

                        .js_box2 .js_b2_txt, .js_box2
                        .txt2_total_sum {
                            width: 186px;
                            line-height: 14px;
                            margin: 5px 0;
                            display: block;
                            overflow: hidden;
                            background: url(../../images/payment_img01.jpg) 0 2px no-repeat;
                            padding-left: 20px;
                            font-size: 12px;
                            font-weight: bold
                        }

                        .js_box2
                        .txt2_total_sum {
                            background: none;
                            height: 25px;
                            line-height: 25px;
                            margin-top: 10px
                        }

                        .js_b2_txt
                        .txt2_left {
                            width: auto;
                            height: 14px;
                            line-height: 14px;
                            display: inline;
                            float: left;
                            overflow: hidden
                        }

                        .js_b2_txt
                        .txt2_right {
                            width: auto;
                            height: 25px;
                            line-height: 25px;
                            display: inline;
                            float: right;
                            overflow: hidden;
                            color: #ed8721;
                            font-weight: bold;
                            font-size: 22px
                        }

                        .btn_buy {
                            width: 204px;
                            height: 38px;
                            line-height: 38px;
                            display: block;
                            overflow: hidden;
                            color: #fff;
                            font-weight: bold;
                            text-align: center;
                            cursor: pointer;
                            border-radius: 3px;
                            background-color: #f93;
                            border: 1px solid #ed8721;
                            margin-bottom: 10px
                        }

                        .btn_buy:hover {
                            border: 1px solid #ee8021;
                            background-color: #fc8f30;
                            box-shadow: 0px 2px 1px rgba(115, 66, 30, 0.15)
                        }

                        .jiesuan_inner
                        .js_box3 {
                            width: 216px;
                            height: auto;
                            display: block;
                            overflow: hidden;
                            color: #707070
                        }

                        .jiesuan_inner .js_box3
                        input {
                            text-align: left;
                            display: inline;
                            float: left;
                            margin-right: 10px
                        }

                        .jiesuan_inner .js_box3
                        label {
                            width: 177px;
                            height: 100%;
                            text-align: left;
                            display: inline;
                            float: left
                        }

                        .js_box3 a, .js_box3 a:link, .js_box3 a:visited {
                            color: #09f;
                            text-decoration: none
                        }

                        .js_box3 a:hover {
                            color: #09f;
                            text-decoration: underline
                        }

                        .jiesuan_inner
                        .js_box4_img {
                            width: 198px;
                            height: 38px;
                            display: block;
                            overflow: hidden;
                            background: url(../../images/payment_img02.jpg) left top no-repeat;
                            border: 1px solid #CCC;
                            margin-top: 20px
                        }

                        .js_box3
                        input {
                            vertical-align: middle
                        }

                        .js_box3
                        label {
                            vertical-align: middle
                        }

                        .help_support {
                            width: 238px;
                            display: block;
                            height: auto;
                            border: 1px solid #e5d8b5;
                            border-radius: 5px;
                            background-color: #fff8e5;
                            margin-top: 10px;
                            text-align: center;
                            position: relative;
                            z-index: 1
                        }

                        .help_support
                        .help_inner {
                            width: 210px;
                            display: block;
                            height: auto;
                            overflow: hidden;
                            margin: 15px auto;
                            text-align: left
                        }

                        .help_inner
                        .help_title {
                            width: 210px;
                            display: block;
                            height: auto;
                            min-height: 20px;
                            font-size: 12px;
                            font-weight: bold;
                            overflow: hidden
                        }

                        .help_inner
                        .help_txt {
                            width: 210px;
                            display: block;
                            line-height: 20px;
                            overflow: hidden;
                            color: #707070
                        }

                        .help_inner .help_txt
                        a {
                            text-decoration: none;
                            color: #707070
                        }

                        .help_inner .help_txt a:hover {
                            text-decoration: underline
                        }

                        .help_inner
                        .help_close {
                            width: 11px;
                            height: 11px;
                            display: block;
                            overflow: hidden;
                            background: url(../../images/payment_img03.jpg) left top no-repeat;
                            cursor: pointer;
                            position: absolute;
                            top: 10px;
                            right: 10px
                        }

                        .c_t_text03_02 {
                            width: auto;
                            height: 40px;
                            line-height: 40px;
                            display: inline;
                            float: left;
                            font-size: 14px;
                            overflow: hidden
                        }

                        .c_t_text03_02
                        p {
                            width: auto;
                            height: 40px;
                            line-height: 40px;
                            display: inline;
                            font-size: 14px;
                            color: #333
                        }

                        .c_t_text03_02
                        span {
                            width: 10px;
                            height: 20px;
                            line-height: 20px;
                            display: inline;
                            margin-right: 5px;
                            float: left;
                            font-size: 10px
                        }

                        .en_us .jiesuan_inner
                        .js_box2 {
                            width: 100%;
                            height: 50px;
                            display: block;
                            overflow: hidden
                        }

                        .fast_track_wrap {
                            display: none;
                            padding-top: 20px
                        }

                        .channel_text {
                            text-align: center;
                            font-size: 14px;
                            margin-top: 12px
                        }

                        .ja_jp
                        .payment_other {
                            width: auto
                        }

                        .ja_jp
                        .tablabel {
                            padding-left: 62px
                        }

                        .ja_jp
                        .tabLi {
                            left: 20px
                        }

                        .ja_jp .payment_other
                        .jajp_other_pay {
                            width: 133px;
                            margin-left: 10px;
                            padding-left: 62px
                        }

                        .ja_jp .payment_other
                        .iu_radio_input {
                            left: 40px
                        }

                        .jp_pay_text {
                            color: #333;
                            font-size: 12px;
                            line-height: 22px
                        }

                        .link_mail {
                            color: #1B84B2;
                            font-family: Arial
                        }

                        .jp_pay_form {
                            width: 300px;
                            margin-top: 17px;
                            display: inline-block
                        }

                        .jp_pay_form
                        .invoice_txt2 {
                            margin-bottom: 13px
                        }

                        .jp_pay_form .invoice_txt2
                        .txt2_title {
                            margin-bottom: 4px
                        }

                        .jppay_invoice_txt {
                            width: 300px
                        }

                        .jppay_invoice_txt
                        .jppay_input_w {
                            width: 278px
                        }

                        .btn_jppay {
                            width: 258px;
                            padding: 0px 20px;
                            text-align: center;
                            font-size: 12px;
                            border-radius: 3px;
                            text-decoration: none;
                            height: 28px;
                            line-height: 28px;
                            display: inline-block;
                            cursor: pointer;
                            background-color: #2D4051;
                            border: 1px solid #2D4051;
                            color: #fff
                        }

                        .btn_jppay:hover {
                            background-color: #243341;
                            box-shadow: 0px 2px 1px rgba(0, 0, 0, 0.2)
                        }

                        .ico_jppay {
                            width: 9px;
                            height: 10px;
                            display: inline-block;
                            margin-right: 8px;
                            background: url(../../images/payment_jppay_download.png) left top no-repeat
                        }

                        @media (min-width: 1173px) {
                            .payment_inner {
                                width: 960px
                            }

                            .plan_left {
                                width: 696px
                            }

                            .plan_right {
                                width: 240px
                            }
                        }

                        @media (min-width: 1450px) {
                            .payment_inner {
                                width: 960px
                            }

                            .plan_left {
                                width: 696px
                            }

                            .plan_right {
                                width: 240px
                            }
                        }

                        .alert_main_wrap {
                            display: table;
                            width: 400px;
                            margin: auto;
                            height: 100%
                        }

                        .alert_main {
                            display: table-cell;
                            vertical-align: middle
                        }

                        .alert_title {
                            text-align: center;
                            font-size: 18px;
                            color: #333;
                            margin-bottom: 65px;
                            font-weight: bold
                        }

                        .alert_text {
                            font-size: 14px;
                            line-height: 20px;
                            margin-bottom: 75px;
                            font-weight: bold
                        }

                        .alert_text_0 {
                            font-size: 14px;
                            line-height: 24px;
                            margin-bottom: 75px;
                            text-align: center
                        }

                        .iu_dialog_button_x, #repay_payment_box
                        .iu_dialog_button_0 {
                            background: #f26c4f;
                            color: white;
                            border: 1px solid #f26c4f;
                            box-shadow: 0 1px 2px rgba(0, 0, 0, .1)
                        }

                        .iu_dialog_button_x:hover, #repay_payment_box .iu_dialog_button_0:hover {
                            background: #fb5f40;
                            color: white;
                            border: 1px solid #fb5f40;
                            box-shadow: 0 1px 2px rgba(0, 0, 0, .1)
                        }

                        .p_title_3, .en_us .p_title_3, .ja_jp .p_title_3, .ko_kr
                        .p_title_3 {
                            margin-bottom: 0px
                        }

                        .mode_tab {
                            display: block;
                            height: 72px;
                            margin-bottom: 22px
                        }

                        .zh_cn
                        .li_wz1_1 {
                            left: 71px
                        }

                        .zh_cn
                        .li_wz1_2 {
                            padding-left: 92px;
                            width: 129px
                        }

                        .zh_cn
                        .li_wz2_1 {
                            left: 57px
                        }

                        .zh_cn
                        .li_wz2_2 {
                            padding-left: 84px;
                            width: 137px
                        }

                        .zh_cn
                        .li_wz3_1 {
                            left: 59px
                        }

                        .zh_cn
                        .li_wz3_2 {
                            padding-left: 81px;
                            width: 140px
                        }

                        .total_person, .plan_piece, .additional_piece, .total_person, .total_month, .total_piece, .month_total {
                            padding-right: 3px
                        }

                        .total_month {
                            padding-left: 5px;
                            padding-right: 3px
                        }

                        #total_sum, #track_total_sum, #plan_total_sum {
                            padding-left: 2px
                        }

                        .js_b2_txt
                        .total_month {
                            padding-left: 0px
                        }

                        .payment_bottom_txt {
                            clear: both;
                            margin-top: 2px;
                            color: #707070;
                            font-size: 11px
                        }

                        .asterisk {
                            color: #f26c4f;
                            margin-right: 5px
                        }

                        .asterisk2 {
                            color: #f26c4f;
                            margin-left: 5px
                        }

                        .cc_bottom_contact {
                            display: block
                        }

                        .ko_kr
                        .cc_bottom_line {
                            width: 240px;
                            border-bottom: 1px solid #e1e1e1;
                            margin: 20px 0px 15px
                        }

                        .ko_kr
                        .cc_bottom_contact {
                            width: 240px;
                            height: auto;
                            display: block;
                            margin: 0px;
                            color: #707070;
                            font-size: 11px;
                            text-align: left
                        }

                        .ko_kr
                        .cc_bc_li {
                            min-height: 22px;
                            line-height: 22px;
                            vertical-align: top
                        }

                        .ko_kr
                        .cc_bc_left {
                            width: auto;
                            min-height: 22px;
                            display: inline-block;
                            float: left;
                            margin-right: 5px
                        }

                        .ko_kr
                        .cc_bc_right {
                            width: auto;
                            max-width: 175px;
                            min-height: 22px;
                            display: inline-block;
                            float: left
                        }

                        .ko_kr
                        .cc_bc_first {
                            margin-top: 0px
                        }

                        .ko_kr
                        .cc_bc_last {
                            margin-bottom: 0px
                        }

                        .check_fujiabao, .check_user_agreement {
                            margin: 2px 10px 0px 0px
                        }

                        .orderlist_radio {
                            position: absolute;
                            left: 55px;
                            top: 30px;
                            margin: 0px
                        }

                        .payment_yinlian
                        .orderlist_radio {
                            left: 32px
                        }

                        .iu_radio_input {
                            cursor: pointer
                        }

                        #korea_buy_dialog_panel
                        .iu_dialog_mask {
                            background-color: #000
                        }

                        #korea_buy_dialog_panel
                        .iu_dialog {
                            background-color: #fff
                        }

                        .dialog_korea_buy {
                            width: 660px;
                            height: 455px;
                            text-align: center;
                            font-family: Arial, 돋움, 'Malgun Gothic', AppleGothic, sans-serif;
                            color: #333
                        }

                        .dialog_korea_inner {
                            width: 420px;
                            margin: 0px auto
                        }

                        .korea_buy_title {
                            font-size: 18px;
                            font-weight: bold;
                            margin-top: 30px
                        }

                        .korea_buy_line {
                            height: 0px;
                            overflow: hidden;
                            border-bottom: 1px solid #e1e1e1;
                            margin: 20px 0px 24px
                        }

                        .kb_li {
                            line-height: 30px;
                            font-size: 14px;
                            color: #333
                        }

                        .kb_left, .kb_right {
                            width: 150px;
                            display: inline-block;
                            vertical-align: top;
                            text-align: right
                        }

                        .kb_right {
                            width: 240px;
                            text-align: left;
                            margin-left: 26px
                        }

                        .korea_buy_tips {
                            font-size: 12px;
                            color: #f26c4f;
                            margin-top: 20px;
                            margin-bottom: 30px
                        }

                        body {
                            background: #fff
                        }

                        .clear_fd {
                            display: block;
                            height: 0px;
                            overflow: hidden;
                            clear: both
                        }
                    </style>
                    <div class="inner">
                        <if condition="$ishave eq 1">
                            <a href="{:U('renewSuite')}">套餐续费</a>|<a href="{:U('addStaff')}">添加成员</a>
                        <elseif condition="$ishave eq 0"/>
                            <a href="{:U('buySuite')}">购买套餐</a>
                        <else/>
                            服务器出现故障
                        </if>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--  分享二维码弹框  -->
<include file="Common/entQrCode"/>
<!--备用框-->
<div class="js_temp_box"></div>
<!--添加部门弹框-->
<div class="js_parents_box">
    <div class="ora-dialog js_adddepart_box">
        <div class="vision-dia-mian">
            <div class="dia-add-vis">
                <h4>添加部门</h4>
                <div class="dia-add-vis-menu">
                    <h5><em>*</em>部门名称</h5>
                    <div class="dia_menu all-width-menu">
                        <input class="fu-dia" maxlength="15" type="text" name="departname" placeholder="必填"/>
                    </div>
                </div>
                <div class="dia-add-vis-menu clear">
                    <h5>上级部门</h5>
                    <div class="dia_menu dia-have-bg js_select_list">
                        <input class="fu-dia js_select_updepart" type="text" name="updepartname" placeholder="必填"
                               readonly="readonly"/>
                        <input type="hidden" name="updepartid" placeholder="必填" readonly="readonly"/>
                        <b class="m-b"><i></i></b>
                        <div class="tree-j-dia js_depart_tree js_select_option">
                            <!--树形结构-->
                            <div class="tree-menu-pad js_treelist">
                                {$tpls}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dia-add-vis-menu clear">
                    <h5>部门成员</h5>
                    <div class="dia_menu dia-have-bg js_select_list">
                        <input class="fu-dia js_select_staff" name="staffdepart" type="text" data-sid=""
                               placeholder="选择群成员" readonly="readonly"/>
                        <b class="m-b"><i></i></b>
                        <div class="menu-ch-per js_depart_staff_select_sh js_select_option">
                            <div class="search-per js_select_search">
                                <input type="text" class="js_search_word"/>
                                <b class="js_searchbtn"><img src="__PUBLIC__/images/search.png" alt=""/></b>
                            </div>
                            <ul class="per-menu js_depart_staff_select">
                                {$staff}
                            </ul>
                            <div class="js_staff_temp" style="display: none;">{$staff}</div>
                            <div class="btn-menu clear">
                                <button type="button" class="js_staff_confirmbtn">确定</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dia-add-vis-menu clear js_select_list">
                    <h5>部门内分享名片</h5>
                    <div class="dia_menu dia-have-bg">
                        <input class="fu-dia js_select_share_btn" type="text" name="sharedepart" val="0" placeholder="否"
                               readonly="readonly"/>
                        <b class="m-b"><i></i></b>
                        <ul class="menu-xl js_select_share js_select_option">
                            <li val="1">是</li>
                            <li val="2">否</li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="dia-add-v-btn clear">
                <input type="hidden" name="departid" value="">
                <button type="button" class="js_cancel_box">取消</button>
                <button type="button" class="bg-di js_submit_box">确定</button>
            </div>
        </div>
    </div>
</div>

<script>
    var js_url_index = "{:U(MODULE_NAME.'/Departments/index','','',true)}";
    var js_url_deldepart = "{:U(MODULE_NAME.'/Departments/delDepartInfo','','',true)}";
    var js_url_getStaff = "{:U(MODULE_NAME.'/Departments/getDepartStaff','','',true)}";
    var js_url_adddepart = "{:U(MODULE_NAME.'/Departments/addDepartment','','',true)}";
    var js_url_editdepart = "{:U(MODULE_NAME.'/Departments/editDepartInfo','','',true)}";
    var js_url_depart_sub = '';
    $(function ($) {
        //点击区域外关闭此下拉框
        $(document).on('click', function (e) {
            if ($(e.target).parents('.js_select_list').length > 0) {
                var currUl = $(e.target).parents('.js_select_list').find('.js_select_option');
                $('.js_select_list .js_select_option').not(currUl).hide()
            } else {
                $('.js_select_list .js_select_option').hide();
            }
        });
        $('.js_contents').on('click', '.js_showhide', function () {
            if ($(this).hasClass('add-hide-icon')) {
                $(this).removeClass('add-hide-icon');
            } else {
                $(this).addClass('add-hide-icon');
            }

            $(this).parents('.js_showhidefu').siblings('.js_siblings').toggle();
        })
        $('.js_contents').on('click', '.js_adddepart,.js_editdepart', function () {
            js_url_depart_sub = js_url_adddepart;
            var _this = this;
            var cloneDom = $('.js_parents_box .js_adddepart_box').clone(true);
            $('.js_temp_box').append(cloneDom);

            if ($(_this).hasClass('js_adddepart')) {
                var isedit = 0;
                //eidt
                var pid = $(_this).parent().attr('data-did');
                var pname = $(_this).parent().attr('data-name');
                if (pid) {
                    cloneDom.find('input[name=updepartid]').val(pid);
                    cloneDom.find('input[name=updepartname]').val(pname);
                }
            }
            if ($(_this).hasClass('js_editdepart')) {
                var isedit = 1;
                js_url_depart_sub = js_url_editdepart;
                //eidt
                var id = $(_this).parent().attr('data-did');
                var pid = $(_this).parent().attr('data-pid');
                var name = $(_this).parent().attr('data-name');
                var pname = $(_this).parents('.js_siblings').siblings('.js_showhidefu:first').find('.js_depart_selected').html();
                var shared = $(_this).parent().attr('data-status');
                var sharedvalue = shared == 1 ? '是' : '否';

                cloneDom.find('input[name=sharedepart]').attr('val', shared);
                cloneDom.find('input[name=sharedepart]').val(sharedvalue);
                //js
                cloneDom.find('input[name=departid]').val(id);
                cloneDom.find('input[name=departname]').val(name);
                cloneDom.find('input[name=updepartid]').val(pid);
                cloneDom.find('input[name=updepartname]').val(pname);

            }

            $('.js_temp_box .js_adddepart_box').show();
            cloneDom.on('click', '.js_cancel_box', function () {
                cloneDom.hide();
                cloneDom.remove();
            })
            cloneDom.on('click', '.js_select_staff', function () {
                cloneDom.find('.js_depart_staff_select_sh').toggle();
            })
            cloneDom.on('click', '.js_select_share_btn', function () {
                cloneDom.find('.js_select_share').toggle();
            })
            if (isedit == 1 && pid == 0) {
            } else {
                cloneDom.on('click', '.js_select_updepart', function () {
                    cloneDom.find('.js_depart_tree').toggle();
                })

                cloneDom.on('click', '.js_depart_selected', function () {
                    cloneDom.find('input[name=updepartid]').val($(this).attr('data-did'));
                    cloneDom.find('input[name=updepartname]').val($(this).html());
                    cloneDom.find('.js_depart_tree').hide();
                })
            }


            cloneDom.on('click', '.js_select_share li', function () {
                cloneDom.find('input[name=sharedepart]').attr('val', $(this).attr('val'))
                cloneDom.find('input[name=sharedepart]').val($(this).html())
                cloneDom.find('.js_select_share').hide();
            })

            cloneDom.on('click', '.js_depart_staff_select_sh .js_staff_confirmbtn', function () {

                var staffid = '';
                var staffname = '';
                cloneDom.find('.js_depart_staff_select_sh').hide();
                cloneDom.find('.js_depart_staff_select_sh .js_depart_staff_select li').each(function (i, d) {
                    if ($(d).find('input').prop('checked') == true) {
                        staffid += $(d).attr('data-sid') + ',';
                        staffname += $(d).find('em').html() + ',';
                    }
                });
                staffid = staffid.substring(0, staffid.length - 1);
                staffname = staffname.substring(0, staffname.length - 1);

                if (staffid != '') {
                    cloneDom.find('input[name=staffdepart]').attr('data-sid', staffid);
                    cloneDom.find('input[name=staffdepart]').val(staffname);
                }
                cloneDom.find('.js_depart_staff_select_sh').hide();

                //reset
                cloneDom.find('.js_depart_staff_select_sh .js_depart_staff_select').html(cloneDom.find('.js_staff_temp').html());
                cloneDom.find('.js_depart_staff_select_sh .js_search_word').val('');

            })
            cloneDom.on('click', '.js_depart_staff_select_sh .js_select_search .js_searchbtn', function () {
                //staff
                var $word = cloneDom.find('.js_depart_staff_select_sh .js_search_word').val();

                $.ajax({
                    url: js_url_getStaff,
                    type: 'post',
                    dataType: 'json',
                    data: 'name=' + $word,
                    success: function (res) {
                        cloneDom.find('.js_depart_staff_select_sh .js_depart_staff_select').html(res);
                    },
                    error: function (res) {
                    }
                });

            })

            cloneDom.on('click', '.js_submit_box', function () {
                var dname = '';
                dname = cloneDom.find('input[name=departname]').val();
                var departid = cloneDom.find('input[name=departid]').val();
                var updepartid = cloneDom.find('input[name=updepartid]').val();
                if (isedit == 1 && pid == 0) updepartid = 0;

                var departstaffid = cloneDom.find('input[name=staffdepart]').attr('data-sid');
                var shared = cloneDom.find('input[name=sharedepart]').attr('val');
                if (dname == '') {
                    //alert('请写部门名称');
                    $.dialog.alert({content: "请写部门名称"});
                    return false;
                }
                $.ajax({
                    url: js_url_depart_sub,
                    type: 'post',
                    dataType: 'json',
                    data: 'dname=' + dname + '&departid=' + departid + '&parentid=' + updepartid + '&status=' + shared + '&staffid=' + departstaffid,
                    success: function (res) {
                        if (res.status == 0) {
                            cloneDom.hide();
                            cloneDom.remove();
                            window.location.href = js_url_index;
                        } else if (res.status == 999005) {
                            $.dialog.alert({content: "此部门名称已存在"});
                        } else {
                            $.dialog.alert({content: "操作失败"});
                        }
                    },
                    error: function (res) {
                    }
                });

            })

            cloneDom.on('click', '.js_showhide', function () {
                if ($(this).hasClass('add-hide-icon')) {
                    $(this).removeClass('add-hide-icon');
                } else {
                    $(this).addClass('add-hide-icon');
                }

                $(this).parents('.js_showhidefu').siblings('.js_siblings').toggle();
            })

        })

        $('.js_contents').on('click', '.js_deldepart', function () {
            var id = $(this).parent().attr('data-did');
            if (id != undefined && id != '') {
                $.ajax({
                    url: js_url_deldepart,
                    type: 'post',
                    dataType: 'json',
                    data: 'id=' + id,
                    success: function (res) {
                        if (res.status == 0) {
                            window.location.href = js_url_index;
                        } else if (res.status == 820002) {
                            $.dialog.alert({content: "此部门下有员工，不能执行删除操作"});
                        } else {
                            $.dialog.alert({content: "删除失败"});
                        }
                    },
                    error: function (res) {
                    }
                });
            }
        })


    });
</script>
<script>
    var addStaffUrl = '{:U("addStaff")}';
    $(function () {
        $('#btn_buy_confirm').on('click', function () {
//            alert(111)
            var num = $('input[name=person]').val();
            var platform = $('input[name=platform]').val();
            var platform = 1;
            $.post(addStaffUrl, {num: num, platform: platform}, function (res) {
                alert(res)
            }, 'json')
        })
    })
</script>