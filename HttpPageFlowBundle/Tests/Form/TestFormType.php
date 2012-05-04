<?php
/****
 *
 * Description:
 *      
 * $Id$
 * $Date$
 * $Rev$
 * $Author$
 * 
 *  This file is part of the $Project$ package.
 *
 * $Copyrights$
 *
 ****/
namespace Rock\OnSymfony\HttpPageFlowBundle\Tests\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilder;
use Symfony\Component\Validator\Constraints\Collection;
use Symfony\Component\Validator\Constraints\MinLength;


class TestFormType extends AbstractType
{
	public function buildForm(FormBuilder $builder, array $options)
	{
		$builder->add('sample', 'text', array('max_length'=>5));
	}
	public function getName()
	{
		return 'test_form';
	}
	public function getDefaultOptions(array $options)
	{
		$collectionConstraint = new Collection(array(
			'sample'  => new MinLength(array('limit' => 2, 'message'=> 'limit')),
		));
		return array('validation_constraint' => $collectionConstraint);
	}

}
