<?php

namespace App\Form;
use DeepCopy\f001\A;
use App\Entity\Recipeet;
use App\Entity\Ingredient;
use App\Repository\IngredientRepository;
use Symfony\Component\Form\AbstractType;
use phpDocumentor\Reflection\Types\Integer;
use Webmozart\Assert\Assert as AssertAssert;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\MoneyType;
use Symfony\Component\Form\Extension\Core\Type\RangeType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;

class RecipeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('name',TextType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'minlength'=>2,
                    'maxlength'=>50
                ],
                'label'=>'Nom',
                'label_attr'=>[
                    'class' => 'form-label mt-4'
                ],
                'constraints'=>[
                    new  Assert\Length(['min'=>2, 'max'=>50]),
                    new Assert\NotBlank()
                ]

            ])
            ->add('time',IntegerType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'min'=>1,
                    'max'=>1440
                ],
                'label'=>'temps (en minutes)',
                'label_attr'=>[
                    'class' => 'form-label mt-4'
                ],
                'constraints'=>[
                new Assert\Positive(),
                new Assert\LessThan(1441)
                ]
            ])
            ->add('nbpeople',IntegerType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'min'=>1,
                    'max'=>1440
                ],
                'required'=>false,
                'label'=>'nombre de personnes',
                'label_attr'=>[
                    'class' => 'form-label mt-4'
                ],
                'constraints'=>[
                new Assert\Positive(),
                new Assert\LessThan(51)
                ]
                ]
            )
            ->add('difficulty',RangeType::class,[
                'attr'=>[
                    'class'=>'form-range',
                    'min'=>1,
                    'max'=>1440
                ],
                'required'=>false,
                'label'=>'Difficulté',
                'label_attr'=>[
                    'class' => 'form-label mt-4'
                ],
                'constraints'=>[
                new Assert\Positive(),
                new Assert\LessThan(5)
                ]
            ])
            ->add('description',TextareaType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'min'=>1,
                    'max'=>1440
                ],
                'label'=>'Description',
                'label_attr'=>[
                    'class' => 'form-label mt-4'
                ],
                'constraints'=>[
                new Assert\NotBlank()
                
                ]
            ])
            ->add('price',MoneyType::class,[
                'attr'=>[
                    'class'=>'form-control',
                    'min'=>1,
                    'max'=>1440
                ],
                'required'=>false,
                'label'=>'Prix',
                'label_attr'=>[
                    'class' => 'form-label mt-4'
                ],
                'constraints'=>[
                    new Assert\Positive(),
                    new Assert\LessThan(1001)
                ]
            ])
            ->add('isfavorite',CheckboxType::class,[
                'attr'=>[
                    'class'=>'form-check-input mt-4',
               
                ],
                'required' => false,
                'label'=>'Favori?',
                'label_attr'=>[
                    'class' => 'form-label mt-4'
                ],
                'constraints'=>[
                new Assert\NotNull()
                
                ]
            ])
            ->add('ingredients',EntityType::class,[
                'label'=>'Les ingredients ',
                'label_attr'=>[
                    'class'=>'form-label mt-4'
                ],
                'class'=>Ingredient::class,
                'query_builder' => function (IngredientRepository $r){
                    return $r->createQueryBuilder('i')
                    ->orderBy('i.name', 'ASC');
                },
                'choice_label'=>'name',
                'multiple'=>'true',
                'expanded'=>'true'
            ])
            ->add('submit',SubmitType::class,[
                'attr'=>['
                class'=>'btn btn-primary mt-4'
                    
            ],
            'label'=> 'créer ma rectte'
        ]);
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Recipeet::class,
        ]);
    }
}
