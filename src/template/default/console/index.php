<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会员中心 - Powered by EBCMS</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha256-djO3wMl9GeaC/u6K+ic4Uj/LKhRUSlUFcsruzS7v5ms=" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha256-fh8VA992XMpeCZiRuU4xii75UIG6KvHrbUF8yIS/2/4=" crossorigin="anonymous"></script>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark border-bottom shadow-sm" style="z-index:2;">
        <div class="container-fluid">
            <a class="navbar-brand wb" href="{:$router->buildUrl('/ebcms/ucenter/console/index')}">会员中心</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto d-block d-lg-none">
                    {foreach $menus as $v}
                    <li class="nav-item">
                        <a class="nav-link" href="{$v.url}" target="main">{$v.title}</a>
                    </li>
                    {/foreach}
                </ul>
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="{:$router->buildUrl('/ebcms/ucenter/auth/logout')}">退出</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{$router->buildUrl('/')}" target="_blank">访问首页</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <script>
        $(function() {
            $(".navbar-nav li a").on("click", function() {
                if (!$(this).hasClass('dropdown-toggle')) {
                    $('.navbar-toggler').trigger('click');
                }
            });
        });
    </script>
    <style>
        html,
        body {
            width: 100%;
            height: 100%;
            overflow: hidden;
        }

        .main {
            overflow: hidden;
            position: absolute;
            left: 0;
            right: 0;
            bottom: 0;
            top: 57px;
        }

        .main .left {
            float: left;
            width: 200px;
            height: 100%;
            overflow: auto;
            border-right: 1px solid #eee;
        }

        .main .right {
            height: 100%;
            overflow: auto;
        }

        /*clear float.*/
        .main:after {
            content: "";
            height: 0;
            line-height: 0;
            display: block;
            visibility: hidden;
            clear: both;
        }
    </style>
    <div class="main">
        <div class="left d-none d-lg-block bg-light">
            <div>
                <ul class="nav flex-column" id="leftnav">
                    {foreach $menus as $v}
                    <li class="nav-item">
                        <a class="nav-link text-truncate py-3 px-4 font-weight-bold text-secondary" href="{$v.url}" target="{$v['target']??'main'}">{if isset($v['icon']) && $v['icon']}<span class="me-2"><img src="{$v['icon']}" alt="" style="width:20px;height:20px;"></span>{/if}{$v.title}{if strlen($v['badge'])}<span class="badge badge-danger badge-pill ml-1">{$v['badge']}</span>{/if}</a>
                    </li>
                    {/foreach}
                </ul>
            </div>
            <script>
                $("#leftnav > li").bind("click", function() {
                    $(this).addClass("cur").siblings().removeClass("cur");
                });
            </script>
            <style>
                #leftnav>li:hover {
                    background-color: #eaeaea;
                }

                #leftnav>.cur {
                    background-color: #eaeaea;
                }

                /*滚动条整体样式*/
                ::-webkit-scrollbar {
                    width: 5px;
                    height: 1px;
                }

                /*滚动条滑块*/
                ::-webkit-scrollbar-thumb {
                    border-radius: 5px;
                    box-shadow: inset 0 0 5px rgba(0, 0, 0, 0.2);
                    background: #f5f5f5;
                }

                /*滚动条轨道*/
                ::-webkit-scrollbar-track {
                    box-shadow: inset 0 0 1px rgba(0, 0, 0, 0);
                    border-radius: 5px;
                    background: #fafafa;
                }
            </style>
        </div>
        <div class="right">
            <iframe src="{:$router->buildUrl('/ebcms/ucenter/console/home')}" id="mainiframe" name="main" style="width:100%;height:100%;overflow:auto;display:block;" frameborder="0"></iframe>
        </div>
    </div>
</body>

</html>