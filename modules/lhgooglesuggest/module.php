<?php

$Module = array("name" => "Google Suggest",
    'variable_params' => true);

$ViewList = array();

$ViewList['options'] = array(
    'params' => array(),
    'functions' => array('use_admin'),
);

$ViewList['optionslist'] = array(
    'params' => array(),
    'functions' => array('use_admin'),
);

$ViewList['new'] = array(
    'params' => array(),
    'functions' => array('use_admin'),
);

$ViewList['edit'] = array(
    'params' => array('id'),
    'functions' => array('use_admin'),
);

$ViewList['delete'] = array(
    'params' => array('id'),
    'uparams' => array('csfr'),
    'functions' => array('use_admin'),
);

$ViewList['index'] = array(
    'params' => array(),
    'functions' => array('use_admin'),
);

$FunctionList['use_admin'] = array('explain' => 'Allow operator to configure Google Suggest');
