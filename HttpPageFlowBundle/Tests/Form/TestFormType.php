<?php
/****
 *
 * Description:
 *      
 * 
 * $Date$
 * Rev    : see git
 * Author : Yoshi Aoki <yoshi@44services.jp>
 * 
 *  This file is part of the Rock package.
 *
 * For the full copyright and license information, 
 * please read the LICENSE file that is distributed with the source code.
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
