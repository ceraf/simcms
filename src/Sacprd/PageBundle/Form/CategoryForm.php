<?php

namespace Sacprd\PageBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Type;
use Symfony\Component\Validator\Constraints\Callback;
use Symfony\Component\Validator\Context\ExecutionContextInterface;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Sacprd\Core\PreviewType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

use Symfony\Component\DependencyInjection\ContainerAwareInterface;

class CategoryForm extends AbstractType
{
    protected $title;
	protected $preview;
    protected $description;
    protected $meta_title;
    protected $meta_keyboard;
    protected $meta_description;
    protected $url;
    protected $options;
	
    protected $formName = 'page_category';

    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->options = $options;

        $builder->add(
            'title',
            TextType::class,
            [
                'label' => 'Название категории',
                'required' => false,
                'attr' => [
                    'size' => '6'
                ],
                'constraints' => [
                    new NotBlank(['message' => 'Введите заголовок'])
                ]
            ]
        );
        
        $builder->add(
            'description',
            TextareaType::class,
            [
                'label' => 'Описание категории',
                'required' => false,
                'attr' => array(
                    'rows' => '10',
                    'size' => '6',
                    'ckeditor' => 1
                ),
                'constraints' => [
                    new NotBlank(['message' => 'Введите описание'])
                ]
            ]
        );        
        
        $builder->add(
            'meta_title',
            TextType::class,
            [
                'label' => 'Мета заголовок',
                'required' => false,
            ]
        );

        $builder->add(
            'seo',
            EntityType::class,
                   array('choice_label' => 'url',
                        'class' => 'SacprdSeoBundle:Rewrite')
        );
        
        $builder->add(
            'url',
            TextareaType::class,
            [
                'label' => 'Ссылка',
                'required' => false,
                'constraints' => [
                    new Callback([$this, 'checkUrl'])
                ]
            ]
        ); 
        
        $builder->add(
            'preview',
            PreviewType::class,
            [
					'data_class' => null,
                    'label' => 'Изображение',
                    'required' => false,
                    'attr' => array(
                        'path' => 'images/page/category/',
                    )
                ]
        );

        $builder->add(
            'meta_keyboard',
            TextareaType::class,
            [
                    'label' => 'Мета ключевые слова',
                    'required' => false,
                    'attr' => array('rows' => '5')
                ]
        );        
        
        $builder->add(
            'meta_description',
            TextareaType::class,
            [
                    'label' => 'Мета описание',
                    'required' => false,
                    'attr' => array('rows' => '5')
                ]
        );  
    }
    
    public function checkUrl($data, ExecutionContextInterface $context)
    { 
        if ($this->options['data']->getId()) {
            global $kernel;
            $this->container = $kernel->getContainer();
            $em = $this->container->get('doctrine');
            $oldcateg = $em
                ->getRepository('Sacprd\PageBundle\Entity\Category')
                ->findBy(array('url' => $data));

            foreach($oldcateg as $item) {
                if ($item->getId() != $this->options['data']->getId())
                    $context->buildViolation('Этот адрес уже есть в системе.')->addViolation();
                else
                    continue;
            }
        }          
    }
    
    
    public function getName()
    {
        return $this->formName;
    }
    
    public function getFields()
    {
        return $this->fields;
    }
    
    public function getUrl()
    {
        return $this->url;
    }

    public function setUrl($title)
    {
        $this->title = $url;
    }
    
    public function getPreview()
    {
        return $this->preview;
    }

    public function setPreview($preview)
    {
        $this->preview = $preview;
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
            'data_class' => 'Sacprd\PageBundle\Entity\Category',
            'csrf_protection' => true,
            'csrf_field_name' => '_token',
            'intention' => 'task_item',
        );
    }

}
