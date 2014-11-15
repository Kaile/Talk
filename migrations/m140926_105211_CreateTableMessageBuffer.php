<?php

use yii\db\Migration;

class m140926_105211_CreateTableMessageBuffer extends Migration
{
	const TABLE_NAME = 'message_buffer';
	
    public function up()
    {
		$this->createTable(self::TABLE_NAME,[
			'id' => 'pk',
			'user_id' => 'int',
			'data' => 'string',
			'date' => 'datetime',
		]);
    }

    public function down()
    {
        return $this->dropTable(self::TABLE_NAME);
    }
}
