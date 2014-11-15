<?php

use yii\db\Migration;

class m141008_113310_AddTableUserInfo extends Migration
{
	const TABLE_NAME = 'user_info';
	const FK_USERS = 'fk_user_info_to_users';
	
    public function safeUp()
    {
		$this->createTable(self::TABLE_NAME, [
			'id' => 'pk',
			'user_id' => 'int not null',
			'name' => 'string',
			'surname' => 'string',
			'lastname' => 'string',
			'born_date' => 'datetime',
			'phone_number' => 'string',
		]);
		
		$this->addForeignKey(self::FK_USERS, self::TABLE_NAME, 'user_id', 'users', 'id', 'CASCADE', 'CASCADE');
		
		return true;
    }

    public function down()
    {
		$this->dropTable(self::TABLE_NAME);
		
		$this->dropForeignKey(self::FK_USERS, self::TABLE_NAME);
		
        return true;
    }
}
