<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  constant.php
 * Project Name                -  AssignSeat
 * @Version                   -  1.0
 * Created by                  -  Chetan Sharma
 * Created on                  -  July 29, 2013
 * ***************************** Update Log ********************************
 * Sr.NO.		Version		Updated by           Updated on          Description
 * -------------------------------------------------------------------------
 * 
 * *************************************************************************
 */
define ( 'SITE_URL', 'http://'.$_SERVER['HTTP_HOST'].'/' );

/*
* Absolute directory path like /var/www/AssignSeat/trunk/development/
*/
define ( 'SITE_PATH', getcwd () );

/*
* Database server
*/
define ( 'DB_SERVER', "localhost" );

/*
* Database user name
*/
define ( 'DB_USER', "root" );

/*
* Database password
*/
define ( 'DB_PASSWORD', "root" );

/*
* Database type
*/
define ( 'DB_TYPE', "mysql" );

/*
* Database name
*/
define ( 'DB_COMMON', "assign_seat" );

/*
* Version
*/
define ( 'VERSION', "1.0" );



