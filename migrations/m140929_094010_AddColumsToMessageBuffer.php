<?php

use yii\db\Migration;

class m140929_094010_AddColumsToMessageBuffer extends Migration
{
	const TABLE_NAME = 'message_buffer';
	const COL1_NAME  = 'from';
	const COL2_NAME  = 'to';
	
	const FK_COL1 = 'fk_message_buffer_from_users';
	const FK_COL2 = 'fk_message_buffer_to_users';
	
    public function safeUp()
    {
		$this->addColumn(self::TABLE_NAME, self::COL1_NAME, 'int');
		$this->addColumn(self::TABLE_NAME, self::COL2_NAME, 'int');
		
		$this->addForeignKey(self::FK_COL1, self::TABLE_NAME, self::COL1_NAME, 'users', 'id', 'CASCADE', 'CASCADE');
		$this->addForeignKey(self::FK_COL2, self::TABLE_NAME, self::COL2_NAME, 'users', 'id', 'CASCADE', 'CASCADE');
		
		return true;
    }

    public function safeDown()
    {
		$this->dropColumn(self::TABLE_NAME, self::COL1_NAME);
		$this->dropColumn(self::TABLE_NAME, self::COL2_NAME);
		
		$this->dropForeignKey(self::FK_COL1, self::TABLE_NAME);
		$this->dropForeignKey(self::FK_COL2, self::TABLE_NAME);
		
        return true;
    }
}
