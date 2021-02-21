<?php 
class Default_Models_AdminAuth 
{
	/**
	 * auth adapter
	 *
	 * @var zend_auth_adapter
	 */
	private $_authAdapter;
	
	private $_dbAdapter;
	
	/**
	 * the passed username
	 *
	 * @var string
	 */
	private $_username;
	
	/**
	 * the passed password
	 *
	 * @var string
	 */
	private $_password;
	
	/**
	 * the user session storage
	 *
	 * @var zend_session_namespace
	 */
	private $_storage;
	
	/**
	 * the table that contains the user credentials
	 *
	 * @var string
	 */
	private $_userTable = "adminusers";
	
	/**
	 * the indentity column
	 *
	 * @var string
	 */
	private $_identityColumn = "userName";
	
	/**
	 * the credential column
	 *
	 * @var string
	 */
	private $_credentialColumn = "userPassword";
	
	
	/**
	 * build the login request
	 *
	 * @param string $username
	 * @param string $password
	 */
	public function __construct($username, $password)
	{
		//set up the db authentication
		//$this->_dbAdapter = clone (Zend_Db_Table::getDefaultAdapter());
		$registry = Zend_Registry::getInstance();
		if (isset($registry->dbAdapter)) {
			$this->_dbAdapter = $registry->dbAdapter;
		}
	
		$this->_authAdapter = new Zend_Auth_Adapter_DbTable($this->_dbAdapter, 'adminusers', 'userName', 'userPassword',"?");
		
		$this->_username = $username;
		$this->_password = md5($password);
		$this->_storage = new Zend_Session_Namespace('adminuserdata');
	}
	
	/**
	 * authenticate the request
	 *
	 * @return zend_auth_response
	 */
	public function authenticate()
	{
		//authenticate the user
		$this->_authAdapter->setIdentity($this->_username);
		$this->_authAdapter->setCredential($this->_password);
		
		$result = $this->_authAdapter->authenticate();
	
		if($result->isValid())
		{
			//save the user and return the result
			$row = $this->_authAdapter->getResultRowObject(array('userId','userName', 'userType'));
			$this->_storage->user = $row;
			return $result;
		}
	}
	
	/**
	 * get the current user identity if it exists
	 *
	 * @return zend_auth_response
	 */
	static function getIdentity()
	{
		$storage = new Zend_Session_Namespace('adminuserdata');
		if(isset($storage->user)){
		  return $storage->user;
		}
	}
	
	/**
	 * destroys the current user session
	 *
	 */
	static function destroy()
	{
		$storage = new Zend_Session_Namespace('adminuserdata');
		$storage->unsetAll();
	}

}