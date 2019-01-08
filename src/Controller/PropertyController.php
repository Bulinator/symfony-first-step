<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Knp\Component\Pager\PaginatorInterface;
use App\Entity\PropertySearch;
use App\Form\PropertySearchType;

class PropertyController extends AbstractController
{
    /**
     * @var PropertyRepository
     */
    private $repository;

    /**
     * if only one, it can be inject into the current method
     * but better way to inject them into the __construct
     *
     */
    public function __construct(PropertyRepository $repository)
    {
        $this->repository = $repository;
        //$this->em = $em;
    }

    /**
     * @Route("/property", name="property.index")
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
        // create entity research
        // create form
        // create request into controller
        $search = new PropertySearch();
        $form = $this->createForm(PropertySearchType::class, $search);
        $form->handleRequest($request);

        $properties = $paginator->paginate(
          $this->repository->findAllVisibleQuery($search),
          $request->query->getInt('page', 1),
          12
        );
        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/good/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     * @param Property
     */
    public function show(Property $property, string $slug): Response
    {
        //$property = $this->repository->find($id);
        if ($property->getSlug() !== $slug) {
            return $this->redirectToRoute('property.show', [
                  'id' => $property->getId(),
                  'slug' => $property->getSlug()
            ], 301);
        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'current_menu' => 'properties'
        ]);
    }
}
