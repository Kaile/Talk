<?php

use yii\db\Schema;
use yii\db\Migration;
use \yii\db\Query;

class m141019_085548_FillEmptyCmdFields extends Migration
{
    public function up()
    {
		$query = new Query();
		$command = $this->db->createCommand("UPDATE message_buffer SET cmd = 'store' WHERE cmd IS NULL");
		$command->execute();

    }

    public function down()
    {
        echo "m141019_085548_FillEmptyCmdFields cannot be reverted.\n";

        return false;
    }
}
