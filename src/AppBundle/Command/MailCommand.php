<?php

namespace AppBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use AppBundle\Entity\Metting;
use AppBundle\Entity\Company;

class MailCommand extends ContainerAwareCommand {

    protected function configure() {
        $this
                ->setName('cron:mails')
                ->setDescription('Send e-mails');
    }

    protected function execute(InputInterface $input, OutputInterface $output) {

        $em = $this->getContainer()->get('doctrine')->getManager();
        $mettings = $em->getRepository('AppBundle:Metting')->findBy(array('status' => 'NEW'));

        $metting = new Metting();
        $company = new Company();
        
        foreach ($mettings as $metting) {
            
            $company = $metting->getCompanyid();
            $company = $em->getRepository('AppBundle:Company')->findOneBy(array('id' => $company->getId()));
            $a = $this->getContainer()->get('mailer')->send(
                    \Swift_Message::newInstance()
                            ->setSubject('Nowe spotkanie')
                            ->setFrom('powiadomienia@lukaszczekaj.pl')
                            ->setTo($metting->getMail())
                            ->setCharset('UTF-8')
                            ->setContentType('text/html')
                            ->setBody($this->getContainer()->get('templating')->render('mail.html.twig', array('firstName' => $metting->getFirstname()
                            )))
            );
            $a = $this->getContainer()->get('mailer')->send(
                    \Swift_Message::newInstance()
                            ->setSubject('Wprowadzono nowe spotkanie')
                            ->setFrom('powiadomienia@lukaszczekaj.pl')
                            ->setTo($company->getEmail())
                            ->setCharset('UTF-8')
                            ->setContentType('text/html')
                            ->setBody($this->getContainer()->get('templating')->render('mail-to-company.html.twig', array(
                                'firstName' => $metting->getFirstname(),
                                'lastName' => $metting->getLastname(),
                                'dateFrom' => $metting->getDatefrom()->format('d.m.Y H:i'),
                                'dateTo' => $metting->getDateto()->format('d.m.Y H:i'),
                            )))
            );
            
            $metting->setStatus('ADDED');
            $em->persist($metting);
            $em->flush();
        }



      //  $output->writeln(var_export($company, true));
    }

}
