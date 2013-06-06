<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/column1';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();

    public function __construct($id, $module = null)
    {
        parent::__construct($id, $module);

        if (isset($_POST['language']))
        {
            $lang = $_POST['language'];
            $multiLangReturnUrl = $_POST[$lang];
            $this->redirect($mulriLangReturnUrl);
        }

		// if language code was passed through the URI
        if (isset($_GET['language']))
        {
			// set it as application's lang
			Yii::app()->language = $_GET['language'];

			// and store it to user's session
			Yii::app()->user->setState('language', $_GET['language']);

			// and store it to user's cookies
			$cookie = new CHttpCookie('language', $_GET['language']);
			$cookie->expire = time() + (60*60*24*14);
			Yii::app()->request->cookies['language'] = $cookie;
        }
		// otherwise we need to get lang code from other places
		else 
		{
			// maybe from user's session
			if (Yii::app()->user->hasState('language'))
			{
				Yii::app()->language = Yii::app()->user->getState('language');
			}

			// or user's cookies
			else if (isset(Yii::app()->request->cookies['language']->value))
			{
				Yii::app()->language = Yii::app()->request->cookie['language']->value;
			}

			// or use application's default language if none of above were founb
			else
			{
				$language = Language::getDefaultLanguage();
				Yii::app()->language = $language->code;
			}

			// build a url with language code
			$route = Yii::app()->urlManager->parseUrl(Yii::app()->request);
			$url = $this->createUrl('/'.$route, array(
				'language'=>Yii::app()->language
			));
			// and redirect user to appropriate page
			$this->redirect($url);
		}
    }

}
