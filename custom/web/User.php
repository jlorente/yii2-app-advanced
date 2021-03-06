<?php

/**
 * @author	José Lorente <jose.lorente.martin@gmail.com>
 * @version	1.0
 */

namespace custom\web;

use Yii;
use yii\web\User as BaseUser;
use yii\web\Cookie;

/**
 * Custom implementation for yii\web\User
 *
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class User extends BaseUser {

    /**
     *
     * @var int value of the current session role
     */
    public $role;

    /**
     *
     * @var string the session variable name used to store the value the current role.
     */
    public $roleParam = '__role';

    /**
     * Sends an identity cookie.
     * This method is used when [[enableAutoLogin]] is true.
     * It saves [[id]], [[IdentityInterface::getAuthKey()|auth key]], and the duration of cookie-based login
     * information in the cookie.
     * @param IdentityInterface $identity
     * @param integer $duration number of seconds that the user can remain in logged-in status.
     * @see loginByCookie()
     */
    protected function sendIdentityCookie($identity, $duration) {
        $cookie = new Cookie($this->identityCookie);
        $cookie->value = json_encode([
            $identity->getId(),
            $identity->getAuthKey(),
            $this->getRole(),
            $duration,
                ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        $cookie->expire = time() + $duration;
        Yii::$app->getResponse()->getCookies()->add($cookie);
    }

    /**
     * Logs in a user by cookie.
     *
     * This method attempts to log in a user using the ID and authKey information
     * provided by the [[identityCookie|identity cookie]].
     */
    protected function loginByCookie() {
        $value = Yii::$app->getRequest()->getCookies()->getValue($this->identityCookie['name']);
        if ($value === null) {
            return;
        }

        $data = json_decode($value, true);
        if (count($data) !== 4 || !isset($data[0], $data[1], $data[2], $data[3])) {
            return;
        }

        list ($id, $authKey, $role, $duration) = $data;
        /* @var $class IdentityInterface */
        $class = $this->identityClass;
        $identity = $class::findIdentity($id);
        if ($identity === null) {
            return;
        } elseif (!($identity instanceof IdentityInterface)) {
            throw new InvalidValueException("$class::findIdentity() must return an object implementing IdentityInterface.");
        }

        if ($identity->validateAuthKey($authKey)) {
            if ($identity->hasRol($role)) {
                $this->role = $role;
                if ($this->beforeLogin($identity, true, $duration)) {
                    $this->switchIdentity($identity, $this->autoRenewCookie ? $duration : 0);
                    $ip = Yii::$app->getRequest()->getUserIP();
                    Yii::info("User '$id' logged in from $ip via cookie.", __METHOD__);
                    $this->afterLogin($identity, true, $duration);
                }
            } else {
                Yii::warning("Invalid role attempted for user '$id': $role", __METHOD__);
            }
        } else {
            Yii::warning("Invalid auth key attempted for user '$id': $authKey", __METHOD__);
        }
    }

    /**
     * Switches to a new identity for the current user.
     *
     * When [[enableSession]] is true, this method may use session and/or cookie to store the user identity information,
     * according to the value of `$duration`. Please refer to [[login()]] for more details.
     *
     * This method is mainly called by [[login()]], [[logout()]] and [[loginByCookie()]]
     * when the current user needs to be associated with the corresponding identity information.
     *
     * @param IdentityInterface|null $identity the identity information to be associated with the current user.
     * If null, it means switching the current user to be a guest.
     * @param integer $duration number of seconds that the user can remain in logged-in status.
     * This parameter is used only when `$identity` is not null.
     */
    public function switchIdentity($identity, $duration = 0) {
        $this->setIdentity($identity);

        if (!$this->enableSession) {
            return;
        }

        $session = Yii::$app->getSession();
        if (!YII_ENV_TEST) {
            $session->regenerateID(true);
        }
        $session->remove($this->idParam);
        $session->remove($this->authTimeoutParam);
        $session->remove($this->roleParam);

        if ($identity) {
            $session->set($this->idParam, $identity->getId());
            if ($this->authTimeout !== null) {
                $session->set($this->authTimeoutParam, time() + $this->authTimeout);
            }
            if ($this->absoluteAuthTimeout !== null) {
                $session->set($this->absoluteAuthTimeoutParam, time() + $this->absoluteAuthTimeout);
            }
            if ($this->role !== null) {
                $session->set($this->roleParam, $this->role);
            }
            if ($duration > 0 && $this->enableAutoLogin) {
                $this->sendIdentityCookie($identity, $duration);
            }
        } elseif ($this->enableAutoLogin) {
            Yii::$app->getResponse()->getCookies()->remove(new Cookie($this->identityCookie));
        }
    }

    /**
     * Set the current session role for the web user.
     * 
     * @param int $role
     */
    public function setRole($role) {
        if ($role !== $this->role) {
            Yii::$app->getSession()->set($this->roleParam, $role);
            $this->role = $role;
        }
    }

    /**
     * Get the current session role of the web user.
     * 
     * @return int
     */
    public function getRole() {
        if ($this->role === null) {
            $this->role = Yii::$app->getSession()->get($this->roleParam, 0);
        }
        return $this->role;
    }

    /**
     * Renews the identity cookie.
     * This method will set the expiration time of the identity cookie to be the current time
     * plus the originally specified cookie duration.
     */
    protected function renewIdentityCookie() {
        $name = $this->identityCookie['name'];
        $value = Yii::$app->getRequest()->getCookies()->getValue($name);
        if ($value !== null) {
            $data = json_decode($value, true);
            if (is_array($data) && isset($data[3])) {
                $cookie = new Cookie($this->identityCookie);
                $cookie->value = $value;
                $cookie->expire = time() + (int) $data[3];
                Yii::$app->getResponse()->getCookies()->add($cookie);
            }
        }
    }

}
