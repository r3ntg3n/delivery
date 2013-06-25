<?php

class MenuWidget extends CWidget
{
	const DEFAULT_CAPTION_TEMPLATE = '{link}';

	public $menuId;
	public $menuClass;
	public $menuElement = 'ul';
	public $itemElement = 'li';
	public $childrenClass = 'children';

	private $itemsTree;

	public function run()
	{
		$this->itemsTree = MenuItem::getMenuTree(array(
			'menu' => $this->menuId,
			'captionTemplate' => isset($this->captionTemplate) ? $this->captionTemplate : self::DEFAULT_CAPTION_TEMPLATE,
		));

		$this->render('MenuWidget', array(
			'items' => $this->itemsTree,
		));
	}
}
