<?php

require Yii::getAlias('@vendor/jlorente/yii2-locations/src/migrations/m150910_235325_location_module_tables.php');

use yii\db\Schema;

class m170209_110755_jlorente_yii2_locations_module extends m150910_235325_location_module_tables {

    /**
     * @inheritdoc
     */
    public function up() {
        parent::up();
        $this->addColumn('cor_user', 'location_id', Schema::TYPE_INTEGER . ' AFTER mobile');
        $this->addForeignKey('FK_JlLocLocation_CorUser_LocationId', 'cor_user', 'location_id', 'jl_loc_location', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down() {
        $this->dropForeignKey('FK_JlLocLocation_CorUser_LocationId', 'cor_user');
        $this->dropColumn('cor_user', 'location_id');
        parent::down();
    }

}
