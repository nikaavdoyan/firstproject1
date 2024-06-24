<?php

namespace App\Controller;

use App\Repository\RecipeetRepository;
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
}
