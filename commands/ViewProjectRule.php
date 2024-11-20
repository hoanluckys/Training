<?php
namespace app\commands;

use yii\rbac\Rule;

/**
 * Checks if authorID matches user passed via params
 */
class ViewProjectRule extends Rule
{
    public $name= 'isViewProject';

    /**
     * @param $user
     * @param $item
     * @param $params
     * @return bool
     */
    public function execute($user, $item, $params)
    {
        return isset($params['idUser']) ? in_array($user,$params['idUser']) : false;
    }
}
