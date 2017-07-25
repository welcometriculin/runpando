<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_privileges_map".
 *
 * @property string $id
 * @property string $role_id
 * @property string $privilege_id
 *
 * @property Privileges $privilege
 * @property Roles $role
 */
class RolePrivilegesMap extends \yii\db\ActiveRecord
{
	public $controller_id;
	public $action_id;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_privileges_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
//             [['role_id', 'privilege_id'], 'required'],
//             [['role_id', 'privilege_id'], 'integer']
        	   [['role_id', 'controller_id'], 'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'privilege_id' => 'Privilege ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrivilege()
    {
        return $this->hasOne(Privileges::className(), ['id' => 'privilege_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role_id']);
    }
}
