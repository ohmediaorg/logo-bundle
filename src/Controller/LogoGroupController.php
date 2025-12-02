<?php

namespace OHMedia\LogoBundle\Controller;

use OHMedia\BackendBundle\Form\MultiSaveType;
use OHMedia\BackendBundle\Routing\Attribute\Admin;
use OHMedia\BootstrapBundle\Service\Paginator;
use OHMedia\LogoBundle\Entity\LogoGroup;
use OHMedia\LogoBundle\Form\LogoGroupType;
use OHMedia\LogoBundle\Repository\LogoGroupRepository;
use OHMedia\LogoBundle\Repository\LogoRepository;
use OHMedia\LogoBundle\Security\Voter\LogoGroupVoter;
use OHMedia\UtilityBundle\Form\DeleteType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Admin]
class LogoGroupController extends AbstractController
{
    public function __construct(private LogoGroupRepository $logoGroupRepository)
    {
    }

    #[Route('/logos/groups', name: 'logo_group_index', methods: ['GET'])]
    public function index(Paginator $paginator): Response
    {
        $newLogoGroup = new LogoGroup();

        $this->denyAccessUnlessGranted(
            LogoGroupVoter::INDEX,
            $newLogoGroup,
            'You cannot access the list of groups.'
        );

        $qb = $this->logoGroupRepository->createQueryBuilder('lg');
        $qb->orderBy('lg.title', 'desc');

        return $this->render('@OHMediaLogo/logo_group/logo_group_index.html.twig', [
            'pagination' => $paginator->paginate($qb, 20),
            'new_logo_group' => $newLogoGroup,
            'attributes' => $this->getAttributes(),
        ]);
    }

    #[Route('/logos/group/create', name: 'logo_group_create', methods: ['GET', 'POST'])]
    public function create(
        Request $request,
        LogoRepository $logoRepository
    ): Response {
        $logoGroup = new LogoGroup();

        $this->denyAccessUnlessGranted(
            LogoGroupVoter::CREATE,
            $logoGroup,
            'You cannot create a new group.'
        );

        $form = $this->createForm(LogoGroupType::class, $logoGroup);

        $form->add('save', MultiSaveType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->logoGroupRepository->save($logoGroup, true);

                $this->addFlash('notice', 'The group was created successfully.');

                return $this->redirectForm($logoGroup, $form);
            }

            $this->addFlash('error', 'There are some errors in the form below.');
        }

        return $this->render('@OHMediaLogo/logo_group/logo_group_create.html.twig', [
            'form' => $form->createView(),
            'logo_group' => $logoGroup,
            'logos_unselected' => $logoRepository->findNotInLogoGroup($logoGroup),
        ]);
    }

    #[Route('/logos/group/{id}/edit', name: 'logo_group_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        LogoGroup $logoGroup,
        LogoRepository $logoRepository
    ): Response {
        $this->denyAccessUnlessGranted(
            LogoGroupVoter::EDIT,
            $logoGroup,
            'You cannot edit this group.'
        );

        $form = $this->createForm(LogoGroupType::class, $logoGroup);

        $form->add('save', MultiSaveType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->logoGroupRepository->save($logoGroup, true);

                $this->addFlash('notice', 'The group was updated successfully.');

                return $this->redirectForm($logoGroup, $form);
            }

            $this->addFlash('error', 'There are some errors in the form below.');
        }

        return $this->render('@OHMediaLogo/logo_group/logo_group_edit.html.twig', [
            'form' => $form->createView(),
            'logo_group' => $logoGroup,
            'logos_unselected' => $logoRepository->findNotInLogoGroup($logoGroup),
        ]);
    }

    private function redirectForm(LogoGroup $logoGroup, FormInterface $form): Response
    {
        $clickedButtonName = $form->getClickedButton()->getName() ?? null;

        if ('keep_editing' === $clickedButtonName) {
            return $this->redirectToRoute('logo_group_edit', [
                'id' => $logoGroup->getId(),
            ]);
        } elseif ('add_another' === $clickedButtonName) {
            return $this->redirectToRoute('logo_group_create');
        } else {
            return $this->redirectToRoute('logo_group_index');
        }
    }

    #[Route('/logos/group/{id}/delete', name: 'logo_group_delete', methods: ['GET', 'POST'])]
    public function delete(
        Request $request,
        LogoGroup $logoGroup,
    ): Response {
        $this->denyAccessUnlessGranted(
            LogoGroupVoter::DELETE,
            $logoGroup,
            'You cannot delete this group.'
        );

        $form = $this->createForm(DeleteType::class, null);

        $form->add('delete', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            if ($form->isValid()) {
                $this->logoGroupRepository->remove($logoGroup, true);

                $this->addFlash('notice', 'The group was deleted successfully.');

                return $this->redirectToRoute('logo_group_index');
            }

            $this->addFlash('error', 'There are some errors in the form below.');
        }

        return $this->render('@OHMediaLogo/logo_group/logo_group_delete.html.twig', [
            'form' => $form->createView(),
            'logo_group' => $logoGroup,
        ]);
    }

    private function getAttributes(): array
    {
        return [
            'create' => LogoGroupVoter::CREATE,
            'delete' => LogoGroupVoter::DELETE,
            'edit' => LogoGroupVoter::EDIT,
        ];
    }
}
