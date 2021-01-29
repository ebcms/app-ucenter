{include common/header@ebcms/admin}
<?php $cur = 'log'; ?>
{include admin/common/nav@ebcms/ucenter}
<div class="my-4">
    <form id="form_filter" class="form-inline" action="{:$router->buildUrl('/ebcms/ucenter/admin/log/index')}" method="GET">

        <label class="mr-2">分页大小</label>
        <select class="custom-select" name="page_num" onchange="document.getElementById('form_filter').submit();">
            <option {if $input->get('page_num')=='20' }selected{/if} value="20">20</option>
            <option {if $input->get('page_num')=='50' }selected{/if} value="50">50</option>
            <option {if $input->get('page_num')=='100' }selected{/if} value="100">100</option>
            <option {if $input->get('page_num')=='500' }selected{/if} value="500">500</option>
        </select>

        <label class="mx-2">用户ID</label>
        <input type="search" class="form-control" name="user_id" value="{:$input->get('user_id')}" onchange="document.getElementById('form_filter').submit();">

        <label class="mx-2">日志类型</label>
        <input type="search" class="form-control" name="type" value="{:$input->get('type')}" onchange="document.getElementById('form_filter').submit();">
        <input type="hidden" name="page" value="1">
    </form>
</div>
<div class="table-responsive my-4">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th class="text-nowrap">用户ID</th>
                <th class="text-nowrap">类型</th>
                <th class="text-nowrap">IP</th>
                <th class="text-nowrap">记录时间</th>
                <th class="text-nowrap">操作</th>
            </tr>
        </thead>
        <tbody>
            {foreach $logs as $v}
            <tr>
                <td>{$v.id}</td>
                <td><a href="{:$router->buildUrl('/ebcms/ucenter/admin/user/index', ['user_id'=>$v['user_id']])}">{$v.user_id}</a></td>
                <td>{$v.type}</td>
                <td>{$v['ip']}</td>
                <td class="text-nowrap">{:date('Y-m-d H:i:s', $v['record_time'])}</td>
                <td>
                    <a href="javascript:M.open({url:'{:$router->buildUrl('/ebcms/ucenter/admin/log/detail', ['id'=>$v['id']])}', title:'日志详情'});">详情</a>
                </td>
            </tr>
            {/foreach}
        </tbody>
    </table>
</div>
<nav>
    <ul class="pagination">
        {foreach $pages as $v}
        {if $v=='...'}
        <li class="page-item disabled"><a class="page-link" href="javascript:void(0);">{$v}</a></li>
        {elseif isset($v['current'])}
        <li class="page-item active"><a class="page-link" href="javascript:void(0);">{$v.page}</a></li>
        {else}
        <li class="page-item"><a class="page-link" href="{:$router->buildUrl('/ebcms/ucenter/admin/user/index')}?page={$v.page}">{$v.page}</a></li>
        {/if}
        {/foreach}
    </ul>
</nav>
{include common/footer@ebcms/admin}