<!DOCTYPE html>
<html lang="zh-CN">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>会员中心 - Powered by {$config->get('copyright.name@ebcms.admin')}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1/dist/css/bootstrap.min.css">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        var M = {};
        M.open = function(open) {
            open = $.extend({
                id: (new Date).getTime(),
                url: '',
                title: '窗口',
                size: 'xl',
            }, open);
            var timer;
            if (!$('#' + open.id).length) {
                var str = '';
                str += '<div class="modal fade" id="' + open.id + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
                str += '<div class="modal-dialog modal-' + open.size + '" role="document">';
                str += '<div class="modal-content">';
                str += '<div class="modal-header">';
                str += '<div class="modal-title">' + open.title + '</div>';
                str += '<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>';
                str += '</div>';
                str += '<div class="modal-body">';
                str += '<iframe frameborder="0" id="iframe_' + open.id + '" src="' + open.url + '" scrolling="no" style="width: 100%;"></iframe>';
                str += '</div>';
                str += '</div>';
                str += '</div>';
                str += '</div>';
                $('body').append(str);
                $("#iframe_" + open.id).on("load", function() {
                    var myiframeH = $('#iframe_' + open.id).contents().find("html").outerHeight(true);
                    $('#iframe_' + open.id).height(myiframeH);
                });
                $('#' + open.id).on('shown.bs.modal', function(e) {

                });
                $('#' + open.id).on('hidden.bs.modal', function(e) {
                    if (timer) {
                        clearInterval(timer);
                    }
                    $('#' + open.id).remove();
                });
            }
            timer = setInterval(function() {
                var myiframeH = $('#iframe_' + open.id).contents().find("html").outerHeight(true);
                $('#iframe_' + open.id).height(myiframeH);
            }, 300);
            $('#' + open.id).modal('show');
            return false;
        }
        M.modal = function(modal) {
            modal = $.extend({
                id: "modal_" + (new Date).getTime(),
                size: 'lg',
                title: '信息',
                body: '<i class="text-muted">(暂无内容)</i>',
            }, modal);
            var str = '';
            str += '<div class="modal fade" id="' + modal.id + '" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">';
            str += '<div class="modal-dialog modal-' + modal.size + '" role="document">';
            str += '<div class="modal-content">';
            str += '<div class="modal-header">';
            str += '<div class="modal-title">' + modal.title + '</div>';
            str += '<button type="button" class="close" data-bs-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
            str += '</div>';
            str += '<div class="modal-body">';
            str += modal.body;
            str += '</div>';
            str += '</div>';
            str += '</div>';
            str += '</div>';
            $('body').append(str);
            $('#' + modal.id).on('hidden.bs.modal', function(e) {
                $('#' + modal.id).remove();
            });
            $('#' + modal.id).modal('show');
            return false;
        }
        M.toast = function(toast) {
            var toasts = JSON.parse(localStorage.getItem("toast") ? localStorage.getItem("toast") : "{}");
            var id = (new Date).getTime();
            toasts[id] = $.extend({
                id: id,
                title: '系统消息',
                delay: 10000,
                icon: '<svg t="1607068486805" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="23817" width="16" height="16"><path d="M0 512a512 512 0 1 1 1024 0A512 512 0 1 1 0 512z" fill="#F34444" p-id="23818"></path><path d="M285.070222 438.442667a30.037333 30.037333 0 0 1 9.045334-22.755556 29.923556 29.923556 0 0 1 21.674666-9.557333h29.582222v143.018666h-30.151111a26.339556 26.339556 0 0 1-21.674666-9.443555 27.875556 27.875556 0 0 1-8.988445-22.755556l0.568889-78.506666z m336.440889-131.413334c13.653333-14.222222 25.713778-22.186667 37.717333-22.186666a36.693333 36.693333 0 0 1 30.321778 9.386666c9.841778 9.159111 17.635556 20.593778 22.528 33.393778 6.257778 15.928889 11.377778 32.312889 15.36 49.038222 3.982222 18.773333 6.997333 37.774222 9.102222 56.888889 1.479111 20.593778 3.015111 39.594667 3.015112 56.888889 0 17.294222-1.536 36.408889-3.015112 53.816889-2.730667 17.066667-6.371556 34.019556-10.865777 50.631111a201.955556 201.955556 0 0 1-16.384 41.244445c-5.404444 10.24-12.515556 19.342222-21.048889 26.851555a29.013333 29.013333 0 0 1-24.234667 6.371556 48.981333 48.981333 0 0 1-27.136-20.593778 122.311111 122.311111 0 0 0-37.717333-28.444445 276.195556 276.195556 0 0 0-51.370667-18.318222 611.953778 611.953778 0 0 0-57.400889-12.8c-19.626667-3.128889-36.238222-6.257778-52.849778-7.850666-16.611556-1.592889-28.615111-4.778667-40.789333-7.964445-12.174222-3.185778-19.512889-6.257778-21.048889-9.443555v-160.426667c1.536-4.664889 5.973333-7.850667 15.075556-11.377778 11.377778-3.811556 22.983111-6.940444 34.702222-9.443555 13.596444-3.185778 28.672-6.371556 46.819556-9.557334 18.090667-3.185778 34.702222-7.850667 52.849777-12.629333a373.76 373.76 0 0 0 52.849778-22.755556c15.644444-8.590222 30.264889-19.228444 43.406222-31.687111l0.113778 0.910222zM447.829333 618.951111a49.834667 49.834667 0 0 0 6.087111 12.629333c2.275556 5.404444 4.778667 10.695111 7.623112 15.815112 3.470222 6.656 7.509333 13.084444 12.060444 19.000888 6.030222 7.964444 10.808889 17.408 16.554667 25.372445 4.721778 7.623111 8.817778 15.644444 12.288 24.007111 3.015111 7.964444 4.551111 12.743111 3.015111 17.408-1.479111 4.664889-5.916444 6.371556-13.539556 6.371556H464.782222a71.509333 71.509333 0 0 1-18.432-3.527112 54.328889 54.328889 0 0 1-15.189333-11.377777 80.952889 80.952889 0 0 1-14.791111-20.252445c-4.437333-7.964444-10.808889-17.408-16.611556-28.444444a161.905778 161.905778 0 0 1-15.075555-33.336889c-3.015111-9.443556-4.551111-17.408-6.087111-23.665778a29.127111 29.127111 0 0 1-1.365334-19.057778c2.901333 0 5.973333 1.592889 8.988445 1.592889 3.754667 0.512 7.395556 1.536 10.808889 3.072 4.551111 1.592889 9.159111 1.592889 15.246222 3.185778 4.892444 1.706667 9.955556 2.787556 15.075555 3.185778 3.868444 1.706667 7.907556 2.730667 12.060445 3.242666l8.419555 4.778667z" fill="#FFFFFF" p-id="23819"></path></svg>',
                content: '<i class="text-muted">(暂无内容)</i>',
            }, toast);
            localStorage.setItem("toast", JSON.stringify(toasts));
            return false;
        }
    </script>
</head>

<body>
    <div class="container-xxl">