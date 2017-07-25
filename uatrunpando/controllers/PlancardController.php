<?php

namespace app\controllers;

use Yii;
use app\models\PlanCards;
use app\models\PlanCardSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use app\models\Villages;
use app\models\Crops;
use app\models\Products;
use app\models\ChannelPartners;
use app\models\LabelNames;
use app\models\FormBuilder;
use yii\helpers\Url;
use app\models\Users;
use app\models\TravelLog;
use  yii\web\Session;
use yii\data\ArrayDataProvider;
use yii\data\Pagination;
/**
 * PlancardController implements the CRUD actions for PlanCards model.
 */
class PlancardController extends KgController
{
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    //'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all PlanCards models.
     * @return mixed
     */
    public function actionIndex()
    {
    	//test
        $searchModel = new PlanCardSearch();
        $model=new PlanCards();
        $label_names_display = LabelNames::labelNamesDisplay();
        $user_id = Yii::$app->user->identity->id;
        $rep = Users::getChildsRecoursive($user_id,true);
        $reportUsers = Users::dashboardUsers($rep);
        $reportUsers = array($user_id => 'All') + $reportUsers;
       // echo '<pre>';print_r(Yii::$app->request->post());exit;
        $dataProvider = $searchModel->search(Yii::$app->request->queryparams);
        $page = Yii::$app->request->get('page');
        $per_page = Yii::$app->request->get('per-page');
        if(!$page && !$per_page) {
        	$geturl = Url::remember(['plancard/index','page'=>Yii::$app->request->get('page'),'per-page'=>Yii::$app->request->get('per-page') ],'previous');
        }
        $geturl = Url::remember('',null);
        $menuscountusers = Users::getMenus(Yii::$app->user->identity->id);
        
    //    $dataProvider->pagination->pageSize=2;
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        	'model'		=>$model,
        	'data'      =>$reportUsers,
        	'menu'		=>$menuscountusers,
        	'label_names_display' => $label_names_display,
        ]);
    }

    /**
     * Displays a single PlanCards model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
    	$data=\app\models\PlanCards::Campcard($id);
    	$label_names_display = LabelNames::labelNamesDisplay();
    	
        return $this->render('view', [
            'model' => $this->findModel($id),'data'=>$data, 'label_names_display' => $label_names_display,
        ]);
    }

    /**
     * Creates a new PlanCards model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
    
        $model = new PlanCards();
        $model->scenario = 'create';
        $crops_list = Crops::cropList();
        $products_list = Products::planproductList();
        $label_names_display = LabelNames::labelNamesDisplay();
        
        if ($model->load(Yii::$app->request->post())) {
        	if ($_POST['save'] == 'saved') {
        	
        	} else {
        		$model->plan_approval_status = 'Approved';
        	}
        	$model->planned_date=date("Y-m-d", strtotime($_POST['PlanCards']['planned_date']));
        	$t=time();
			$time=date("Y-m-d H:i:s");
        	$planned_date=$model->planned_date;
        	$plan_type =Plancards::planType($planned_date,$time);
        	//echo $plan_type;exit;
        	$model->plan_type=$plan_type;
        	if ($model->activity == 'Channel Card') {
        		$model->crop_id = 0;
        		$model->product_id = 0;
        		$model->card_type="channel card";
//         		$new_village_save = Villages::addNewVillageSave($model->village_name, $model->assign_to);
//         		$new_channel_partner_save = ChannelPartners::addNewChannelPartnerSave($model->channel_partner, $model->assign_to);
        	} else {
        		$model->channel_partner = NULL;
        		//$new_village_save = Villages::addNewVillageSave($model->village_name, $model->assign_to);
        		//$new_crop_save = Crops::addNewCropSave($model->crop_name, $model->assign_to);
        		//$new_product_save = Products::addNewProductSave($model->product_name, $model->assign_to);
        	}
        	$last_insert_id = PlanCards::find()->select('id')->orderBy('id DESC')->one();
        	$model->mobile_timestamp = $last_insert_id['id'] + 1;
        	if($model->save(false)){
        	Yii::$app->session->setFlash('plan-create');
            return $this->redirect(['index']);
        	}
        } else {
            return $this->render('create', [
                'model' => $model,
            	'crops_list' => $crops_list,
            	'products_list' => $products_list,
            	'label_names_display' => $label_names_display,
            ]);
        	}
        
    }

    /**
     * Updates an existing PlanCards model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
       $model = $this->findModel($id);
       $updated = PlanCards::updateUser($id);
       $model->scenario = 'update';
       $crops_list = Crops::cropList();
       $products_list = Products::planproductList();
       $label_names_display = LabelNames::labelNamesDisplay();
		
    if ($model->load(Yii::$app->request->post())) {
    	//echo '<pre>';print_r(Yii::$app->request->post());exit;
  	  		if ($_POST['edit'] == 'approve') {
    			$model->plan_approval_status = 'Approved';
        		$model->status = 'not_submitted';
        		Yii::$app->session->setFlash('plan-approve');
        	} elseif ($_POST['edit'] == 'reject') {
        		$model->plan_approval_status = 'Rejected';
        		$model->status = 'rejected';
        		Yii::$app->session->setFlash('plan-reject');
        	} elseif ($_POST['edit'] == 'updated') {
        		$model->plan_approval_status = $model->plan_approval_status;
        		Yii::$app->session->setFlash('plan-update');
        	}
   				//$model->planned_date=date("Y-m-d", strtotime($_POST['PlanCards']['planned_date']));
	        	if(isset($_POST['PlanCards']['planned_date'])) {
	        		$model->planned_date=date("Y-m-d", strtotime($_POST['PlanCards']['planned_date']));
	        	}
   				$t=time();
   				$time=date("Y-m-d h:m:s",$t);
   		 		$planned_date=$model->planned_date;
   		 		$plan_type =Plancards::planType($planned_date,$time);
   				$model->plan_type=$plan_type;
   				if($model->activity == 'Channel Card') {	
   					$model->crop_id = 0;
   					$model->product_id = 0;
   					//$model->channel_partner = $_POST['PlanCards']['channel_partner'];
   					if(isset($_POST['PlanCards']['channel_partner'])) {
   						$model->channel_partner = $_POST['PlanCards']['channel_partner'];
   					}
   				} else {
   		 			$model->channel_partner = NULL;
   				}
    			$model->save(false);
          	return $this->redirect(Url::previous());
      } else {
       		return $this->render('update', [
                				'model' => $model,
       		    		   		'updated'=> $updated,
       		    		   		'crops_list' => $crops_list,
       		    		   		'products_list' => $products_list,
       							'label_names_display' => $label_names_display,
            					]);
       }
   	}

    /**
     * Deletes an existing PlanCards model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
       	$sql2 = Yii::$app->db->createCommand()
   				->update('plan_cards', ['is_deleted' => 1], ['id' => $id])
   				->execute();
       	Yii::$app->session->setFlash('plan-delete');
        return $this->redirect(Url::previous());
    }
    public function actionActivity($id)
    {
    	$label_names_display = LabelNames::labelNamesDisplay();
    	$activityName = PlanCards::find()->select('activity')->where(['guid' => $id])->column();
    	if ($id == '' || empty($activityName)) {
    		throw new NotFoundHttpException('The requested page does not exist.');
    	}
    	$activityLabels = FormBuilder::activityLabels($activityName[0]);
    	return $this->render('activity', ['response' => $this->activityData($id), 'label_names_display' => $label_names_display, 'actvityLabels' => $activityLabels]);
    		
    }
    /**
     * Finds the PlanCards model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return PlanCards the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
    	$model = PlanCards::find()->where(['guid' => $id])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    protected function findDetails($id)
    {
    	$query = new \yii\db\Query();
		$query->select('*')
				->from('plan_cards pc')
				->innerJoin('campaign_card_activities cc', 'pc.id = cc.plan_card_id')
				->where(['pc.id' => $id]);
		$query = $query->createCommand();
		return $queryresp = $query->queryOne();
    }
   protected function activityData($guid)
   {
   	
   	$model=new PlanCards();
   	$user_id=Yii::$app->user->identity->id;
   	$plancardProducts = array();
   //$da=$model::find()->select('id,activity')->where(['guid'=>$guid])->one();
   /* $sql = "select  p.id as plan_card_id_d,IF( p.created_by =$user_id,  'self',  'manager' ) AS plan_created_by,p.planned_date, mv.village_name, pr.product_name, cr.crop_name ,  
    			p.activity,  p.plan_type, p.card_type ,p.channel_partner,p.status ,p.updated_date,p.updated_date,
    			IF(c.contacted_person_name is null or c.contacted_person_name = '', '--', c.contacted_person_name) as contacted_person_name,
				IF(c.contacted_person_phone is null or c.contacted_person_phone = '', '--', c.contacted_person_phone) as contacted_person_phone,
				IF(c.no_of_farmers is null or c.no_of_farmers = '', '--', c.no_of_farmers) as no_of_farmers,
				IF(c.no_of_female_farmers is null or c.no_of_female_farmers = '', '--', c.no_of_female_farmers) as no_of_female_farmers,
				IF(c.no_of_villages is null or c.no_of_villages = '', '--', c.no_of_villages) as no_of_villages,
				IF(c.no_of_retailers is null or c.no_of_retailers = '', '--', c.no_of_retailers) as no_of_retailers,
				IF(c.no_of_dealers is null or c.no_of_dealers = '', '--', c.no_of_dealers) as no_of_dealers,
				IF(c.feedback is null or c.feedback = '', '--', c.feedback) as feedback,
				IF(c.purpose is null or c.purpose = '', '--', c.purpose) as purpose,
    			c.picture1,c.picture2,c.picture3,c.picture1_uri,c.picture2_uri,c.picture3_uri,
    			IF(ch.target_value is null or ch.target_value = '', '--', ch.target_value) as target_value,
				IF(ch.actual_value is null or ch.actual_value = '', '--', ch.actual_value) as actual_value,
				IF(ch.feedback is null or ch.feedback = '', '--', ch.feedback) as cfeedback,
    			u.first_name as created, uu.first_name as assignee ,IF(sa.sub_activity_name is null or sa.sub_activity_name = '', '--', sa.sub_activity_name) as sub_activity_name
    			from plan_cards p
    			inner join users uu on p.assign_to = uu.id
    			inner join users u on p.created_by = u.id
    			left join crops cr on cr.id = p.crop_id
    			left join products pr on pr.id = p.product_id
    			left join villages_master mv on mv.village_id = p.village_id			
    			inner join activity a on a.activity_name = p.activity
    			left join campaign_card_activities c
				on c.plan_card_id=p.id
				left join channel_card_activities ch
				on ch.plan_card_id = p.id
				left join sub_activity sa on sa.sub_activity_id = c.sub_activity_id and sa.activity_id = a.activity_id
				where p.guid = '".$guid."'"; */
   	$sql = "select  p.id as plan_card_id_d,IF( p.created_by =$user_id,  'self',  'manager' ) AS plan_created_by,p.planned_date, mv.village_name, pr.product_name, cr.crop_name ,
			   	p.activity,  p.plan_type, p.card_type ,p.channel_partner,p.status ,p.updated_date,p.updated_date,
			   	IF(c.contacted_person_name is null or c.contacted_person_name = '', '--', c.contacted_person_name) as contacted_person_name,
			   	IF(c.contacted_person_phone is null or c.contacted_person_phone = '', '--', c.contacted_person_phone) as contacted_person_phone,
			   	IF(c.no_of_farmers is null or c.no_of_farmers = '', '--', c.no_of_farmers) as no_of_farmers,
			   	IF(c.no_of_female_farmers is null or c.no_of_female_farmers = '', '--', c.no_of_female_farmers) as no_of_female_farmers,
			   	IF(c.no_of_villages is null or c.no_of_villages = '', '--', c.no_of_villages) as no_of_villages,
			   	IF(c.no_of_retailers is null or c.no_of_retailers = '', '--', c.no_of_retailers) as no_of_retailers,
			   	IF(c.no_of_dealers is null or c.no_of_dealers = '', '--', c.no_of_dealers) as no_of_dealers,
			   	IF(c.feedback is null or c.feedback = '', '--', c.feedback) as feedback,
			   	IF(c.purpose is null or c.purpose = '', '--', c.purpose) as purpose,
			   	c.picture1,c.picture2,c.picture3,c.picture1_uri,c.picture2_uri,c.picture3_uri,
			   	IF(ch.feedback is null or ch.feedback = '', '--', ch.feedback) as cfeedback,ch.target_value,
    			ch.actual_value,u.first_name as created, uu.first_name as assignee ,IF(sa.sub_activity_name is null or sa.sub_activity_name = '', '--', sa.sub_activity_name) as sub_activity_name
			   	,GROUP_CONCAT(CONCAT(ci.image_path,ci.image_name)) as imagepath from plan_cards p
			   	inner join users uu on p.assign_to = uu.id
			   	inner join users u on p.created_by = u.id
			   	left join crops cr on cr.id = p.crop_id
			   	left join products pr on pr.id = p.product_id
			   	left join villages_master mv on mv.village_id = p.village_id
			   	inner join activity a on a.activity_name = p.activity
			   	left join campaign_card_activities c
			   	on c.plan_card_id=p.id
			   	left join channel_card_activities ch
			   	on ch.plan_card_id = p.id
			   	left join channel_card_images ci on ci.plan_card_id = p.id
			   	left join sub_activity sa on sa.sub_activity_id = c.sub_activity_id and sa.activity_id = a.activity_id
			   	where p.guid = '".$guid."'";
 
   $q = Yii::$app->db->createCommand($sql)->queryAll();
   /* $sql2 = "select ct.plan_card_id,cth.product_id,cth.product_unit,cth.liquidation_status,cth.demand_volume,
    			p.product_name,cth.season_progress from channel_card_activities ct
				JOIN channel_card_tracking_info cth ON cth.plan_card_id = ct.plan_card_id
				JOIN products p ON  p.id = cth.product_id
   				ORDER BY p.product_name"; */
   $sql2 =    "select ct.plan_card_id,cth.product_id,cth.product_unit,IF(cth.liquidation_status is null or cth.liquidation_status = '', '--',cth.liquidation_status) as liquidation_status,IF(cth.demand_volume is null or cth.demand_volume = '', '--',cth.demand_volume) as demand_volume ,
				IF(cth.season_progress is null or cth.season_progress = '', '--',cth.season_progress) as season_progress,IF(cth.collection_value_four is null or cth.collection_value_four = '', '--',cth.collection_value_four) as collection_value_four,
				p.product_name,IF(cth.collection_value_five is null or cth.collection_value_five = '', '--',cth.collection_value_five) as collection_value_five from channel_card_activities ct
				JOIN channel_card_tracking_info cth ON cth.plan_card_id = ct.plan_card_id
				JOIN products p ON  p.id = cth.product_id";

   $query = Yii::$app->db->createCommand($sql2)->queryAll();
   if (!empty($query)) {
	   foreach ($query as $key=>$value){
	   	$plancardProducts[$value['plan_card_id']][] = array('product_id'=>$value['product_id'], 'product_name'=>$value['product_name'],
	   			'product_unit'=>$value['product_unit'],
	   			'liquidation_status'=>$value['liquidation_status'],
	   			'demand_volume'=>$value['demand_volume'],
	   			'season_progress'=>$value['season_progress'],
	   			'collection_value_four' => $value['collection_value_four'],
	   			'collection_value_five' => $value['collection_value_five']
	   	);
	   }
   }
  /*  if (!empty($q)) {
	   foreach($q as $key=>$data){
	   	$id = $data['plan_card_id_d'];
		   	if(array_key_exists ($id,$plancardProducts) ){
		   		$q[$key]['Products'] = $plancardProducts[$id];
		   	}
   		}
   } */
