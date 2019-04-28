<?php

$Module = array("name" => "Google Suggest",
    'variable_params' => true);

$ViewList = array();

$ViewList['options'] = array(
    'params' => array(),
    'functions' => array('use_admin'),
);

$ViewList['index'] = array(
    'params' => array(),
    'functions' => array('use_admin'),
);

$FunctionList['use_admin'] = array('explain' => 'Allow operator to configure Google Suggest');
