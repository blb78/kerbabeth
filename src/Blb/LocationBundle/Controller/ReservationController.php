<?php

namespace Blb\LocationBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;

use Blb\LocationBundle\Entity\Reservation;

class ReservationController extends Controller
{
    /**
     * @Route("/reservations/load",name="load_json")
     * 
     */
    public function loadReservations()
    {
        $em = $this->getDoctrine()->getManager();
        $events = $em->getRepository('BlbLocationBundle:Reservation')->getReservations();
        
    
        $items = array();
        /** @var $event Event */
        foreach ($events as $i=>$event) {
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
            
    
            $items[$i] = $item;
        }
    
        //return $this->render('BlbLocationBundle:Blb:ReservationJson.html.twig', array(
        //    'items' => $items
        //));
       
        $jsonData = json_encode($items);
        
        $headers = array(
              'Content-Type' => 'application/json'
        );
      
        $response = new Response($jsonData, 200, $headers);
        return $response;
    }
    /**
     * @Route("/reservations/add",name="reservation_add")
     * 
     */
    public function addReservation(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->container->get('request');
        $qStart = $request->get('start');
        $qEnd = $request->get('end');
        $sStart = new \DateTime($qStart);
        //$debut->format('Y-m-d 00:00:00');
        $sEnd = new \DateTime($qEnd);
        //$fin->format('Y-m-d 23:59:59');
        
        
        $oReservation = new Reservation();
        
        $oReservation->setTitle('Réservé');
        $oReservation->setStart($sStart);
        $oReservation->setEnd($sEnd);
        
        
        $em->persist($oReservation);
        $em->flush();
        
        $items = array();
            $item['id'] = $oReservation->getId();
            $item['title'] = $oReservation->getTitle();
            $item['allDay'] = $oReservation->getAllday();
            $item['start'] = $oReservation->getStart()->format('Y-m-d H:i:s');
            $item['end'] = $oReservation->getEnd()->format('Y-m-d H:i:s');
            $item['url'] = $oReservation->getUrl();
            $item['className'] = $oReservation->getClassname();
            $item['editable'] = $oReservation->getEditable();
            $item['startEditable'] = $oReservation->getStarteditable();
            $item['durationEditable'] = $oReservation->getDurationeditable();
            $item['color'] = $oReservation->getColor();
            $item['backgroundColor'] = $oReservation->getBackgroundcolor();
            $item['borderColor'] = $oReservation->getBordercolor();
        $items[0] = $item;
        
        $jsonData = json_encode($items);
        $headers = array(
              'Content-Type' => 'application/json'
        );
        $response = new Response($jsonData, 200, $headers);
        return $response;
        
       
       
    }
    /**
     * @Route("/reservations/new",name="reservation_new")
     * 
     */
    public function newReservations(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->container->get('request');
        $myDate = $request->get('myDate');
        $start = new \DateTime($myDate);
        //$debut->format('Y-m-d 00:00:00');
        $end = new \DateTime($myDate);
        //$fin->format('Y-m-d 23:59:59');
        
        
        $oReservation = new Reservation();
        
        $oReservation->setTitle('Réservé');
        $oReservation->setStart($start);
        $oReservation->setEnd($end);
        
        
        $em->persist($oReservation);
        $em->flush();
        
        $items = array();
            $item['id'] = $oReservation->getId();
            $item['title'] = $oReservation->getTitle();
            $item['allDay'] = $oReservation->getAllday();
            $item['start'] = $oReservation->getStart()->format('Y-m-d H:i:s');
            $item['end'] = $oReservation->getEnd()->format('Y-m-d H:i:s');
            $item['url'] = $oReservation->getUrl();
            $item['className'] = $oReservation->getClassname();
            $item['editable'] = $oReservation->getEditable();
            $item['startEditable'] = $oReservation->getStarteditable();
            $item['durationEditable'] = $oReservation->getDurationeditable();
            $item['color'] = $oReservation->getColor();
            $item['backgroundColor'] = $oReservation->getBackgroundcolor();
            $item['borderColor'] = $oReservation->getBordercolor();
        $items[0] = $item;
        
        $jsonData = json_encode($items);
        $headers = array(
              'Content-Type' => 'application/json'
        );
        $response = new Response($jsonData, 200, $headers);
        return $response;
        
       
       
    }
    /**
     * @Route("/reservations/update",name="reservation_update")
     * 
     */
    public function updateReservation(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->container->get('request');
        $event_id = $request->get('event_id');
        $qStart = $request->get('start');
        $qEnd = $request->get('end');
        $sStart = new \DateTime($qStart);
        //$debut->format('Y-m-d 00:00:00');
        $sEnd = new \DateTime($qEnd);
        //$fin->format('Y-m-d 23:59:59');
        
        
        $oReservation = $em->getRepository('BlbLocationBundle:Reservation')->find($event_id);
        
        $oReservation->setStart($sStart);
        $oReservation->setEnd($sEnd);
        
        
        $em->persist($oReservation);
        $em->flush();
        return new Response('Mise à jour effectuée !');
        
        
       
       
    }
    /**
     * @Route("/reservations/resize",name="reservation_resize")
     * 
     */
    public function updateReservations(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->container->get('request');
        $event_id = $request->get('event_id');
        $dayDelta = $request->get('dayDelta');
        
        $oReservation = $em->getRepository('BlbLocationBundle:Reservation')->find($event_id);
        
            $origineDateDebut = $oReservation->getStart();
            $origineDateFin = $oReservation->getEnd();
            
            
            if ($dayDelta<0){
                $days_ago = new \DateInterval( "P".abs($dayDelta)."D" ); 
                $days_ago->invert = 1; //Make it negative. 
                
                $oDate = $origineDateFin->add($days_ago);
                $newFin = new \DateTime($oDate->format('Y-m-d 23:00:00'));
                $oReservation->setEnd($newFin);
                
            }else{
                
                $oDate = $origineDateFin->add(new \DateInterval("P".$dayDelta."D"));
                $newFin = new \DateTime($oDate->format('Y-m-d 23:00:00'));
                $oReservation->setEnd($newFin);
            }
           
            $em->persist($oReservation);
            $em->flush();
        return new Response('Maj ok');
    }
    /**
     * @Route("/reservations/event/drop",name="reservation_event_drop")
     * 
     */
    public function eventDropReservations(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->container->get('request');
        $event_id = $request->get('event_id');
        $dayDelta = $request->get('dayDelta');
        
        $oReservation = $em->getRepository('BlbLocationBundle:Reservation')->find($event_id);
        
            $origineDateDebut = $oReservation->getStart();
            $origineDateFin = $oReservation->getEnd();
            
            
            if ($dayDelta<0){
                $days_ago = new \DateInterval( "P".abs($dayDelta)."D" ); 
                $days_ago->invert = 1; //Make it negative. 
                $oDateDebut = $origineDateDebut->add($days_ago);
                $newDebut = new \DateTime($oDateDebut->format('Y-m-d 23:00:00'));
                $oReservation->setStart($newDebut);
                $oDateFin = $origineDateFin->add($days_ago);
                $newFin = new \DateTime($oDateFin->format('Y-m-d 23:00:00'));
                $oReservation->setEnd($newFin);
                
            }else{
                $oDateDebut = $origineDateDebut->add(new \DateInterval("P".$dayDelta."D"));
                $newDebut = new \DateTime($oDateDebut->format('Y-m-d 23:00:00'));
                $oReservation->setStart($newDebut);
                $oDateFin = $origineDateFin->add(new \DateInterval("P".$dayDelta."D"));
                $newFin = new \DateTime($oDateFin->format('Y-m-d 23:00:00'));
                $oReservation->setEnd($newFin);
            }
            
            $em->persist($oReservation);
            $em->flush();
           
           return new Response('Maj ok');
       
    }
    /**
     * @Route("/reservations/event/click",name="reservation_event_click")
     * @Template("BlbLocationBundle:Blb:modalEvent.html.twig")
     * 
     */
    public function eventClickReservations(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->container->get('request');
        $event_id = $request->get('event_id');
        
        $oReservation = $em->getRepository('BlbLocationBundle:Reservation')->find($event_id);
        if ($this->get('Request')->isXMLHttpRequest()){
            return array('oReservation'=> $oReservation);
        }else{
            return new Response('Pb : Le controlleur ne voit pas de requete ajax !');
        }
        
    }
     /**
     * @Route("/reservations/event/remove",name="reservation_event_remove")
     */
    public function eventRemoveReservations(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->container->get('request');
        $event_id = $request->get('event_id');
        
        $oReservation = $em->getRepository('BlbLocationBundle:Reservation')->find($event_id);
        
        if ($oReservation){
            $em->remove($oReservation);
            $em->flush();
            return $this->redirect($this->generateUrl('dashboard'));
        }else{
            return new Response('Pb : Le controlleur ne trouve pas la réservation !');
        }
        
    }
    /**
     * @Route("/indsiponibilite/add",name="indispo_add")
     * 
     */
    public function addIndisponibilite(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $request = $this->container->get('request');
        $qStart = $request->get('start');
        $qEnd = $request->get('end');
        $sStart = new \DateTime($qStart);
        //$debut->format('Y-m-d 00:00:00');
        $sEnd = new \DateTime($qEnd);
        //$fin->format('Y-m-d 23:59:59');
        
        
        $oReservation = new Reservation();
        
        $oReservation->setTitle('Indisponible');
        $oReservation->setBackgroundcolor('#d9534f');
        $oReservation->setBordercolor('#d43f3a');
        $oReservation->setStart($sStart);
        $oReservation->setEnd($sEnd);
        
        
        $em->persist($oReservation);
        $em->flush();
        
        $items = array();
            $item['id'] = $oReservation->getId();
            $item['title'] = $oReservation->getTitle();
            $item['allDay'] = $oReservation->getAllday();
            $item['start'] = $oReservation->getStart()->format('Y-m-d H:i:s');
            $item['end'] = $oReservation->getEnd()->format('Y-m-d H:i:s');
            $item['url'] = $oReservation->getUrl();
            $item['className'] = $oReservation->getClassname();
            $item['editable'] = $oReservation->getEditable();
            $item['startEditable'] = $oReservation->getStarteditable();
            $item['durationEditable'] = $oReservation->getDurationeditable();
            $item['color'] = $oReservation->getColor();
            $item['backgroundColor'] = $oReservation->getBackgroundcolor();
            $item['borderColor'] = $oReservation->getBordercolor();
        $items[0] = $item;
        
        $jsonData = json_encode($items);
        $headers = array(
              'Content-Type' => 'application/json'
        );
        $response = new Response($jsonData, 200, $headers);
        return $response;
        
       
       
    }
    
}
