<!doctype html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>登录</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" integrity="sha256-djO3wMl9GeaC/u6K+ic4Uj/LKhRUSlUFcsruzS7v5ms=" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha256-fh8VA992XMpeCZiRuU4xii75UIG6KvHrbUF8yIS/2/4=" crossorigin="anonymous"></script>
    <script>
        var M = {};
        M.login = function() {
            var code = prompt('校验码已发送到手机，请输入手机收到的校验码：');
            if (code !== null) {
                $.ajax({
                    type: "POST",
                    url: "{:$router->buildUrl('/ebcms/ucenter/auth/login')}",
                    data: {
                        code: code,
                    },
                    dataType: "JSON",
                    success: function(response) {
                        alert(response.message);
                        if (!response.code) {
                            if (response.data) {
                                M.login();
                            }
                        } else {
                            location.href = response.url;
                        }
                    }
                });
            }
        }
        $(function() {
            $("#captcha").trigger('click');
            $("#form").bind('submit', function() {
                $.ajax({
                    type: "POST",
                    url: "{:$router->buildUrl('/ebcms/ucenter/auth/send-code')}",
                    data: $("#form").serialize(),
                    dataType: "JSON",
                    success: function(response) {
                        $("#captcha").trigger('click');
                        if (!response.code) {
                            alert(response.message);
                        } else {
                            M.login();
                        }
                    }
                });
                return false;
            });
        });
    </script>
</head>

<body>
    <div class="my-3" style="max-width: 400px; margin:0 auto;">
        <div class="display-5 my-4">用户登录</div>
        <div class="border p-4 rounded shadow">
            <form id="form">
                <div class="mb-3">
                    <label class="form-label" for="phone">电话号码</label>
                    <input type="tel" name="phone" class="form-control form-control-lg" id="phone" autocomplete="off" required>
                </div>
                <div class="mb-3">
                    <label class="form-label" for="captchav">验证码</label>
                    <div class="input-group mb-2 me-sm-2">
                        <input type="text" name="captcha" id="captchav" class="form-control form-control-lg" autocomplete="off" required>
                        <div class="input-group-append">
                            <img id="captcha" style="vertical-align: middle;cursor: pointer;height: 48px;" class="rounded-right" onclick="this.src = '<?php echo $router->buildUrl('/ebcms/ucenter/auth/captcha'); ?>?time=' + (new Date()).getTime();">
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn btn-primary btn-lg btn-block mb-2">登录</button>
                <div class="form-text">无需注册，直接登陆</div>
            </form>
        </div>
        <div class="text-muted my-4">
            <p>Powered By <a href="http://www.ebcms.com" target="_blank">EBCMS</a></p>
        </div>
    </div>
</body>

</html>