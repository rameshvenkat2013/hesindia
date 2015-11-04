<?php

namespace Hes\Bundle\IndiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use Hes\Bundle\IndiaBundle\Entity\Tickets;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HESIndiaBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function aboutUsAction()
    {
        return $this->render('HESIndiaBundle:hes:aboutUs.html.twig');
    }
    public function servicesAction($activelink)
    {
        $link = strtolower($activelink);
        
        $em = $this->getDoctrine()->getManager();
        $products = $em->getRepository('HESIndiaBundle:Services')
                    ->findByMainServices($link);
        
        $services = Array();
        $i = 0;
        
        foreach($products as $data)
        {
            $services[$i]['main'] =  $data->getMainServices();
            $services[$i]['serv'] =  $data->getServices();
            $services[$i]['desc'] = $data->getServiceDescription();
            $i++;
        }
        
        return $this->render('HESIndiaBundle:hes/services:'.$link.'_services.html.twig', Array('activelink' => $activelink, 'services' => $services));
    }

    public function faqAction()
    {
        return $this->render('HESIndiaBundle:hes:faq.html.twig');
    }
    
    public function addTicketAction()
    {
        return $this->render('HESIndiaBundle:hes:add_ticket.html.twig');
    }
    
    public function ticketContentsAction(Request $request)
    {
        

        $c_name         = $request->request->get('name');
        $date           = $request->request->get('date');
        $date           = new \DateTime($date);
        $model_no       = $request->request->get('mobile');
        $inward         = $request->request->get('inward');
        $outward        = $request->request->get('outward');
        $old_job        = $request->request->get('oldjob');
        $mat_desc       = $request->request->get('matdesc');
        $kw_hp          = $request->request->get('kwhp');
        $serial_no      = $request->request->get('serialno');
        $job_no         = $request->request->get('jobno');
        $rework         = $request->request->get('rework');
        $status         = $request->request->get('status');
        $assigned_to    = $request->request->get('engineer');
        $remarks        = $request->request->get('remark');
        
        $ticket_id = substr(md5($job_no), 0, 6);
        
        $tickets = new Tickets();
        
        $em = $this->getDoctrine()->getManager();
        
        $tickets->setTicketId($ticket_id)
                ->setJobNo($job_no)
                ->setSerialNo($serial_no)
                ->setOldJobNo($old_job)
                ->setInwardDc($inward)
                ->setOutwardDc($outward)
                ->setReportedIssue($remarks)
                ->setModelNo($model_no)
                ->setDate($date)
                ->setCustomerName($c_name)
                ->setMaterialDesc($mat_desc)
                ->setKwHp($kw_hp)
                ->setRework($rework)
                ->setstatus($status)
                ->setAssignedTo($assigned_to);
        
        
        $em->persist($tickets);
        
        $em->flush();

        return $this->redirectToRoute('add_ticket');
        
    }
    
    public function listTIcketAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $tickets = $em->getRepository('HESIndiaBundle:Tickets')->findAll();
        
        return $this->render('HESIndiaBundle:hes:list_ticket.html.twig', Array('count' => sizeof($tickets), 'tickets' => $tickets));
        
    }
    
    public function viewTicketAction($ticketId)
    {
        
        $em = $this->getDoctrine()->getManager();
        
        $tickets = $em->getRepository('HESIndiaBundle:Tickets')->findAll();
        
        return $this->render('HESIndiaBundle:hes:view_ticket.html.twig');
        
    }
    
    public function privacyAction()
    {
        return $this->render('HESIndiaBundle:hes:privacy.html.twig');
    }
    
    public function termsAction()
    {
        return $this->render('HESIndiaBundle:hes:terms.html.twig');
    }
    
    public function contactAction()
    {
        return $this->render('HESIndiaBundle:hes:contact.html.twig');
    }
    
    public function contacttwoAction()
    {
        return $this->render('HESIndiaBundle:hes:contacttwo.html.twig');
    }
    
    public function sidebarTemplateAction($activelink)
    {
        return $this->render('HESIndiaBundle:hes:sidebar.html.twig', Array('link' => $activelink) );
    }
    
    public function servicesidebarTemplateAction($activelink)
    {
        return $this->render('HESIndiaBundle:hes:services_sidebar.html.twig', Array('link' => $activelink) );
    }
    
    public function headerTemplateAction()
    {
        return $this->render('HESIndiaBundle:hes:header.html.twig');
    }
    
    public function footerTemplateAction()
    {
        return $this->render('HESIndiaBundle:hes:footer.html.twig');
    }
    
    public function homepageAction()
    {
        $request = $this->getRequest();
         $session = $request->getSession();   //retrieves the session object
               // get the login error if there is one
               $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

            
            if ($request->attributes->has(SecurityContext::AUTHENTICATION_ERROR)) 
            {
                  $error = $request->attributes->get(SecurityContext::AUTHENTICATION_ERROR);

            }
            else
            {
                    $error = $session->get(SecurityContext::AUTHENTICATION_ERROR);
                    $session->remove(SecurityContext::AUTHENTICATION_ERROR);

            }  
            
                    
        return $this->render('HESIndiaBundle:hes:homepage.html.twig', Array(
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error));
     
        exit();
        $em = $this->getDoctrine()->getManager();
        $table_data = $em->getRepository('HESIndiaBundle:TestingTable')->findOneByName('ramesh');
        $table_datas = $em->getRepository('HESIndiaBundle:TestingTable')->findAll();
        
        
        echo $table_data->getPlace(). '<br />';
        echo $table_data->getDate()->format('Y:m:d'). '<br />';
        echo $table_data->getTime()->format('H:i:s');
//        print_r($table_data); exit();
        
        echo count($table_datas);
        
        foreach($table_datas as $data)
        {
            echo 'inside foreach';
            echo $data->getPlace();
        }
        
        exit();
    }
    
    public function LoginSuccessAction()
    {
              $ses = $this->get('security.context')->getToken()->getUser();  //get the session context
             
             echo "Login Success".'<br/>';
             echo 'Session Id='.$ses->getSerialId().'<br/>'; 
             echo 'Session Email='.$ses->getUserEmail().'<br/>'; 
             echo '<a href="/hesindia/web/app_dev.php/logout">Sign Out</a>';
             
             exit;
    }
    
    public function loginCheckAction()
    {
        echo 'hai this is the login check form function'; exit();
    }
}