//    echo '<pre>';print_r($q);exit;
     if (!empty($q)) {
     	$productIds  = array();
		if (!empty($query)) {
			foreach ($query as $key=>$value){
				$productIds[] = $value['product_id']; // get all products ids
			}
			$product_Ids = implode(',', $productIds);
				
		/* 	$partnerLabelQuery = "select temp.form_builder_id, temp.form_builder_activity_id, temp.product_id,group_concat(replace(temp.label, ' ','_') separator '~') as label, unit from (SELECT fb.form_builder_id, fb.form_builder_activity_id,  pi.product_id,fb.label, GROUP_CONCAT( pi.product_unit ) as unit
					FROM form_builder fb
					JOIN product_info pi ON pi.form_builder_activity_id = fb.form_builder_activity_id
					WHERE fb.step =1 and pi.product_id in(".$product_Ids.")
							GROUP BY fb.form_builder_id) as temp
							group by temp.form_builder_activity_id, temp.product_id"; */
			$partnerLabelQuery = "SELECT fb.form_builder_id, fb.form_builder_activity_id, fb.product_id, group_concat( replace( fb.label, ' ', '_' ) order by fb.form_builder_id
					SEPARATOR '~' ) AS label
					FROM form_builder fb
					WHERE fb.step =1
					AND fb.product_id IN (".$product_Ids.")
					GROUP BY fb.form_builder_activity_id, fb.product_id";
			$partnerLabelQueryResult = Yii::$app->db->createCommand($partnerLabelQuery)->queryAll();
				
			$productLabelArray = array();
			if(!empty($partnerLabelQueryResult)) {
				//$i = 0;
				foreach($partnerLabelQueryResult as $productResult) {
					$labelProducts[] = $productResult['product_id'];
					$productLabelArray[$productResult['label']][] = $productResult['product_id'];
				}
				$uniqProductIds = array_unique($productIds);
				$uniqProductIds = array_values($uniqProductIds);
				$result_array_diff = array_diff($uniqProductIds,$labelProducts);
				$productLabelArray['liquidation_status~demand_volume~season_progress'] = $result_array_diff;
			}
				
			foreach ($query as $value) {
				$channelLabels = array('product_id' => $value['product_id'],'product_name'=>$value['product_name'],
						'product_unit'=>$value['product_unit'],
						'liquidation_status'=>$value['liquidation_status'],
						'demand_volume'=>$value['demand_volume'],
						'season_progress'=>$value['season_progress'],
						'collection_value_four' => $value['collection_value_four'],
						'collection_value_five' => $value['collection_value_five']);
					
				$plancardProducts[$value['plan_card_id']][] = $channelLabels;
			}
		}
