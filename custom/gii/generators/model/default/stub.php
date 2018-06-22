<?php
/**
 * This is the template for generating the model class of a specified table.
 */

/* @var $this yii\web\View */
/* @var $generator custom\gii\generators\model\Generator */
/* @var $tableName string full table name */
/* @var $className string class name */
/* @var $queryClassName string query class name */
/* @var $tableSchema yii\db\TableSchema */
/* @var $properties array list of properties (property => [type, name. comment]) */
/* @var $labels string[] list of attribute labels (name => label) */
/* @var $rules string[] list of validation rules */
/* @var $relations array list of relations (name => relation declaration) */

echo "<?php\n";
?>

namespace <?= $generator->ns ?>;

use Yii;

/**
 * This is the stub class for table "<?= $generator->generateTableName($tableName) ?>".
 *
<?php if (!empty($relations)): ?>
 *
<?php foreach ($relations as $name => $relation): ?>
 * @property <?= $relation[1] . ($relation[2] ? '[]' : '') . ' $' . lcfirst($name) . "\n" ?>
<?php endforeach; ?>
<?php endif; ?>
 */
class <?= $className ?> extends base\<?= $className ?> {
    /**
     * @inheritdoc
     */
    public function rules() {
        return array_merge(parent::rules(), [<?= !empty($relationRules) ? ("\n            " . implode(",\n            ", $relationRules) . ",\n        ") : "\n" ?>]);
    }
<?php foreach ($relations as $name => $relation): ?>

    /**
     * @return <?= ($generator->generateQuery ? ($relation[2] ? substr($name, 0, -1) : $name) . 'Query' : '\\yii\\db\\ActiveQuery') . "\n"?>
     */
    public function get<?= $name ?>() {
        <?= $relation[0] . "\n" ?>
    }
<?php endforeach; ?>
<?php if ($queryClassName): ?>
<?php
    $queryClassFullName = ($generator->ns === $generator->queryNs) ? $queryClassName : '\\' . $generator->queryNs . '\\' . $queryClassName;
    echo "\n";
?>
    /**
     * @inheritdoc
     * @return <?= $queryClassFullName ?> the active query used by this AR class.
     */
    public static function find() {
        return new <?= $queryClassFullName ?>(get_called_class());
    }
<?php endif; ?>
}

<?php if ($generator->generateQuery) : ?>
/**
 * This is the ActiveQuery class for [[<?= $className ?>]].
 *
 * @see <?= $className . "\n" ?>
 */
class <?= $queryClassName ?> extends <?= '\\' . ltrim($generator->queryBaseClass, '\\') ?> {

}
<?php endif; ?>