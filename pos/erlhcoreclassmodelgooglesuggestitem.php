<?php

$def = new ezcPersistentObjectDefinition();
$def->table = "lhc_googlesugest_item";
$def->class = "erLhcoreClassModelGoogleSuggestItem";

$def->idProperty = new ezcPersistentObjectIdProperty();
$def->idProperty->columnName = 'id';
$def->idProperty->propertyName = 'id';
$def->idProperty->generator = new ezcPersistentGeneratorDefinition(  'ezcPersistentNativeGenerator' );

$def->properties['name'] = new ezcPersistentObjectProperty();
$def->properties['name']->columnName   = 'name';
$def->properties['name']->propertyName = 'name';
$def->properties['name']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['identifier'] = new ezcPersistentObjectProperty();
$def->properties['identifier']->columnName   = 'identifier';
$def->properties['identifier']->propertyName = 'identifier';
$def->properties['identifier']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['configuration'] = new ezcPersistentObjectProperty();
$def->properties['configuration']->columnName   = 'configuration';
$def->properties['configuration']->propertyName = 'configuration';
$def->properties['configuration']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['custom_arguments'] = new ezcPersistentObjectProperty();
$def->properties['custom_arguments']->columnName   = 'custom_arguments';
$def->properties['custom_arguments']->propertyName = 'custom_arguments';
$def->properties['custom_arguments']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['field'] = new ezcPersistentObjectProperty();
$def->properties['field']->columnName   = 'field';
$def->properties['field']->propertyName = 'field';
$def->properties['field']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['search_id'] = new ezcPersistentObjectProperty();
$def->properties['search_id']->columnName   = 'search_id';
$def->properties['search_id']->propertyName = 'search_id';
$def->properties['search_id']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

$def->properties['referrer'] = new ezcPersistentObjectProperty();
$def->properties['referrer']->columnName   = 'referrer';
$def->properties['referrer']->propertyName = 'referrer';
$def->properties['referrer']->propertyType = ezcPersistentObjectProperty::PHP_TYPE_STRING;

return $def;

?>