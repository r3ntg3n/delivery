<?php

class MenuWidget extends CWidget
{
	public $menuId;
	public $menuClass;

	private $itemsTree;

	public function run()
	{
		$params = new stdClass;
		$params->menuId = $this->menuId;
		$params->textNodeCallback = function($item)
		{
			return CHtml::link($item->caption, $item->link); 
		};

		$this->itemsTree = MenuItem::getMenuTree($params);

		$this->render('MenuWidget', array(
			'items' => $this->itemsTree,
			'menuClass' => $this->menuClass,
		));
	}
}
