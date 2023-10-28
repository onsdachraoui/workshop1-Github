<?php

namespace App\Controller;

use App\Entity\Book;
use App\Form\BookType;
use App\Form\RechercheType;
use App\Repository\BookRepository;
use Cassandra\Date;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use PhpParser\Node\Expr\Array_;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BookController extends AbstractController
{



//    $ref=$_GET["ref"];
    #[Route('/book', name: 'app_book')]
    public function index(): Response
    {

        return $this->render('book/index.html.twig', [
            'controller_name' => 'BookController',
        ]);
    }
    #[Route('/addbook', name: 'addbook')]
    public function addbook(ManagerRegistry $managerRegistry, Request $request): Response
    {
        $em=$managerRegistry->getManager();
        $book = new Book();
        $form = $this->createForm(BookType::class, $book);
        $form->handleRequest($request);
        if ($form->isSubmitted() and $form->isValid()){
            $em->persist($book);
            $em->flush();
            return $this->redirect("showbook");
        }
        return $this->renderForm('book/addbook.html.twig', [
            'form'=>$form

        ]);

    }

    #[Route('/showbook', name: 'showbook')]
    public function showbook(BookRepository $bookRepository, Request $req): Response
    {
        $form = $this->createForm(RechercheType::class);
        $form->handleRequest($req);

        $results = [];
        if ($form->isSubmitted() && $form->isValid()) {
            $ref = $form->get('ref')->getData();
            $results = $this->getDoctrine()->getRepository(Book::class)->findBy(['ref' => $ref]);
            return $this->render('book/showbookAtelier.html.twig', [
                //'form' => $form->createView(),
                'results' => $results,


            ]);
        }
        $book = $bookRepository->findAll();

        return $this->render('book/showbook.html.twig', [
            'form' => $form->createView(),
//            'results' => $results,
            'book'=>$book


        ]);

    }
    #[Route('/showbookAuthor/{id}', name: 'showbookAuthor')]
    public function showbookAuthor($id, BookRepository $bookRepository): Response
    {
        $books = $this->getDoctrine()->getRepository(Book::class)->findBy(['author' => $id]);


        return $this->render('author/showauthorbook.html.twig', [
            'booktitle' => $books,
        ]);
    }





    #[Route('/editbook/{id}', name: 'editbook')]
    public function editbook($id, ManagerRegistry $manager, BookRepository $bookRepository, Request $req): Response
    {
        // var_dump($id) . die();

        $em = $manager->getManager();
        $idData = $bookRepository->find($id);
        // var_dump($idData) . die();
        $form = $this->createForm(BookType::class, $idData);
        $form->handleRequest($req);

        if ($form->isSubmitted() and $form->isValid()) {
            $em->persist($idData);
            $em->flush();

            return $this->redirectToRoute('showbook');
        }

        return $this->renderForm('book/edit.html.twig', [
            'form' => $form
        ]);
    }

    #[Route('/deletebook/{id}', name: 'deletebook')]
    public function deletebook($id, ManagerRegistry $manager, BookRepository $repo): Response
    {
        $emm = $manager->getManager();
        $idremove = $repo->find($id);
        $emm->remove($idremove);
        $emm->flush();


        return $this->redirectToRoute('showbook');
    }
    #[Route('/ShowCondition', name: 'ShowCondition')]
    public function ShowCondition(ManagerRegistry $manager, BookRepository $repo): Response
    {

        $year = new \DateTime('2015-01-01') ;
        $minBookCount = 20;
        $books = $repo->findBooksPublishedBeforeYearWithAuthorBooksCount($year, $minBookCount);

        return $this->render('book/list.html.twig', [
            'books' => $books,
        ]);
    }




}
