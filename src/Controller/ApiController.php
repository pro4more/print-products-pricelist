<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/api")
 */
class ApiController extends AbstractController
{
    /**
     * @Route("/prices", name="prices")
     */
    public function prices(ProductRepository $productRepository, Request $request): Response
    {
        $discount = $request->query->get('discount', 0);
        if (!is_numeric($discount)) {
            return new JsonResponse('Invalid Query Parameter! Please use a numeric value.', 500);
        }

        $products = $productRepository->findAll();
        $multiDimData = [];
        foreach ($products as $product) {
            $multiDimData[$product->getId()] = [
                'name' => $product->getName(),
                'data' => array_map(function ($entry) use ($discount) {
                    $entry['data'] = array_map(function ($entry) use ($discount) {
                        $price = $entry->getPrice();
                        if (is_numeric($discount)) {
                            $price = intdiv($price * (100 - $discount) , 100);
                        }
                        return [
                            'copies' => $entry->getCopies(),
                            'price' => $price,
                        ];
                    }, $entry['data']);
                    return $entry;
                }, $product->getPricelistEntriesMultiDim()),
            ];
        }

        return $this->json($multiDimData);
    }
}
