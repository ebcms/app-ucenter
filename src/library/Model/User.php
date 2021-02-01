<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Model;

use Ebcms\App;
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

    public function login(int $id): bool
    {
        $this->getSession()->set('ucenter_user_id', $id);
        return true;
    }

    public function logout(): bool
    {
        $this->getSession()->delete('ucenter_user_id');
        return true;
    }

    public function getLoginId(): int
    {
        return (int)($this->getSession()->get('ucenter_user_id') ?: 0);
    }

    private function getSession(): Session
    {
        return App::getInstance()->execute(function (
            Session $session
        ): Session {
            return $session;
        });
    }
}
