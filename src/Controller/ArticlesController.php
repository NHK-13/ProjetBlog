<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Articles;
use App\Entity\Commentaires;
use App\Form\CommentairesType;

/**
 * Class ArticlesController
 * @package App\Controller
 * @Route("/actualites", name="actualites_")
 */
class ArticlesController extends AbstractController
{
    /**
     * @Route("/", name="articles")
     */
    public function index()
    {
        // Méthode findBy qui permet de récupérer les données avec des critères de filtre et de tri
        $articles = $this->getDoctrine()
                            ->getRepository(Articles::class)
                            ->findBy([],['createdat' => 'desc']);

        return $this->render('articles/index.html.twig', [
            'articles' => $articles,
        ]);
    }
    /**
     * @Route("/{slug}", name="article")
     */
    public function article($slug, Request $request)
    {   //On recupere l'article correspondant au slug
        $article = $this->getDoctrine()
                        ->getRepository(Articles::class)
                        ->findOneBy(['slug' => $slug]);

        // On récupère les commentaires actifs de l'article
        $commentaires = $this->getDoctrine()
                                ->getRepository(Commentaires::class)
                                ->findBy(['articles' => $article,
                                            'actif' => 1],
                                            ['createdat' => 'desc']);

        if(!$article){
            //Si pas d'article trouvé, création d'une exception
            throw $this->createNotFoundException('L\'article n\'existe pas');
        }

        // Nous créons l'instance de "Commentaires"
        $commentaire = new Commentaires();

        // Nous créons le formulaire en utilisant "CommentairesType" et on lui passe l'instance
        $form = $this->createForm(CommentairesType::class, $commentaire);

        // Nous récupérons les données
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Hydrate notre commentaire avec l'article
            $commentaire->setArticles($article);
            // Hydrate notre commentaire avec la date et l'heure courants
            $commentaire->setCreatedAt(new \DateTime('now'));
            $doctrine = $this->getDoctrine()->getManager();
            // On hydrate notre instance $commentaire
            $doctrine->persist($commentaire);
            // On écrit en base de données
            $doctrine->flush();
            }

        // Si l'article existe nous envoyons les données à la vue
        return $this->render('articles/article.html.twig', [
            'form' => $form->createView(),
            'article' => $article,
            'commentaires' => $commentaires,
        ])
        ;
    }
}
