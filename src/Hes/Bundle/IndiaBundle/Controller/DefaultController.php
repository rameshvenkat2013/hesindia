<?php

namespace Hes\Bundle\IndiaBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Security\Core\SecurityContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;
use Symfony\Component\Security\Core\Exception\UsernameNotFoundException;

use Hes\Bundle\IndiaBundle\Entity\ContactUs;
use Hes\Bundle\IndiaBundle\Entity\Tickets;
use Hes\Bundle\IndiaBundle\Entity\Engineer;
use Hes\Bundle\IndiaBundle\Entity\Customers;
use Hes\Bundle\IndiaBundle\Entity\Referrer;
use Hes\Bundle\IndiaBundle\Entity\TicketsRemarksStatus;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('HESIndiaBundle:Default:index.html.twig', array('name' => $name));
    }
    
    public function aboutUsAction()
    {
        
//        $message = \Swift_Message::newInstance()
//        ->setSubject('Hello Email')
//        ->setFrom('support@hesindia.net')
//        ->setTo('ramesh@agkiyatechnologies.com')
//        ->setBody(
//                'some sample text in the body'        );
//        
//        $this->get('mailer')->send($message);
        
        return $this->render('HESIndiaBundle:hes:aboutUs.html.twig');
    }

    public function sidebarLinksAction()
    {
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            return $this->render('HESIndiaBundle:hes:sidebar_links.html.twig', Array( 'userLevel' => $ses->getUserLevel() ));
        }
    }
    
    public function userProfileAction()
    {
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            $em = $this->getDoctrine()->getManager();
            
            if($ses->getUserLevel() == 0 || $ses->getUserLevel() == 1)
            {
                    $userInfo = $em->getRepository('HESIndiaBundle:Manager')
                    ->findOneByEnggEmail($ses->getUserEmail());
            }
            else if($ses->getUserLevel() == 2)
            {
                    $userInfo = $em->getRepository('HESIndiaBundle:Engineer')
                    ->findOneByEnggEmail($ses->getUserEmail());
            }
            
            return $this->render('HESIndiaBundle:hes:profile.html.twig', Array('email' => $ses->getUserEmail(), 'userInfo' => $userInfo,
                                'route' => 'profile') );
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }
    
    
    public function editProfileAction()
    {
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            $em = $this->getDoctrine()->getManager();
            
                if(isset($_POST['submit_referrer']) && $_POST['submit_referrer'] == 'Edit Referrer')
                {

                $data =  Array();

                $field['ref_id'] = $data[0]['value']    =   $referrer_id = $request->request->get('ref_id');
                $data[0]['key']    =   'ref_id';
                $data[0]['constraint'][0]    =   'notblank';

                $field['ref_name'] = $data[1]['value']            =   $referrer_name      = $request->request->get('ref_name');
                $data[1]['key']    =   'ref_name';
                $data[1]['constraint'][0]    =   'notblank';

                $field['email_id'] = $data[2]['value']    =   $email_id      = $request->request->get('email_id');
                $data[2]['key']    =   'email_id';
                $data[2]['constraint'][0]    =   'notblank';
                $data[2]['constraint'][1]    =   'email';

                $field['mobile_no'] = $data[3]['value']    =   $mobile_no      = $request->request->get('mobile_no');
                $data[3]['key']    =   'mobile_no';
                $data[3]['constraint'][0]    =   'notblank';
                //$data[3]['constraint'][1]    =   'number';

                $field['address1'] = $data[4]['value']    =   $address1      = $request->request->get('address1');
                $data[4]['key']    =   'address1';
                $data[4]['constraint'][0]    =   'notblank';

                $field['address2'] = $data[5]['value']    =   $address2      = $request->request->get('address2');
                $data[5]['key']    =   'address2';
                $data[5]['constraint'][0]    =   'notblank';

                $field['pincode'] = $data[6]['value']    =   $pincode      = $request->request->get('pincode');
                $data[6]['key']    =   'pincode';
                $data[6]['constraint'][0]    =   'notblank';


                $field['city'] = $data[7]['value']    =   $city      = $request->request->get('city');
                $data[7]['key']    =   'city';
                $data[7]['constraint'][0]    =   'notblank';


                $field['state'] = $data[8]['value']    =   $state      = $request->request->get('state');
                $data[8]['key']    =   'state';
                $data[8]['constraint'][0]    =   'notblank';


                $remarks      = $request->request->get('remarks');

                $error = $this->validationAction($data);

    //            print_r($field); exit();

                if(count($error) > 0)
                {
                    return $this->render('HESIndiaBundle:hes:edit_referrer.html.twig', Array( 'error' => $error, 'field' => $field, 'email' => $ses->getUserEmail() ) );
                }
                else
                {

                            $em = $this->getDoctrine()->getManager();

                        $refInfo = $em->getRepository('HESIndiaBundle:Referrer')
                                        ->findOneByReferrerId($ref_id);

                            $refInfo->setReferrerName($referrer_name)
                                    ->setEmail($email_id)
                                    ->setMobileNo($mobile_no)
                                    ->setAddress1($address1)
                                    ->setAddress2($address2)
                                    ->setPincode($pincode)
                                    ->setCity($city)
                                    ->setState($state)
                                    ->setRemarks($remarks);

                            $em->flush();

                            return $this->redirectToRoute('ref_profile', Array('refId' => $referrer_id), 301);

                }

            }
            else
            {

                $em = $this->getDoctrine()->getManager();


                if($ses->getUserLevel() == 0 || $ses->getUserLevel() == 1)
                {
                        $userInfo = $em->getRepository('HESIndiaBundle:Manager')
                        ->findOneByEnggEmail($ses->getUserEmail());
                }
                else if($ses->getUserLevel() == 2)
                {
                        $userInfo = $em->getRepository('HESIndiaBundle:Engineer')
                        ->findOneByEnggEmail($ses->getUserEmail());
                }

                $refInfo = $em->getRepository('HESIndiaBundle:Referrer')
                        ->findOneByReferrerId($ref_id);

                $field = Array();

                $field['email'] =  $userInfo->getEmail();

                return $this->render('HESIndiaBundle:hes:edit_profile.html.twig', Array( 'field' => $field, 'email' => $ses->getUserEmail() ) );

            }
        
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
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
            $services[$i]['file'] = $data->getServiceFile();
            $i++;
        }
        
        return $this->render('HESIndiaBundle:hes/services:'.$link.'_services.html.twig', Array('activelink' => $activelink, 'services' => $services));
    }

    public function faqAction()
    {
        $em = $this->getDoctrine()->getManager();
        $faqQA = $em->getRepository('HESIndiaBundle:Faq')->findAll();
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            return $this->render('HESIndiaBundle:hes:faq.html.twig', Array('faq' => $faqQA, 'session' => 'no', 'email' => $ses->getUserEmail() ));
        }
        else
        {
            return $this->render('HESIndiaBundle:hes:faq.html.twig', Array('faq' => $faqQA, 'session' => 'no', 'email' => 'nothing' ));
        }

    }

    public function searchTicketAction(Request $request)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            $em = $this->getDoctrine()->getManager();
            
            $material_id = $cust_name = '000';

            $material_id = $request->request->get('mat_id');
            $material_id = (isset($material_id)) ? $material_id : '' ;
            
            $cust_name = $request->request->get('cust_name');
            $cust_name = (isset($cust_name)) ? $cust_name : '' ;
            
            $where = '';
            
            $first_where = 0;
            
            if(isset($material_id))
            {
                $first_where = 1;
                $where .= 't.jobNo = :job_no';
            }
            
            if(isset($cust_name))
            {
                
                if($first_where == 0)
                {
                    $where .= 't.customerId = :customer_id';
                }
                else if($first_where == 1)
                {
                    $where .= ' OR t.customerId = :customer_id';
                }
            }
            
            $customerInfo = $em->getRepository('HESIndiaBundle:Customers')->findAll();
            
            sort($customerInfo);

            $not_found = 'false';
            $found = 'false';
            
            $query = $em->createQuery(
                        'SELECT t.date,
                            t.customerId,
                            t.reportedIssue,
                            t.ticketId,
                            t.ticketStatus
                        FROM HESIndiaBundle:Tickets t where '. $where
                    )->setParameter('job_no', $material_id)->setParameter('customer_id' , $cust_name);

                $result = $query->getResult();

                if(isset($_POST['submit_search']) && $_POST['submit_search'] == 'Search the Ticket' )
                {
                    if(count($result) >= 1)
                    {
                        $found = 'true';
                    }
                    else
                    {
                        $not_found = 'true';
                    }
                }

            return $this->render('HESIndiaBundle:hes:search_ticket.html.twig', Array( 'email' =>$ses->getUserEmail(), 'mat_id' => $material_id,
                                    'mat_id' => $material_id,
                                    'cust_id' => $cust_name,
                                    'not_found' => $not_found,
                                    'found' => $found,
                                    'tickets' => $result,
                                    'customerInfo' => $customerInfo
                                ));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }

    public function addTicketAction(Request $request)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            $em = $this->getDoctrine()->getManager();
            $custList = $em->getRepository('HESIndiaBundle:Customers')->findAll();
            
            sort($custList);
            
            if($request->request->get('submit_ticket') == 'Submit')
            {
                    $total_cnt         = $request->request->get('total_cnt');
                    
                        $date           = date("Y/m/d");    //$request->request->get('date');
                        $date           = new \DateTime($date);
                        
                        $c_name         = $request->request->get('comp_name');
                        $inward         = $request->request->get('inward_dc');
                        $rgp_date       = $request->request->get('rgp_date');
                        $rgp_date       = new \DateTime($rgp_date);
                        $job         = $request->request->get('job_no');
                        
                    for($i=0; $i<$total_cnt; $i++)
                    {
                        
                        
                        $serial_no      = $request->request->get('serialno_'.$i);
                        $old_job        = $request->request->get('oldjob_'.$i);
                        $issue_reported = $request->request->get('reportedissue_'.$i);
                        $model_no       = $request->request->get('model_'.$i);
                        $mat_desc       = $request->request->get('matdesc_'.$i);
                        $kw_hp          = $request->request->get('kwhp_'.$i);
                        $remarks        = $request->request->get('remarks_'.$i);
                        
                        $job_no         = 'H'. $job . '/' . ($i+1);
                        
                        $outward_dc = '';

                        $ticket_id = substr(md5($job_no), 0, 6);
                        
                                $tickets = new Tickets();

                    $em = $this->getDoctrine()->getManager();

                    $tickets->setTicketId($ticket_id)
                            ->setJobNo($job_no)
                            ->setSerialNo($serial_no)
                            ->setOldJobNo($old_job)
                            ->setInwardDc($inward)
                            ->setOutwardDc('')
                            ->setReportedIssue($issue_reported)
                            ->setModelNo($model_no)
                            ->setDate($date)
                            ->setRgpDate($rgp_date)
                            ->setCustomerId($c_name)
                            ->setMaterialDesc($mat_desc)
                            ->setKwHp($kw_hp)
                            ->setRework('no')
                            ->setReportedStatus('unassigned')
                            ->setAssignedTo(0)
                            ->setTicketStatus('Open')
                            ->setRemarks($remarks);

                    $em->persist($tickets);

                    $em->flush();
                    

                    }
                    
                    return $this->redirectToRoute('print_mra', Array('job_no' => $job), 301);

            }
            
                $query = $em->createQuery(
                'SELECT t FROM HESIndiaBundle:Tickets t ORDER BY t.rowId DESC'
                );

                $ticket_result = $query->setMaxResults(1)->getResult();
                
                foreach($ticket_result as $data)
                {
                    $jobno = $data->getJobNo();
                }
                
                $jobno = explode('/', $jobno);
                $jobno = substr($jobno[0], 1);
                $new_jobno = $jobno + 1;
                
            return $this->render('HESIndiaBundle:hes:add_ticket.html.twig', Array( 'email' =>$ses->getUserEmail(), 'custlist' => $custList, 
                'newjobno' => $new_jobno ));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }
    
    
    public function printmraAction($job_no)
    {
        
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            return $this->render('HESIndiaBundle:hes:mra_ticket_details.html.twig', Array( 'email' =>$ses->getUserEmail(), 'job_no' => $job_no ) );
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }
    
    
    public function displaymraAction($job_no)
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            
            $em = $this->getDoctrine()->getManager();
            
            $job_no = 'H'. $job_no;
            
            $query = $em->createQuery(
                        "SELECT t.date,
                            t.customerId,
                            t.materialDesc mat_desc,
                            t.modelNo,
                            t.serialNo,
                            t.reportedIssue,
                            t.inwardDc,
                            t.rgpDate
                        FROM HESIndiaBundle:Tickets t where t.jobNo LIKE '$job_no%'
                    "); //->setParameter('job_no', $job_no);

                $result = $query->getResult();
                
                if($result>1)
                {
                    
                    foreach($result as $data)
                    {
                        $customerId = $data['customerId'];
                        $inwardDc = $data['inwardDc'];
                        $date = $data['date'];
                        $rgp_date = $data['rgpDate'];
                    }
                    
                }
                
                
                $custInfo = $em->getRepository('HESIndiaBundle:Customers')
                    ->findOneByCompanyId($customerId);
                
            return $this->render('HESIndiaBundle:hes:mra_template.html.twig', Array( 'email' =>$ses->getUserEmail(), 'custInfo' => $custInfo,
                                    'job_no' => $job_no, 'ticket' => $result, 'date' => $date, 'rgp_date' => $rgp_date, 'inwarddc' => $inwardDc ) );
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }
    
    public function ticketContentsAction(Request $request)
    {
        

        $date           = $request->request->get('date');
        $date           = new \DateTime($date);
        
        $c_name         = $request->request->get('name');
        $model_no       = $request->request->get('mobile');
        $inward         = $request->request->get('inward');
        $old_job        = $request->request->get('oldjob');
        $outward        = $request->request->get('outward');
        $mat_desc       = $request->request->get('matdesc');
        $kw_hp          = $request->request->get('kwhp');
        $serial_no      = $request->request->get('serialno');
        $job_no         = $request->request->get('jobno');
        $rework         = $request->request->get('rework');
        $issue_reported = $request->request->get('reportedIssue');
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
                ->setReportedIssue($issue_reported)
                ->setModelNo($model_no)
                ->setDate($date)
                ->setCustomerId($c_name)
                ->setMaterialDesc($mat_desc)
                ->setKwHp($kw_hp)
                ->setRework($rework)
                ->setstatus('in progress')
                ->setAssignedTo($assigned_to)
                ->setTicketStatus('Open')
                ->setRemarks($remarks);
        
        
        $em->persist($tickets);
        
        $em->flush();

        return $this->redirectToRoute('add_ticket', Array(), 301);
        
    }
    
    public function listTIcketAction()
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context
        
        if(gettype($ses) === 'object' )
        {
            
            $userEmail = $ses->getUserEmail();

            $em = $this->getDoctrine()->getManager();

            if($ses->getUserLevel() == 0)
            {
                    //$tickets_unassigned = $em->getRepository('HESIndiaBundle:Tickets')->findByReportedStatus('unassigned');
//                    $tickets_unapproved = $em->getRepository('HESIndiaBundle:Tickets')->findByReportedStatus('unapproved');
//                    $tickets_unrepaired = $em->getRepository('HESIndiaBundle:Tickets')->findByReportedStatus('unrepaired');
//                    $tickets_repaired   = $em->getRepository('HESIndiaBundle:Tickets')->findByReportedStatus('repaired');
//                    $tickets_inprogress = $em->getRepository('HESIndiaBundle:Tickets')->findByReportedStatus('in_progress');
                
                
                $query = $em->createQuery(
                        'SELECT t.date,
                            t.customerId,
                            t.reportedIssue,
                            t.ticketId,
                            t.ticketStatus,
                            t.jobNo,
                            t.assignedTo,
                            t.modelNo,
                            t.remarks
                        FROM HESIndiaBundle:Tickets t where t.reportedStatus = :status ORDER BY t.rowId DESC'
                    )->setParameter('status', 'unassigned')->setMaxResults(6);

                $tickets_unassigned = $query->getResult();
                
                
                $query = $em->createQuery(
                        'SELECT t.date,
                            t.customerId,
                            t.reportedIssue,
                            t.ticketId,
                            t.ticketStatus,
                            t.jobNo,
                            t.assignedTo,
                            t.modelNo,
                            t.remarks
                        FROM HESIndiaBundle:Tickets t where t.reportedStatus = :status ORDER BY t.rowId DESC'
                    )->setParameter('status', 'unapproved')->setMaxResults(6);

                $tickets_unapproved = $query->getResult();
                
                
                
                $query = $em->createQuery(
                        'SELECT t.date,
                            t.customerId,
                            t.reportedIssue,
                            t.ticketId,
                            t.ticketStatus,
                            t.jobNo,
                            t.assignedTo,
                            t.modelNo,
                            t.remarks
                        FROM HESIndiaBundle:Tickets t where t.reportedStatus = :status ORDER BY t.rowId DESC'
                    )->setParameter('status', 'unrepaired')->setMaxResults(6);

                $tickets_unrepaired = $query->getResult();
                
                
                
                
                $query = $em->createQuery(
                        'SELECT t.date,
                            t.customerId,
                            t.reportedIssue,
                            t.ticketId,
                            t.ticketStatus,
                            t.jobNo,
                            t.assignedTo,
                            t.modelNo,
                            t.remarks
                        FROM HESIndiaBundle:Tickets t where t.reportedStatus = :status ORDER BY t.rowId DESC'
                    )->setParameter('status', 'repaired')->setMaxResults(6);

                $tickets_repaired = $query->getResult();
                
                
                
                
                $query = $em->createQuery(
                        'SELECT t.date,
                            t.customerId,
                            t.reportedIssue,
                            t.ticketId,
                            t.ticketStatus,
                            t.jobNo,
                            t.assignedTo,
                            t.modelNo,
                            t.remarks
                        FROM HESIndiaBundle:Tickets t where t.reportedStatus = :status ORDER BY t.rowId DESC'
                    )->setParameter('status', 'in_progress')->setMaxResults(6);

                $tickets_inprogress = $query->getResult();
                    
                
                
                $query = $em->createQuery(
                        'SELECT t.date,
                            t.customerId,
                            t.reportedIssue,
                            t.ticketId,
                            t.ticketStatus,
                            t.jobNo,
                            t.assignedTo,
                            t.modelNo,
                            t.remarks
                        FROM HESIndiaBundle:Tickets t where t.reportedStatus = :status ORDER BY t.rowId DESC'
                    )->setParameter('status', 'comprequired')->setMaxResults(6);

                $tickets_comprequired = $query->getResult();
                
                $query = $em->createQuery(
                        'SELECT t.date,
                            t.customerId,
                            t.reportedIssue,
                            t.ticketId,
                            t.ticketStatus,
                            t.jobNo,
                            t.assignedTo,
                            t.modelNo,
                            t.remarks
                        FROM HESIndiaBundle:Tickets t where t.reportedStatus = :status ORDER BY t.rowId DESC'
                    )->setParameter('status', 'apprrequired')->setMaxResults(6);

                $tickets_apprrequired = $query->getResult();

                    return $this->render('HESIndiaBundle:hes:list_ticket.html.twig', 
                                        Array(
                                                        'tickets_unassigned' => $tickets_unassigned, 
                                                        'tickets_unapproved' => $tickets_unapproved,
                                                        'tickets_unrepaired' => $tickets_unrepaired,
                                                        'tickets_repaired' => $tickets_repaired,
                                                        'tickets_inprogress' => $tickets_inprogress,
                                                        'tickets_comprequired' => $tickets_comprequired,
                                                        'tickets_apprrequired' => $tickets_apprrequired,
                                                        'email' => $userEmail,
                                                        'userLevel' => $ses->getUserLevel()
                                              ));

            }
            else if($ses->getUserLevel() == 2)
            {
                    $enggInfo = $em->getRepository('HESIndiaBundle:Engineer')->findOneByEnggEmail($userEmail);
                    
                    $tickets = $em->getRepository('HESIndiaBundle:Tickets')->findByAssignedTo($enggInfo->getEnggId());
                    
                    return $this->render('HESIndiaBundle:hes:list_ticket_engineer.html.twig', 
                                        Array(
                                                        'tickets' => $tickets,
                                                        'engg_name' => $enggInfo->getEngineerName(),
                                                        'email' => $userEmail
                                              ));
                    
            }
            else if($ses->getUserLevel() == 1)
            {
                    $adminInfo = $em->getRepository('HESIndiaBundle:Manager')->findOneByEnggEmail($userEmail);
                    
                    $tickets = $em->getRepository('HESIndiaBundle:Tickets')->findByAssignedTo($adminInfo->getEnggId());
                    
                    return $this->render('HESIndiaBundle:hes:list_ticket_admin.html.twig', 
                                        Array(
                                                        'tickets' => $tickets,
                                                        'engg_name' => $adminInfo->getEngineerName(),
                                                        'email' => $userEmail
                                              ));
                    
            }

        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }

    }
    
    public function printTicketAction()
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            $em = $this->getDoctrine()->getManager();
            
            $query = $em->createQuery(
                        'SELECT 
                            t.customerId,
                            t.jobNo job_no,
                            t.materialDesc mat_desc,
                            t.reportedIssue issue,
                            t.date
                        FROM HESIndiaBundle:Tickets t GROUP BY t.customerId ORDER BY t.date'
                    );

                $result = $query->getResult();
                
            return $this->render('HESIndiaBundle:hes:printlist_tickets.html.twig', Array( 'email' =>$ses->getUserEmail(), 'printlist' => $result ));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }

    }


    public function viewTicketAction($ticketId)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {

            $em = $this->getDoctrine()->getManager();

            $ticket = $em->getRepository('HESIndiaBundle:Tickets')->findOneByTicketId($ticketId);

            $block_engg_comment = 'false';

            if($ticket->getAssignedTo() != 0)
            {
                $enggInfo = $em->getRepository('HESIndiaBundle:Engineer')->findOneByEnggId($ticket->getAssignedTo());
            }
            else
            {
                $enggInfo['EngineerName'] = 'Prakash M Gowda';
                $block_engg_comment = 'true';
            }
            
            $customerInfo = $em->getRepository('HESIndiaBundle:Customers')->findOneByCompanyId($ticket->getCustomerId());
            
            $ticketremarks = $em->getRepository('HESIndiaBundle:TicketsRemarksStatus')->findByTicketId($ticketId);

            $enggList = $em->getRepository('HESIndiaBundle:Engineer')->findByActiveStatus(1);

            return $this->render('HESIndiaBundle:hes:view_ticket.html.twig', 
                                    Array('ticket' => $ticket, 'email' => $ses->getUserEmail(), 'enggInfo' => $enggInfo, 
                                                            'ticketsremarks' => $ticketremarks, 'block_comment' => $block_engg_comment, 
                                                'user_level' => $ses->getUserLevel(), 'engg_list' => $enggList, 
                                                'customerName' => $customerInfo->getCompanyName()));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }

    }


    public function storeRemarksAction(Request $request)
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context
        
        if(gettype($ses) === 'object' )
        {

            $em = $this->getDoctrine()->getManager();
            
            $ticket_id = $request->request->get('ticket_id');
            $remark = $request->request->get('remark');
            
            if($ses->getUserLevel() == 0 || $ses->getUserLevel() == 1)
            {

                $reassignedTo = $request->request->get('reassignto');
                $reportstatus = $request->request->get('reportstatus');

                $assignedToUpdate = $em->getRepository('HESIndiaBundle:Tickets')->findOneByTicketId($ticket_id);

                $assignedToUpdate->setAssignedTo($reassignedTo);
                $assignedToUpdate->setReportedStatus($reportstatus);

                $em->flush($assignedToUpdate);
                
                $enggId = 2;
                $enggName = 'Prakash M Gowda';
                $enggEmail = 'pmgowda@hesindia.net';
            }
            else
            {
                $enggInfo = $em->getRepository('HESIndiaBundle:Engineer')->findOneByEnggEmail($ses->getUserEmail());
                
                $assignedToUpdate = $em->getRepository('HESIndiaBundle:Tickets')->findOneByTicketId($ticket_id);
                
                $reportstatus = $request->request->get('reportstatus');
                
                $assignedToUpdate->setAssignedTo(0);
                $assignedToUpdate->setReportedStatus($reportstatus);
                
                $em->flush($assignedToUpdate);

                $enggId = $enggInfo->getEnggId();
                $enggName = $enggInfo->getEngineerName();
                $enggEmail = $enggInfo->getEnggEmail();
            }

            $ticketRemarks = new TicketsRemarksStatus();

            $ticketRemarks->setTicketId($ticket_id);
            $ticketRemarks->setEnggId($enggId);
            $ticketRemarks->setEnggName($enggName);
            $ticketRemarks->setEnggEmail($enggEmail);
            $ticketRemarks->setEnggRemarks($remark);

            $em->persist($ticketRemarks);

            $em->flush();
            
            return $this->redirectToRoute('list_ticket', Array(), 301);
            
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
        
    }
    
    public function openTicketAction($ticketid)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            $em = $this->getDoctrine()->getManager();
            $ticketInfo = $em->getRepository('HESIndiaBundle:Tickets')->findOneByTicketId($ticketid);
            
            $ticketInfo->setTicketStatus('Open');
            
            $em->persist($ticketInfo);
            $em->flush();

            return $this->redirectToRoute('view_ticket', Array('ticketId' => $ticketid), 301);
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }

    public function closeTicketAction($ticketid)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            
            $em = $this->getDoctrine()->getManager();
            $ticketInfo = $em->getRepository('HESIndiaBundle:Tickets')->findOneByTicketId($ticketid);
            
            $ticketInfo->setTicketStatus('Closed');
            
            $em->persist($ticketInfo);
            $em->flush();

            return $this->redirectToRoute('list_ticket', Array(), 301);
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }

    
    public function addCustomerAction(Request $request)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            $em = $this->getDoctrine()->getManager();
            
            if(isset($_POST['submit_customer']) && $_POST['submit_customer'] == 'Add Customer')
            {

                
            $data =  Array();

            $field['comp_name'] = $data[0]['value']    =   $comp_name = $request->request->get('comp_name');
            $data[0]['key']    =   'comp_name';
            $data[0]['constraint'][0]    =   'notblank';

            $field['contact_person'] = $data[1]['value']            =   $contact_person      = $request->request->get('contact_person');
            $data[1]['key']    =   'contact_person';
            $data[1]['constraint'][0]    =   'notblank';

            $field['email_id'] = $data[2]['value']    =   $email_id      = $request->request->get('email_id');
            $data[2]['key']    =   'email_id';
            $data[2]['constraint'][0]    =   'notblank';
            $data[2]['constraint'][1]    =   'email';
            
            $field['designation'] = $data[3]['value']    =   $designation      = $request->request->get('designation');
            $data[3]['key']    =   'designation';
            $data[3]['constraint'][0]    =   'notblank';
            
            $field['mobile_no'] = $data[4]['value']    =   $mobile_no      = $request->request->get('mobile_no');
            $data[4]['key']    =   'mobile_no';
            $data[4]['constraint'][0]    =   'notblank';
            
            $field['tele_no'] = $data[5]['value']    =   $tele_no      = $request->request->get('tele_no');
            $data[5]['key']    =   'tele_no';
            $data[5]['constraint'][0]    =   'notblank';
            
            $field['address1'] = $data[6]['value']    =   $address1      = $request->request->get('address1');
            $data[6]['key']    =   'address1';
            $data[6]['constraint'][0]    =   'notblank';
            
            $field['address2'] = $data[7]['value']    =   $address2      = $request->request->get('address2');
            $data[7]['key']    =   'address2';
            $data[7]['constraint'][0]    =   'notblank';
            
            $field['pincode'] = $data[8]['value']    =   $pincode      = $request->request->get('pincode');
            $data[8]['key']    =   'pincode';
            $data[8]['constraint'][0]    =   'notblank';
            
            $field['city'] = $data[9]['value']    =   $city      = $request->request->get('city');
            $data[9]['key']    =   'city';
            $data[9]['constraint'][0]    =   'notblank';
            
            $field['state'] = $data[10]['value']    =   $state      = $request->request->get('state');
            $data[10]['key']    =   'state';
            $data[10]['constraint'][0]    =   'notblank';
            
            $field['tin_no'] = $data[11]['value']    =   $tin_no      = $request->request->get('tin_no');
            $data[11]['key']    =   'tin_no';
            $data[11]['constraint'][0]    =   'notblank';
            
            $field['addtl_info'] = $data[12]['value']    =   $addtl_info      = $request->request->get('addtl_info');
            $data[12]['key']    =   'addtl_info';
            $data[12]['constraint'][0]    =   'notblank';
            
            $field['ref_by'] = $data[13]['value']    =   $ref_by      = $request->request->get('ref_by');
            $data[13]['key']    =   'ref_by';
            $data[13]['constraint'][0]    =   'notblank';
            
            $field['remarks'] = $data[14]['value']    =   $remarks      = $request->request->get('remarks');
            $data[14]['key']    =   'remarks';
            $data[14]['constraint'][0]    =   'notblank';
            
            $field['website'] = $data[15]['value']    =   $website      = $request->request->get('website');
            $data[15]['key']    =   'website';
            $data[15]['constraint'][0]    =   'notblank';
            
            $error = $this->validationAction($data);
            
            if(count($error) > 0)
            {
                return $this->render('HESIndiaBundle:hes:add_customer.html.twig', Array( 'error' => $error, 'field' => $field, 'email' => $ses->getUserEmail() ) );
            }
            else
            {

                        $em = $this->getDoctrine()->getManager();
                        $customer = new Customers();

                        $company_id     = substr(md5($comp_name . $email_id), 0, 8);

                        $customer->setCompanyName($comp_name)
                                 ->setContactPerson($contact_person)
                                 ->setCompanyId($company_id)
                                ->setDesignation($designation)
                                ->setMobileNo($mobile_no)
                                ->setPhoneNo($tele_no)
                                ->setAddress1($address1)
                                ->setAddress2($address2)
                                ->setPincode($pincode)
                                ->setCity($city)
                                ->setState($state)
                                ->setEmail($email_id)
                                ->setWebsite($website)
                                ->setTinNo($tin_no)
                                ->setAdditionalDetails($addtl_info)
                                ->setReferredBy($ref_by)
                                ->setRemarks($remarks);

                        $em->persist($customer);

                        $em->flush();

                        return $this->redirectToRoute('add_customer', Array(), 301);

            }

        }
            
            return $this->render('HESIndiaBundle:hes:add_customer.html.twig', Array( 'email' =>$ses->getUserEmail()));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }
    
    
    
    public function editCustomerAction(Request $request, $comp_id)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            
            $em = $this->getDoctrine()->getManager();
            
        if(isset($_POST['submit_customer']) && $_POST['submit_customer'] == 'Edit Customer')
        {
            
$data =  Array();

            $field['comp_name'] = $data[0]['value']    =   $comp_name = $request->request->get('comp_name');
            $data[0]['key']    =   'comp_name';
            $data[0]['constraint'][0]    =   'notblank';

            $field['contact_person'] = $data[1]['value']            =   $contact_person      = $request->request->get('contact_person');
            $data[1]['key']    =   'contact_person';
            $data[1]['constraint'][0]    =   'notblank';

            $field['email_id'] = $data[2]['value']    =   $email_id      = $request->request->get('email_id');
            $data[2]['key']    =   'email_id';
            $data[2]['constraint'][0]    =   'notblank';
            $data[2]['constraint'][1]    =   'email';
            
            $field['designation'] = $data[3]['value']    =   $designation      = $request->request->get('designation');
            $data[3]['key']    =   'designation';
            $data[3]['constraint'][0]    =   'notblank';
            
            $field['mobile_no'] = $data[4]['value']    =   $mobile_no      = $request->request->get('mobile_no');
            $data[4]['key']    =   'mobile_no';
            $data[4]['constraint'][0]    =   'notblank';
            
            $field['tele_no'] = $data[5]['value']    =   $tele_no      = $request->request->get('tele_no');
            $data[5]['key']    =   'tele_no';
            $data[5]['constraint'][0]    =   'notblank';
            
            $field['address1'] = $data[6]['value']    =   $address1      = $request->request->get('address1');
            $data[6]['key']    =   'address1';
            $data[6]['constraint'][0]    =   'notblank';
            
            $field['address2'] = $data[7]['value']    =   $address2      = $request->request->get('address2');
            $data[7]['key']    =   'address2';
            $data[7]['constraint'][0]    =   'notblank';
            
            $field['pincode'] = $data[8]['value']    =   $pincode      = $request->request->get('pincode');
            $data[8]['key']    =   'pincode';
            $data[8]['constraint'][0]    =   'notblank';
            
            $field['city'] = $data[9]['value']    =   $city      = $request->request->get('city');
            $data[9]['key']    =   'city';
            $data[9]['constraint'][0]    =   'notblank';
            
            $field['state'] = $data[10]['value']    =   $state      = $request->request->get('state');
            $data[10]['key']    =   'state';
            $data[10]['constraint'][0]    =   'notblank';
            
            $field['tin_no'] = $data[11]['value']    =   $tin_no      = $request->request->get('tin_no');
            $data[11]['key']    =   'tin_no';
            $data[11]['constraint'][0]    =   'notblank';
            
            $field['addtl_info'] = $data[12]['value']    =   $addtl_info      = $request->request->get('addtl_info');
            $data[12]['key']    =   'addtl_info';
            $data[12]['constraint'][0]    =   'notblank';
            
            $field['ref_by'] = $data[13]['value']    =   $ref_by      = $request->request->get('ref_by');
            $data[13]['key']    =   'ref_by';
            $data[13]['constraint'][0]    =   'notblank';
            
            $field['remarks'] = $data[14]['value']    =   $remarks      = $request->request->get('remarks');
            $data[14]['key']    =   'remarks';
            $data[14]['constraint'][0]    =   'notblank';
            
            $field['website'] = $data[15]['value']    =   $website      = $request->request->get('website');
            $data[15]['key']    =   'website';
            $data[15]['constraint'][0]    =   'notblank';
            
            $error = $this->validationAction($data);
            
            if(count($error) > 0)
            {
                return $this->render('HESIndiaBundle:hes:edit_customer.html.twig', Array( 'error' => $error, 'field' => $field, 'email' => $ses->getUserEmail(),
                                    'compId' => $comp_id ) );
            }
            else
            {

                        $em = $this->getDoctrine()->getManager();
                        
                    $custInfo = $em->getRepository('HESIndiaBundle:Customers')
                                    ->findOneByCompanyId($comp_id);
                    
                        $custInfo->setContactPerson($contact_person)
                                ->setDesignation($designation)
                                ->setMobileNo($mobile_no)
                                ->setPhoneNo($tele_no)
                                ->setAddress1($address1)
                                ->setAddress2($address2)
                                ->setPincode($pincode)
                                ->setCity($city)
                                ->setState($state)
                                ->setEmail($email_id)
                                ->setWebsite($website)
                                ->setTinNo($tin_no)
                                ->setAdditionalDetails($addtl_info)
                                ->setReferredBy($ref_by)
                                ->setRemarks($remarks);

                        $em->flush();

                        return $this->redirectToRoute('cust_profile', Array('compId' => $comp_id), 301);

            }

        }
        else
        {
            

            $em = $this->getDoctrine()->getManager();
            
            $custInfo = $em->getRepository('HESIndiaBundle:Customers')
                    ->findOneByCompanyId($comp_id);
            
            $field = Array();

            $field['comp_name'] = $custInfo->getCompanyName();
            $field['contact_person'] =  $custInfo->getContactPerson();
            $field['designation'] =  $custInfo->getDesignation();
            $field['mobile_no'] =  $custInfo->getMobileNo();
            $field['tele_no'] =  $custInfo->getPhoneNo();
            $field['email_id'] =  $custInfo->getEmail();
            $field['website'] =  $custInfo->getWebsite();
            $field['tin_no'] =  $custInfo->getTinNo();
            
            $field['address1'] =  $custInfo->getAddress1();
            $field['address2'] =  $custInfo->getAddress2();
            $field['pincode'] =  $custInfo->getPincode();
            $field['city'] =  $custInfo->getCity();
            $field['state'] =  $custInfo->getState();
            $field['addtl_info'] =  $custInfo->getAdditionalDetails();
            $field['ref_by'] =  $custInfo->getReferredBy();
            $field['remarks'] =  $custInfo->getRemarks();

            return $this->render('HESIndiaBundle:hes:edit_customer.html.twig', Array( 'field' => $field, 
                        'email' => $ses->getUserEmail(),'compId' => $comp_id  ) );

        }

        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }



    public function listCustomerAction($pageNo)
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            $em = $this->getDoctrine()->getManager();
//            $custList = $em->getRepository('HESIndiaBundle:Customers')->findAll();

            $limit = $pageNo * 15;

                $query = $em->createQuery(
                'SELECT c FROM HESIndiaBundle:Customers c ORDER BY c.rowId '
                );

                $recordCount = $query->getResult();

                $custList = $query->setMaxResults(15)->setFirstResult($limit)->getResult();
                
                $lastPage = 'false';

                if($recordCount <= 15)
                    $lastPage = 'true';
                else if(count($recordCount) - $pageNo * 15 <= 15)
                    $lastPage = 'true';
                
                
                $custLists = $em->getRepository('HESIndiaBundle:Customers')->findAll();
            
                sort($custLists);
                
