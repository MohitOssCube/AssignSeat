<?php
/**
 * **************************** Creation Log *******************************
 * File Name                   -  DBconnect.php
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
include('PDO/cxpdo.php');
abstract class DBConnection
{
    protected $_db;
    private $_config = array();
    /**
     *  Set all database paremeters
     */ 
    public function __construct ()
    {
        $this->_config['DATABSE_USER_NAME'] = DB_USER;
        $this->_config['DATABSE_PASSWORD'] = DB_PASSWORD;
        $this->_config['DATABASE_NAME'] = DB_COMMON;
        $this->_config['DATABASE_HOST'] = DB_SERVER;
        $this->_config['DATABASE_TYPE'] = DB_TYPE;
        $this->_config['DATABASE_PORT'] = null;
        $this->_config['DATABASE_PERSISTENT'] = true;
        $this->_db = db::instance($this->_config);
    }
}