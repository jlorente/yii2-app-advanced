<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models\core\ar;

use yii\db\ActiveQuery;
use jlorente\location\db\LocationTrait;

/**
 * User model
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class User extends base\User {

    use LocationTrait;

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), $this->locationRules(), [
            [['name', 'last_name', 'phone', 'mobile', 'fax', 'email'], 'trim']
            , ['email', 'email']
        ]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return array_merge(parent::attributeLabels(), $this->locationAttributeLabels());
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return array_merge(parent::behaviors(), [
            [
                'class' => SluggableBehavior::className(),
                'ensureUnique' => true,
                'immutable' => false,
                'attribute' => 'name'
            ]
        ]);
    }

    /**
     * 
     * @return AccountQuery
     */
    public function getAccount() {
        return $this->hasOne(Account::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function save($runValidation = true, $attributeNames = null) {
        $trans = $this->getDb()->beginTransaction();
        try {
            if ($this->saveLocation($runValidation, $attributeNames) === false) {
                throw new SaveException($this);
            }
            if (parent::save($runValidation, $attributeNames) === false) {
                throw new SaveException($this);
            }
            $trans->commit();
            return true;
        } catch (Exception $ex) {
            $trans->rollBack();
            return false;
        }
    }

    /**
     * @inheritdoc
     */
    public static function populateRecord($record, $row) {
        parent::populateRecord($record, $row);
        $record->populateLocationOwner();
    }

}

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class UserQuery extends ActiveQuery {
    
}
