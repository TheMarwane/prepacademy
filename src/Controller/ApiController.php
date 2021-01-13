<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Item;
use App\Service\ApiService;
use App\Service\ContestService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Pokemon controller.
 *
 * @Route("api/pokemon")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/create-categ",name="create_categ",methods={"POST"},options={"expose":true})
     * @param Request $request
     * @return JsonResponse
     */
    public function newCateg(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $categ = new Category();
        $categ->setParent($data['parent']);
        $categ->setName($data['name']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($categ);
        $em->flush();

        return new JsonResponse($categ);
    }

    /**
     * @Route("/delete-categ/{id}",name="delete_categ",methods={"DELETE"},options={"expose":true})
     * @param Category $categ
     * @return JsonResponse
     */
    public function deleteCateg(Category $categ): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($categ);
        $em->flush();

        return new JsonResponse(true);
    }

    /**
     * @Route("/create-item",name="create_item",methods={"POST"},options={"expose":true})
     * @param Request $request
     * @return JsonResponse
     */
    public function newItem(Request $request): JsonResponse
    {
        $data = json_decode($request->getContent(), true);
        $item = new Item();
        $item->setCategories($data['categories']);
        $item->setName($data['name']);

        $em = $this->getDoctrine()->getManager();
        $em->persist($item);
        $em->flush();

        return new JsonResponse($item);
    }

    /**
     * Supprime un item
     *
     * @Route("/delete-item/{id}",name="delete_item",methods={"DELETE"},options={"expose":true})
     * @param Item $item
     * @return JsonResponse
     */
    public function deleteItem(Item $item): JsonResponse
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($item);
        $em->flush();

        return new JsonResponse(true);
    }

    /**
     * Retourne le nombre total d'items contenus dans la catégorie demandée
     * et dans ses catégories filles
     *
     * @Route("/get-nb-item/{id}",name="get_nb_item",methods={"GET"},options={"expose":true})
     * @param Category $categ
     * @param ApiService $service
     * @return JsonResponse
     */
    public function getNbItem(Category $categ, ApiService $service): JsonResponse
    {
        $count = $service->getNbItemsByCateg($categ);

        return new JsonResponse($count);
    }


    /**
     * @Route("/contest-reward",name="contest_reward",methods={"POST"},options={"expose":true})
     * @param Request $request
     * @param ContestService $service
     * @return JsonResponse
     */
    public function getContestReward(Request $request, ContestService $service): JsonResponse
    {
        $data = json_decode($request->getContent(), true);

        return new JsonResponse($service->getRewards($data['winnings'], $data['chaine']));
    }

    /**
     * @Route("/nearest-zero",name="nearest_zero",methods={"POST"},options={"expose":true})
     * @param Request $request
     * @param ContestService $service
     * @return JsonResponse
     */
    public function getNearestToZero(Request $request, ContestService $service): JsonResponse
    {
        return new JsonResponse($service->getNearestToZero(
            json_decode($request->getContent())
        ));
    }
}