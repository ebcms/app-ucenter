{include common/header@ebcms/admin}
<div class="container-xxl">
    <dl>
        <dd>
            <span class="me-3"><b>IP:</b> <code>{$log.ip}</code></span>
            <span class="me-3"><b>时间:</b> <code>{:date('Y-m-d H:i:s', $log['record_time'])}</code></span>
            <span class="me-3"><b>用户ID:</b> <code>{$log.user_id}</code></span>
        </dd>
        <dt class="text-nowrap">类型</dt>
        <dd><code>{$log.type}</code></dd>
        <dt class="text-nowrap">上下文</dt>
        <dd><code>{$log.context}</code></dd>
        <dt class="text-nowrap">原始数据</dt>
        <dd><code style="white-space: pre-wrap;">{:htmlspecialchars($log['http_raw'])}</code></dd>
    </dl>
</div>
{include common/footer@ebcms/admin}