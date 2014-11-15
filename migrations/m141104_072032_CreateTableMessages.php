<?php

use yii\db\Schema;
use yii\db\Migration;

class m141104_072032_CreateTableMessages extends Migration
{
    const TABLE_NAME   = 'messages';
    const FK_USER_TO   = 'fk_messages_to_users1';
    const FK_USER_FROM = 'fk_messages_to_users2';

    public function safeUp()
    {
        $this->createTable(self::TABLE_NAME, [
                'id' => 'pk',
                'message' => 'text',
                'date' => 'date',
                'to' => 'int',
                'from' => 'int',
            ]);

        $this->addForeignKey(self::FK_USER_TO, self::TABLE_NAME, 'to', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->addForeignKey(self::FK_USER_FROM, self::TABLE_NAME, 'from', 'users', 'id', 'CASCADE', 'CASCADE');

        return true;
    }

    public function safeDown()
    {
        $this->dropTable(self::TABLE_NAME);
        $this-dropForeignKey(self::FK_USER_TO, self::TABLE_NAME);
        $this-dropForeignKey(self::FK_USER_FROM, self::TABLE_NAME);
        
        return true;
    }
}
