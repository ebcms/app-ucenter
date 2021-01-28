<?php

use Ebcms\App;
use Ebcms\Router;

return App::getInstance()->execute(function (
    Router $router
): array {
    $res = [];
    $res[] = [
        'title' => '修改个人信息',
        'url' => $router->buildUrl('/ebcms/ucenter/console/edit-info'),
        'icon' => '<svg t="1611839103797" class="icon" viewBox="0 0 1024 1024" version="1.1" xmlns="http://www.w3.org/2000/svg" p-id="3979" width="20" height="20"><path d="M800.995556 662.186667a1214.577778 1214.577778 0 0 0-227.555556-71.68 201.386667 201.386667 0 0 0 35.271111-37.546667 199.111111 199.111111 0 0 0 38.684445-117.191111v-119.466667A200.817778 200.817778 0 0 0 568.888889 155.306667 198.542222 198.542222 0 0 0 448.284444 113.777778a200.248889 200.248889 0 0 0-199.68 202.524444v119.466667a200.248889 200.248889 0 0 0 77.937778 158.151111A1226.524444 1226.524444 0 0 0 113.777778 661.617778a97.848889 97.848889 0 0 0-56.888889 87.04v155.875555c10.808889 31.857778 22.186667 62.577778 56.888889 62.577778h682.666666c38.115556 0 52.337778-20.48 56.888889-56.888889v-170.666666a62.008889 62.008889 0 0 0-10.808889-40.96 92.728889 92.728889 0 0 0-41.528888-36.408889" fill="#0177FD" p-id="3980"></path><path d="M739.555556 113.777778m28.444444 0l170.666667 0q28.444444 0 28.444444 28.444444l0 0q0 28.444444-28.444444 28.444445l-170.666667 0q-28.444444 0-28.444444-28.444445l0 0q0-28.444444 28.444444-28.444444Z" fill="#0177FD" p-id="3981"></path><path d="M739.555556 227.555556m28.444444 0l170.666667 0q28.444444 0 28.444444 28.444444l0 0q0 28.444444-28.444444 28.444444l-170.666667 0q-28.444444 0-28.444444-28.444444l0 0q0-28.444444 28.444444-28.444444Z" fill="#0177FD" p-id="3982"></path><path d="M739.555556 341.333333m28.444444 0l170.666667 0q28.444444 0 28.444444 28.444445l0 0q0 28.444444-28.444444 28.444444l-170.666667 0q-28.444444 0-28.444444-28.444444l0 0q0-28.444444 28.444444-28.444445Z" fill="#0177FD" p-id="3983"></path></svg>',
        'priority' => 30,
    ];
    return $res;
});