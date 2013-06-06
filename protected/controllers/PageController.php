<?php

class PageController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
		);
	}

	/**
	 * Specifies the access control rules.
	 * This method is used by the 'accessControl' filter.
	 * @return array access control rules
	 */
	public function accessRules()
	{
		return array(
			array('allow',  // allow all users to perform 'index' and 'view' actions
				'actions'=>array('index','view'),
				'users'=>array('*'),
			),
			array('allow', // allow authenticated user to perform 'create' and 'update' actions
				'actions'=>array('create','update'),
				'users'=>array('@'),
			),
			array('allow', // allow admin user to perform 'admin' and 'delete' actions
				'actions'=>array('admin','delete'),
				'users'=>array('admin'),
			),
			array('deny',  // deny all users
				'users'=>array('*'),
			),
		);
	}

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($title)
	{
		$model = PageTranslation::model()->findByAttributes(array(
			'lang_id' => Language::getLanguageIdByCode(Yii::app()->language),
			'sef_title' => $title,
		));
		if ($model === null)
		{
			throw new CHttpException(404, Yii::t('default', 'Page not found'));
		}
		$this->render('view',array(
			'model'=>$model,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Page;

		// craete a translation for the page
		$model->prepareTranslation();

		// here and all the PageController component
		// we work with page's translation
		// so all validation and other stuff will relate to it
		//$this->performAjaxValidation($model);
		//$this->performAjaxValidation($model->translation);

		if(isset($_POST['PageTranslation']))
		{
			$model->translation->attributes = $_POST['PageTranslation'];
			if($model->validate() && $model->translation->validate())
			{
				// save generic page model without validation
				// cause we have already validated the page model
				$model->save(false);

				// set translation's page id
				$model->translation->page_id = $model->id;
				// and save translation without running validation
				$model->translation->save(false);

				$this->redirect(array('view','title'=>$model->translation->sef_title));
			}
		}

		$this->render('create',array(
			'model'=>$model,
		));
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
		$model=$this->loadModel($id);

		// Uncomment the following line if AJAX validation is needed
		//$this->performAjaxValidation($model);
		//$this->performAjaxValidation($model->translation);

		if(isset($_POST['PageTranslation']))
		{
			/**
			 * If another page's translation was loaded during update
			 * try to load appropriate PageTranslation model
			 */
			if ($model->translation->lang_id !== $_POST['PageTranslation']['lang_id'])
			{
				$model->prepareTranslation($_POST['PageTranslation']['lang_id']);
				unset($_POST['PageTranslation']['land_id']);
			}

			$model->translation->attributes = $_POST['PageTranslation'];
			if($model->translation->save())
			{
				$language = Language::model()->findByPk($model->translation->lang_id);
				$this->redirect(array('view',
					'title'=>$model->translation->sef_title,
					'language' => $language->code,
				));
			}
		}

		$this->render('update',array(
			'model'=>$model,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		$this->loadModel($id)->delete();

		// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
		if(!isset($_GET['ajax']))
			$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('Page', array(
			'criteria' => array(
				'with' => array('translation'),
			),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new Page('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['Page']))
			$model->attributes=$_GET['Page'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return Page the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=Page::model()->with('translation')->findByPk($id);
		if ($model->translation === null)
		{
			$model->prepareTranslation();
		}

		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param Page $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='page-form')
		{
			echo CActiveForm::validate($model->translation);
			Yii::app()->end();
		}
	}
}
