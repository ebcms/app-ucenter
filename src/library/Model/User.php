<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Model;

use Ebcms\App;
use Ebcms\Config;
use Ebcms\Database\Model;
use Ebcms\Session;

class User extends Model
{

    private $users = [];

    public function getTable(): string
    {
        return 'ebcms_user_user';
    }

    public function init($ids)
    {
        $tmp = [];
        foreach ($ids as $value) {
            if (!isset($this->users[$value])) {
                $tmp[] = $value;
            }
        }
        if ($tmp) {
            $users = $this->select('*', [
                'id' => $tmp,
            ]);
            foreach ($users as $value) {
                $this->users[$value['id']] = $value;
            }
        }
    }

    public function login(int $uid): bool
    {
        $this->getLog()->record($uid, 'login');
        $this->getSession()->set('ucenter_user_id', $uid);
        setcookie($this->getTokenKey(), $this->makeToken($uid), time() + (int)$this->getConfig()->get('auth.expire_time@ebcms.ucenter', 0), '/');
        return true;
    }

    public function logout(): bool
    {
        $this->getLog()->record($this->getLoginId(), 'logout');
        setcookie($this->getTokenKey(), '', time() - 3600, '/');
        $this->getSession()->unset('ucenter_user_id');
        return true;
    }

    public function getLoginId(): int
    {
        if ($uid = $this->getSession()->get('ucenter_user_id')) {
            return (int)$uid;
        }

        if ($uid = $this->autoLogin()) {
            return (int)$uid;
        }

        return 0;
    }

    private function autoLogin(): int
    {
        if (isset($_COOKIE[$this->getTokenKey()])) {
            $token = $_COOKIE[$this->getTokenKey()];

            $tmp = array_filter(explode('_', $token));
            if (count($tmp) == 2) {
                $uid = (int)$tmp[0];
                $code = $tmp[1];
                if ($user = $this->get('*', [
                    'id' => $uid,
                ])) {
                    if (md5($user['salt'] . '_' . $uid) == $code) {
                        $this->login($uid);
                        return $uid;
                    }
                }
            }
        }
        return 0;
    }

    private function makeToken(int $uid): string
    {
        if ($user = $this->get('*', [
            'id' => $uid,
        ])) {
            return $uid . '_' . md5($user['salt'] . '_' . $uid);
        }
        return '';
    }

    private function getTokenKey(): string
    {
        return md5($_SERVER['HTTP_USER_AGENT']);
    }

    private function getSession(): Session
    {
        return App::getInstance()->execute(function (
            Session $session
        ): Session {
            return $session;
        });
    }

    private function getConfig(): Config
    {
        return App::getInstance()->execute(function (
            Config $config
        ): Config {
            return $config;
        });
    }

    private function getLog(): Log
    {
        return App::getInstance()->execute(function (
            Log $log
        ): Log {
            return $log;
        });
    }
}
