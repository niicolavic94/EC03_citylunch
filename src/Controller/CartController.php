namespace App\Controller;

use App\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\Annotation\Route;

class CartController extends AbstractController
{
    #[Route('/cart/add/{id}', name: 'cart_add')]
    public function add(Product $product, RequestStack $requestStack): Response
    {
        $session = $requestStack->getSession();
        $cart = $session->get('cart', []);
        $id = $product->getId();

        if (!empty($cart[$id])) {
            $cart[$id]++;
        } else {
            $cart[$id] = 1;
        }

        $session->set('cart', $cart);
        $this->addFlash('success', 'Produit ajouté au panier !');

        return $this->redirectToRoute('app_product_index');
    }
}