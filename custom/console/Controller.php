<?php

/**
 * @author      José Lorente <jose.lorente.martin@gmail.com>
 * @version     1.0
 */

namespace custom\console;

use yii\console\Controller as BaseController;
use yii\helpers\Console;

/**
 * 
 * @author José Lorente <jose.lorente.martin@gmail.com>
 */
class Controller extends BaseController {

    /**
     * 
     * @param string $string
     * @return string
     */
    public function output($string) {
        if ($this->isColorEnabled()) {
            $args = func_get_args();
            array_shift($args);
            $string = Console::ansiFormat($string, $args);
        }
        $b = Console::stdout($string);
        echo PHP_EOL;
        return $b;
    }

}
