<?php
namespace App\Controller\admin;

use App\Entity\Picture;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class PictureController
 * @package App\Controller\admin
 * @Route("/admin/picture")
 */
class PictureController extends AbstractController
{
    /**
     * @Route("/{id}", name="admin.picture.delete", methods="DELETE")
     * @param Picture $picture
     * @return JsonResponse
     */
    public function delete(Picture $picture, Request $request)
    {
        $data = json_decode($request->getContent(), true);
        if ($this->isCsrfTokenValid('delete'.$picture->getId(), $data['_token'])) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($picture);
            $entityManager->flush();
            return new JsonResponse(['success' => 1]);
        }

        //return $this->redirectToRoute('admin.property.edit', ['id' => $propertyId]);
        return new JsonResponse(['error' => 'Token invalid'], 400);
    }
}