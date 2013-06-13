<?php

class MenuItemController extends Controller
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column2';

	/**
	 * @var object associated Menu model
	 */
	private $_menuModel = null;

	/**
	 * @var object parent MenuItem  model
	 */
	private $_parentModel = null;

	/**
	 * @return array action filters
	 */
	public function filters()
	{
		return array(
			'accessControl', // perform access control for CRUD operations
			'postOnly + delete', // we only allow deletion via POST request
			'relatedContext + create, admin, index',
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
	public function actionView($id)
	{
		$this->render('view',array(
			'model'=>$this->loadModel($id),
			'menu' =>$this->_menuModel,
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new MenuItem;
		$this->prepareModel($model);
		$parentItemId = $model->parent_id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MenuItem']))
		{
			$model->attributes=$_POST['MenuItem'];
			if ($parentItemId && ($model->parent_id !== $parentItemId))
			{
				$parent = MenuItem::model()->findByPk($model->parent_id);
				$model->level = ++$parent->level;
				$model->path = $parent->path;
			}
			if($model->save())
			{
				$model->path .= (($model->level > 1) ? '/' : '') . $model->id;
				$model->save();
				$this->redirect(array('view','id'=>$model->id));
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
		$parentItemId = $model->parent_id;

		// Uncomment the following line if AJAX validation is needed
		// $this->performAjaxValidation($model);

		if(isset($_POST['MenuItem']))
		{
			$model->attributes=$_POST['MenuItem'];
			if ($model->parent_id !== $parentItemId)
			{
				$parent = MenuItem::model()->findByPk($model->parent_id);
				$model->path = "{$parent->path}/{$model->id}";
				$model->level = ++$parent->level;
			}
			if($model->save())
				$this->redirect(array('view','id'=>$model->id));
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
		$dataProvider=new CActiveDataProvider('MenuItem', array(
			'criteria' => array(
				'condition' => "menu_id={$this->_menuModel->id}",
			),
		));
		$this->render('index',array(
			'dataProvider'=>$dataProvider,
			'menu' => $this->_menuModel,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new MenuItem('search');
		$model->unsetAttributes();  // clear any default values
		if(isset($_GET['MenuItem']))
			$model->attributes=$_GET['MenuItem'];

		$this->render('admin',array(
			'model'=>$model,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer $id the ID of the model to be loaded
	 * @return MenuItem the loaded model
	 * @throws CHttpException
	 */
	public function loadModel($id)
	{
		$model=MenuItem::model()->findByPk($id);
		if($model===null)
			throw new CHttpException(404,'The requested page does not exist.');
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param MenuItem $model the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='menu-item-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}

	/**
	 * Sets basic item properties in place
	 * @params MenuItem model instance
	 * @return void
	 */
	private function prepareModel(MenuItem &$model)
	{
		$model->menu_id = $this->_menuModel->id;
		$model->lang_id = Language::getLanguageIdByCode(Yii::app()->language);
		$model->parent_id =  ($this->_parentModel !== null) ? $this->_parentModel->id : 0;
		$model->level =  ($this->_parentModel !== null) ? ++$this->_parentModel->level : 1;
		$model->path = ($this->_parentModel !== null) ? $this->_parentModel->path : '';
	}

	/**
	 * Additional filter to apply to create, update and other actions
	 * @param object filter chain
	 */
	public function filterRelatedContext($filterChain)
	{
		$this->createMenuContext();
		$this->createParentItemContext();
		$filterChain->run();
	}

	/**
	 * Create Menu context to provide existing Model model for items
	 * @return void
	 */
	protected function createMenuContext()
	{
		$id = Yii::app()->request->getParam('menu');

		$context = new stdClass;
		$context->property = &$this->_menuModel;
		$context->className = 'Menu';
		$context->id = $id;
		$context->exceptionOnNull = true;

		$this->createContext($context);
	}

	/**
	 * Create parentItem context if any parent id was specified
	 * @return void
	 */
	protected function createParentItemContext()
	{
		$id = Yii::app()->request->getParam('parent');

		$context = new stdClass;
		$context->property = &$this->_parentModel;
		$context->className = 'MenuItem';
		$context->id = $id;
		$context->exceptionOnNull = false;

		$this->createContext($context);
	}

	/**
	 * Creates context 
	 * @param stdClass object containing context params
	 * @return void
	 */
	protected function createContext(stdClass &$context)
	{
		if (empty($context->property))
		{
			$this->loadContext($context);
		}
		if (!empty($context->exceptionOnNull) && ($context->property === null))
		{
			throw new CHttpException(404, 'The requested ' . strtolower($context->className) . ' does not exist');
		}
	}

	/**
	 * Loads context object
	 * @param stdClass object with context properties
	 */
	protected function loadContext(stdClass &$context)
	{
		$contextClass = $context->className;
		$context->property = $contextClass::model()->findByPk($context->id);
	}

}
