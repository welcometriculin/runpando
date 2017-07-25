<?php

namespace app\api\modules\v2\models;

use Yii;

/**
 * This is the model class for table "tmp_plan_wise_yearly_summary".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $total
 * @property string $year
 * @property integer $rejected
 * @property integer $accepted
 * @property integer $bc
 * @property integer $bnc
 * @property integer $ac
 * @property integer $anc
 * @property integer $bc_planned
 * @property integer $bc_adhoc
 * @property integer $ac_planned
 * @property integer $ac_adhoc
 * @property integer $bnc_planned
 * @property integer $bnc_adhoc
 * @property integer $anc_planned
 * @property integer $anc_adhoc
 */
class TmpPlanWiseYearlySummary extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tmp_plan_wise_yearly_summary';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'total', 'year', 'rejected', 'accepted', 'bc', 'bnc', 'ac', 'anc', 'bc_planned', 'bc_adhoc', 'ac_planned', 'ac_adhoc', 'bnc_planned', 'bnc_adhoc', 'anc_planned', 'anc_adhoc'], 'required'],
            [['user_id', 'total', 'rejected', 'accepted', 'bc', 'bnc', 'ac', 'anc', 'bc_planned', 'bc_adhoc', 'ac_planned', 'ac_adhoc', 'bnc_planned', 'bnc_adhoc', 'anc_planned', 'anc_adhoc'], 'integer'],
            [['year'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'total' => 'Total',
            'year' => 'Year',
            'rejected' => 'Rejected',
            'accepted' => 'Accepted',
            'bc' => 'Bc',
            'bnc' => 'Bnc',
            'ac' => 'Ac',
            'anc' => 'Anc',
            'bc_planned' => 'Bc Planned',
            'bc_adhoc' => 'Bc Adhoc',
            'ac_planned' => 'Ac Planned',
            'ac_adhoc' => 'Ac Adhoc',
            'bnc_planned' => 'Bnc Planned',
            'bnc_adhoc' => 'Bnc Adhoc',
            'anc_planned' => 'Anc Planned',
            'anc_adhoc' => 'Anc Adhoc',
        ];
    }
}
