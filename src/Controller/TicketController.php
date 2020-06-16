<?php

namespace App\Controller;

use App\Entity\Ticket;
use App\Entity\User;
use App\Form\TicketFormType;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
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
     * @Route("new", name="ticket")
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
        return $this->render('ticket/newticket.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
