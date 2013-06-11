<?php

/**
 * Abstract PageBaseController component provides common logic
 * for content pages' models: ordinary pages, news pages etc.
 * E.g. it provides common logic for managing content translations
 * for these types of pages. 
 *
 * @package Controllers
 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
 * @version 1.0.0.1
 */
abstract class PageBaseController extends Controller
{
	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new Page;

		// craete a translation for the page
		// all content pages must extend Page model
		// to get translations managenet available
		$model->prepareTranslation();

		// here and all the PageBaseController component
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
	 * Displays a particular model.
	 * @param string $title SEF title of the model' translation to be displayed
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
}
