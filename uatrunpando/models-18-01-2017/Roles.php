<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "roles".
 *
 * @property string $id
 * @property string $role_name
 * @property string $role_desc
 *
 * @property RolePrivilegesMap[] $rolePrivilegesMaps
 * @property Users[] $users
 */
class Roles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
	const KGADMIN = 1;
	const ICADMIN = 2;
	const MANAGER = 3;
	const FIELDFORCE = 4;
	
    public static function tableName()
    {
        return 'roles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_name', 'role_desc'], 'required'],
            [['role_name'], 'string', 'max' => 25],
            [['role_desc'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_name' => 'Role Name',
            'role_desc' => 'Role Desc',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRolePrivilegesMaps()
    {
        return $this->hasMany(RolePrivilegesMap::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(Users::className(), ['roleid' => 'id']);
    }
}
