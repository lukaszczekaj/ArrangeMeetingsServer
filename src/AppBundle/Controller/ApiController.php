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
 * Api dostępu do aplikacji zarządzania spotkaniami
 *
 * @author Łukasz Czekaj
 */
class ApiController extends FOSRestController {

    /**
     * Pobranie listy dostepnych firm
     * 
     * @Rest\Get("/company-list")
     */
    public function getCompanyListAction() {
        $em = $this->getDoctrine()->getEntityManager();
        $allCompany = $em->getRepository('AppBundle:Company')->findAll();
        return $allCompany;
    }

    /**
     * Pobranie danych na temat pojedynczej firmy
     * 
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
     * Zapis spotkania
     * 
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


        $dateFrom = sprintf('%s-%s-%s %s:%s:00', $data['year'], str_pad(intval($data['month']) + 1, 2, 0, STR_PAD_LEFT), str_pad($data['day'], 2, 0, STR_PAD_LEFT), str_pad($data['timeFromHour'], 2, 0, STR_PAD_LEFT), str_pad($data['timeFromMinute'], 2, 0, STR_PAD_LEFT));
        $dateTo = sprintf('%s-%s-%s %s:%s:00', $data['year'], str_pad(intval($data['month']) + 1, 2, 0, STR_PAD_LEFT), str_pad($data['day'], 2, 0, STR_PAD_LEFT), str_pad($data['timeToHour'], 2, 0, STR_PAD_LEFT), str_pad($data['timeToMinute'], 2, 0, STR_PAD_LEFT));

        $metting = new Metting();
        $metting->setFirstname($data['firstName']);
        $metting->setLastname($data['lastName']);
        $metting->setPhone($data['phone']);
        $metting->setMail($data['mail']);
        $metting->setDateadd(new \DateTime());
        $metting->setDatefrom(new \DateTime($dateFrom));
        $metting->setDateto(new \DateTime($dateTo));
        $company = $this->getDoctrine()->getRepository('AppBundle:Company')->findOneBy(array('id' => $data['companyID']));
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

        // file_put_contents('/tmp/data.txt', var_export($metting, true) . PHP_EOL, FILE_APPEND);



        return json_encode(array('code' => 200, 'message' => 'Zapisane'));
    }

    /**
     * Obsługuje wysyłkę maili
     * @return boolean czy się udało wysłać
     */
    private function sendMailMessage() {
                $message = \Swift_Message::newInstance()
                ->setSubject('Nowe spotkanie2')
                ->setFrom('powiadomienia@lukaszczekaj.pl')
                ->setTo('lukaszcz16@gmail.com')
                ->setCharset('UTF-8')
                ->setContentType('text/html')
                ->setBody(
                $this->renderView(
                        // app/Resources/views/Emails/registration.html.twig
                        'mail.html.twig', array('name' => 'aa')
                ), 'text/html'
        );


        try {
            $a =  $this->get('mailer')->send($message);
        } catch (Exception $exc) {
            $a = $exc->getMessage();
        }

    return $a;

    }
    
    /**
     * Logowanie firmy do autoryzowanej części aplikacji
     * 
     * @Rest\Post("/login/")
     */
    public function loginCompanyAction(Request $request) {
        $mail = $request->get('mail');
        $pass = $request->get('password');
        if (empty($mail) || empty($pass)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $company = $em->getRepository('AppBundle:Company')->findOneBy(array('mail' => $mail));
        if (!$company) {
            return json_encode(array('code' => 403, 'message' => 'Niepoprawne dane logowania'));
        }
        if ($company->getPass() !== hash('sha256', $pass)) {
            return json_encode(array('code' => 403, 'message' => 'Niepoprawne dane logowania'));
        }
        $company->setAuthtoken(md5(uniqid()));
        $em->flush();

        return json_encode(array('code' => 403, 'authToken' => $company->getAuthtoken(), 'message' => 'Zalogowano'));
    }
    
    /**
     * Aktualizacja anych o firmie
     * 
     * @Rest\Post("/update-profile/")
     */
    public function updateCompanyProfileAction(Request $request) {
        $token = $request->get('authToken');
        if (empty($token)) {
            return new Response("API: Brak kompletnych danych ", Response::HTTP_NOT_ACCEPTABLE);
        }
        $em = $this->getDoctrine()->getEntityManager();
        $company = $em->getRepository('AppBundle:Company')->findOneBy(array('authtoken' => $token));
        if (!$company) {
            return new Response("API: Niepoprawna identyfikacja", Response::HTTP_FORBIDDEN);
        }
        $data = $request->request->all();
        if (isset($data['name']) && !empty($data['name'])) {
            $company->setName($data['name']);
        }
        if (isset($data['addressStreet']) && !empty($data['addressStreet'])) {
            $company->setAddressstreet($data['addressStreet']);
        }
        if (isset($data['addressPost']) && !empty($data['addressPost'])) {
            $company->setAddresspost($data['addressPost']);
        }
        $em->flush();
        return new Response('API: Zapisano zmiany', Response::HTTP_OK);
    }

    /**
     * Pobranie firmy na temat tokenu autoryzującego
     * @param string $token token autoryzujący
     * @return Enitity Company encja firmy
     */
    private function getCompanyByAuthToken($token) {
        $em = $this->getDoctrine()->getEntityManager();
        return $em->getRepository('AppBundle:User')->findOneBy(array('authtoken' => $token));
    }

}
