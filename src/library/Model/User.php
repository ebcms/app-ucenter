<?php

declare(strict_types=1);

namespace App\Ebcms\Ucenter\Model;

use Ebcms\Database\Model;

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
}