// 		echo '<pre>';print_r($plancardProducts);exit('111111');
		
		if (!empty($q)) {
			$product_label = array();
			foreach($q as $key=>$data){
				$id = $data['plan_card_id_d'];
				if(array_key_exists ($id,$plancardProducts) ){
					$productMap = array();
					foreach($plancardProducts[$id] as $productDetails) {
						foreach($productLabelArray as $key1 => $productfinal) {
							if(in_array($productDetails['product_id'],$productfinal)){								
								$productMap[$key1][] = $productDetails;
							}
						}

					}
					$q[$key]['Products'] = $productMap;
				}
			}
		}
		
		if(!empty($q)) {
		foreach( $q as $key => $infoArr){
			$pArr = array();
			$pArr1 = array();
			if($infoArr['activity'] == 'Channel Card'){
				if (array_key_exists('Products', $infoArr)) {
					foreach($infoArr['Products'] as $k => $pDetail){
						$labelarray = explode('~',str_replace("_"," ",$k));
						$pArr['liquidation_status'] = (isset($labelarray[0])  && $labelarray[0] != '') ? $labelarray[0] : '';
						$pArr['demand_volume'] = (isset($labelarray[1])  && $labelarray[1] != '') ? $labelarray[1] : '';
						$pArr['season_progress'] = (isset($labelarray[2])  && $labelarray[2] != '') ? $labelarray[2] : '';
						$pArr['collection_value_four'] = (isset($labelarray[3])  && $labelarray[3] != '') ? $labelarray[3] : '';
						$pArr['collection_value_five'] = (isset($labelarray[4])  && $labelarray[4] != '') ? $labelarray[4] : '';
						$pArr['product_details'] = $pDetail;
						$pArr1[] = $pArr;
					}
				} else {
					$infoArr['Products'] = array();
				}
				$infoArr['Products'] = $pArr1;
				$q[$key]['Products'] = $infoArr['Products'];
			}
		}
		}
		if(!empty($q)) {
			foreach( $q as $key => $planDetails){
				$pArr2 = array();
				if($planDetails['activity'] == 'Channel Card'){
					if (array_key_exists('Products', $planDetails)) {
						foreach($planDetails['Products'] as $productDe) {
							foreach($productDe['product_details'] as $productLa) {
								//echo '<pre>';print_r($productLa);exit;
								$productLa['liquidation_status_label'] = $productDe['liquidation_status'];
								$productLa['demand_volume_label'] = $productDe['demand_volume'];
								$productLa['season_progress_label'] = $productDe['season_progress'];
								$productLa['collection_value_four_label'] = $productDe['collection_value_four'];
								$productLa['collection_value_five_label'] = $productDe['collection_value_five'];
								$pArr2[] = $productLa;
												
							} 
						}
					} else {
						$planDetails['Products'] = array();
					}
					$planDetails['Productsk'] = $pArr2;
					$q[$key]['Products'] = array_unique($planDetails['Productsk'],SORT_REGULAR);
				}
			}
		}
		//echo '<pre>';print_r($q);exit;
		$images = $channelImages = array();
		if(!empty($q)) {
			foreach($q as $Card) {
				$images = array();
				if($Card['card_type'] != 'channel card') {
					if($Card['picture1'] != '') {
						$images[] = $Card['picture1_uri']. $Card['picture1'];
					}
					if($Card['picture2'] != '') {
						$images[] = $Card['picture2_uri']. $Card['picture2'];
					}
					if($Card['picture3'] != '') {
						$images[] = $Card['picture3_uri']. $Card['picture3'];
					}
					unset($Card['picture1_uri'],$Card['picture1'],$Card['picture2_uri'],$Card['picture2'],$Card['picture3'],$Card['picture3_uri'],$Card['imagepath']);
					$Card['images'] = $images;
					$finalData[] = $Card;
				} else {
					if($Card['imagepath'] != '' ) {
						$channelImages = explode(",",$Card['imagepath']);
					}
					unset($Card['picture1_uri'],$Card['picture1'],$Card['picture2_uri'],$Card['picture2'],$Card['picture3'],$Card['picture3_uri'],$Card['imagepath']);
					$Card['images'] = $channelImages;
					$finalData[] = $Card;
				}
			}
		}
		return $finalData;
   } else {
   	throw new NotFoundHttpException('The requested page does not exist.');
   }
 
