<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter;

use Ebcms\App;
use Ebcms\Database\Db;

class Package
{

    public static function postPackageInstall()
    {
        App::getInstance(getcwd())->execute(function (
            App $app,
            Db $db
        ) {
            $sql = self::getInstallSql();
            $sqls = array_filter(explode(";" . PHP_EOL, $sql));
            $prefix = 'prefix_';
            $cfg_file = $app->getAppPath() . '/config/database.php';
            if (file_exists($cfg_file)) {
                $cfg = (array)include $cfg_file;
                if (isset($cfg['master']['prefix'])) {
                    $prefix = $cfg['master']['prefix'];
                }
            }
            foreach ($sqls as $sql) {
                $db->master()->exec(str_replace('prefix_', $prefix, $sql . ';'));
            }
        });
    }

    public static function postPackageUpdate()
    {
    }

    public static function prePackageUninstall()
    {
        App::getInstance(getcwd())->execute(function (
            App $app,
            Db $db
        ) {
            $sql = '';
            fwrite(STDOUT, "是否删除数据库？[yes]：");
            switch (trim((string) fgets(STDIN))) {
                case '':
                case 'yes':
                    fwrite(STDOUT, "删除数据库\n");
                    $sql .= PHP_EOL . self::getUninstallSql();
                    break;

                default:
                    break;
            }
            $sqls = array_filter(explode(";" . PHP_EOL, $sql));
            $prefix = 'prefix_';
            $cfg_file = $app->getAppPath() . '/config/database.php';
            if (file_exists($cfg_file)) {
                $cfg = (array)include $cfg_file;
                if (isset($cfg['master']['prefix'])) {
                    $prefix = $cfg['master']['prefix'];
                }
            }
            foreach ($sqls as $sql) {
                $db->master()->exec(str_replace('prefix_', $prefix, $sql . ';'));
            }
        });
    }

    private static function getInstallSql(): string
    {
        return <<<'str'
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
    `score` int(10) unsigned NOT NULL COMMENT '积分',
    `coin` int(10) unsigned NOT NULL COMMENT '金币',
    `state` tinyint(3) unsigned NOT NULL DEFAULT '0',
    `salt` char(32) NOT NULL DEFAULT '',
    PRIMARY KEY (`id`) USING BTREE,
    UNIQUE KEY `phone` (`phone`) USING BTREE,
    UNIQUE KEY `nickname` (`nickname`) USING BTREE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 ROW_FORMAT=COMPACT COMMENT='会员表';
str;
    }

    private static function getUninstallSql(): string
    {
        return <<<'str'
DROP TABLE IF EXISTS `prefix_ebcms_user_log`;
DROP TABLE IF EXISTS `prefix_ebcms_user_user`;
str;
    }
}
