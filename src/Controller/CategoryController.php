<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\ProgramRepository;
use App\Repository\CategoryRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route("/category", name: "category_")]
class CategoryController extends AbstractController
{
    #[Route("/", name: "index")]
    public function index(CategoryRepository $categoryRepository): Response
    {
        $categories = $categoryRepository->findAll();

        return $this->render(
            "category/index.html.twig",
            ["categories" => $categories]
        );
    }

    #[Route("/{categoryName}", name: "show", methods: ["GET"])]
    public function show(string $categoryName, CategoryRepository $categoryRepository, ProgramRepository $programRepository): Response
    {
        $category = $categoryRepository->findOneByName($categoryName);

        if (!$category) {
            throw $this->createNotFoundException(
                "No category with the name : ".$categoryName." found."
            );
        }

        $programs = $programRepository->findByCategory(
            $category,
            ['id' => 'DESC'],
            3
        );

        return $this->render("category/show.html.twig", [
            "programs" => $programs,
            "category" => $category,
        ]);
    }
};