//                $count = (int)count($recordCount) - $pageNo * 15;
                
            return $this->render('HESIndiaBundle:hes:list_customer.html.twig', Array( 'email' =>$ses->getUserEmail(), 'custList' => $custList, 
                'pageno' => $pageNo, 'lastPage' => $lastPage, 'custlists' => $custLists ));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }

    }


    public function unassignedListAction($pageNo)
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            $em = $this->getDoctrine()->getManager();
//            $custList = $em->getRepository('HESIndiaBundle:Customers')->findAll();
            
            $limit = $pageNo * 15;

                $query = $em->createQuery(
                'SELECT t FROM HESIndiaBundle:Tickets t WHERE t.reportedStatus = :unassigned ORDER BY t.rowId'
                )->setParameter('unassigned', 'unassigned');

                $recordCount = $query->getResult();
                
                $custList = $query->setMaxResults(15)->setFirstResult($limit)->getResult();
                
                $lastPage = 'false';

                if($recordCount <= 15)
                    $lastPage = 'true';
                else if(count($recordCount) - $pageNo * 15 <= 15)
                    $lastPage = 'true';
                
//                $count = (int)count($recordCount) - $pageNo * 15;
            
            return $this->render('HESIndiaBundle:hes:list_unassigned_material.html.twig', Array( 'email' =>$ses->getUserEmail(), 'custList' => $custList, 
                'pageno' => $pageNo, 'lastPage' => $lastPage ));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }

    }

    public function custProfileAction($compId)
    {
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {

            $em = $this->getDoctrine()->getManager();

            $userInfo = $em->getRepository('HESIndiaBundle:Customers')
                    ->findOneByCompanyId($compId);

            return $this->render('HESIndiaBundle:hes:customer_profile.html.twig', Array('email' => $ses->getUserEmail(), 'userInfo' => $userInfo, 
                        'comp_id' => $compId ) );
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }
    
    public function customerInfoAction(Request $request)
    {
        
        $company_name  = $request->request->get('comp_name');
        $contact_person = $request->request->get('contact_person');
        $designation    = $request->request->get('designation');
        $email_id       = $request->request->get('email_id');
        $mobile_no      = $request->request->get('mobile_no');
        $tele_no        = $request->request->get('tele_no');
        $tin_no         = $request->request->get('tin_no');
        
        $address1       = $request->request->get('address1');
        $address2       = $request->request->get('address2');
        $pincode        = $request->request->get('pincode');
        $city           = $request->request->get('city');
        $state          = $request->request->get('state');
        $addtl_info     = $request->request->get('addtl_info');
        $ref_by         = $request->request->get('ref_by');
        $website        = $request->request->get('website');
        $remarks        = $request->request->get('remarks');
        
        $company_id     = substr(md5($company_name . $email), 0, 8);

        $customer = new Customers();

        $em = $this->getDoctrine()->getManager();
        
        $customer->setCompanyName($company_name)
                 ->setContactId($company_id)
                 ->setContactPerson($contact_person)
                ->setDesignation($designation)
                ->setEmail($email_id)
                ->setMobileNo($mobile_no)
                ->setPhoneNo($tele_no)
                ->setTinNo($tin_no)
                ->setAddress1($address1)
                ->setAddress2($address2)
                ->setPincode($pincode)
                ->setCity($city)
                ->setState($state)
                ->setAdditionalDetails($addtl_info)
                ->setReferredBy($ref_by)
                ->setWebsite($website)
                ->setRemarks($remarks);

        $em->persist($customer);
        
        $em->flush();

        return $this->redirectToRoute('add_customer', Array(), 301);
        
    }
    
    
    public function addEngineerAction(Request $request)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
               
            $em = $this->getDoctrine()->getManager();
            
        if(isset($_POST['submit_engineer']) && $_POST['submit_engineer'] == 'Add Engineer')
        {

            $data =  Array();

            $field['engineer_id'] = $data[0]['value']    =   $engineer_id = $request->request->get('engineer_id');
            $data[0]['key']    =   'engineer_id';
            $data[0]['constraint'][0]    =   'notblank';

            $field['engineer_name'] = $data[1]['value']            =   $engineer_name      = $request->request->get('engineer_name');
            $data[1]['key']    =   'engineer_name';
            $data[1]['constraint'][0]    =   'notblank';

            $field['engineer_email'] = $data[2]['value']    =   $email_id      = $request->request->get('engineer_email');
            $data[2]['key']    =   'engineer_email';
            $data[2]['constraint'][0]    =   'notblank';
            $data[2]['constraint'][1]    =   'email';
            
            $field['blood_group'] = $data[3]['value']    =   $blood_group      = $request->request->get('blood_group');
            $data[3]['key']    =   'blood_group';
            $data[3]['constraint'][0]    =   'notblank';
            
            $field['mobile_no'] = $data[4]['value']    =   $mobile_no      = $request->request->get('mobile_no');
            $data[4]['key']    =   'mobile_no';
            $data[4]['constraint'][0]    =   'notblank';
            
            $field['address1'] = $data[5]['value']    =   $address1      = $request->request->get('address1');
            $data[5]['key']    =   'address1';
            $data[5]['constraint'][0]    =   'notblank';
            
            $field['address2'] = $data[6]['value']    =   $address2      = $request->request->get('address2');
            $data[6]['key']    =   'address2';
            $data[6]['constraint'][0]    =   'notblank';
            
            $field['doj'] = $data[7]['value']    =   $doj      = $request->request->get('doj');
            $data[7]['key']    =   'doj';
            $data[7]['constraint'][0]    =   'notblank';
            
            $field['pincode'] = $data[8]['value']    =   $pincode      = $request->request->get('pincode');
            $data[8]['key']    =   'pincode';
            $data[8]['constraint'][0]    =   'notblank';
            
            $field['city'] = $data[9]['value']    =   $city      = $request->request->get('city');
            $data[9]['key']    =   'city';
            $data[9]['constraint'][0]    =   'notblank';
            
            $field['state'] = $data[10]['value']    =   $state      = $request->request->get('state');
            $data[10]['key']    =   'state';
            $data[10]['constraint'][0]    =   'notblank';
            
            
            $field['designation'] = $data[11]['value']    =   $designation      = $request->request->get('designation');
            $data[11]['key']    =   'designation';
            $data[11]['constraint'][0]    =   'notblank';
            
            $error = $this->validationAction($data);
            
            if(count($error) > 0)
            {
                return $this->render('HESIndiaBundle:hes:add_engineer.html.twig', Array( 'error' => $error, 'field' => $field, 'email' => $ses->getUserEmail() ) );
            }
            else
            {

                        $em = $this->getDoctrine()->getManager();
                        $engineer = new Engineer();

                        $doj           = new \DateTime($doj);

                        $engineer->setEnggId($engineer_id)
                                 ->setEnggEmail($email_id)
                                ->setEngineerName($engineer_name)
                                ->setDesignation($designation)
                                ->setBloodGroup($blood_group)
                                ->setMobileNo($mobile_no)
                                ->setAddress1($address1)
                                ->setAddress2($address2)
                                ->setPincode($pincode)
                                ->setCity($city)
                                ->setState($state)
                                ->setDateOfJoining($doj);

                        $em->persist($engineer);

                        $em->flush();

                        return $this->redirectToRoute('add_engineer', Array(), 301);

                
                
                
            }

        }
            
            return $this->render('HESIndiaBundle:hes:add_engineer.html.twig', Array( 'email' =>$ses->getUserEmail()));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }
    
    public function editEngineerAction(Request $request, $eng_id)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            $em = $this->getDoctrine()->getManager();
            $refList = $em->getRepository('HESIndiaBundle:Referrer')->findAll();
            
        if(isset($_POST['submit_engineer']) && $_POST['submit_engineer'] == 'Edit Engineer')
        {
            
            $data =  Array();

            $field['engg_id'] = $data[0]['value']    =   $engg_id = $request->request->get('engg_id');
            $data[0]['key']    =   'engg_id';
            $data[0]['constraint'][0]    =   'notblank';

            $field['engg_name'] = $data[1]['value']            =   $engineer_name      = $request->request->get('engg_name');
            $data[1]['key']    =   'engg_name';
            $data[1]['constraint'][0]    =   'notblank';

            $field['email_id'] = $data[2]['value']    =   $email_id      = $request->request->get('email_id');
            $data[2]['key']    =   'email_id';
            $data[2]['constraint'][0]    =   'notblank';
            $data[2]['constraint'][1]    =   'email';
            
            $field['mobile_no'] = $data[3]['value']    =   $mobile_no      = $request->request->get('mobile_no');
            $data[3]['key']    =   'mobile_no';
            $data[3]['constraint'][0]    =   'notblank';
            
            $field['address1'] = $data[4]['value']    =   $address1      = $request->request->get('address1');
            $data[4]['key']    =   'address1';
            $data[4]['constraint'][0]    =   'notblank';
            
            $field['address2'] = $data[5]['value']    =   $address2      = $request->request->get('address2');
            $data[5]['key']    =   'address2';
            $data[5]['constraint'][0]    =   'notblank';
            
            $field['pincode'] = $data[6]['value']    =   $pincode      = $request->request->get('pincode');
            $data[6]['key']    =   'pincode';
            $data[6]['constraint'][0]    =   'notblank';
            
            
            $field['city'] = $data[7]['value']    =   $city      = $request->request->get('city');
            $data[7]['key']    =   'city';
            $data[7]['constraint'][0]    =   'notblank';
            
            
            $field['state'] = $data[8]['value']    =   $state      = $request->request->get('state');
            $data[8]['key']    =   'state';
            $data[8]['constraint'][0]    =   'notblank';
            
            $field['designation'] = $data[9]['value']    =   $designation      = $request->request->get('designation');
            $data[9]['key']    =   'designation';
            $data[9]['constraint'][0]    =   'notblank';

            $field['blood_group'] = $data[10]['value']    =   $blood_group      = $request->request->get('blood_group');
            $data[10]['key']    =   'blood_group';
            $data[10]['constraint'][0]    =   'notblank';
            
            $field['doj'] = $data[11]['value']    =   $doj      = $request->request->get('doj');
            $data[11]['key']    =   'doj';
            $data[11]['constraint'][0]    =   'notblank';
            
            
            $error = $this->validationAction($data);
            
            if(count($error) > 0)
            {
                return $this->render('HESIndiaBundle:hes:edit_engineer.html.twig', Array( 'error' => $error, 'field' => $field, 'email' => $ses->getUserEmail() ) );
            }
            else
            {
                
                        $em = $this->getDoctrine()->getManager();
                        
                    $enggInfo = $em->getRepository('HESIndiaBundle:Engineer')
                                    ->findOneByEnggId($eng_id);
                    
                    $doj            = new \DateTime($doj);

                        $enggInfo->setEnggEmail($email_id)
                                ->setDesignation($designation)
                                ->setMobileNo($mobile_no)
                                ->setAddress1($address1)
                                ->setAddress2($address2)
                                ->setPincode($pincode)
                                ->setCity($city)
                                ->setState($state);

                        $em->flush();

                        return $this->redirectToRoute('engg_profile', Array('enggId' => $eng_id), 301);

            }

        }
        else
        {

            $em = $this->getDoctrine()->getManager();
            
            $enggInfo = $em->getRepository('HESIndiaBundle:Engineer')
                    ->findOneByEnggId($eng_id);
            
            $field = Array();
            
            $field['engg_id'] = $enggInfo->getEnggId();
            $field['engg_name'] =  $enggInfo->getEngineerName();
            $field['email_id'] =  $enggInfo->getEnggEmail();
            $field['designation'] =  $enggInfo->getDesignation();
            $field['blood_group'] =  $enggInfo->getBloodGroup();
            $field['mobile_no'] =  $enggInfo->getMobileNo();
            
            $field['address1'] =  $enggInfo->getAddress1();
            $field['address2'] =  $enggInfo->getAddress2();
            $field['pincode'] =  $enggInfo->getPincode();
            $field['city'] =  $enggInfo->getCity();
            $field['state'] =  $enggInfo->getState();
            $field['doj'] =  $enggInfo->getDateOfJoining();

            return $this->render('HESIndiaBundle:hes:edit_engineer.html.twig', Array( 'field' => $field, 
                        'email' => $ses->getUserEmail(),'enggId' => $eng_id  ) );

        }

        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }

    public function listEngineerAction()
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            $em = $this->getDoctrine()->getManager();
            $enggList = $em->getRepository('HESIndiaBundle:Engineer')->findAll();
            
            return $this->render('HESIndiaBundle:hes:list_engineer.html.twig', Array( 'email' =>$ses->getUserEmail(), 'enggList' => $enggList ));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }

    }

    public function enggProfileAction($enggId)
    {
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            $request = $this->container->get('request');
            $routeName = $request->get('_route');

            $em = $this->getDoctrine()->getManager();
            
                    $userInfo = $em->getRepository('HESIndiaBundle:Engineer')
                    ->findOneByEnggId($enggId);
            
            return $this->render('HESIndiaBundle:hes:profile.html.twig', Array('email' => $ses->getUserEmail(), 
                        'userInfo' => $userInfo, 'route' => $routeName, 'enggId' => $enggId ) );
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }
    
    public function engineerInfoAction(Request $request)
    {
        

        $engineer_id    = $request->request->get('engineer_id');
        $engineer_name  = $request->request->get('engineer_name');
        $engineer_email = $request->request->get('engineer_email');
        $designation    = $request->request->get('designation');
        $blood_group    = $request->request->get('blood_group');
        $mobile_no      = $request->request->get('mobile_no');
        $doj            = $request->request->get('doj');
        $doj            = new \DateTime($doj);
        
        $address1       = $request->request->get('address1');
        $address2       = $request->request->get('address2');
        $pincode        = $request->request->get('pincode');
        $city           = $request->request->get('city');
        $state          = $request->request->get('state');
        
        $engineer = new Engineer();

        $em = $this->getDoctrine()->getManager();
        
        $engineer->setEnggId($engineer_id)
                 ->setEnggEmail($engineer_email)
                ->setEngineerName($engineer_name)
                ->setDesignation($designation)
                ->setBloodGroup($blood_group)
                ->setMobileNo($mobile_no)
                ->setAddress1($address1)
                ->setAddress2($address2)
                ->setPincode($pincode)
                ->setCity($city)
                ->setState($state)
                ->setDateOfJoining($doj);
        
        $em->persist($engineer);
        
        $em->flush();

        return $this->redirectToRoute('add_engineer', Array(), 301);
        
    }
    
    public function engineerRelieveAction($engg_id)
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            $em = $this->getDoctrine()->getManager();
            
            $enggInfo = $em->getRepository('HESIndiaBundle:Engineer')
                            ->findOneByEnggId($engg_id);
            
            if($enggInfo)
            {
                $enggInfo->setActiveStatus(0);
                
                $em->flush();
                
                return $this->redirectToRoute('list_engineer', Array(), 301);
            }
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
            
            
    }
    
    
    public function addReferrerAction(Request $request)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            
            $em = $this->getDoctrine()->getManager();
            $refList = $em->getRepository('HESIndiaBundle:Referrer')->findAll();
            
        if(isset($_POST['submit_referrer']) && $_POST['submit_referrer'] == 'Add Referrer')
        {

            $data =  Array();

            $field['ref_id'] = $data[0]['value']    =   $referrer_id = $request->request->get('ref_id');
            $data[0]['key']    =   'ref_id';
            $data[0]['constraint'][0]    =   'notblank';

            $field['ref_name'] = $data[1]['value']            =   $referrer_name      = $request->request->get('ref_name');
            $data[1]['key']    =   'ref_name';
            $data[1]['constraint'][0]    =   'notblank';

            $field['email_id'] = $data[2]['value']    =   $email_id      = $request->request->get('email_id');
            $data[2]['key']    =   'email_id';
            $data[2]['constraint'][0]    =   'notblank';
            $data[2]['constraint'][1]    =   'email';
            
            $field['mobile_no'] = $data[3]['value']    =   $mobile_no      = $request->request->get('mobile_no');
            $data[3]['key']    =   'mobile_no';
            $data[3]['constraint'][0]    =   'notblank';
            //$data[3]['constraint'][1]    =   'number';
            
            $field['address1'] = $data[4]['value']    =   $address1      = $request->request->get('address1');
            $data[4]['key']    =   'address1';
            $data[4]['constraint'][0]    =   'notblank';
            
            $field['address2'] = $data[5]['value']    =   $address2      = $request->request->get('address2');
            $data[5]['key']    =   'address2';
            $data[5]['constraint'][0]    =   'notblank';
            
            $field['pincode'] = $data[6]['value']    =   $pincode      = $request->request->get('pincode');
            $data[6]['key']    =   'pincode';
            $data[6]['constraint'][0]    =   'notblank';
            
            
            $field['city'] = $data[7]['value']    =   $city      = $request->request->get('city');
            $data[7]['key']    =   'city';
            $data[7]['constraint'][0]    =   'notblank';
            
            
            $field['state'] = $data[8]['value']    =   $state      = $request->request->get('state');
            $data[8]['key']    =   'state';
            $data[8]['constraint'][0]    =   'notblank';
            
            
            $remarks      = $request->request->get('remarks');

            $error = $this->validationAction($data);
            
//            print_r($field); exit();

            if(count($error) > 0)
            {
                return $this->render('HESIndiaBundle:hes:add_referrer.html.twig', Array( 'error' => $error, 'field' => $field, 'email' => $ses->getUserEmail() ) );
            }
            else
            {
                
                        $em = $this->getDoctrine()->getManager();
                        $referrer = new Referrer();

                        $referrer->setReferrerId($referrer_id)
                                 ->setReferrerName($referrer_name)
                                ->setEmail($email_id)
                                ->setMobileNo($mobile_no)
                                ->setAddress1($address1)
                                ->setAddress2($address2)
                                ->setPincode($pincode)
                                ->setCity($city)
                                ->setState($state)
                                ->setRemarks($remarks);

                        $em->persist($referrer);

                        $em->flush();

                        return $this->redirectToRoute('add_referrer', Array(), 301);

                
                
                
            }

        }
            
            return $this->render('HESIndiaBundle:hes:add_referrer.html.twig', Array( 'email' =>$ses->getUserEmail(), 'reflist' => $refList ));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }

    
    public function editReferrerAction(Request $request, $ref_id)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            $em = $this->getDoctrine()->getManager();
            $refList = $em->getRepository('HESIndiaBundle:Referrer')->findAll();
            
        if(isset($_POST['submit_referrer']) && $_POST['submit_referrer'] == 'Edit Referrer')
        {
            
            $data =  Array();

            
            $field['ref_id'] = $data[0]['value']    =   $referrer_id = $request->request->get('ref_id');
            $data[0]['key']    =   'ref_id';
            $data[0]['constraint'][0]    =   'notblank';

            $field['ref_name'] = $data[1]['value']            =   $referrer_name      = $request->request->get('ref_name');
            $data[1]['key']    =   'ref_name';
            $data[1]['constraint'][0]    =   'notblank';
            
            $field['email_id'] = $data[2]['value']    =   $email_id      = $request->request->get('email_id');
            $data[2]['key']    =   'email_id';
            $data[2]['constraint'][0]    =   'notblank';
            $data[2]['constraint'][1]    =   'email';
            
            $field['mobile_no'] = $data[3]['value']    =   $mobile_no      = $request->request->get('mobile_no');
            $data[3]['key']    =   'mobile_no';
            $data[3]['constraint'][0]    =   'notblank';
            //$data[3]['constraint'][1]    =   'number';
            
            $field['address1'] = $data[4]['value']    =   $address1      = $request->request->get('address1');
            $data[4]['key']    =   'address1';
            $data[4]['constraint'][0]    =   'notblank';
            
            $field['address2'] = $data[5]['value']    =   $address2      = $request->request->get('address2');
            $data[5]['key']    =   'address2';
            $data[5]['constraint'][0]    =   'notblank';
            
            $field['pincode'] = $data[6]['value']    =   $pincode      = $request->request->get('pincode');
            $data[6]['key']    =   'pincode';
            $data[6]['constraint'][0]    =   'notblank';
            
            
            $field['city'] = $data[7]['value']    =   $city      = $request->request->get('city');
            $data[7]['key']    =   'city';
            $data[7]['constraint'][0]    =   'notblank';
            
            
            $field['state'] = $data[8]['value']    =   $state      = $request->request->get('state');
            $data[8]['key']    =   'state';
            $data[8]['constraint'][0]    =   'notblank';
            
            
            $remarks      = $request->request->get('remarks');

            $error = $this->validationAction($data);
            
//            print_r($field); exit();

            if(count($error) > 0)
            {
                return $this->render('HESIndiaBundle:hes:edit_referrer.html.twig', Array( 'error' => $error, 'field' => $field, 'email' => $ses->getUserEmail() ) );
            }
            else
            {
                
                        $em = $this->getDoctrine()->getManager();
                        
                    $refInfo = $em->getRepository('HESIndiaBundle:Referrer')
                                    ->findOneByReferrerId($ref_id);

                        $refInfo->setEmail($email_id)
                                ->setMobileNo($mobile_no)
                                ->setAddress1($address1)
                                ->setAddress2($address2)
                                ->setPincode($pincode)
                                ->setCity($city)
                                ->setState($state)
                                ->setRemarks($remarks);

                        $em->flush();

                        return $this->redirectToRoute('ref_profile', Array('refId' => $referrer_id), 301);

            }

        }
        else
        {

            $em = $this->getDoctrine()->getManager();
            
            $refInfo = $em->getRepository('HESIndiaBundle:Referrer')
                    ->findOneByReferrerId($ref_id);
            
            $field = Array();
            
            $field['ref_id'] = $refInfo->getReferrerId();
            $field['ref_name'] =  $refInfo->getReferrerName();
            $field['email_id'] =  $refInfo->getEmail();
            $field['mobile_no'] =  $refInfo->getMobileNo();
            $field['remarks'] =  $refInfo->getRemarks();
            
            $field['address1'] =  $refInfo->getAddress1();
            $field['address2'] =  $refInfo->getAddress2();
            $field['pincode'] =  $refInfo->getPincode();
            $field['city'] =  $refInfo->getCity();
            $field['state'] =  $refInfo->getState();

            return $this->render('HESIndiaBundle:hes:edit_referrer.html.twig', Array( 'field' => $field, 'email' => $ses->getUserEmail() ) );

        }

        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }



    public function listReferrerAction()
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            
            $em = $this->getDoctrine()->getManager();
            $refList = $em->getRepository('HESIndiaBundle:Referrer')->findAll();
            
            return $this->render('HESIndiaBundle:hes:list_referrer.html.twig', Array( 'email' =>$ses->getUserEmail(), 'refList' => $refList ));
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }

    }

    public function refProfileAction($refId)
    {
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {

            $em = $this->getDoctrine()->getManager();

            $userInfo = $em->getRepository('HESIndiaBundle:Referrer')
                    ->findOneByReferrerId($refId);

            return $this->render('HESIndiaBundle:hes:referrer_profile.html.twig', Array('email' => $ses->getUserEmail(), 'userInfo' => $userInfo,
                    'ref_id' => $refId ) );
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }
    
    public function referrerInfoAction(Request $request)
    {
        
        $referrer_id    = $request->request->get('ref_id');
        $referrer_name  = $request->request->get('ref_name');
        $email_id       = $request->request->get('email_id');
        $mobile_no      = $request->request->get('mobile_no');
        $remarks        = $request->request->get('remarks');
        
        $address1       = $request->request->get('address1');
        $address2       = $request->request->get('address2');
        $pincode        = $request->request->get('pincode');
        $city           = $request->request->get('city');
        $state          = $request->request->get('state');


        $em = $this->getDoctrine()->getManager();
        $referrer = new Referrer();
        
        $referrer->setReferrerId($referrer_id)
                 ->setReferrerName($referrer_name)
                ->setEmail($email_id)
                ->setMobileNo($mobile_no)
                ->setAddress1($address1)
                ->setAddress2($address2)
                ->setPincode($pincode)
                ->setCity($city)
                ->setState($state)
                ->setRemarks($remarks);

        $em->persist($referrer);
        
        $em->flush();

        return $this->redirectToRoute('add_referrer', Array(), 301);
        
    }
    

    public function changePasswordAction()
    {
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {

            $em = $this->getDoctrine()->getManager();

            return $this->render('HESIndiaBundle:hes:change_password.html.twig', Array('email' => $ses->getUserEmail() ) );
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }

    public function changePassQueryAction(Request $request)
    {
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {

            $old_password = SHA1($request->request->get('old_pass'));
            $new_password = $request->request->get('new_pass');
            $new_pass_rep = $request->request->get('new_pass_rep');
            
            $em = $this->getDoctrine()->getManager();
            
            $userInfo = $em->getRepository('HESIndiaBundle:User')
                    ->findOneBy(Array('userEmail' => $ses->getUserEmail(), 'userPassword' => $old_password ) );

            if(count($userInfo) == 1)
            {
                if(strcmp($new_password, $new_pass_rep) == 0 ) 
                {
                    $userInfo->setUserPassword(SHA1($new_password));
                    
                    $em->flush();
               }
            }
            else
            {
                
            }
            
            return $this->redirectToRoute('change_password', Array(), 301);
            
        }
        else
        {
            return $this->redirectToRoute('hes_welcome-page', Array(), 301);
        }
    }

    public function privacyAction()
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            return $this->render('HESIndiaBundle:hes:privacy.html.twig', Array('email' => $ses->getUserEmail() ));
        }
        else
        {
            return $this->render('HESIndiaBundle:hes:privacy.html.twig', Array('email' => 'nothing' ));
        }

    }
    
    public function termsAction()
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            return $this->render('HESIndiaBundle:hes:terms.html.twig', Array('email' => $ses->getUserEmail() ));
        }
        else
        {
            return $this->render('HESIndiaBundle:hes:terms.html.twig', Array('email' => 'nothing' ));
        }
    }
    
    public function contactAction()
    {
        return $this->redirectToRoute('contacttwo', Array(), 301);
        exit();
        
        return $this->render('HESIndiaBundle:hes:contact.html.twig');
    }
    
    public function contacttwoAction($error = '')
    {
        return $this->render('HESIndiaBundle:hes:contacttwo.html.twig', Array('error' => $error));
    }
    
    public function contactStoreAction(Request $request)
    {
        
        $contact = new ContactUs();
        
        $data =  Array();
        
        $field['fname'] = $data[0]['value']    =   $fname = $request->request->get('fname');
        $data[0]['key']    =   'fname';
        $data[0]['constraint'][0]    =   'notblank';
        
        $field['lname'] = $data[1]['value']            =   $lname      = $request->request->get('lname');
        $data[1]['key']    =   'lname';
        $data[1]['constraint'][0]    =   'notblank';
        
        $field['email'] = $data[2]['value']    =   $email      = $request->request->get('email');
        $data[2]['key']    =   'email';
        $data[2]['constraint'][0]    =   'notblank';
        $data[2]['constraint'][1]    =   'email';
        
        $field['phone'] = $data[3]['value']    =   $phone      = $request->request->get('phone');
        $data[3]['key']    =   'phone';
        $data[3]['constraint'][0]    =   'notblank';
        $data[3]['constraint'][1]    =   'number';
        
        $field['subject'] = $data[4]['value']  =   $subject    = $request->request->get('subject');
        $data[4]['key']    =   'subject';
        $data[4]['constraint'][0]    =   'notblank';
        
        
        $field['message'] = $data[5]['value']  =   $message    = $request->request->get('message');
        $data[5]['key']    =   'message';
        $data[5]['constraint'][0]    =   'notblank';

        $error = $this->validationAction($data);
        
        if(count($error) > 0)
        {
            return $this->render('HESIndiaBundle:hes:contacttwo.html.twig', Array( 'error' => $error, 'field' => $field ) );
        }

        $read_ct    = $request->request->get('contact');

        $contact->setFirstName($fname)
                ->setLastName($lname)
                ->setEmail($email)
                ->setContactNo($phone)
                ->setSubject($subject)
                ->setMessage($message);

        $em = $this->getDoctrine()->getManager();

        $em->persist($contact);

        $em->flush();

        if($read_ct == 'contacttwo')
        {
            return $this->redirectToRoute('contacttwo', Array(), 301);
        }
        else if($read_ct == 'contact')
        {
            return $this->redirectToRoute('contact', Array(), 301);
        }

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
    
    public function sessionHeaderTemplateAction($email)
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context
        
        if(gettype($ses) === 'object' )
        {
            
            $userLevel = $ses->getUserLevel();
            
                $em = $this->getDoctrine()->getManager();
                
            if($userLevel == 0 || $userLevel == 1)
            {
                    $userInfo = $em->getRepository('HESIndiaBundle:Manager')
                    ->findOneByEnggEmail($ses->getUserEmail());
            }
            else if($userLevel == 2)
            {
                    $userInfo = $em->getRepository('HESIndiaBundle:Engineer')
                    ->findOneByEnggEmail($ses->getUserEmail());
                
            }
            
            
            return $this->render('HESIndiaBundle:hes:session_header.html.twig', Array('userInfo' => $userInfo, 'userlevel' => $ses->getUserLevel() ));
        }
        else
        {
            return $this->render('HESIndiaBundle:hes:session_header.html.twig');
        }
    }
    
    public function faviconAction()
    {
        return $this->render('HESIndiaBundle:hes:favicon.html.twig');
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
                    
        $em = $this->getDoctrine()->getManager();
        
        $faqQA = $em->getRepository('HESIndiaBundle:Faq')->findAll();
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            return $this->render('HESIndiaBundle:hes:homepage.html.twig', Array('email' => $ses->getUserEmail(), 'faq' => $faqQA, 'error' => '' ));
        }
        else
        {
            return $this->render('HESIndiaBundle:hes:homepage.html.twig', Array(
                    'last_username' => $session->get(SecurityContext::LAST_USERNAME),
                    'error' => $error, 'faq' => $faqQA, 'email' => 'nothing'));
        }

        exit();

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
    
    
    public function validationAction($data)
    {
        
//        print_r($data); exit();
        
        $error = Array();
        
        for($i=0; $i<count($data); $i++)
        {
            for($j=0; $j<count($data[$i]['constraint']); $j++)
            {
                $constraint = $data[$i]['constraint'][$j];
                
                if($constraint == 'notblank')
                {
                            if(strlen($data[$i]['value']) == 0)
                            {
                                $error[$data[$i]['key']]['error'] = 1;
                                $error[$data[$i]['key']]['desc'] = 'This field cannot be blank';
                            }
                }
                else if($constraint == 'email')
                {
                            if (filter_var($data[$i]['value'], FILTER_VALIDATE_EMAIL) == false)
                            {
                                $error[$data[$i]['key']]['error'] = 1;
                                $error[$data[$i]['key']]['desc'] = 'This is not a valid email format';
                            }
                }
                else if($constraint == 'number')
                {
                            if (filter_var($data[$i]['value'], FILTER_VALIDATE_INT) === false)
                            {
                                $error[$data[$i]['key']]['error'] = 1;
                                $error[$data[$i]['key']]['desc'] = 'This is not a valid number';
                                break;
                            }
                }
                else
                {
                }
                
            }
            
            
        }
        
        
        return ($error);
        
    }
    
    
    public function getCustomerNameAction($custId)
    {
        
        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {
            $em = $this->getDoctrine()->getManager();
            $custInfo = $em->getRepository('HESIndiaBundle:Customers')->findOneByCompanyId($custId);
            
            return $this->render('HESIndiaBundle:hes:customername.html.twig', Array('customerName' => $custInfo->getCompanyName() ));
        }
        else
        {
            return $this->render('HESIndiaBundle:hes:faq.html.twig', Array('faq' => $faqQA, 'session' => 'no', 'email' => 'nothing' ));
        }
        

    }
    
    public function searchCustomersAction(Request $request)
    {

        $ses = $this->get('security.context')->getToken()->getUser();  //get the session context

        if(gettype($ses) === 'object' )
        {

            $custId = $request->request->get('comp_name');

            $em = $this->getDoctrine()->getManager();
            $custInfo = $em->getRepository('HESIndiaBundle:Customers')->findOneByCompanyId($custId);

            $custLists = $em->getRepository('HESIndiaBundle:Customers')->findAll();

            sort($custLists);

            return $this->render('HESIndiaBundle:hes:search_result_customer.html.twig', Array('customerName' => $custInfo->getCompanyName(), 
                            'email' => $ses->getUserEmail(), 'custlists' => $custLists, 'custInfo' => $custInfo ));
        }
        else
        {
            return $this->render('HESIndiaBundle:hes:faq.html.twig', Array('faq' => $faqQA, 'session' => 'no', 'email' => 'nothing' ));
        }
        

    }
}