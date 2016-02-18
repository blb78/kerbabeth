<?php

namespace Blb\LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blb\LocationBundle\Entity\Message;
use Blb\LocationBundle\Form\MessageType;
use Blb\LocationBundle\Entity\Reservation;
use Blb\LocationBundle\Form\ReservationType;

class DefaultController extends Controller
{
    /**
    * @Route("/",name="index")
    */
    public function indexAction()
    {
        $this->get('session')->getFlashBag()->clear();
        return $this->render('BlbLocationBundle:Blb:index.html.twig');
    }
    /**
    * @Route("/admin/reservation",name="reservation")
    */
    public function reservationAction()
    {
        $this->get('session')->getFlashBag()->clear();
       return $this->redirect($this->generateUrl('dashboard'));
    }
    /**
    * @Route("/admin/reservations",name="reservations")
    * @Template("BlbLocationBundle:Blb:reservation.html.twig")
    */
    public function reservationsAction()
    {
        
       
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('BlbLocationBundle:Reservation')->getReservations();
        
        
        $items = array();
        /** @var $event Event */
        foreach ($events as $event) {
            $item['id'] = $event->getId();
            $item['title'] = $event->getTitle();
            $item['allDay'] = $event->getAllday();
            $item['start'] = $event->getStart()->format('Y-m-d H:i:s');
            $item['end'] = $event->getEnd()->format('Y-m-d H:i:s');
            $item['url'] = $event->getUrl();
            $item['className'] = $event->getClassname();
            $item['editable'] = $event->getEditable();
            $item['startEditable'] = $event->getStarteditable();
            $item['durationEditable'] = $event->getDurationeditable();
            $item['color'] = $event->getColor();
            $item['backgroundColor'] = $event->getBackgroundcolor();
            $item['borderColor'] = $event->getBordercolor();
            
        
            $items[] = $item;
        }
        return array ('items' => $items);
        
        
    }
    /**
    * @Route("/admin/dashboard",name="dashboard")
    * @Template("BlbLocationBundle:Blb:dashboard.html.twig")
    */
    public function dashboardAction()
    {
       
        $reservation = new Reservation();
        $form = $this->createForm(new ReservationType(), $reservation);
      
        $request = $this->get('request');
        if ($request->getMethod() == 'POST') {
            $form->bind($request);
            if ($form->isValid()) {
                $em = $this->getDoctrine()->getManager();
                $em->persist($reservation);
                $em->flush();
                //////On définit un message flash
                $this->get('session')->getFlashBag()->clear();
                $this->get('session')->getFlashBag()->add('notice', 'La réservation est enregistrée du '.$reservation->getStart()->format('Y-m-d').' au '.$reservation->getEnd()->format('Y-m-d'));
                return $this->redirect($this->generateUrl('index'));
            }
        }
    
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('BlbLocationBundle:Reservation')->getReservations();
        
    
        $items = array();
        /** @var $event Event */
        foreach ($events as $event) {
            $item['id'] = $event->getId();
            $item['title'] = $event->getTitle();
            $item['allDay'] = $event->getAllday();
            $item['start'] = $event->getStart()->format('Y-m-d H:i:s');
            $item['end'] = $event->getEnd()->format('Y-m-d H:i:s');
            $item['url'] = $event->getUrl();
            $item['className'] = $event->getClassname();
            $item['editable'] = $event->getEditable();
            $item['startEditable'] = $event->getStarteditable();
            $item['durationEditable'] = $event->getDurationeditable();
            $item['color'] = $event->getColor();
            $item['backgroundColor'] = $event->getBackgroundcolor();
            $item['borderColor'] = $event->getBordercolor();
            
    
            $items[] = $item;
        }
        return array ('items' => $items,'form' => $form->createView());
        
        
    }
    /**
    * @Route("/nous_ecrire",name="nous_ecrire")
    * @Template("BlbLocationBundle:Blb:modalForm.html.twig")
    */
    public function nousEcrireAction()
    {
       
        $message = new Message();
        // On crée le formulaire grâce à l'ArticleType
        $form = $this->createForm(new MessageType(), $message);
        // On récupère la requête
        $request = $this->getRequest();
        if($request->isXmlHttpRequest()){ return array ('form' => $form->createView());}
        // On vérifie qu'elle est de type POST
        if ($request->getMethod() == 'POST') {
            // On fait le lien Requête <-> Formulaire
            $form->bind($request);
            $temps_soumission = time();
            $temps_chargement_page = intval($form["epoch"]->getData());
            $temps_ecouler= $temps_soumission-$temps_chargement_page;
            
            if ($temps_ecouler > 10){
                // On vérifie que les valeurs entrées sont correctes
                // (Nous verrons la validation des objets en détail dans le prochain chapitre)
                if ($form->isValid()) {
                  // On enregistre notre objet $message dans la base de données
                  $em = $this->getDoctrine()->getManager();
                  $em->persist($message);
                  $em->flush();
                  //On envoie un le mail avec le message
                  $mail = \Swift_Message::newInstance()
                      ->setSubject('kerbabeth.fr : demande d\'informations')
                      ->setFrom(array('contact@kerbabeth.fr'=>'Kerbabeth.fr'))
                      ->setTo(array('subradar@hotmail.com','cadoux.loc@gmail.com'))
                      ->setBody($this->container->get('templating')->render('BlbLocationBundle:Blb:mail.txt.twig', array('message' => $message)),'text/html')
                      ->setReplyTo($message->getEmail());
                      $this->get('mailer')->send($mail);
                  // On définit un message flash
                  $this->get('session')->getFlashBag()->clear();
                  $this->get('session')->getFlashBag()->add('notice', 'Message envoyé');
                  // On redirige vers la page de visualisation de l'article nouvellement créé
                  return $this->redirect($this->generateUrl('index'));
                }
            }else{
                $this->get('session')->getFlashBag()->add('notice','méchant robot !');
            }
            return $this->redirect($this->generateUrl('index'));
        }
        return array ('form' => $form->createView());
    }
   
}
