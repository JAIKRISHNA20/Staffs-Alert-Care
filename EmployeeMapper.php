<?php
class Default_Models_EmployeeMapper
{
	protected $_dbTable;

	public function setDbTable($dbTable)
	{
		if (is_string($dbTable))
		{
			$dbTable = new $dbTable();
		}
		if (!$dbTable instanceof Zend_Db_Table_Abstract)
		{
			throw new Exception('Invalid table data gateway provided');
		}
		$this->_dbTable = $dbTable;
		return $this;
	}

	public function getDbTable()
	{
		if (null === $this->_dbTable)
		{
			$this->setDbTable('Default_Models_DbTable_Employee');
		}
		return $this->_dbTable;
	}
	
	public function save(Default_Models_Employee $users) {
		$data = array(
			uid => $users->getUid(),	
			adminid => $users->getAdminid(),
			usercode => $users->getUsercode(),
			aadhar => $users->getAadhar(),
			email => $users->getEmail(),
			firstname => $users->getFirstname(),
			lastname=> $users->getLastname(),
			mobile => $users->getMobile(),
			address => $users->getAddress(),
			city => $users->getCity(),
			country => $users->getCountry(),
			zipcode => $users->getZipcode(),
			gender => $users->getGender(),
			dob => $users->getDob(),
			status => $users->getStatus(),
			otemail => $users->getOtemail(),
			otmobile => $users->getOtmobile(),
			bloodgroup => $users->getBloodgroup(),
		);
		
		if (null === ($uid = $users->getUid()))
		{
			unset($data['uid']);
			$data['created'] = date('Y-m-d H:i:s');
			$uid = $this->getDbTable()->insert($data);
			return $uid;
        }
		else
		{
			$data['updated'] = date('Y-m-d H:i:s');
			$this->getDbTable()->update($data, array('uid = ?' => $uid));
        }
	}

	public function find($uid, Default_Models_Employee $users)
	{
		$result = $this->getDbTable()->find($uid);        
		if (0 == count($result)) {
			return;
		}
		$entries   = array();
		$row = $result->current();
		$entries =		$users->setUid($row->uid)
				->setAadhar($row->aadhar)
				->setEmail($row->email)
				->setAdminid($row->adminid)
				->setUsercode($row->usercode)
				->setFirstname($row->firstname)
				->setLastname($row->lastname)
				->setMobile($row->mobile)
				->setAddress($row->address)
				->setCity($row->city)
				->setCountry($row->country)
				->setZipcode($row->zipcode)
				->setGender($row->gender)
				->setDob($row->dob)
				->setStatus($row->status)
				->setOtemail($row->otemail)
				->setOtmobile($row->otmobile)
				->setBloodgroup($row->bloodgroup);
	}

	public function fetchRow()
	{
		$row = $this->getDbTable()->fetchRow();        
		if (0 == count($row)) {
			return;
		}
		$entries   = array();
		$users = new Default_Models_Users();
		$entries =		$users->setUid($row->uid)
				->setAadhar($row->aadhar)
				->setEmail($row->email)
				->setFirstname($row->firstname)
				->setAdminid($row->adminid)
				->setUsercode($row->usercode)
				->setLastname($row->lastname)
				->setMobile($row->mobile)
				->setAddress($row->address)
				->setCity($row->city)
				->setCountry($row->country)
				->setZipcode($row->zipcode)
				->setGender($row->gender)
				->setDob($row->dob)
				->setStatus($row->status)
				->setOtemail($row->otemail)
				->setOtmobile($row->otmobile)
				->setBloodgroup($row->bloodgroup);
		return $entries;
	}

	public function fetchAll()
	{
		$resultSet = $this->getDbTable()->fetchAll();
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Default_Models_Users();
			$entries->setUid($row->uid);
			$entries->setAdminid($row->adminid);
			$entries->setUsercode($row->usercode);
			$entries->setAadhar($row->aadhar);
			$entries->setEmail($row->email);
			$entries->setFirstname($row->firstname);
			$entries->setLastname($row->lastname);
			$entries->setMobile($row->mobile);
			$entries->setAddress($row->address);
			$entries->setCity($row->city);
			$entries->setCountry($row->country);
			$entries->setZipcode($row->zipcode);
			$entries->setGender($row->gender);
			$entries->setDob($row->dob);
			$entries->setStatus($row->status);			
			$entries->setOtemail($row->otemail);			
			$entries->setOtmobile($row->otmobile);			
			$entries->setBloodgroup($row->bloodgroup);			
			
			$entries[] = $entry;
		}
		return $entries;
	}

	public function getEntries($where = '')
	{
		$resultSet = $this->getDbTable()->fetchAll($where);
		$entries   = array();
		foreach ($resultSet as $row) {
			$entry = new Default_Models_Users();
			$entries->setUid($row->uid);
			$entries->setAdminid($row->adminid);
			$entries->setUsercode($row->usercode);
			$entries->setAadhar($row->aadhar);
			$entries->setEmail($row->email);
			$entries->setFirstname($row->firstname);
			$entries->setLastname($row->lastname);
			$entries->setMobile($row->mobile);
			$entries->setAddress($row->address);
			$entries->setCity($row->city);
			$entries->setCountry($row->country);
			$entries->setZipcode($row->zipcode);
			$entries->setGender($row->gender);
			$entries->setDob($row->dob);
			$entries->setStatus($row->status);	
			$entries->setOtemail($row->otemail);	
			$entries->setOtmobile($row->otmobile);	
			$entries->setBloodgroup($row->bloodgroup);	
			$entries[] = $entry;
		}
		return $entries;
	}
}