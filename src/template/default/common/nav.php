<div class="my-4 h1">用户中心</div>
<ul class="nav nav-tabs bg-light pt-2 px-2">
    <li class="nav-item">
        <a class="nav-link {if $cur=='index'}active{/if}" href="{:$router->buildUrl('/ebcms/ucenter/index')}">概览</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {if $cur=='user'}active{/if}" href="{:$router->buildUrl('/ebcms/ucenter/user/index')}">用户管理</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {if $cur=='log'}active{/if}" href="{:$router->buildUrl('/ebcms/ucenter/log/index')}">日志管理</a>
    </li>
</ul>