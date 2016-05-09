<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

$config = array('signup' => array(
                                    array(
                                            'field' => 'firstName',
                                            'label' => 'First Name',
                                            'rules' => 'required'
                                         ),
                                   	array(
                                            'field' => 'lastName',
                                            'label' => 'Last Name',
                                            'rules' => 'required'
                                         ),
                                   	array(
						                    'field'   => 'email',
						                    'label'   => 'Email',
						                    'rules'   => 'required'
						                 ),
                                    array(
                                            'field' => 'password',
                                            'label' => 'Password',
                                            'rules' => 'required|matches[cpassword]'
                                         ),
                                    array(
                                            'field' => 'cpassword',
                                            'label' => 'Password Confirmation',
                                            'rules' => 'required'
                                         ),
                                    array(
						                    'field'   => 'mobile',
						                    'label'   => 'Phone no.',
						                    'rules'   => 'required'
						                 ),
						            array(
						                    'field'   => 'birthDate',
						                    'label'   => 'Birth Month',
						                    'rules'   => 'required'
						                 ),      
						            array(
						                    'field'   => 'address',
						                    'label'   => 'Address',
						                    'rules'   => 'required'
						                 )   
                                   	
                                    ),
                 'email' => array(
                                    array(
                                            'field' => 'emailaddress',
                                            'label' => 'EmailAddress',
                                            'rules' => 'required|valid_email'
                                         ),
                                    array(
                                            'field' => 'name',
                                            'label' => 'Name',
                                            'rules' => 'required|alpha'
                                         ),
                                    array(
                                            'field' => 'title',
                                            'label' => 'Title',
                                            'rules' => 'required'
                                         ),
                                    array(
                                            'field' => 'message',
                                            'label' => 'MessageBody',
                                            'rules' => 'required'
                                         )
                                    )                          
               );


/* End of file form_validation.php */
/* Location: ./application/config/form_validation.php */
