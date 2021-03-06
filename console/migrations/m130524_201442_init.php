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
            ], 'cor_auth' => [
                'id' => Schema::TYPE_INTEGER . ' NOT NULL'
                , 'access_token' => 'varbinary(255) not null'
                , 'expires_at' => Schema::TYPE_INTEGER
                , 'created_at' => Schema::TYPE_INTEGER
                , 'created_by' => Schema::TYPE_INTEGER
                , 'updated_at' => Schema::TYPE_INTEGER
                , 'updated_by' => Schema::TYPE_INTEGER
            ], 'cor_file' => [
                'id' => Schema::TYPE_PK,
                'name' => Schema::TYPE_STRING,
                'path' => Schema::TYPE_STRING . ' NOT NULL',
                'mime_type' => Schema::TYPE_STRING . ' NOT NULL',
                'created_at' => Schema::TYPE_INTEGER,
                'created_by' => Schema::TYPE_INTEGER,
                'updated_at' => Schema::TYPE_INTEGER,
                'updated_by' => Schema::TYPE_INTEGER
            ], 'cor_resource_file' => [
                'resource_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'file_id' => Schema::TYPE_INTEGER . ' NOT NULL',
                'class' => Schema::TYPE_STRING . ' NOT NULL'
            ], 'cor_user' => [
                'id' => Schema::TYPE_PK
                , 'account_id' => Schema::TYPE_INTEGER
                , 'slug' => Schema::TYPE_STRING . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL'
                , 'name' => Schema::TYPE_STRING
                , 'last_name' => Schema::TYPE_STRING
                , 'nif' => Schema::TYPE_STRING
                , 'email' => Schema::TYPE_STRING . ' CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL'
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
    public function getPrimaryKeys() {
        return [
            ['PK_CorResourceFile_ResourceId_FileId', 'cor_resource_file', ['resource_id', 'file_id']]
            , ['PK_CorAuth_Id', 'cor_auth', 'id']
        ];
    }

    /**
     * @inheritdoc
     */
    public function getIndexes() {
        return [
            ['UNIQUE_CorAccount_Username', 'cor_account', 'username', true]
            , ['UNIQUE_CorUser_Slug', 'cor_user', 'slug', true]
            , ['INDEX_CorAuth_AccessToken', 'cor_auth', 'access_token', false]
        ];
    }

    /**
     * @inheritdoc
     */
    public function getForeignKeys() {
        return [
            ['FK_CorAccount_CorUser_AccountId', 'cor_user', 'account_id', 'cor_account', 'id', 'SET NULL', 'CASCADE']
            , ['FK_CorFile_CorResourceFile_FileId', 'cor_resource_file', 'file_id', 'cor_file', 'id', 'CASCADE', 'CASCADE']
            , ['FK_CorAuth', 'cor_auth', 'id', 'cor_account', 'id', 'CASCADE', 'CASCADE']
        ];
    }

}
