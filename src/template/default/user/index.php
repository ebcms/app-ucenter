{include common/header@ebcms/admin}
<div class="container-xxl">
    <?php $cur = 'user'; ?>
    {include common/nav@ebcms/ucenter}
    <div class="my-4">
        <form id="form_filter" class="row row-cols-auto gy-2 gx-3 align-items-center mb-3" action="{:$router->buildUrl('/ebcms/ucenter/user/index')}" method="GET">

            <div class="col">
                <label class="visually-hidden">分页大小</label>
                <select class="form-select" name="page_num" onchange="document.getElementById('form_filter').submit();">
                    <option {if $request->get('page_num')=='20' }selected{/if} value="20">20</option>
                    <option {if $request->get('page_num')=='50' }selected{/if} value="50">50</option>
                    <option {if $request->get('page_num')=='100' }selected{/if} value="100">100</option>
                    <option {if $request->get('page_num')=='500' }selected{/if} value="500">500</option>
                </select>
            </div>

            <div class="col">
                <label class="visually-hidden">状态</label>
                <select class="form-select" name="state" onchange="document.getElementById('form_filter').submit();">
                    <option {if $request->get('state')=='' }selected{/if} value="">全部</option>
                    <option {if $request->get('state')=='1' }selected{/if} value="1">正常</option>
                    <option {if $request->get('state')=='2' }selected{/if} value="2">黑名单</option>
                    <option {if $request->get('state')=='99' }selected{/if} value="99">待审核</option>
                </select>
            </div>

            <div class="col">
                <input type="hidden" name="page" value="1">
                <input type="search" class="form-control mx-2" placeholder="请输入搜索词" name="q" value="{:$request->get('q')}" onchange="document.getElementById('form_filter').submit();">
            </div>
        </form>
    </div>
    <div class="table-responsive my-3">
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>昵称</th>
                    <th>电话</th>
                    <th>金币</th>
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
                    <td>{$v.coin}</td>
                    <td>{$v.state}</td>
                    <td>
                        <a href="{:$router->buildUrl('/ebcms/ucenter/user/edit', ['id'=>$v['id']])}">编辑</a>
                        <a href="{:$router->buildUrl('/ebcms/ucenter/log/index', ['user_id'=>$v['id']])}">日志</a>
                        <a href="{:$router->buildUrl('/ebcms/ucenter/user/coin', ['user_id'=>$v['id']])}">金币</a>
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
            <li class="page-item"><a class="page-link" href="{:$router->buildUrl('/ebcms/ucenter/user/index')}?page={$v.page}">{$v.page}</a></li>
            {/if}
            {/foreach}
        </ul>
    </nav>
</div>
{include common/footer@ebcms/admin}