<?php

use Composer\Package\PackageInterface;

$install_sql = <<<'str'
DROP TABLE IF EXISTS `prefix_ebcms_user_log`;
CREATE TABLE `prefix_ebcms_user_log` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `type` varchar(24) NOT NULL DEFAULT '' COMMENT '类型',
    `user_id` int(10) unsigned NOT NULL DEFAULT '0',
    `context` text,
    `http_raw` text,
    `ip` varchar(15) NOT NULL DEFAULT '' COMMENT 'ip',
    `record_date` date DEFAULT '1970-01-01',
    `record_time` int(10) unsigned NOT NULL DEFAULT '0',
    PRIMARY KEY (`id`) USING BTREE,
    KEY `record_date` (`record_date`),
    KEY `user_id` (`user_id`),
    KEY `ip` (`ip`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='会员日志表';
DROP TABLE IF EXISTS `prefix_ebcms_user_user`;
CREATE TABLE `prefix_ebcms_user_user` (
    `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',
    `phone` varchar(20) NOT NULL DEFAULT '',
    `nickname` varchar(20) NOT NULL DEFAULT '' COMMENT '标题',
    `avatar` varchar(255) NOT NULL DEFAULT '',
    `introduction` varchar(255) NOT NULL DEFAULT '',
    `coin` int(10) unsigned NOT NULL COMMENT '金币',
    `state` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `salt` char(32) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE KEY `phone` (`phone`) USING BTREE,
    UNIQUE KEY `nickname` (`nickname`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='会员表';
str;

$uninstall_sql = <<<'str'
DROP TABLE IF EXISTS `prefix_ebcms_user_log`;
DROP TABLE IF EXISTS `prefix_ebcms_user_user`;
str;

$demo_sql = <<<'str'
str;

return [
    'postPackageInstall' => function () use ($install_sql, $demo_sql) {
        $sql = $install_sql;
        fwrite(STDOUT, "是否安装演示数据？[yes]：");
        switch (trim((string) fgets(STDIN))) {
            case '':
            case 'yes':
                fwrite(STDOUT, "安装演示数据\n");
                $sql .= PHP_EOL . $demo_sql;
                break;

            default:
                fwrite(STDOUT, "不安装演示数据\n");
                break;
        }
        $sqls = array_filter(explode(";" . PHP_EOL, $sql));

        $prefix = 'prefix_';
        $cfg_file = getcwd() . '/config/database.php';
        $cfg = (array)include $cfg_file;
        if (isset($cfg['master']['prefix'])) {
            $prefix = $cfg['master']['prefix'];
        }

        $dbh = new PDO("{$cfg['master']['database_type']}:host={$cfg['master']['server']};dbname={$cfg['master']['database_name']}", $cfg['master']['username'], $cfg['master']['password']);

        foreach ($sqls as $sql) {
            $dbh->exec(str_replace('prefix_', $prefix, $sql . ';'));
        }
    },
    'postPackageUpdate' => function (PackageInterface $initialPackage, PackageInterface $targetPackage) {
    },
    'prePackageUninstall' => function () use ($uninstall_sql) {
        $sql = '';
        fwrite(STDOUT, "是否删除数据库？[yes]：");
        switch (trim((string) fgets(STDIN))) {
            case '':
            case 'yes':
                fwrite(STDOUT, "删除数据库\n");
                $sql .= PHP_EOL . $uninstall_sql;
                break;

            default:
                break;
        }
        $sqls = array_filter(explode(";" . PHP_EOL, $sql));

        $prefix = 'prefix_';
        $cfg_file = getcwd() . '/config/database.php';
        $cfg = (array)include $cfg_file;
        if (isset($cfg['master']['prefix'])) {
            $prefix = $cfg['master']['prefix'];
        }

        $dbh = new PDO("{$cfg['master']['database_type']}:host={$cfg['master']['server']};dbname={$cfg['master']['database_name']}", $cfg['master']['username'], $cfg['master']['password']);

        foreach ($sqls as $sql) {
            $dbh->exec(str_replace('prefix_', $prefix, $sql . ';'));
        }
    },
];
