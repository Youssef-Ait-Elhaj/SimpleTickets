<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use App\Form\TicketFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Security;
use Symfony\Component\Security\Core\User\UserInterface;

class TicketController extends AbstractController
{
    private $security;

    public function __construct(Security $security)
    {
        $this->security = $security;
    }

    /**
     * @Route("/tickets/new", name="ticket_create")
     */
    public function createTicket(Request $request, ObjectManager $manager)
    {
        $ticket = new Ticket();
        // make sure user is logged-in then access his ID
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_FULLY');
        $userId = $this->getUser()->getId();   // current logged-in user id

        $customer = $this->getDoctrine()
            ->getRepository(User::class)
            ->find($userId);
        $ticket->setCustomer($customer);
        $form = $this->createForm(TicketFormType::class, $ticket);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ticket);
            $manager->flush();
        }
        return $this->render('ticket/new_ticket.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/tickets/edit/{id}", name="ticket_edit")
     */
    public function editTicket(Ticket $ticket, Request $request, ObjectManager $manager) {
        $form = $this->createForm(TicketFormType::class, $ticket);
        $form->handleRequest($request);
//
//        $entityManager = $this->getDoctrine()->getManager();
//        $ticket = $entityManager->getRepository(Ticket::class)->find($id);

        if ($form->isSubmitted() && $form->isValid()) {
            $manager->persist($ticket);
            $manager->flush();
        }

        return $this->render('ticket/edit_ticket.html.twig', [
            'form' => $form->createView(),
            'ticket' => $ticket
        ]);
    }

    /**
     * @Route("/tickets/show/{id}", name="ticket_show")
     */
    public function showTicket(Ticket $ticket) {
        return $this->render('ticket/show_ticket.html.twig', [
            'ticket' => $ticket
        ]);
    }

    /**
     * @Route("/tickets", name="tickets_index")
     */
    public function findAll() {
        $repository = $this->getDoctrine()->getRepository(Ticket::class);
        $tickets = $repository->findAll();
        $repo = $this->getDoctrine()->getRepository(User::class);
        $technicians = $repo->findByRole("ROLE_TECHNICIAN");
        return $this->render('ticket/index.html.twig', [
            'tickets' => $tickets,
            'technicians' => $technicians
        ]);
    }

    /**
     * @Route("/tickets/delete/{id}", name="ticket_delete")
     */
    public function deleteTicket(Ticket $ticket, ObjectManager $manager) {
        $manager->remove($ticket);
        $manager->flush();
        $res = '<html><body><h1>DELETED SUCCESSFULLY</h1></body></html>';
        return new Response($res, 202);
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/tickets/validate/{id}", name="ticket_validate")
     */
    public function validateTicket(Ticket $ticket) {
        $entityManager = $this->getDoctrine()->getManager();
        $ticket->setStatus("APPROVED");
        $entityManager->flush();

        return $this->redirectToRoute('tickets_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/tickets/reject/{id}", name="ticket_reject")
     */
    public function rejectTicket(Ticket $ticket) {
        $entityManager = $this->getDoctrine()->getManager();
        $ticket->setStatus("REJECTED");
        $entityManager->flush();

        return $this->redirectToRoute('tickets_index');
    }

    /**
     * @IsGranted("ROLE_ADMIN")
     * @Route("/tickets/assign/{id}", name="ticket_assign")
     */
    public function assignTechnician(Ticket $ticket, Request $request) {
        $entityManager = $this->getDoctrine()->getManager();

        $techId = dump($request->query->get('tech'));
        $technician = $entityManager->getRepository(User::class)->find($techId);

        $date = new \DateTime('@'.strtotime('now'));

        $ticket->setTechnician($technician);
        $ticket->setStatus("ASSIGNED");
        $ticket->setAssignmentDate($date);
        $entityManager->flush();

        return $this->redirectToRoute('tickets_index');
    }
}
