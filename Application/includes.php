<?php

include(__DIR__ . '/Session.php');
include(__DIR__ . '/Database.php');
include(__DIR__ . '/Auth.php');

Session::set('auth', ['logged_in' => false]);
$auth = Auth::getInstance();