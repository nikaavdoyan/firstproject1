<?php

namespace App\Controller;

use App\Entity\Recipeet;
use App\Form\RecipeType;
use App\Repository\IngredientRepository;
use App\Repository\RecipeetRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class RecipeetController extends AbstractController
{
    /**
     * show the all recipes
     *
     * @param RecipeetRepository $recipeetRepository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */
    
    
    #[Route('/recipeet', name: 'app_recipeet')]
    public function index(RecipeetRepository $recipeetRepository,PaginatorInterface $paginator, Request $request): Response
    {
        $recipes =$paginator->paginate(
            $recipeetRepository->findAll(),
            $request->query->getInt('page', 1),
            10
        );


        return $this->render('pages/recipeet/index.html.twig', [
            
            'recipeet' => $recipes,
        ]);
    }

    #[Route('/recipeet/creation', name: 'app_recipe_new',methods:['GET','POST'])]
    public function new(Request $request, EntityManagerInterface $manager) : Response
    {
        $recipe = new Recipeet();
        $form = $this->createForm(RecipeType::class, $recipe);
        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            dd($form->getData());

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été crée avec succès'
            );
            return $this->redirectToRoute('app_recipe');
        }

        
        return $this->render('pages/recipeet/new.html.twig',[
            'form' =>$form->createView(),
        ]);
    }

    #[Route('/recipeet/edition/{id}', name:'app_recipe_edit',methods:['GET','POST'])]
    public function edit(RecipeetRepository $recipeetRepository,int $id,Request $request,EntityManagerInterface $manager,):Response
    {
        $recipe = $recipeetRepository->findOneBy(['id'=>$id]);
        $form = $this->createForm(RecipeType::class);

        
        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){

            $manager->persist($recipe);
            $manager->flush();

            $this->addFlash(
                'success',
                'Votre recette a été modifiée avec succès'
            );
            return $this->redirectToRoute('app_recipe');
        }

        
        return $this->render('pages/recipeet/new.html.twig',[
            'form' =>$form->createView(),
        ]);
        
        return $this->render('pages/recipe/edit.html.twig');
    }

    #[Route('/recipeet/suppression/{id}', name:'app_recipe_delete',methods:['GET','POST'])]
    public function delete(RecipeetRepository $recipeetRepository,int $id,IngredientRepository $ingredientRepository,EntityManagerInterface $manager,):Response
    {
        $recipe = $ingredientRepository->findOneBy(["id"=>$id]);
        //verification si l'ingredient existe
        if(!$recipe){
            $this->addFlash(
                'success',
                "Votre recette n'a pas été retrouvée"
            );
            return $this->redirectToRoute('app_ingredient');
        }

        $manager->persist($recipe);
        $manager->flush();

        $this->addFlash(
            'success',
            "Votre recette a  été supprimer avec succès"
        );
        return $this->redirectToRoute('app_recipe');
}

}