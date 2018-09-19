<?php

namespace Sacprd\AdminBundle\Model;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;

class UserpasswordType extends AbstractType
{
    public function getParent()
    {
        return PasswordType::class;
    }
	
    public function getName()
    {
        return 'userpassword';
    }
}