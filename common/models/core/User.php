<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models\core;

use yii\db\ActiveQuery;

/**
 * User model
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class User extends base\User {

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['name', 'last_name', 'phone', 'mobile', 'fax', 'email'], 'trim']
            , ['email', 'email']
        ]);
    }

    /**
     * 
     * @return AccountQuery
     */
    public function getAccount() {
        return $this->hasOne(Account::className(), ['id' => 'id']);
    }

}

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class UserQuery extends ActiveQuery {
    
}
