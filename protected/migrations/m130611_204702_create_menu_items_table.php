<?php

class m130611_204702_create_menu_items_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{menu_items}}', array(
			'id' => 'pk',
			'menu_id' => 'INT NOT NULL',
			'lang_id' => 'INT(2) NOT NULL',
			'caption' => 'VARCHAR(45) NOT NULL',
			'link' => 'VARCHAR(500) NOT NULL',
			'active' => 'BOOL',
			'parent_id' => 'INT NOT NULL DEFAULT 0',
			'level' => 'INT(2) NOT NULL DEFAULT 1',
			'path' => 'VARCHAR(255)',
			'access_level' => 'INT(1) NOT NULL DEFAULT 0',
		));

		$this->createIndex('menu_lang_level_active_index', '{{menu_items}}', 'menu_id, lang_id, level, active');
		$this->createIndex('parent_lang_level_active', '{{menu_items}}', 'parent_id, lang_id, level, active');
		
	}

	public function down()
	{
		$this->dropTable('{{menu_items}}');
		return false;
	}

	/*
	// Use safeUp/safeDown to do migration with transaction
	public function safeUp()
	{
	}

	public function safeDown()
	{
	}
	*/
}
