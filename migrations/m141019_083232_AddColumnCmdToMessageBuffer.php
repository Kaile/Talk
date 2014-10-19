<?php

use yii\db\Schema;
use yii\db\Migration;

class m141019_083232_AddColumnCmdToMessageBuffer extends Migration
{
	const TABLE_NAME = 'message_buffer';
	const COLUMN_NAME = 'cmd';

    public function up()
    {
		return $this->addColumn(self::TABLE_NAME, self::COLUMN_NAME, 'string');
    }

    public function down()
    {
        return $this->dropColumn(self::TABLE_NAME, self::COLUMN_NAME);
    }
}
