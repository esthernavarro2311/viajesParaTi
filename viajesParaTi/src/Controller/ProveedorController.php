namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Entity\Proveedor; // Asegúrate de usar la entidad correcta
use App\Form\ProveedorType; // Si decides usar un formulario
use Doctrine\ORM\EntityManagerInterface;

class ProveedorController extends AbstractController
{
    public function index(): Response
    {
        $proveedores = $this->getDoctrine()->getRepository(Proveedor::class)->findAll();

        return $this->render('proveedor/index.html.twig', [
            'proveedores' => $proveedores,
        ]);
    } 

    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $proveedor = new Proveedor();
        // Aquí podrías añadir un formulario si lo deseas
        // $form = $this->createForm(ProveedorType::class, $proveedor);
        // $form->handleRequest($request);
        
        // Si estás usando un formulario, verifica si es enviado y válido
        // if ($form->isSubmitted() && $form->isValid()) {
        //     $em->persist($proveedor);
        //     $em->flush();
        //     return $this->redirectToRoute('proveedor_index');
        // }

        // return $this->render('proveedor/create.html.twig', [
        //     'form' => $form->createView(),
        // ]);

        // Si decides no usar un formulario Symfony, asegúrate de manejar la creación con el Request
        // y persistir el nuevo proveedor con EntityManager.
    }

    public function edit(Request $request, EntityManagerInterface $em, Proveedor $proveedor): Response
    {
        // Similar al método create, pero cargando y actualizando un proveedor existente.
    }

    public function delete(EntityManagerInterface $em, Proveedor $proveedor): Response
    {
        // Eliminar el proveedor y redirigir al listado.
    }
}
