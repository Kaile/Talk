<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_084703_DropColUserIdFromMessageBuffer extends Migration
{
	const TABLE_NAME = 'message_buffer';
	const COLUMN_NAME = 'user_id';

    public function up()
    {
		return $this->dropColumn(self::TABLE_NAME, self::COLUMN_NAME);
    }

    public function down()
    {
        return $this->addColumn(self::TABLE_NAME, self::COLUMN_NAME, 'int');
    }
}
