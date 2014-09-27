<?php

use yii\db\Migration;

class m140927_100826_CreateTableUsers extends Migration
{
	const TABLE = 'users';
	
    public function safeUp()
    {
		$this->createTable(self::TABLE, [
			'id' => 'pk',
			'login' => 'string',
			'password' => 'string',
			'registered' => 'datetime',
			'auth_key' => 'string',
			'access_token' => 'string',
		]);
		
		$this->insert(self::TABLE, [
			'login' => 'admin',
			'password' => hash('sha256', 'admin'),
			'registered' => date('Y/m/d h:i:s'),
			'auth_key' => 'admin_auth_key',
			'access_token' => 'admin_access_token',
		]);
    }

    public function down()
    {
        return $this->dropTable(self::TABLE);
    }
}
