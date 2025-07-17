<?php

namespace OHMedia\LogoBundle\Controller;

use OHMedia\BackendBundle\Routing\Attribute\Admin;
use OHMedia\BootstrapBundle\Service\Paginator;
use OHMedia\LogoBundle\Entity\Logo;
use OHMedia\LogoBundle\Form\LogoType;
use OHMedia\LogoBundle\Repository\LogoRepository;
use OHMedia\LogoBundle\Security\Voter\LogoVoter;
use OHMedia\UtilityBundle\Form\DeleteType;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Admin]
class LogoController extends AbstractController
{
    public function __construct(private LogoRepository $logoRepository)
    {
    }

    #[Route('/logos', name: 'logo_index', methods: ['GET'])]
    public function index(Paginator $paginator): Response
    {
        $newLogo = new Logo();

        $this->denyAccessUnlessGranted(
            LogoVoter::INDEX,
            $newLogo,
            'You cannot access the list of logos.'
        );

        $qb = $this->logoRepository->createQueryBuilder('l');
        $qb->orderBy('l.name', 'desc');

        return $this->render('@OHMediaLogo/logo/logo_index.html.twig', [
            'pagination' => $paginator->paginate($qb, 20),
            'new_logo' => $newLogo,
            'attributes' => $this->getAttributes(),
        ]);
    }

    #[Route('/logo/create', name: 'logo_create', methods: ['GET', 'POST'])]
    public function create(Request $request): Response
    {
        $logo = new Logo();

        $this->denyAccessUnlessGranted(
            LogoVoter::CREATE,
            $logo,
            'You cannot create a new logo.'
        );

        $form = $this->createForm(LogoType::class, $logo);

        $form->add('save', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->logoRepository->save($logo, true);

                $this->addFlash('notice', 'The logo was created successfully.');

                return $this->redirectToRoute('logo_index');
            }

            $this->addFlash('error', 'There are some errors in the form below.');
        }

        return $this->render('@OHMediaLogo/logo/logo_create.html.twig', [
            'form' => $form->createView(),
            'logo' => $logo,
        ]);
    }

    #[Route('/logo/{id}/edit', name: 'logo_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        #[MapEntity(id: 'id')] Logo $logo,
    ): Response {
        $this->denyAccessUnlessGranted(
            LogoVoter::EDIT,
            $logo,
            'You cannot edit this logo.'
        );

        $form = $this->createForm(LogoType::class, $logo);

        $form->add('save', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->logoRepository->save($logo, true);

                $this->addFlash('notice', 'The logo was updated successfully.');

                return $this->redirectToRoute('logo_index');
            }

            $this->addFlash('error', 'There are some errors in the form below.');
        }

        return $this->render('@OHMediaLogo/logo/logo_edit.html.twig', [
            'form' => $form->createView(),
            'logo' => $logo,
        ]);
    }

    #[Route('/logo/{id}/delete', name: 'logo_delete', methods: ['GET', 'POST'])]
    public function delete(
        Request $request,
        #[MapEntity(id: 'id')] Logo $logo,
    ): Response {
        $this->denyAccessUnlessGranted(
            LogoVoter::DELETE,
            $logo,
            'You cannot delete this logo.'
        );

        $form = $this->createForm(DeleteType::class, null);

        $form->add('delete', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->logoRepository->remove($logo, true);

                $this->addFlash('notice', 'The logo was deleted successfully.');

                return $this->redirectToRoute('logo_index');
            }

            $this->addFlash('error', 'There are some errors in the form below.');
        }

        return $this->render('@OHMediaLogo/logo/logo_delete.html.twig', [
            'form' => $form->createView(),
            'logo' => $logo,
        ]);
    }

    private function getAttributes(): array
    {
        return [
            'create' => LogoVoter::CREATE,
            'delete' => LogoVoter::DELETE,
            'edit' => LogoVoter::EDIT,
        ];
    }
}
