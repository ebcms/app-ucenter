<!doctype html>
<html lang="zh-CN">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>登录</title>
    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/css/bootstrap.min.css" integrity="sha256-aAr2Zpq8MZ+YA/D6JtRD3xtrwpEz2IqOS+pWD/7XKIw=" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.min.js" integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.0/dist/js/bootstrap.bundle.min.js" integrity="sha256-Xt8pc4G0CdcRvI0nZ2lRpZ4VHng0EoUDMlGcBSQ9HiQ=" crossorigin="anonymous"></script>
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
    <div class="container-lg">
        <div class="my-3" style="max-width: 400px;margin-left: auto;margin-right: auto;">
            <div class="display-4 my-5 text-center">用户登录</div>
            <div class="border p-4 rounded shadow ">
                <form id="form">
                    <div class="form-group">
                        <label for="phone">电话号码</label>
                        <input type="tel" name="phone" class="form-control form-control-lg" id="phone" autocomplete="off" required>
                    </div>
                    <div class="form-group">
                        <label>验证码</label>
                        <div class="input-group mb-2 mr-sm-2">
                            <input type="text" name="captcha" class="form-control form-control-lg" autocomplete="off" required>
                            <div class="input-group-append">
                                <img id="captcha" style="vertical-align: middle;cursor: pointer;height: 48px;" class="rounded-right" onclick="this.src = '<?php echo $router->buildUrl('/ebcms/ucenter/auth/captcha'); ?>?time=' + (new Date()).getTime();">
                            </div>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block mt-4">登录</button>
                    <div class="text-secondary">无需注册，直接登陆</div>
                </form>
            </div>
            <div class="text-muted my-4">
                <p>Powered By <a href="http://www.ebcms.com" target="_blank">EBCMS</a></p>
            </div>
        </div>
    </div>
</body>

</html>