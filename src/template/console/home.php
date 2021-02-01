{include console/header@ebcms/ucenter}
<div class="display-4 my-4">个人中心</div>
<hr>
<div class="my-3 h3">欢迎你</div>
<div class="media">
    <img style="width: 90px;height: 90px;" class="mr-3" src="{$my['avatar']?:'data:image/svg+xml;base64,PHN2ZyB0PSIxNjEyMTc4MjI4MzM0IiBjbGFzcz0iaWNvbiIgdmlld0JveD0iMCAwIDEwMjQgMTAyNCIgdmVyc2lvbj0iMS4xIiB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHAtaWQ9IjIyOTUiIHdpZHRoPSIxMjgiIGhlaWdodD0iMTI4Ij48cGF0aCBkPSJNMTAgMTBoMTAwNHYxMDA0SDEweiIgZmlsbD0iI0ZGRkZGRiIgcC1pZD0iMjI5NiI+PC9wYXRoPjxwYXRoIGQ9Ik0tMS43Mjk0MjIyMi0xLjcyOTQyMjIyaDEwMjkuODg2MTAzN3YxMDI5Ljg4NjEwMzdILTEuNzI5NDIyMjJWLTEuNzI5NDIyMjJ6IiBmaWxsPSIjRThFQ0ZGIiBwLWlkPSIyMjk3Ij48L3BhdGg+PHBhdGggZD0iTTMzMi4zOCA0NDcuMTZjMCAxMTEuMiA3OCAyMDEuMiAxNzQgMjAxLjIgOTYuMiAwIDE3NC05MCAxNzQtMjAxLjIgMC0xMTEuMi03Ny44LTIwMS4yLTE3NC0yMDEuMi05NiAwLTE3NCA5MC0xNzQgMjAxLjJ6IiBmaWxsPSIjRkRENUMzIiBwLWlkPSIyMjk4Ij48L3BhdGg+PHBhdGggZD0iTTMyOS4yNiA0ODcuMTZzNjIuMi02MC44IDIwNy42LTcwLjRjMCAwIDk3LjItOS42IDEyNy42LTQ0LjZsMTkuMiA5MXM2NS40LTE2NC42LTI4LjgtMjAyLjhjMCAwLTMwNi40LTk3LjQtMzI3LjIgNjMuOCAwLTEuNi0xNy42IDY4LjYgMS42IDE2M3oiIGZpbGw9IiM1NTU1NTUiIHAtaWQ9IjIyOTkiPjwvcGF0aD48cGF0aCBkPSJNNDQ3LjI0IDU4My43NGgxMjEuNHYxMTUuNmgtMTIxLjR2LTExNS42eiIgZmlsbD0iI0ZERDVDMyIgcC1pZD0iMjMwMCI+PC9wYXRoPjxwYXRoIGQ9Ik01MTUuOTIgNjk3LjEyYy0xNzUuNiAwLTMxOCAxMDcuMi0zMTggMjM5LjRoNjM2LjJjMC0xMzIuMi0xNDIuNC0yMzkuNC0zMTguMi0yMzkuNHoiIGZpbGw9IiM2MDdCRjEiIHAtaWQ9IjIzMDEiPjwvcGF0aD48L3N2Zz4='}" alt="...">
    <div class="media-body">
        <h5 class="mt-0 mb-1">{$my.nickname}</h5>
        <div>
            <code><b>电话：</b>{:substr($my['phone'], 0, 3)}****{:substr($my['phone'], 7)} <b>积分：</b>{$my.score} <b>金币：</b>{$my.coin}</code>
        </div>
        <div class="mt-1">{$my['introduction']?:'<em>暂无介绍</em>'}</div>
    </div>
</div>
<div class="mt-3">
    <a href="{:$router->buildUrl('/ebcms/ucenter/console/edit-info')}" class="btn btn-primary btn-sm">编辑个人信息</a>
</div>
{include console/footer@ebcms/ucenter}