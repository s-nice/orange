<!DOCTYPE html>
<html class="no-js"  lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="initial-scale=1, maximum-scale=1, minimum-scale=1, user-scalable=no">
    <!-- <link rel="shortcut icon" href="http://localhost/album/images/favicon.ico" type="image/x-icon"> -->
    <title>名片相册</title>
    <link href="__PUBLIC__/css/Home/normalize.css" rel="stylesheet"  type="text/css">
    <link href="__PUBLIC__/css/bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/css/Home/foundation.min.css" rel="stylesheet"  type="text/css">
    <link href="__PUBLIC__/css/Home/set1.css" rel="stylesheet" type="text/css" />
    <link href="__PUBLIC__/css/Home/main.css" rel="stylesheet" type="text/css">
    <link href="__PUBLIC__/css/Home/responsive.css" rel="stylesheet" type="text/css">
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script src="__PUBLIC__/js/oradt/Home/modernizr-2.8.3.min.js" type="text/javascript"></script>
</head>
<body>
    <main class="main-wrapper" id="container" style="max-width: 1200px;margin: 0 auto;">
        <div class="wrapper">
            <div class="">
                <ul class="small-block-grid-2 medium-block-grid-2 large-block-grid-2 masonry">
                    <volist name="data" id="item">
                    <volist name="item" id="list">
                    <volist name="list" id="value">
<!--                    {:dump($value)}-->
                    <li class="masonry-item grid">
                        <figure class="effect-sarah">
                            <img src="{$value}" alt="" />
                        </figure>
                    </li>
                    </volist>
                    </volist>
                    </volist>
                </ul>
            </div>
        </div>
    </main>
    <script src="__PUBLIC__/js/jquery/jquery.js"></script>
    <script src="__PUBLIC__/js/oradt/Home/plugins.js" type="text/javascript"></script>
    <script src="__PUBLIC__/js/oradt/Home/bootstrap.min.js" type="text/javascript"></script>
    <script src="__PUBLIC__/js/oradt/Home/jquery.contact.js" type="text/javascript"></script>
    <script src="__PUBLIC__/js/oradt/Home/main.js" type="text/javascript"></script>
    <script src="__PUBLIC__/js/oradt/Home/masonry.pkgd.min.js" type="text/javascript"></script>
    <script src="__PUBLIC__/js/oradt/Home/imagesloaded.pkgd.min.js" type="text/javascript"></script>
    <script src="__PUBLIC__/js/oradt/Home/jquery.infinitescroll.min.js" type="text/javascript"></script>
    <script src="__PUBLIC__/js/oradt/Home/main.js" type="text/javascript"></script>
    <script src="__PUBLIC__/js/oradt/Home/jquery.nicescroll.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        // $(function(){
        //   $('img.lazy').lazyload();
        // })
    </script>
</body>
</html>