<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Entity\User;
use AppBundle\Entity\Metting;

/**
 * Description of ApiController
 *
 * @author Łukasz Czekaj <admin@ecrosio.com>
 */
class ApiController extends FOSRestController {

    /**
     * @Rest\Get("/company-list")
     */
    public function getCompanyListAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $allCompany = $em->getRepository('AppBundle:Company')->findAll();
        return $allCompany;
    }

    /**
     * @Rest\Get("/receiving-customers-date/{id}")
     */
    public function getAviableDatesByCompanyIdAction($id, Request $request) {
        file_put_contents('/tmp/data.txt', var_export($id, true) . PHP_EOL, FILE_APPEND);
        file_put_contents('/tmp/data.txt', var_export($request->getContent(), true) . PHP_EOL, FILE_APPEND);
        if (empty($id)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $all = $em->getRepository('AppBundle:Alloweddates')->findBy(array('companyid' => $id));
        return $all;
    }

    /**
     * @Rest\Post("/save-metting")
     */
    public function postSaveMeetingAction(Request $request) {
        $data = json_decode($request->getContent(), true);
        file_put_contents('/tmp/data.txt', var_export($data, true) . PHP_EOL, FILE_APPEND);
        if (!$data) {
            return json_encode(array('code' => 300, 'message' => 'Błędne dane'));
        }
        if (empty($data['mail']) || !filter_var($data['mail'], FILTER_VALIDATE_EMAIL)) {
            return json_encode(array('code' => 300, 'message' => 'Błędny adres e-mail'));
        }
        if (empty($data['phone'])) {
            return json_encode(array('code' => 300, 'message' => 'Podaj nr telefonu'));
        }
        if (empty($data['year']) || empty($data['day']) || empty($data['month'])) {
            return json_encode(array('code' => 300, 'message' => 'Nie podano daty'));
        }
        if (empty($data['timeFromHour']) || empty($data['timeFromMinute'])) {
            return json_encode(array('code' => 300, 'message' => 'Nie podano godziny rozpoczecia'));
        }
        if (empty($data['timeToHour']) || empty($data['timeToMinute'])) {
            return json_encode(array('code' => 300, 'message' => 'Nie podano godziny zakonczenia'));
        }


        $dateFrom = sprintf('%s-%s-%s %s:%s:00', $data['year'], str_pad(intval($data['month'])+1, 2, 0, STR_PAD_LEFT), str_pad($data['day'], 2, 0, STR_PAD_LEFT), str_pad($data['timeFromHour'], 2, 0, STR_PAD_LEFT),str_pad($data['timeFromMinute'], 2, 0, STR_PAD_LEFT));
        $dateTo = sprintf('%s-%s-%s %s:%s:00', $data['year'], str_pad(intval($data['month'])+1, 2, 0, STR_PAD_LEFT), str_pad($data['day'], 2, 0, STR_PAD_LEFT), str_pad($data['timeToHour'], 2, 0, STR_PAD_LEFT),str_pad($data['timeToMinute'], 2, 0, STR_PAD_LEFT));

        $metting = new Metting();
        $metting->setFirstname($data['firstName']);
        $metting->setLastname($data['lastName']);
        $metting->setPhone($data['phone']);
        $metting->setMail($data['mail']);
        $metting->setDateadd(new \DateTime());
        $metting->setDatefrom(new \DateTime($dateFrom));
        $metting->setDateto(new \DateTime($dateTo));
        $company =  $this->getDoctrine()->getRepository('AppBundle:Company')->findOneBy(array('id' => $data['companyID']));
        if (!$company) {
            return json_encode(array('code' => 300, 'message' => 'Błąd pobrania firmy'));
        }
        $metting->setCompanyid($company);

        $em = $this->getDoctrine()->getEntityManager();
        $em->persist($metting);
       //     file_put_contents('/tmp/data.txt', var_export($metting, true) . PHP_EOL, FILE_APPEND);

        try {
            $em->flush();
        } catch (Exception $exc) {
            return json_encode(array('code' => 300, 'message' => $exc->getMessage()));
        } 
        
        $this->sendMailMessage();

       // file_put_contents('/tmp/data.txt', var_export($metting, true) . PHP_EOL, FILE_APPEND);



        return json_encode(array('code' => 400, 'message' => 'Zapisano'));
    }
    
    private function sendMailMessage() {
        $message = \Swift_Message::newInstance()
        ->setSubject('Hello Email')
        ->setFrom('powiadomienia@lukaszczekaj.pl')
        ->setTo('lukaszcz16@gmail.com')
        ->setBody(
            "aaaa"
        )
        /*
         $this->renderView(
                // app/Resources/views/Emails/registration.html.twig
                'Emails/registration.html.twig',
                array('name' => $name)
            ),
            'text/html'
        */
    ;
    $this->get('mailer')->send($message);
    }

}