//    	if($da->activity!='Channel Card')
//    	{
//    		$query = new \yii\db\Query;
//    		$query->select('p.id,p.planned_date,p.village_name,p.crop_name,p.product_name,p.assign_to,p.activity,p.created_by,p.plan_type,p.card_type,p.status,c.*,u.first_name as created, uu.first_name as assignee')
//    		->from('plan_cards p')
//    		->innerJoin('users uu','p.assign_to = uu.id')
//    		->innerJoin('users u','p.created_by = u.id')
//    		->leftJoin('campaign_card_activities c', 'p.id =c.plan_card_id')
//    		->where(['p.guid'=>$guid]);
//    		$command = $query->createCommand();
//    		return $response = $command->queryAll();
   		
//    	}else{
//    			$query = new \yii\db\Query;
//    		$query->select('p.id,p.planned_date,p.village_name,p.crop_name,p.product_name,p.assign_to,p.activity,p.created_by,p.plan_type,p.card_type,p.status,c.*,u.first_name as created, uu.first_name as assignee')
//    		->from('plan_cards p')
//    		->innerJoin('users uu','p.assign_to = uu.id')
//    		->innerJoin('users u','p.created_by = u.id')
//    		->leftJoin('campaign_card_activities c', 'p.id =c.plan_card_id')
//    		->where(['p.guid'=>$guid]);
//    		$command = $query->createCommand();
//    		return $response = $command->queryAll();
//    	}
   	
   }
   public function actionActivitaion($status,$id)
   {
   	if($status == 'rejected'){
   		$apr_status = 'Rejected';
   		$status='rejected';
   	}
   	else{
   		$apr_status='Approved';
   		$status='not_submitted';
   	}
   	$sql2 = Yii::$app->db->createCommand()
   	->update('plan_cards', ['status' => $status,'plan_approval_status' => $apr_status], ['id' => $id])
   	->execute();
   	Yii::$app->session->setFlash('Card has been'.$status);
   return $this->redirect(['update', 'id' =>$id]);
   	
   }
   public  function actionPlantype()
   {
   
   	$planned_date = date("Y-m-d", strtotime($_GET['planned_date']));
   	$time= date('Y-m-d H:i:s');
	$resp = Plancards::planType($planned_date,$time);
	return "<option value='".$resp."' selected>".ucfirst($resp)."</option>"; 
	
   }
   
   //plan history 
   public function actionHistory() 
   {
	$searchModel = new PlanCardSearch();
   	$model=new PlanCards();
   	$label_names_display = LabelNames::labelNamesDisplay();
   	$user_id = Yii::$app->user->identity->id;
   	// 		$reportees_list[$user_id] = 'All';
   	$rep = Users::getChildsRecoursive($user_id,true);
   	$reportUsers = Users::dashboardUsers($rep);
   	$fieldForce = Users::getRecoursive($user_id,true);
   	$villageList = Villages::allVillages($fieldForce);
   	$reportUsers = array($user_id => 'All') + $reportUsers;
   	$dataProvider = $searchModel->search(Yii::$app->request->queryParams);
   	return $this->render('history', [
   			'searchModel' => $searchModel,
   			'dataProvider' => $dataProvider,
   			'model'		=>$model,
   			'data'      =>$reportUsers,
   			'villageList' => $villageList,
   			'label_names_display' => $label_names_display,
   	]);
   }
   
   public function actionDropdownlist() 
   {
   	if(isset($_REQUEST)) {
   		$flag = 'create';
   		$assign_to = $_REQUEST['assign_to'];
   		if ($assign_to != '') {
	   		$villages_list = Villages::villageList($assign_to, $flag);
	   		//$products_list = Products::productList($assign_to, $flag);
	   		//$crops_list = Crops::cropList($assign_to, $flag);
	   		$partners = ChannelPartners::partnersList($assign_to, $flag);
	   		$response = array($villages_list,$partners);
   		} else {
   			$response = 0;
   		}
   		return json_encode($response);
   	}
   }
   
   public function actionDownload()
   {
   
   	if(isset($_REQUEST)) {
   		$TotalData = $json_data = array();
   		$data = $_REQUEST;
   		$session = Yii::$app->session;
   		if(isset($_REQUEST['from_date'])) {
   			$session->set('export', $data);
   		}
   		if(Yii::$app->request->get('page')) {
   			if(Yii::$app->session->has('export')) {
   				$page = Yii::$app->request->get('page');
   				$data = Yii::$app->session->get('export');
   			}
   		}
   		/*  if ($session->has('export')) {
   		 $data = Yii::$app->session->get('export');
   		 } if($session->has('export') && Yii::$app->request->get('from_date')) {
   		 $session->set('export', $data);
   		 } */
   		// echo '<pre>';print_r($data);exit;
   		$exportUrl = Url::to(['plancard/export']);
   		$exportUrl2 = Url::to(['plancard/summaryexport']);
   		$TotalData = $this->summaryData($data,'ajax');
   		$pagerparams1['type'] = 'summary1';
   		$pagerparams2['type'] = 'summary2';
   		$provider1 = new ArrayDataProvider([
   				'allModels' => $TotalData['summary1'],
   				'pagination' => [
   						'pageSize' => 10,
   						'params'  => ['type' => 'summary1', 'page' => Yii::$app->request->get('page')],
   				],
   		]);
   		$provider2 = new ArrayDataProvider([
   				'allModels' => $TotalData['summary2'],
   				'pagination' => [
   						'pageSize' => 10,
   						'params'  => ['type' => 'summary2', 'page' => Yii::$app->request->get('page')],
   				],
   		]);
   		$data1 = $this->renderAjax('_summary', [
   				'userRoleDataProvider' => $provider1,
   				'pjax_id' => rand(1,100000)
   		]);
   		$data2 = $this->renderAjax('_summary2', [
   				'userRoleDataProvider' => $provider2,
   				'pjax_id' => rand(1,100000)
   		]);
   		//return $data1;
   		if(Yii::$app->request->get('page')) {
   			if(Yii::$app->request->get('type') == 'summary1') {
   				return $data1;
   			}
   			if(Yii::$app->request->get('type') == 'summary2') {
   				return $data2;
   			}
   		} else {
   			\Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
   			return array($data1,$data2,count($TotalData['summary1']));
   		}
   		/*
   
   		$table = '<div class="pull-right">
   		<a href="'.$exportUrl.'" type="button" class="btn btn-primary mb20 build_btn"><i class="fa fa-plus"></i> Export</a>
   		</div>
   		<div class ="table-responsive">
   		<table class="table table-striped table-bordered">
   		<thead>
   		<tr>
   		<th>App User</th>
   		<th>Reports to</th>
   		<th>Active days</th>
   		<th>Inactive days</th>
   		<th>Distance travalled</th>
   		<th>Average Distance</th>
   		<th>Head Quarters</th>
   		</tr></thead><tbody>';
   		if(!empty($TotalData)) {
   		foreach($TotalData['summary1'] as $tableData) {
   		$table .='<tr><td>'.$tableData['field_force'].'</td>
   		<td>'.$tableData['reports_to'].'</td>
   		<td>'.$tableData['active_days'].'</td>
   		<td>'.$tableData['inactive_days'].'</td>
   		<td>'.$tableData['distance'].'</td>
   		<td>'.$tableData['average_distance'].'</td>
   		<td>'.$tableData['head_quarter'].'</td>	</tr>';
   		}
   
   		}  else {
   		$table .= '<tr><td colspan="7">No results found</td></tr>';
   		}
   		$table .='</tbody></table>';
   		$table2 = '
   		<div class ="table-responsive">
   		<table class="table table-striped table-bordered">
   		<thead>
   		<tr>
   		<th>App User</th>
   		<th>Reports to</th>
   		<th>Build Plans</th>
   		<th>Assigned Plans</th>
   		<th>Submitted Plans</th>
   		<th>villages</th>
   		<th>Unique Villages</th>
   		<th>Partners</th>
   		<th>Unique Partners</th>
   		</tr></thead><tbody>';
   		if(!empty($TotalData)) {
   		foreach($TotalData['summary2'] as $tableData2) {
   		$table2 .='<tr><td>'.$tableData2['field_force'].'</td>
   		<td>'.$tableData2['reports_to'].'</td>
   		<td>'.$tableData2['plan_build'].'</td>
   		<td>'.$tableData2['plan_assign'].'</td>
   		<td>'.$tableData2['plan_submitted'].'</td>
   		<td>'.$tableData2['villages'].'</td>
   		<td>'.$tableData2['villages_unique'].'</td>
   		<td>'.$tableData2['partners'].'</td>
   		<td>'.$tableData2['villages_unique'].'</td>';
   		}
   
   		}  else {
   		$table2 .= '<tr><td colspan="11">No results found</td></tr>';
   		}
   		$table .='</tbody></table>';
   		$json_data[0] =  $table;
   		$json_data[1] =  $table2;
   		return json_encode($json_data); */
   
   	}
   }
   function summaryData($data, $flag)
   {
   	$lastData = $exportArray = $export_data = $finalData = $exportInfo = $exportData = $exportVill = $finalArrayData = $finalArray = array();
   	$from = strtotime($data['from_date']);
   	$to = strtotime($data['to_date']);
   	$from_date = date('Y-m-d',$from);
   	$to_date = date('Y-m-d',$to);
   	$date1=date_create($from_date);
   	$date2=date_create($to_date);
   	$diff = date_diff($date1,$date2);
   	$no_of_days = $diff->format("%a");
   	$no_of_days = $no_of_days+1;
   	// 	   	echo '<pre>';print_r($data);exit;
   	$rep = Users::getRecoursive($data['assign_to'],true);
   	$query = TravelLog::find()->select(['p.updated_date, p.assign_to, SUM(p.distance_travelled) as distance_travelled, GROUP_CONCAT(p.location_name) AS location_name,  u.first_name,sum(TIMESTAMPDIFF(SECOND,p.updated_date,p.start_time)) as time'])
   	->from('plan_cards p')
   	->innerJoin('users u', 'u.id = p.assign_to')
   	->where(['p.status' => 'submitted','p.assign_to' => $rep])
   	->andWhere(['between','DATE(p.updated_date)',$from_date,$to_date])
   	->groupBy(['DATE(p.updated_date)', 'p.assign_to']);
   
   	$query2 = TravelLog::find()->select(["ut.date_time AS updated_date, ut.user_id AS assign_to, SUM(ut.distance_travelled) as distance_travelled, ut.location_name AS location_name,  u.first_name,sum(TIMESTAMPDIFF(SECOND,ut.date_time,ut.start_time)) as time"])
   	->from('user_travellog ut')
   	->innerJoin('users u', 'u.id = ut.user_id')
   	->where(['ut.user_id' => $rep])
   	->andWhere(['between','DATE(ut.date_time)',$from_date,$to_date])
   	->groupBy(['DATE(ut.date_time), ut.user_id']);
   	//	var_dump($query->prepare(Yii::$app->db->queryBuilder)->createCommand()->rawSql);exit;
   
   	$union = (new \yii\db\Query())
   	->select('updated_date, assign_to, SUM(distance_travelled) as distance_travelled ,location_name,first_name,sum(time) as time')
   	->from(['dummy_name' => $query->union($query2)])
   	->groupBy(['date(updated_date)', 'assign_to'])
   	->orderBy(['first_name' => SORT_ASC])->all();
   	if(!empty($union)) {
   		$dis = 0;
   		foreach($union as $result) {
   			$exportData[$result['assign_to']][] = $result;
   			$dis = $result['distance_travelled'];
   		}
   	}
   	 
   	//echo '<pre>';print_r($exportData);exit;
   	if(is_array($rep)) {
   		$fieldForce = implode(',',$rep);
   	} else {
   		$fieldForce = $rep;
   	}
   	if ($fieldForce == null) {
   		$fieldForce = -1;
   	}
   	/* $plansQuery = 'SELECT IF(u.head_quarters is null or u.head_quarters = "", "N/A", u.head_quarters) as head_quarters, p.assign_to,u.first_name as App_User,uu.first_name as RM,0 as total_villages,0 as uniqueV,0 as total_partners, 0 as uniqueP,
   	 sum(if((p.status = "submitted"),1,0)) as plan_submitted,
   	 sum(if((p.status != "submitted" and p.plan_approval_status != "Rejected" and p.created_by = assign_to),1,0)) as plan_build,
   	 sum(if((p.status != "submitted" and p.plan_approval_status != "Rejected" and p.created_by != assign_to),1,0)) as plan_assigned
   	 FROM plan_cards p
   	 left join users u on u.id = p.assign_to
   	 left join users uu on u.reporting_user_id = uu.id
   	 where p.is_deleted = 0 and p.updated_date >= "'.$from_date.'" and p.updated_date <= "'.$to_date.'" and assign_to in ('.$fieldForce.')  group by p.assign_to'; */
   	/* $plansQuery = 'SELECT IF(u.head_quarters is null or u.head_quarters = "", "N/A", u.head_quarters) as head_quarters, p.assign_to,u.first_name as App_User,uu.first_name as RM,0 as total_villages,0 as uniqueV,0 as total_partners, 0 as uniqueP,
   	 sum(if((p.status = "submitted"),1,0)) as plan_submitted,
   	 sum(if((p.status != "submitted" and p.plan_approval_status != "Rejected" and p.created_by = assign_to),1,0)) as plan_build,
   	 sum(if((p.status != "submitted" and p.plan_approval_status != "Rejected" and p.created_by != assign_to),1,0)) as plan_assigned
   	 FROM plan_cards p
   	 left join users u on u.id = p.assign_to
   	 left join users uu on u.reporting_user_id = uu.id
   	 where p.is_deleted = 0 and p.assign_to in ('.$fieldForce.') and DATE(p.updated_date) between "'.$from_date.'" and "'.$to_date.'" group by p.assign_to'; */
   	$plansQuery = 'SELECT IF(u.head_quarters is null or u.head_quarters = "", "N/A", u.head_quarters) as head_quarters, p.assign_to,u.first_name as App_User,uu.first_name as RM,0 as total_villages,0 as uniqueV,0 as total_partners, 0 as uniqueP,
	   			sum(if((p.status = "submitted"),1,0)) as plan_submitted,
	   			sum(if((p.created_by = assign_to),1,0)) as plan_build,
	   			sum(if((p.created_by != assign_to),1,0)) as plan_assigned,
	   			sum(if((p.status = "not_submitted"),1,0)) as plan_pending,
	   			sum(if((p.status = "rejected"),1,0)) as plan_rejected
	   			FROM plan_cards p
	   			left join users u on u.id = p.assign_to
	   			left join users uu on u.reporting_user_id = uu.id
	   			where p.is_deleted = 0 and p.assign_to in ('.$fieldForce.') and DATE(p.updated_date) between "'.$from_date.'" and "'.$to_date.'" group by p.assign_to';
   	$plansQueryResult = Yii::$app->db->createCommand($plansQuery)->queryAll();
   	$villpar = 'SELECT  IF(u.head_quarters is null or u.head_quarters = "", "N/A", u.head_quarters) as head_quarters ,uu.first_name as RM, p.assign_to, COUNT( p.village_id ) total_villages, COUNT( DISTINCT p.village_id ) AS uniqueV,count( p.channel_partner) AS total_partners, COUNT( DISTINCT p.channel_partner ) AS uniqueP
	   			FROM plan_cards p
	   			left join users u on u.id = p.assign_to
	   			left join users uu on u.reporting_user_id = uu.id
	   			WHERE p.status =  "submitted" and p.assign_to in ('.$fieldForce.') and p.is_deleted = 0 and DATE(p.updated_date) between "'.$from_date.'" and "'.$to_date.'"  group by p.assign_to';
   	$villparResult = Yii::$app->db->createCommand($villpar)->queryAll();
   	/* echo '<pre>';print_r($plansQueryResult);
   	 echo '<pre>';print_r($villparResult);exit; */
   	if(!empty($villparResult)) {
   		foreach($villparResult as $villparData) {
   			$exportVill[$villparData['assign_to']] = $villparData;
   		}
   	}
   
   	$sum = $hour = 0;
   	if(!empty($plansQueryResult)) {
   		foreach($plansQueryResult as $planData) {
   			$exportInfo[$planData['assign_to']] = $planData;
   		}
   	}
   	/*  		        echo '<pre>';print_r($exportInfo);
   	 echo '<pre>';print_r($exportVill);exit; */
   	if(!empty($exportInfo)) {
   		foreach($exportInfo as $key => $expinfo) {
   			if(array_key_exists($key,$exportVill)) {
   				$finalArray[$key] = $exportVill[$key] + $expinfo;
   			} else {
   				//echo $key;exit;
   				$finalArray[$key] = $exportInfo[$key];
   			}
   		}
   	}
   	// echo '<pre>';print_r($finalArray);exit;
   	if(!empty($exportData)) {
   		foreach($exportData as $key => $exp) {
   			$sum = 0;
   			$hour = 0;
   			foreach ($exp as $dis) {
   				$sum +=  $dis['distance_travelled'];
   				$hour += $dis['time'];
   			}
   			$finalData[$key]['distance'] = $sum;
   			$finalData[$key]['active_days'] = count($exportData[$key]);
   			$finalData[$key]['inactive_days'] = (string)abs($no_of_days - $finalData[$key]['active_days']);
   			$finalData[$key]['hour'] = abs($hour);
   			//gettype($finalData[$key]['inactive_days']);
   		}
   	}
   
   	if(!empty($finalArray)) {
   		foreach($finalArray as $key => $finalinfo) {
   			if(array_key_exists($key,$finalData)) {
   				$finalArrayData[$key] = $finalData[$key] + $finalinfo;
   			} else {
   				$planartArray['distance'] = 0;
   				$planartArray['active_days'] = 0;
   				$planartArray['hour'] = 0;
   				$planartArray['inactive_days'] = (string)$no_of_days;
   				$finalArrayData[$key] = $finalinfo + $planartArray;
   
   			}
   		}
   	}
   	//	echo '<pre>';print_r($finalArray);exit;
   	$usersInfoArray = $usersInfoArray1 = $fieldForce3 = array();
   	if(empty($finalArray) && count($finalData) > 0) {
   		$userKeys = array_keys($finalData);
   		$fieldForce2 = implode(',',$userKeys);
   		$usersInfo = 'select  IF(u.head_quarters is null or u.head_quarters = "", "N/A", u.head_quarters) as head_quarters , u.id,u.first_name as App_User,uu.first_name as RM
	   		,0 as plan_build,0 as plan_assigned, 0 as plan_submitted, 0 as plan_rejected, 0 as plan_pending, 0 as total_villages, 0 as uniqueV ,0 as total_partners, 0 as uniqueP from users u
	   		left join users uu on u.reporting_user_id = uu.id
	   		where u.id in ('.$fieldForce2.') group by u.id ';
   		$usersInfoResult = Yii::$app->db->createCommand($usersInfo)->queryAll();
   		if(!empty($usersInfoResult)) {
   			foreach($usersInfoResult as $userR) {
   				$usersInfoArray[$userR['id']] = $userR;
   			}
   		}
   		foreach($finalData as $key => $travelInfo) {
   	   
   			$finalArrayData[$key] = $finalData[$key] + $usersInfoArray[$key];
   		}
   	}
   	if(count($finalData) > 0 && !empty($finalArray)) {
   		$userKeys1 = array_keys($finalData);
   		foreach($userKeys1 as $key8 => $keyData) {
   			if(!array_key_exists($keyData,$finalArray)) {
   				$fieldForce3[] = $keyData;
   			}
   		}
   		if(!empty($fieldForce3)) {
   			$fieldForce5 = implode(',',$fieldForce3);
   			$usersInfo1 = 'select  IF(u.head_quarters is null or u.head_quarters = "", "N/A", u.head_quarters) as head_quarters , u.id,u.first_name as App_User,uu.first_name as RM
	   		,0 as plan_build,0 as plan_assigned, 0 as plan_submitted,0 as plan_rejected, 0 as plan_pending, 0 as total_villages, 0 as uniqueV ,0 as total_partners, 0 as uniqueP from users u
	   		left join users uu on u.reporting_user_id = uu.id
	   		where u.id in ('.$fieldForce5.') group by u.id ';
   			$usersInfoResult1 = Yii::$app->db->createCommand($usersInfo1)->queryAll();
   
   			if(!empty($usersInfoResult1)) {
   				foreach($usersInfoResult1 as $userR1) {
   					$usersInfoArray1[$userR1['id']] = $userR1;
   				}
   			}
   			foreach($usersInfoArray1 as $key5 => $manageraArray) {
   				$finalArrayData[$key5] =  $manageraArray + $finalData[$key5];
   				/* echo $manageraArray;exit;
   				 if(!array_key_exists($key5,$finalData)) {
   
   				} */
   			}
   		}
   	}
   	 
   	$fname = array();
   	if(!empty($finalArrayData)) {
   		foreach ($finalArrayData as $key10 => $row5) {
   			$fname[$key10] = $row5['App_User'];
   		}
   		array_multisort($fname, SORT_ASC, $finalArrayData);
   	}
   	/* 	if(!empty($finalData)) {
   	 foreach($finalData as $key2 => $travelInfo) {
   	 if(!array_key_exists($key2,$finalArray)) {
   	 $finalArrayData[$key] = $finalData[$key] + $planartArray;
   	 }
   	 }
   	 } */
   	if(!empty($finalArrayData)){
   		foreach($finalArrayData as $last) {
   			$avg_dist = ($last['distance'] == 0 || $last['active_days'] == 0) ? 0 : $last['distance']/$last['active_days'];
   			$avg_hour = ($last['hour'] == 0 || $last['hour'] == 0) ? 0 : $last['hour']/$last['active_days'];
   			$hoursTime = Travellog::travellogtime(abs($last['hour']));
   			$AvghoursTime = Travellog::travellogtime(abs($avg_hour));
   			$lastArray1['field_force'] = $last['App_User'];
   			$lastArray1['reports_to'] = $last['RM'];
   			$lastArray1['active_days'] = $last['active_days'];
   			$lastArray1['inactive_days'] = $last['inactive_days'];
   			$lastArray1['distance'] = $last['distance'];
   			$lastArray1['average_distance'] =  $avg_dist;
   			$lastArray1['villages'] = $last['total_villages'];
   			$lastArray1['villages_unique'] = $last['uniqueV'];
   			$lastArray1['partners'] = $last['total_partners'];
   			$lastArray1['partners_unique'] = $last['uniqueP'];
   			$lastArray1['head_quarter'] = $last['head_quarters'];
   			$lastArray1['hour'] = $hoursTime;
   			$lastArray1['avg_hour'] = $AvghoursTime;
   	   
   	   
   			$lastArray2['field_force'] = $last['App_User'];
   			$lastArray2['reports_to'] = $last['RM'];
   			$lastArray2['plan_build'] = $last['plan_build'];
   			$lastArray2['plan_assign'] = $last['plan_assigned'];
   			$lastArray2['plan_rejected'] = $last['plan_rejected'];
   			$lastArray2['plan_pending'] = $last['plan_pending'];
   			$lastArray2['plan_submitted'] = $last['plan_submitted'];
   			$lastArray2['head_quarter'] = $last['head_quarters'];
   			$export['field_force'] = $last['App_User'];
   			$export['reports_to'] = $last['RM'];
   			$export['head_quarter'] = (string)$last['head_quarters'];
   			$export['plan_build'] = (string)$last['plan_build'];
   			$export['plan_assign'] = (string)$last['plan_assigned'];
   			$export['plan_rejected'] = $last['plan_rejected'];
   			$export['plan_pending'] = $last['plan_pending'];
   			$export['plan_submitted'] = (string)$last['plan_submitted'];
   			$export['active_days'] = (string)$last['active_days'];
   			$export['inactive_days'] = (string)$last['inactive_days'];
   			$export['hour'] = (string)$hoursTime;
   			$export['avg_hour'] = (string)$AvghoursTime;
   			$export['distance'] = (string)round($last['distance'],2);
   			$export['average_distance'] =  (string)round($avg_dist,2);
   			$export['villages'] = (string)$last['total_villages'];
   			$export['villages_unique'] = (string)$last['uniqueV'];
   			$export['partners'] = (string)$last['total_partners'];
   			$export['partners_unique'] = (string)$last['uniqueP'];
   	   
   	   
   			$lastData['summary1'][] = $lastArray1;
   			$lastData['summary2'][] = $lastArray2;
   			$exportArray[] = $export;
   		}
   	} else {
   		$lastData['summary1'] = array();
   		$lastData['summary2'] = array();
   	}
   		
   	if($flag == 'ajax') {
   		return $lastData;
   	} else if($flag == 'export') {
   		return $exportArray;
   	}
   	$rep = array();
   		
   }
   public function actionExport()
   {
   	$summaryparam = array();
   	$summaryparam = Yii::$app->session->get('export');
   	if(!empty($summaryparam)){
   		$finalInfo  = $this->summaryData($summaryparam,'export');
   	};
   	$objPHPExcel = \PHPExcel_IOFactory::createReader('Excel5');
   	$objPHPExcel = $objPHPExcel->load('../crops_template.xls');
   	$objPHPExcel->getActiveSheet()->fromArray($finalInfo, null, 'A2');
   	$objPHPExcel->getActiveSheet()->setTitle('Activity Summary');
   	$objPHPExcel->getActiveSheet()
   	->setCellValue('A1', 'App User')
   	->setCellValue('B1', 'Reports to')
   	->setCellValue('C1', 'Head Quarters')
   	->setCellValue('D1', 'Built Plans')
   	->setCellValue('E1', 'Assigned Plans')
   	->setCellValue('F1', 'Rejected Plans')
   	->setCellValue('G1', 'Pending Plans')
   	->setCellValue('H1', 'Submitted Plans')
   	->setCellValue('I1', 'Active days')
   	->setCellValue('J1', 'Inactive days')
   	->setCellValue('K1', 'Hours (H:M:S)')
   	->setCellValue('L1', 'Average Hours (H:M:S)')
   	->setCellValue('M1', 'Distance travalled (Kms)')
   	->setCellValue('N1', 'Average Distance (Kms)')
   	->setCellValue('O1', 'No.of Village Visits')
   	->setCellValue('P1', 'Villages Visited')
   	->setCellValue('Q1', 'No.of Partner Visits')
   	->setCellValue('R1', 'Partners Visited');
   	// Set AutoSize for name and email fields
   	/*  $sheet = $objPHPExcel->getSheet(0);
   	$highestRow = $sheet->getHighestRow();
   	$highestColumn = $sheet->getHighestColumn();
   
   	$sheetData = $sheet->rangeToArray(
   	'A2:' . $highestColumn . $highestRow,
   	NULL,TRUE,FALSE
   	); */
   	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
   	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
   	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
   	$objWriter->save(\Yii::getAlias('@webroot').'/activity_summary.xls');
   	return \Yii::$app->response->sendFile(\Yii::getAlias('@webroot').'/activity_summary.xls');
   }
   public function actionSummaryexport()
   {
   $summaryparam = array();
   $summaryparam = Yii::$app->session->get('export');
   if(!empty($summaryparam)){
   $finalInfo  = $this->summaryData($summaryparam);
   	};
   	//  	echo '<pre>';print_r($finalInfo);exit;
   	$objPHPExcel = \PHPExcel_IOFactory::createReader('Excel5');
   	$objPHPExcel = $objPHPExcel->load('../crops_template.xls');
   	$objPHPExcel->getActiveSheet()->fromArray($finalInfo['summary2'], null, 'A2');
   	$objPHPExcel->getActiveSheet()->setTitle('Activity Summary');
   	$objPHPExcel->getActiveSheet()
      	->setCellValue('A1', 'App User')
			   	->setCellValue('B1', 'Reports to')
   			   	->setCellValue('C1', 'Build Plans')
   			   			->setCellValue('D1', 'Assigned Plans')
   			   					->setCellValue('E1', 'Villages')
   			   			->setCellValue('F1', 'Unique Villages')
   			   			->setCellValue('G1', 'Partners')
   			   			->setCellValue('H1', 'Unique Partners')
   			   			->setCellValue('I1', 'Head Quarters');
   			   			// Set AutoSize for name and email fields
   			   			/*  $sheet = $objPHPExcel->getSheet(0);
   	$highestRow = $sheet->getHighestRow();
   	$highestColumn = $sheet->getHighestColumn();
   	 
   	$sheetData = $sheet->rangeToArray(
   	'A2:' . $highestColumn . $highestRow,
   	NULL,TRUE,FALSE
   	); */
   	 
   	 
   	$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
   	$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);
   	$objWriter = \PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
   			$objWriter->save('/var/www/html/activity_summary.xls');
   			return \Yii::$app->response->sendFile('/var/www/html/activity_summary.xls');
   }
   
}
