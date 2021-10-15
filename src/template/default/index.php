{include common/header@ebcms/admin}
<div class="container-xxl">
    <?php $cur = 'index'; ?>
    {include common/nav@ebcms/ucenter}
    <div class="my-4 bg-light p-4 shadow-sm border h4">用户总数：<code>{$total}</code></div>
    <script src="https://cdn.jsdelivr.net/npm/echarts@4.9.0/dist/echarts.min.js" integrity="sha256-lwAMcEIM4LbH2eRQ18mRn5fwNPqOwEaslnGcCKK78yQ=" crossorigin="anonymous"></script>
    <script type="text/javascript">
        var myChart;

        function render() {
            $.ajax({
                type: "GET",
                url: "{:$router->buildUrl('/ebcms/ucenter/stats')}",
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
    <form class="row gy-2 gx-3 align-items-center mb-3" id="formdd">
        <div class="col-auto">
            <label for="month" class="visually-hidden">月份</label>
            <input type="month" class="form-control" value="{:date('Y-m')}" onchange="render()" id="month" name="month" placeholder="月份">
        </div>
    </form>
    <div id="main" style="width: 100%;height:400px;" class="mb-4"></div>
</div>
{include common/footer@ebcms/admin}