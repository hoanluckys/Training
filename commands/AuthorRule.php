<?php
namespace app\commands;

use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class AuthorRule extends Rule
{
    public $name= 'isAuthor';

    /**
     * @param $user
     * @param $item
     * @param $params
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        return isset($params['project']) ? $params['project']->projectManagerId == $user : false;
    }
}