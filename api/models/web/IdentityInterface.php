<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace api\models\web;

/**
 * @inheritdoc
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 */
interface IdentityInterface extends BaseIdentityInterface {

    /**
     * Forces the indentity to generate new credentials.
     */
    public function renewAuthorization();

    /**
     * Extends the expiration time of the authorization.
     */
    public function renewExpirationTime();
}
