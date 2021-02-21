<?php
class Default_Models_Employee
{
  protected $_uid;
  protected $_adminid;
  protected $_usercode;
  protected $_firstname;
  protected $_lastname;
  protected $_aadhar;
  protected $_email;
  protected $_mobile;
  protected $_address;
  protected $_city;
  protected $_country;
  protected $_zipcode;
  protected $_gender;
  protected $_dob;
  protected $_status;
  protected $_otemail;
  protected $_otmobile;
  protected $_bloodgroup;
  protected $_created;
  protected $_updated;
  protected $_mapper;

	public function __construct(array $options = null)
	{
		if (is_array($options))
		{
			$this->setOptions($options);
		}
	}

	public function __set($name, $value)
	{
		$method = 'set' . $name;
			if (('mapper' == $name) || !method_exists($this, $method))
			{
				throw new Exception('Invalid Employee property');
			}
		$this->$method($value);
	}

	public function __get($name)
	{
		$method = 'get' . $name;
			if (('mapper' == $name) || !method_exists($this, $method))
			{
				throw new Exception('Invalid Employee property');
			}
		return $this->$method();
	}

	public function setOptions(array $options)
	{
		$methods = get_class_methods($this);
			foreach ($options as $key => $value)
			{
				$method = 'set' . ucfirst($key);
				if (in_array($method, $methods))
				{
					$this->$method($value);
				}
			}
		return $this;
	}

	#-----------------------uid--------------------------------------#
	public function setUid($uid)
	{
		$this->_uid = (string)$uid;
		return $this;
	}
	
	public function getUid()
	{
		return $this->_uid;
	}
	
	#-----------------------adminid--------------------------------------#
	public function setAdminid($adminid)
	{
		$this->_adminid = (string)$adminid;
		return $this;
	}
	
	public function getAdminid()
	{
		return $this->_adminid;
	}
	
	#-----------------------usercode--------------------------------------#
	public function setUsercode($usercode)
	{
		$this->_usercode = (string)$usercode;
		return $this;
	}
	
	public function getUsercode()
	{
		return $this->_usercode;
	}
	#-----------------------firstname--------------------------------------#
	public function setFirstname($firstname)
	{
		$this->_firstname = (string)$firstname;
		return $this;
	}
	
	public function getFirstname()
	{
		return $this->_firstname;
	}
	#-----------------------lastname--------------------------------------#
	public function setLastname($lastname)
	{
		$this->_lastname = (string)$lastname;
		return $this;
	}
	
	public function getLastname()
	{
		return $this->_lastname;
	}
	#-----------------------aadhar--------------------------------------#
	public function setAadhar($aadhar)
	{
		$this->_aadhar = (string)$aadhar;
		return $this;
	}
	
	public function getAadhar()
	{
		return $this->_aadhar;
	}
	#-----------------------email--------------------------------------#
	public function setEmail($email)
	{
		$this->_email = (string)$email;
		return $this;
	}
	
	public function getEmail()
	{
		return $this->_email;
	}
	#-----------------------mobile--------------------------------------#
	public function setMobile($mobile)
	{
		$this->_mobile = (string)$mobile;
		return $this;
	}
	
	public function getMobile()
	{
		return $this->_mobile;
	}
	#-----------------------address--------------------------------------#
	public function setAddress($address)
	{
		$this->_address = (string)$address;
		return $this;
	}
	
	public function getAddress()
	{
		return $this->_address;
	}
	#-----------------------city--------------------------------------#
	public function setCity($city)
	{
		$this->_city = (string)$city;
		return $this;
	}
	
	public function getCity()
	{
		return $this->_city;
	}
	#-----------------------country--------------------------------------#
	public function setCountry($country)
	{
		$this->_country = (string)$country;
		return $this;
	}
	
	public function getCountry()
	{
		return $this->_country;
	}
	#-----------------------zipcode--------------------------------------#
	public function setZipcode($zipcode)
	{
		$this->_zipcode = (string)$zipcode;
		return $this;
	}
	
	public function getZipcode()
	{
		return $this->_zipcode;
	}
	#-----------------------gender--------------------------------------#
	public function setGender($gender)
	{
		$this->_gender = (string)$gender;
		return $this;
	}
	
	public function getGender()
	{
		return $this->_gender;
	}
	#-----------------------dob--------------------------------------#
	public function setDob($dob)
	{
		$this->_dob = (string)$dob;
		return $this;
	}
	
	public function getDob()
	{
		return $this->_dob;
	}
	#-----------------------status--------------------------------------#
	public function setStatus($status)
	{
		$this->_status = (string)$status;
		return $this;
	}
	
	public function getStatus()
	{
		return $this->_status;
	}	
	#-----------------------otemail--------------------------------------#
	public function setOtemail($otemail)
	{
		$this->_otemail = (string)$otemail;
		return $this;
	}
	
	public function getOtemail()
	{
		return $this->_otemail;
	}	
	#-----------------------otmobile--------------------------------------#
	public function setOtmobile($otmobile)
	{
		$this->_otmobile = (string)$otmobile;
		return $this;
	}
	
	public function getOtmobile()
	{
		return $this->_otmobile;
	}	
	#-----------------------bloodgroup--------------------------------------#
	public function setBloodgroup($bloodgroup)
	{
		$this->_bloodgroup = (string)$bloodgroup;
		return $this;
	}
	
	public function getBloodgroup()
	{
		return $this->_bloodgroup;
	}	
	#-------------------------------------------------------------#
	public function setCreated($created)
	{
		$this->_created = (string)$created;
		return $this;
	}
	
	public function getCreated()
	{
		return $this->_created;
	}

	#-------------------------------------------------------------#
	public function setUpdated($updated)
	{
		$this->_updated=(string)$updated;
		return $this;
	}
	
	public function getUpdated()
	{
		return $this->_updated;
	}	
#-------------------------------------------------------------#
    public function setMapper($mapper)
    {
        $this->_mapper = $mapper;
        return $this;
    }

    public function getMapper()
    {
        if (null === $this->_mapper) {
            $this->setMapper(new Default_Models_EmployeeMapper());
        }
        return $this->_mapper;
    }
	#-------------------------------------------------------------#
    public function save()
    {
        return $this->getMapper()->save($this);
    }
	#-------------------------------------------------------------#
    public function find($dfsId)
    {        
        $this->getMapper()->find($dfsId, $this);
        return $this;
    }
	#-------------------------------------------------------------#
	public function fetchRow()
	{
		return $this->getMapper()->fetchRow();
	}
	#-------------------------------------------------------------#
    public function fetchAll()
    {
        return $this->getMapper()->fetchAll();
    }
	#-------------------------------------------------------------#
    public function getEntries($where)
    {
        return $this->getMapper()->getEntries($where, $this);
    }
}