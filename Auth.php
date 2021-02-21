<?php
class Default_Form_Auth extends Zend_Form
{
public function __construct($options=array())
{
		parent::__construct(array('decorators'=>array(
		'FormElements',
		'Fieldset',
        'Form',
     ),'disableLoadDefaultDecorators' => true));
		$this->setDisableLoadDefaultDecorators(true);
	    $this->addPrefixPath('Default_Decorator_',APPLICATION_PATH . '/../library/Default/Decorator','decorator');
       $this->setMethod('post');

		$email_element = new Zend_Form_Element_Text('useremail',array(
			'class'		=> 'login-inp',
			'placeholder'		=> 'Username',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags')));
		$email_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($email_element);

		$password_element = new Zend_Form_Element_Password('password',array(
			'class'		=> 'login-inp',
			'placeholder'		=> 'Password',
            'required'   => true,
            'filters'    => array('StringTrim','StripTags')
			));
		$password_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($password_element);

		$remember_element = new Zend_Form_Element_Checkbox('rememberme',array(
			'class'		=> 'checkbox-size',
			'id' => 'login-check',
            'required'   => false,
            'filters'    => array('StringTrim','StripTags')));
		$remember_element->setDecorators(array('CompositeNoLabel'));
		$this->addElement($remember_element);

		$this->setDecorators(array(array('ViewScript', array('viewScript' => 'index.phtml'))));
    }
}
