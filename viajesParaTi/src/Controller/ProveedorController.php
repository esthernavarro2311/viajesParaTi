<?php
namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use App\Entity\Proveedor; 
use Doctrine\ORM\EntityManagerInterface;
 
class ProveedorController extends AbstractController
{
    private $entityManager;
    private $formFactory;

    public function __construct(EntityManagerInterface $entityManager, FormFactoryInterface $formFactory)
    {
        $this->entityManager = $entityManager;
        $this->formFactory = $formFactory;
    }

    #[Route('/index')]
    public function index(): Response
    {
        $proveedores = $this->entityManager->getRepository(Proveedor::class)->findAll();

        $mensaje = empty($proveedores) ? 'No existen valores de proveedores.' : '';

        return $this->render('proveedor/index.html.twig', [
            'proveedores' => $proveedores,
            'mensaje' => $mensaje,
        ]);
    } 

    #[Route('/proveedor/create', name: 'proveedor_create')]
    public function create(Request $request): Response
    {
        $proveedor = new Proveedor();

        $form = $this->createFormBuilder($proveedor)
        ->add('name', TextType::class, [
            'label' => 'Proveedor',
            'attr' => ['class' => 'form-control'],
            'constraints' => [new NotBlank()]
        ])
        ->add('email', EmailType::class, [
            'label' => 'Correo Electrónico',
            'attr' => ['class' => 'form-control'],
            'constraints' => [new NotBlank()]
        ])
        ->add('phone', TelType::class, [
            'label' => 'Teléfono',
            'attr' => ['class' => 'form-control'],
            'constraints' => [new NotBlank()]
        ])
        ->add('type', ChoiceType::class, [
            'label' => 'Tipo',
            'attr' => ['class' => 'form-control'],
            'choices' => [
                'Hotel' => 'hotel',
                'Pista' => 'pista',
                'Complemento' => 'complemento',
            ],
            'constraints' => [new NotBlank()]
        ])
        ->add('active', CheckboxType::class, [
            'label' => 'Activo',
            'required' => false,
            'label_attr' => ['class' => 'form-check-label'],
            'attr' => ['class' => 'form-check-input toggle-checkbox'],
        ])
        ->add('save', SubmitType::class, [
            'label' => 'Crear proveedor',
            'attr' => ['class' => 'btn btn-primary']
        ])
        ->getForm();


        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $proveedor = $form->getData();

            $proveedor->setCreatedAt(new \DateTime());
            $proveedor->setUpdatedAt(new \DateTime());

            $entityManager = $this->entityManager; 
            $entityManager->persist($proveedor);
            $entityManager->flush();

            $this->addFlash('success', 'Proveedor creado correctamente.');

            return $this->redirectToRoute('app_proveedor_index');
        }

        return $this->render('proveedor/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    public function edit(Request $request, EntityManagerInterface $em, Proveedor $proveedor): Response
    {
        // Similar al método create, pero cargando y actualizando un proveedor existente.
    }

    #[Route('/delete/{id}', name: 'delete_proveedor', methods: ['POST'])]
    public function delete(Request $request, Proveedor $proveedor, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($proveedor);
        $entityManager->flush();

        $this->addFlash('success', 'Proveedor eliminado correctamente.');

        // return $this->redirectToRoute('index'); 
        return $this->redirectToRoute('app_proveedor_index');
    }
}

