<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "privileges".
 *
 * @property string $id
 * @property string $controller
 * @property string $action
 *
 * @property RolePrivilegesMap[] $rolePrivilegesMaps
 */
class Privileges extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'privileges';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller', 'action'], 'required'],
            [['controller', 'action'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'controller' => 'Controller',
            'action' => 'Action',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolePrivilegesMaps()
    {
        return $this->hasMany(RolePrivilegesMap::className(), ['privilege_id' => 'id']);
    }
}
