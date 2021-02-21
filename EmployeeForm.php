<?php
class Default_Form_EmployeeForm extends Zend_Form
{
	public function __construct($options=array())
	{
		parent::__construct(array('decorators'=>array(
			'FormElements',
			'Fieldset',
			'Form',
		 ),'disableLoadDefaultDecorators' => true));

		$view = $this->getView();
		$this->setDisableLoadDefaultDecorators(true);
		$this->addPrefixPath('Default_Decorator_',APPLICATION_PATH . '/../library/Default/Decorator','decorator');
		$this->setMethod('post');
		
		if($view->profileaction == "add"){

		} else {
			$userid_element = new Zend_Form_Element_Hidden('uid',array(
						'value'	=> $view->row->uid));
			$userid_element->setDecorators(array('None'));
			$this->addElement($userid_element);
		}
		
		#--------------------------firstname-----------------------------------#
		$firstname_element  = new Zend_Form_Element_Text('firstname',array(
			'class'		=> 'form-control',
			'required'   => true,
			'value'   => $view->row->firstname,
			'placeholder'   => 'Firstname',
			'maxlength'   => '50',
			'filters'   => array('StringTrim','StripTags')
			));
		$firstname_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($firstname_element);
		 
		#--------------------------lastname-----------------------------------#
		$lastname_element  = new Zend_Form_Element_Text('lastname',array(
			'class'		=> 'form-control',
			'required'   => true,
			'value'   => $view->row->lastname,
			'placeholder'   => 'Lastname',
			'maxlength'   => '50',
			'filters'   => array('StringTrim','StripTags')
			));
		$lastname_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($lastname_element);
		 
		#--------------------------aadhar-----------------------------------#
		$aadhar_element  = new Zend_Form_Element_Text('aadhar',array(
			'class'		=> 'form-control allownumericwithoutdecimal',
			'required'   => true,
			'value'   => $view->row->aadhar,
			'placeholder'   => 'Aadhar',
			'maxlength'   => '12',
			'filters'   => array('StringTrim','StripTags')
			));
		$aadhar_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($aadhar_element);
		 
		#--------------------------email-----------------------------------#
		$email_element  = new Zend_Form_Element_Text('email',array(
			'class'		=> 'form-control',
			'required'   => true,
			'value'   => $view->row->email,
			'placeholder'   => 'Email',
			'maxlength'   => '50',
			'filters'   => array('StringTrim','StripTags')
			));
		$email_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($email_element);
		 
		#--------------------------mobile-----------------------------------#
		$mobile_element  = new Zend_Form_Element_Text('mobile',array(
			'class'		=> 'form-control allownumericwithoutdecimal',
			'required'   => true,
			'value'   => $view->row->mobile,
			'placeholder'   => 'Mobile',
			'maxlength'   => '10',
			'filters'   => array('StringTrim','StripTags')
			));
		$mobile_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($mobile_element);
		 
		#--------------------------address-----------------------------------#
		$address_element  = new Zend_Form_Element_Text('address',array(
			'class'		=> 'form-control',
			'required'   => false,
			'value'   => $view->row->address,
			'placeholder'   => 'Address',
			'filters'   => array('StringTrim','StripTags')
			));
		$address_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($address_element);
		 
		#--------------------------city-----------------------------------#
		$city_element  = new Zend_Form_Element_Text('city',array(
			'class'		=> 'form-control',
			'required'   => false,
			'value'   => $view->row->city,
			'placeholder'   => 'City',
			'filters'   => array('StringTrim','StripTags')
			));
		$city_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($city_element);
		 
		#--------------------------country-----------------------------------#
		$country_element  = new Zend_Form_Element_Text('country',array(
			'class'		=> 'form-control',
			'required'   => false,
			'value'   => $view->row->country,
			'placeholder'   => 'State',
			'filters'   => array('StringTrim','StripTags')
			));
		$country_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($country_element);
		 
		#--------------------------zipcode-----------------------------------#
		$zipcode_element  = new Zend_Form_Element_Text('zipcode',array(
			'class'		=> 'form-control allownumericwithoutdecimal',
			'required'   => false,
			'value'   => $view->row->zipcode,
			'placeholder'   => 'Zipcode',
			'maxlength'   => '6',
			'filters'   => array('StringTrim','StripTags')
			));
		$zipcode_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($zipcode_element);
		 
		#--------------------------gender-----------------------------------#
		$gender = array(
						"1" => "Male",
						"2" => "Female",
						"3" => "Other",
					);
		$gender_element  = new Zend_Form_Element_Select('gender',array(
			'class'		=> 'form-control',
			'required'   => true,
			'value'   => $view->row->gender,
			'filters'   => array('StringTrim','StripTags')
			));
		$gender_element->addMultiOptions($gender);
		$gender_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($gender_element);
		 
		#--------------------------dob-----------------------------------#
		$dob_element  = new Zend_Form_Element_Text('dob',array(
			'class'		=> 'form-control dobdatepicker',
			'required'   => false,
			'readonly'   => true,
			'value'   => $view->row->dob,
			'placeholder'   => 'Date of Birth',
			'filters'   => array('StringTrim','StripTags')
			));
		$dob_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($dob_element);
		
		#--------------------------status-----------------------------------#
		$status = array(
						"1" => "Active",
						"2" => "InActive",
					);
		$status_element  = new Zend_Form_Element_Select('status',array(
			'class'		=> 'form-control',
			'required'   => true,
			'value'   => $view->row->status,
			'filters'   => array('StringTrim','StripTags')
			));
		$status_element->addMultiOptions($status);
		$status_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($status_element);
		 
		#--------------------------otemail-----------------------------------#
		$otemail_element  = new Zend_Form_Element_Text('otemail',array(
			'class'		=> 'form-control',
			'required'   => false,
			'value'   => $view->row->otemail,
			'placeholder'   => 'Other Email',
			'maxlength'   => '150',
			'filters'   => array('StringTrim','StripTags')
			));
		$otemail_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($otemail_element);
		 
		#--------------------------otmobile-----------------------------------#
		$otmobile_element  = new Zend_Form_Element_Text('otmobile',array(
			'class'		=> 'form-control allownumericwithoutdecimal',
			'required'   => false,
			'value'   => $view->row->otmobile,
			'placeholder'   => 'Other Mobile',
			'maxlength'   => '10',
			'filters'   => array('StringTrim','StripTags')
			));
		$otmobile_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($otmobile_element);
		 
		#--------------------------bloodgroup-----------------------------------#
		$bloodgroup_element  = new Zend_Form_Element_Text('bloodgroup',array(
			'class'		=> 'form-control',
			'required'   => false,
			'value'   => $view->row->bloodgroup,
			'placeholder'   => 'Bloodgroup',
			'maxlength'   => '10',
			'filters'   => array('StringTrim','StripTags')
			));
		$bloodgroup_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($bloodgroup_element);
	}
}
