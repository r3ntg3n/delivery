<?php

/**
 * Custom UrlManager component provides a logic for creating and parsing mulitlingual URLs
 *
 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
 * @version 1.0.1.2
 */
class UrlManager extends CUrlManager
{
	/**
	 * Creates a URL with computing language for it
	 * @param string URL route
	 * @param array additional params to get bound to URL
	 * @param string an ampersand value used to join GET params
	 * @return string an generated URL
	 *
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.2
	 */
    public function createUrl($route, $params = array(), $ampersand = '&')
    {
        if (!isset($params['language']))
        {
            if (Yii::app()->user->hasState('language'))
            {
                Yii::app()->language = Yii::app()->user->getState('language');
            }
            else if (isset(Yii::app()->request->cookies['language']->value))
            {
                Yii::app()->language = Yii::app()->request->cookies['language']->value;
            }
			$params['language'] = Yii::app()->language;
        }

		if ($this->isPageRoute($route))
		{
			$params['title'] = $route;
			$route = 'page/view';
		}

        $url = parent::createUrl($route, $params, $ampersand);
		return $url;
    }

	/**
	 * Parse a url according to rules
	 *
	 * @param CHttpRequest instance
	 * @return string <controller>/<action> route
	 *
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 * @since 1.0.0.2
	 */
	public function parseUrl($request)
	{
		if (!preg_match('/^[a-z]{2}/', $request->getPathInfo()))
		{
			return $request->getPathInfo();
		}

		if (preg_match('/^(?<language>[a-z]{2})\/(?<title>[a-z1-9-]+)$/', $request->getPathInfo(), $matches))
		{
			$_GET['language'] = $matches['language'];
			if ($this->isPageRoute($matches['title']))
			{
				$_GET['title'] = $matches['title'];
				return 'page/view';
			}
			else
			{
				return $matches['title'];
			}
		}
		else
		{
			return parent::parseUrl($request);
		}
	}

	/**
	 * Checks is specified route is a custom page route
	 * @param string route
	 * @return boolean
	 *
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 * @since 1.0.0.2
	 */
	private function isPageRoute($route)
	{
		$route = explode('/', $route);
		if (!$this->controllerExists($route[0]) && !$this->moduleExists($route[0]))
		{
			return true;
		}
		else
		{
			return false;
		}
	}

	/**
	 * Checks is controller exist
	 * @param string controller ID
	 * @return boolean
	 *
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 0.1.alpha
	 * @since 1.0.0.2
	 */
	private function controllerExists($id)
	{
		$controller = ucfirst($id);
		$path = $this->getComponentPath();
		return file_exists($path.DIRECTORY_SEPARATOR.$controller.'Controller.php');
	}

	/**
	 * Checks is controller exist
	 * @param string controller ID
	 * @return boolean
	 *
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 * @since 1.0.0.2
	 */
	private function moduleExists($id)
	{
		$path = $this->getComponentPath(true);
		$path = implode(DIRECTORY_SEPARATOR, array(
			$path,
			$id,
			ucfirst($id).'Module.php'
		));
		return file_exists($path);
	}

	/**
	 * Returns a path to components
	 * @param boolean to get path for modules or controller
	 * @return string application'c path to components
	 *
	 * @author Ievgenii Dytyniuk <i.dytyniuk@gmail.com>
	 * @version 1.0.0.1
	 * @since 1.0.0.2
	 */
	private function getComponentPath($module = false)
	{
		return ($module) ? Yii::app()->modulePath : Yii::app()->controllerPath;
	}
}
