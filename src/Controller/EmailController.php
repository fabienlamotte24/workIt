<?php

namespace App\Controller;

use App\Entity\TemplateEmail;
use App\Form\TemplateEmailType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class EmailController extends AbstractController
{
    /**
     * @Route("/email", name="email")
     */
    public function index()
    {
        return $this->render('email/index.html.twig');
    }

    /**
     * @Route("/ajout_template", name="ajout_template")
     */
    public function ajoutTemplate(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $templateEmail = new TemplateEmail();
        $form = $this->createForm(TemplateEmailType::class, $templateEmail);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $templateEmail->setDateCreation(new \DateTime());
            $em->persist($templateEmail);
            $em->flush();

            $this->addFlash("success", "Votre nouveau template a été enregistré avec succès");
            return $this->redirectToRoute('email');
        }

        return $this->render('email/ajouter_template.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/charger_template", name="charger_template", options={"expose"=true})
     */
    public function chargerTemplate(){
        
    }
}
