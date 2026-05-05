<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin')]
#[IsGranted('ROLE_GERANT')]
class AdminController extends AbstractController
{
    #[Route('/products', name: 'admin_products')]
    public function products(EntityManagerInterface $em): Response
    {
        return $this->render('admin/products.html.twig', [
            'products' => $em->getRepository(Product::class)->findAll(),
        ]);
    }

    #[Route('/products/new', name: 'admin_product_new', methods: ['GET', 'POST'])]
    public function newProduct(Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $product = new Product();
            $product->setName($request->request->get('name'));
            $product->setPrice((float) $request->request->get('price'));
            $product->setCategory($request->request->get('category'));
            $product->setDescription($request->request->get('description'));
            $product->setStock((int) $request->request->get('stock', 0));
            $em->persist($product);
            $em->flush();
            $this->addFlash('success', 'Produit ajouté.');
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/product_form.html.twig', ['product' => null]);
    }

    #[Route('/products/{id}/edit', name: 'admin_product_edit', methods: ['GET', 'POST'])]
    public function editProduct(Product $product, Request $request, EntityManagerInterface $em): Response
    {
        if ($request->isMethod('POST')) {
            $product->setName($request->request->get('name'));
            $product->setPrice((float) $request->request->get('price'));
            $product->setCategory($request->request->get('category'));
            $product->setDescription($request->request->get('description'));
            $product->setStock((int) $request->request->get('stock', 0));
            $em->flush();
            $this->addFlash('success', 'Produit modifié.');
            return $this->redirectToRoute('admin_products');
        }

        return $this->render('admin/product_form.html.twig', ['product' => $product]);
    }

    #[Route('/products/{id}/delete', name: 'admin_product_delete', methods: ['POST'])]
    public function deleteProduct(Product $product, EntityManagerInterface $em): Response
    {
        $em->remove($product);
        $em->flush();
        $this->addFlash('success', 'Produit supprimé.');
        return $this->redirectToRoute('admin_products');
    }

    #[Route('/livreurs', name: 'admin_livreurs')]
    public function livreurs(EntityManagerInterface $em): Response
    {
        $livreurs = $em->getRepository(User::class)->findBy([], null);
        $livreurs = array_filter($livreurs, fn(User $u) => in_array('ROLE_LIVREUR', $u->getRoles()));

        return $this->render('admin/livreurs.html.twig', [
            'livreurs' => array_values($livreurs),
        ]);
    }

    #[Route('/livreurs/new', name: 'admin_livreur_new', methods: ['GET', 'POST'])]
    public function newLivreur(Request $request, EntityManagerInterface $em, UserPasswordHasherInterface $hasher): Response
    {
        if ($request->isMethod('POST')) {
            $user = new User();
            $user->setEmail($request->request->get('email'));
            $user->setRoles(['ROLE_LIVREUR']);
            $user->setPassword($hasher->hashPassword($user, $request->request->get('password')));
            $em->persist($user);
            $em->flush();
            $this->addFlash('success', 'Livreur ajouté.');
            return $this->redirectToRoute('admin_livreurs');
        }

        return $this->render('admin/livreur_form.html.twig');
    }

    #[Route('/livreurs/{id}/delete', name: 'admin_livreur_delete', methods: ['POST'])]
    public function deleteLivreur(User $user, EntityManagerInterface $em): Response
    {
        $em->remove($user);
        $em->flush();
        $this->addFlash('success', 'Livreur supprimé.');
        return $this->redirectToRoute('admin_livreurs');
    }
}
