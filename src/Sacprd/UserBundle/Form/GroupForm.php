<?php

namespace Sacprd\UserBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sacprd\AdminBundle\Model\PreviewType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class GroupForm extends AbstractType
{
    protected $title;
    protected $description;
    protected $options;
	
    protected $formName = 'groups';

    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->options = $options;

        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'Название группы',
                'required' => false,
                'attr' => [
                    'size' => '6'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Введите название'])
                ]
            ]
        );
        
        $builder->add(
            'role',
            TextType::class,
            [
                'label' => 'Роль',
                'required' => false,
                'attr' => [
                    'size' => '6'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Введите роль'])
                ]
            ]
        );
        
        $builder->add(
            'description',
            TextareaType::class,
            [
                'label' => 'Описание группы',
                'required' => false,
                'attr' => array(
                    'rows' => '10',
                    'size' => '12',
                    'ckeditor' => 1
                ),
                'constraints' => [
                    new NotBlank(['message' => 'Введите описание'])
                ]
            ]
        );        
    }
        
    public function getName()
    {
        return $this->formName;
    }

    public function getFields()
    {
        return $this->fields;
    }
    
    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title)
    {
        $this->title = $title;
    }
    
    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription($description)
    {
        $this->description = $description;
    }
    
    public static function loadValidatorMetadata(ClassMetadata $metadata)
    {
        $metadata->addPropertyConstraint('title', new NotBlank());
        $metadata->addPropertyConstraint('description', new NotBlank());
    }
    
    public function setDefaultOptions(array $options)
    {
        return array(
            'data_class' => 'Sacprd\UserBundle\Entity\Group',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => 'task_item',
        );
    }

}
