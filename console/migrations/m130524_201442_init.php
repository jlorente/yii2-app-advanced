<?php

use yii\db\Schema;
use custom\db\StructureMigration;

class m130524_201442_init extends StructureMigration {

    /**
     * @inheritdoc
     */
    public function getTables() {
        return [
            'cor_account' => [
                'id' => Schema::TYPE_PK
                , 'username' => Schema::TYPE_STRING . ' NOT NULL'
                , 'auth_key' => Schema::TYPE_STRING . ' NOT NULL'
                , 'password_hash' => Schema::TYPE_STRING . ' NOT NULL'
                , 'password_reset_token' => Schema::TYPE_STRING
                , 'status' => Schema::TYPE_SMALLINT . ' NOT NULL DEFAULT 10'
                , 'role' => Schema::TYPE_INTEGER . ' NOT NULL DEFAULT 1'
                , 'created_at' => Schema::TYPE_INTEGER
                , 'created_by' => Schema::TYPE_INTEGER
                , 'updated_at' => Schema::TYPE_INTEGER
                , 'updated_by' => Schema::TYPE_INTEGER
            ], 'usr_user' => [
                'id' => Schema::TYPE_PK
                , 'account_id' => Schema::TYPE_INTEGER
                , 'slug' => Schema::TYPE_STRING . ' NOT NULL CHARACTER SET utf8mb4 COLLATE utf8mb4_bin'
                , 'name' => Schema::TYPE_STRING
                , 'last_name' => Schema::TYPE_STRING
                , 'nif' => Schema::TYPE_STRING
                , 'email' => Schema::TYPE_STRING . ' NOT NULL CHARACTER SET utf8mb4 COLLATE utf8mb4_bin'
                , 'phone' => Schema::TYPE_STRING
                , 'mobile' => Schema::TYPE_STRING
                , 'created_at' => Schema::TYPE_INTEGER
                , 'created_by' => Schema::TYPE_INTEGER
                , 'updated_at' => Schema::TYPE_INTEGER
                , 'updated_by' => Schema::TYPE_INTEGER
                , 'deleted_at' => Schema::TYPE_INTEGER
                , 'deleted_by' => Schema::TYPE_INTEGER
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function getIndexes() {
        return [
            ['UNIQUE_CorAccount_Username', 'cor_account', 'username', true]
            , ['UNIQUE_UsrUser_Slug', 'usr_user', 'slug', true]
        ];
    }

    /**
     * @inheritdoc
     */
    public function getForeignKeys() {
        return [
            ['FK_CorAccount_UsrUser_AccountId', 'cor_account', 'id', 'usr_user', 'account_id', 'SET NULL', 'CASCADE']
        ];
    }

}
