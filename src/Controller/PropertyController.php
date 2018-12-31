<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

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
    public function index(): Response
    {
        // tuto => insert one flat at least in database
        // $property = new Property();
        // // set property (dev)
        // $property
        //   ->setTitle('My first flat')
        //   ->setPrice(200000)
        //   ->setRoom(4)
        //   ->setBedrooms(2)
        //   ->setDescription('Short description')
        //   ->setSurface(200)
        //   ->setFloor(2)
        //   ->setHeat(1)
        //   ->setCity('Brussels')
        //   ->setAddress('Rue marché aux poulets')
        //   ->setPostalCode(1000);
        //
        // // register entity into db
        // $em = $this->getDoctrine()->getManager();
        // $em->persist($property);
        // $em->flush(); // update all change in database

        // get record
        //$repository = $this->getDoctrine()->getRepository(Property::class);
        //dump($repository);
        // $property = $this->repository->findAllVisible();
        // dump($property);
        // $this->em->flush();

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties'
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
