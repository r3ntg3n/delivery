<?php

class m130611_204205_create_menu_table extends CDbMigration
{
	public function up()
	{
		$this->createTable('{{menu}}', array(
			'id' => 'pk',
			'name' => 'VARCHAR(45) NOT NULL UNIQUE',
			'active' => 'BOOLEAN',
			'description' => 'VARCHAR(255)',
		), 'CHARSET=UTF8');
	}

	public function down()
	{
		$this->dropTable('{{menu}}');
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
