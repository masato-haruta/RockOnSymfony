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
// <Namespace>
namespace Rock\OnSymfony\HttpPageFlowBundle\Configuration;

// <Base>
use Rock\Components\Flow\Configuration\Configuration;

// <Interface>
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ConfigurationInterface;


/**
 * @Annotation
 */
class Flow Extends Configuration
  implements
    ConfigurationInterface
{
    /**
     * 
     *
     * @return string 'flow'
     */
    public function getAliasName()
	{
	    return 'flow';
	}
}
