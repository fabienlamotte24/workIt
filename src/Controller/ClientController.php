<?php

namespace App\Controller;

use App\Entity\Client;
use App\Form\ClientType;
use App\Repository\ClientRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ClientController extends AbstractController
/**
 * ////////////////////////////////////////
 * 
 * //////////// ACTIONS ////////////
 * 
 * index 
 * ajouterClient                        ( ajouter_client )
 * 
 * //////////// AJAX ////////////
 * 
 * chargerClient                        ( charger_client )
 * 
 * ////////////////////////////////////////
 * 
 */
{
    /**
     * @Route("/", name="")
     */
    public function index()
    {   
        return $this->render('client/index.html.twig');
    }

    /**
     * @Route("/ajouter_client", name="ajouter_client")
     * @Route("/modifier_client/{id}", options={"expose"=true}, name="modifier_client")
     */
    public function ajouterModifierClient(Request $request, Client $id = null){
        $em = $this->getDoctrine()->getManager();
        $messageFlash = "";

        $rechercheClient = $em->getRepository(Client::class)->findOneBy(array('id' => $id));
        if($rechercheClient == null){
            $client = new Client();
            $messageFlash = "Client ajouté avec succès !";
            $title = "Ajout d'un nouveau client";
            $valueSave = "Enregistrer nouveau client";
        } else {
            $messageFlash = 'Client modifié avec succès !';
            $client = $rechercheClient;
            $title = "Modification des informations du client : " . $client->getPrenom() . ' ' . $client->getNom() . ' !';
            $valueSave = "Modifier les informations";
        }

        $form = $this->createForm(ClientType::class, $client);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $client->setDateAjout(new \DateTime());
            $em->persist($client);
            $em->flush();

            $this->addFlash('success', $messageFlash);
            return $this->redirectToRoute('');
        }

        return $this->render('client/ajouter_client.html.twig', [
            'form'      => $form->createView(),
            'title'     => $title,
            'valueSave' => $valueSave
        ]);
    }

    /**
     * @Route("/supprimer_client", name="supprimer_client", options={"expose"=true})
     */
    public function supprimerClient(Request $request){
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('id');

        $client = $em->getRepository(Client::class)->findOneBy(array('id' => $id));
        $em->remove($client);
        $em->flush();

        return $this->json('ok');
    }

    /**
     * @Route("/charger_client", name="charger_client", options={"expose"=true})
     */
    public function chargerClient(Request $request){
        // Récupération des variables de bases 
            $em = $this->getDoctrine()->getManager();
            $data = $request->request->get('params');

            $colonnes = array(
                0 => 'c.id'        ,             // Id
                1 => 'c.nom'       ,            // Nom
                2 => 'c.prenom'    ,            // Prénom
                3 => 'c.age'       ,            // Age
                4 => 'c.ville'     ,            // Ville
                5 => 'c.codePostal',            // Codepostal
           );

            $index_a_trier  = $request->request->get('order')[0]['column'];            // Index de la colonne à trier
            $order          = $request->request->get('order')[0]['dir'];               // Ordre d'affichage : ASC ou DESC
            $windowWidth    = $request->query->get('windowWidth');                     // Récupération taille page
            $nbItem         = $request->request->get('length');                        // Nombre de ligne à afficher
            $page           = $request->request->get('start');                         // Page à afficher -> click sur 2 dans la pagination
            $clients        = $em->getRepository(Client::class)->findAllClient($colonnes[$index_a_trier], $order, $nbItem, $page);
            $nbClientFiltre = $em->getRepository(Client::class)->getCountClients();
            $totalClient    = $em->getRepository(Client::class)->getCountClients();
            $datatable = array();

            foreach($clients as $key => $client){

                // Formatage numéro de téléphone et téléphone portable
                $numFixe = $this->formatTel($client->getTelephoneFixe());
                $numPortable = $this->formatTel($client->getTelephone());

                $datatable[$key][0] = $client->getId();                                 // Nom du client
                $datatable[$key][1] = $client->getNom();                                // Nom du client
                $datatable[$key][2] = $client->getPrenom();                             // Prénom du client
                $datatable[$key][3] = $client->getAge();                                // Age du client
                $datatable[$key][4] = $client->getVille();                              // Ville
                $datatable[$key][5] = $client->getCodePostal();                         // Code postal
                $datatable[$key][6] = $client->getEmail();                              // Email du client
                $datatable[$key][7] = $numFixe;                                         // Téléphone fixe du client
                $datatable[$key][8] = $numPortable;                                     // Téléphone portable du client
                $datatable[$key][9] = $client->getPhaseClient()->getLibelle();          // Phase du client
                $datatable[$key][10] = "";                                              // Bouttons d'actions
            }

            $tab                    = array();
            $tab['recordsFiltered'] = $nbClientFiltre;
            $tab['recordsTotal']    = $totalClient;
            $tab['data']            = $datatable;

        return $this->json($tab);
    }

    public function formatTel(String $numero){
        $result = "";
        $tableau = str_split($numero);

        for($i = 0; $i < count($tableau); $i++){
            if($i != 0 && $i%2 != 0){
                $result = $result . $tableau[$i] . ' ';
            } else {
                $result = $result . $tableau[$i];
            }
        }

        return $result;
    }
}