{include common/header@ebcms/admin}
<?php $cur = 'index'; ?>
{include admin/common/nav@ebcms/ucenter}
<div class="my-4 bg-light p-4 shadow-sm border h4">用户总数：<code>{$total}</code></div>
<div class="my-4">
    <a class="btn btn-primary" href="javascript:M.open({url:'{:$router->buildUrl('/ebcms/ucenter/admin/config')}', title:'用户中心设置'});">系统设置</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/echarts@4.9.0/dist/echarts.min.js" integrity="sha256-lwAMcEIM4LbH2eRQ18mRn5fwNPqOwEaslnGcCKK78yQ=" crossorigin="anonymous"></script>
<script type="text/javascript">
    var myChart;

    function render() {
        $.ajax({
            type: "GET",
            url: "{:$router->buildUrl('/ebcms/ucenter/admin/stats')}",
            data: $("#formdd").serialize(),
            dataType: "JSON",
            success: function(response) {
                myChart.setOption(response);
            }
        });
    }
    $(document).ready(function() {
        myChart = echarts.init(document.getElementById('main'));
        render();
    });
</script>
<div class="my-3">
    <form class="form-inline" id="formdd">
        <div class="form-group mb-2">
            <label for="month" class="sr-only">月份</label>
            <input type="month" class="form-control" value="{:date('Y-m')}" onchange="render()" id="month" name="month" placeholder="月份">
        </div>
    </form>
</div>
<div id="main" style="width: 100%;height:400px;" class="mb-4"></div>
{include common/footer@ebcms/admin}