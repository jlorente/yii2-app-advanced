<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace common\models\core\ar;

use Yii;
use yii\base\NotSupportedException;
use custom\web\IdentityInterface;
use yii\db\ActiveQuery;
use jlorente\roles\models\Roleable,
    jlorente\roles\models\RoleableTrait;
use yii\helpers\ArrayHelper;

/**
 * Account model
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Account extends base\Account implements IdentityInterface, Roleable {

    use RoleableTrait;

    //Status
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;
    //Roles
    const ROLE_USER = 'User';
    const ROLE_ADMIN = 'Admin';

    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [
            [['username'], 'trim']
            , ['username', 'string', 'length' => [4, 40]]
            , ['username', 'match', 'pattern' => '/^[a-z][\w-]*[a-z]$/i']
            , ['status', 'default', 'value' => self::STATUS_ACTIVE]
            , ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]]
                ], $this->roleRules());
    }

    /**
     * @inheritdoc
     */
    public function behaviors() {
        return ArrayHelper::merge(parent::behaviors(), [
        ]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id) {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null) {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username) {
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token) {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
                    'password_reset_token' => $token,
                    'status' => self::STATUS_ACTIVE,
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token) {
        if (empty($token)) {
            return false;
        }
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int) end($parts);
        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId() {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey() {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey) {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password) {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password) {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey() {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken() {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken() {
        $this->password_reset_token = null;
    }

    /**
     * @inheritdoc
     */
    public function hasRol($rol) {
        return $this->role & $rol === $rol;
    }

    /**
     * 
     * @return UserQuery
     */
    public function getUser() {
        return $this->hasOne(User::className(), ['id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function getValidRoles() {
        return [self::ROLE_USER];
    }

    /**
     * 
     * @return AccountQuery
     */
    public static function find() {
        return Yii::createObject(AccountQuery::className(), [get_called_class()]);
    }

}

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class AccountQuery extends ActiveQuery {

    /**
     * Adds the active filter to the query object.
     * 
     * @return $this the query object itself
     */
    public function active() {
        $this->filterWhere(['status' => Account::STATUS_ACTIVE]);
        return $this;
    }

    /**
     * Adds an email filter by performing a join with the user table.
     * 
     * @param string $email
     * @return $this the query object itself
     */
    public function filterByEmail($email) {
        return $this->innerJoin(User::tableName(), User::tableName() . 'account_id = cor_account.id')
                        ->andWhere(['email' => $email]);
    }

}
