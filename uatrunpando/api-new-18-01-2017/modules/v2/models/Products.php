<?php

namespace app\api\modules\v2\models;

use Yii;
use yii\helpers\Arrayhelper;
/**
 * This is the model class for table "products".
 *
 * @property integer $id
 * @property string $guid
 * @property string $product_name
 * @property integer $comp_id
 * @property integer $user_id
 * @property integer $created_by
 * @property string $created_date
 * @property integer $updated_by
 * @property string $updated_date
 *
 * @property Users $user
 * @property InputCompanies $comp
 */
class Products extends  Kg
{
	public $bulkproducts;
	public $free_text_search;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'products';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['guid', 'product_name', 'comp_id', 'user_id', 'created_by', 'created_date', 'updated_by', 'updated_date'], 'required'],
            [['comp_id', 'user_id', 'created_by', 'updated_by'], 'integer'],
            [['created_date', 'updated_date'], 'safe'],
            [['guid', 'product_name'], 'string', 'max' => 100],
            ['bulkproducts', 'required'],
            [['bulkproducts'], 'file', 'skipOnEmpty' => false, 'extensions' => 'xls, csv'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'guid' => 'Guid',
            'product_name' => (count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['product_label']) :'Product').' Name',
            'comp_id' => 'Comp ID',
            'user_id' => 'User ID',
            'created_by' => 'Created By',
            'created_date' => 'Created Date',
            'updated_by' => 'Updated By',
            'updated_date' => 'Updated Date',
        	'bulkproducts' => 'Bulk '.(count($label_names_display = LabelNames::labelNamesDisplay()) > 0 ? ucfirst($label_names_display['product_label']) :'Products'),	
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComp()
    {
        return $this->hasOne(InputCompanies::className(), ['id' => 'comp_id']);
    }
/*     public static function productList($assign_to, $flag)
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	$list = self::find()->select('id, product_name')->where(['comp_id' => $company_id, 'is_deleted' => 0])->andWhere(['!=', 'role_id', 0])->asArray()->all();
    	if ($flag == 'create') {
    	$dropdown = '<option value = "" >Select Product</option>';
    	if(!empty($list)) {
    		foreach ($list as $drop) {
    			$dropdown .= "<option value = '".$drop['product_name']."' >".$drop['product_name']."</option>";
    		}
    	}
    	//$dropdown .='<option value = "add-new-elements" style = "background-color:#5e4091;color:white">Add New</option>';
    		return $dropdown;
    	} else {
    		return $list;
    	}
    	/* $user_id=Yii::$app->user->identity->id;
    	$sql="SELECT p.product_name from users u
			JOIN products p ON p.user_id = u.id where u.reporting_user_id =".$user_id;
    	return $q = Yii::$app->db->createCommand($sql)->queryAll(); */
    	//return $list=self::find()->select('product_name,id')->where(['comp_id'=>$company_id])->all();
    /*} */
    //for web products dropdown build plan
    public static function productList()
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	$list = self::find()->select('id, product_name')->where(['comp_id' => $company_id, 'is_deleted' => 0])->andWhere(['!=', 'role_id', 0])->orderBy(['product_name' => SORT_ASC])->asArray()->all();
    	$listData = ArrayHelper::map($list, 'id', 'product_name');
    	return $listData;
    }
    public static function productsdata($date,$id)
    {
    	$products = array();
    	if(!$date){
    		$products=Yii::$app->db->createCommand("select product_name from products where user_id=$id")->queryAll();
    		if(empty($products))
    		{
    			return $products;
    		}
    	}else{
    		$products=Yii::$app->db->createCommand("select product_name from products where user_id=$id $date")->queryAll();
    		if(empty($products))
    		{
    			return $products;
    		}
    	}	
    	foreach($products as $key => $v){
    		$product[] = $v['product_name'];
    	}
    	return $product;
    }
    
    public static function addNewProductSave($new_product, $assign_to)
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	$model = new Products();
    	$new_product_count = Products::find()
				    	->select('COUNT(*)')
				    	->where(['product_name' => $new_product, 'comp_id' => $company_id, 'user_id' => $assign_to])
				    	->count();
    	if ($new_product_count == 0) {
    		$model->product_name = $new_product;
    		$model->comp_id = $company_id;
    		$model->user_id = $assign_to;
    		$model->save(false);
    	}
    }
    /* web service - master products start */ 
    public static function masteProducts()
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	$user_id = Yii::$app->user->identity->id;
    	/*$master_data = Crops::find()->select("c.id,c.crop_name,c.comp_id,IF(fc.crop_id, '`1`' ,'`0`') as is_fav")
    	 ->from('crops c')
    	 ->leftJoin('fav_crops fc','fc.crop_id = c.id')
    	 ->where(['c.comp_ids' => $company_id])->andWhere(['!=','c.role_id',0])
    	 ->asArray()->all();*/
    	$sql = "SELECT p.id, p.product_name, p.comp_id, IF(fp.product_id, if(fp.is_channel_fav=1,0,1), 0) AS is_fav,IFNULL( fp.is_channel_fav, 0 ) as is_channel_fav  
    			FROM products p 
    			LEFT JOIN fav_products fp ON fp.product_id = p.id AND fp.user_id = $user_id
    			WHERE p.comp_id = $company_id
    			AND p.role_id != 0
    			AND p.is_deleted = 0
    			ORDER BY p.product_name";
    	$master_data = Yii::$app->db->createCommand($sql)->queryAll();
    	return $master_data;
    }
    /* web service - master products end*/
    
    //for products unique check
    public function uniqueProducts()
    {
    	$crop_name = trim(strip_tags($this->product_name));
    	$comp_id = Yii::$app->user->identity->input_company_id;
    	if (Yii::$app->controller->action->id == 'create') {
    		$condition = '';
    	} else {
    		$condition = "AND guid != '".$this->guid."'";
    	}
    	$query = "SELECT product_name FROM products
    	WHERE comp_id = '".$comp_id."'
        	AND is_deleted = 0
        	AND role_id != 0 $condition";
    	$res_arr = Yii::$app->db->createCommand($query)
    	->queryColumn();
    
    	if (in_array(strtolower($crop_name), array_map('strtolower', $res_arr))) {
    		$this->addError('product_name', 'Already Exist');
    		return false;
    	} else {
    		return true;
    	}
    }
    //for bulk upload uniqque products
    public function uniqueProductsUpload()
    {
    	$comp_id = Yii::$app->user->identity->input_company_id;
    	$query = "SELECT product_name FROM products
    			WHERE comp_id = '".$comp_id."'
    			AND is_deleted = 0";
    	$res_arr = Yii::$app->db->createCommand($query)
    	->queryColumn();
    	$res_arr = array_map('strtolower', $res_arr);
    	return $res_arr;
    }
    /* web service for products  start */ 
    public static function products($hit_timestamp)
    {
    	$company_id = Yii::$app->user->identity->input_company_id;
    	if (!$hit_timestamp) {
    		$result = Products::find()->select('id, product_name')->where(['comp_id' => $company_id])->orderBy('product_name asc')->all();
    		return $result;
    	} else {
    		return $result = Products::find()->select('id, product_name')->where(['>', 'created_date', $hit_timestamp])->andWhere(['comp_id' => $company_id])->orderBy('product_name asc')->all();
    	}
    }
    /* web service for products  end */
}
