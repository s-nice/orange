<?php
// 网站全局钩子
return array(
        'app_end'       =>  array(
            '\Hooks\PrintDevInfo', // 页面结束后， 打印开发需要的信息
        ),
    );