{include common/header@ebcms/admin}
<?php $cur = 'user'; ?>
{include admin/common/nav@ebcms/ucenter}
<div class="my-4">
    <form id="form_filter" class="form-inline" action="{:$router->buildUrl('/ebcms/ucenter/admin/user/index')}" method="GET">

        <label class="mr-2">分页大小</label>
        <select class="custom-select" name="page_num" onchange="document.getElementById('form_filter').submit();">
            <option {if $input->get('page_num')=='20' }selected{/if} value="20">20</option>
            <option {if $input->get('page_num')=='50' }selected{/if} value="50">50</option>
            <option {if $input->get('page_num')=='100' }selected{/if} value="100">100</option>
            <option {if $input->get('page_num')=='500' }selected{/if} value="500">500</option>
        </select>

        <label class="mx-2">状态</label>
        <select class="custom-select" name="state" onchange="document.getElementById('form_filter').submit();">
            <option {if $input->get('state')=='' }selected{/if} value="">全部</option>
            <option {if $input->get('state')=='1' }selected{/if} value="1">正常</option>
            <option {if $input->get('state')=='2' }selected{/if} value="2">黑名单</option>
            <option {if $input->get('state')=='99' }selected{/if} value="99">待审核</option>
        </select>

        <input type="search" class="form-control mx-2" name="q" value="{:$input->get('q')}" onchange="document.getElementById('form_filter').submit();">
        <input type="hidden" name="page" value="1">
    </form>
</div>
<div class="table-responsive my-3">
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>昵称</th>
                <th>电话</th>
                <th>状态</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            {foreach $users as $v}
            <tr>
                <td>{$v.id}</td>
                <td>{$v.nickname}</td>
                <td>{$v.phone}</td>
                <td>{:$v['state']}</td>
                <td>
                    <a href="{:$router->buildUrl('/ebcms/ucenter/admin/user/edit', ['id'=>$v['id']])}">编辑</a>
                    <a href="{:$router->buildUrl('/ebcms/ucenter/admin/log/index', ['user_id'=>$v['id']])}">日志</a>
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