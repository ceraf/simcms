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

    protected $fields = [
        'title' => [
                'name' => 'title',
                'type' => TextType::class,
                'params' => [
                    'label' => 'Название категории',
                    'required' => false,
                ],
				'constraints' => [
					['validclass' => NotBlank::class, 'message' => "Введите заголовок"]
				]
        ],
        'description' => [
                'name' => 'description',
                'type' => TextareaType::class,
                'params' => [
                    'label' => 'Описание категории',
                    'required' => false,
                    'attr' => array(
                        'rows' => '10',
                        'ckeditor' => 1
                    )
                ],
				'constraints' => [
					['validclass' => NotBlank::class, 'message' => "Введите Описание"]
				]
        ],
        'meta_title' => [
                'name' => 'meta_title',
                'type' => TextType::class,
                'params' => [
                    'label' => 'Мета заголовок',
                    'required' => false,
                ]
        ],
        'url' => [
                'name' => 'url',
                'type' => TextType::class,
                'params' => [
                    'label' => 'Ссылка',
                    'required' => false,
                ],
				'constraints' => [
					['validfunc' => 'checkUrl']
				]
        ],
        'preview' => [
                'name' => 'preview',
                'type' => PreviewType::class,
                'params' => [
					'data_class' => null,
                    'label' => 'Изображение',
                    'required' => false,
                    'attr' => array(
                        'path' => 'images/page/category/',
                    )
                ],
        ],
        'meta_keyboard' => [
                'name' => 'meta_keyboard',
                'type' => TextareaType::class,
                'params' => [
                    'label' => 'Мета ключевые слова',
                    'required' => false,
                    'attr' => array('rows' => '5')
                ]
        ],
        'meta_description' => [
                'name' => 'meta_description',
                'type' => TextareaType::class,
                'params' => [
                    'label' => 'Мета описание',
                    'required' => false,
                    'attr' => array('rows' => '5')
                ]
        ],
    ];
    
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->options = $options;

        foreach ($this->fields as $field) {
			if (isset($field['constraints'])) {
				$validparam = [];	
				$constraints = [];
				foreach($field['constraints'] as $constr) {

					if (isset($constr['message']))
						$validparam['message'] = $constr['message'];
                    if (isset($constr['validclass']))
                        $constraints[] = new $constr['validclass']($validparam);
                    elseif (isset($constr['validfunc']))
                        $constraints[] = new Callback([$this, $constr['validfunc']]);
                    //    $constraints[] = $this->$constr['validfunc']($validparam);
				}
				$field['params']['constraints'] = $constraints;
			}
			$builder->add($field['name'], $field['type'], $field['params']);
		}   
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
