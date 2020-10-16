<?php


namespace App\Controller;

use App\Entity\Epreuve;
use App\Model\BDD;
use Exception;
use Symfony\Component\HttpFoundation\Request;



class EpreuveController
{
    private Request $request;

    public function __construct(){
        $this->request = Request::createFromGlobals();
    }

    public function addEpreuve(){
        try{
            if(is_string($this->request->get('submit'))){
                $newEpreuve= new Epreuve(
                    $this->request->get('epreuveNom'),
                    $this->request->get('epreuveDate')
                );
                $connexion = new BDD('logitudski','localhost','3307','root','root');
                $db =$connexion->connectToBDD();
                return $connexion->addToBDD($db,$newEpreuve);
            } else {
                throw new Exception("Erreur: Ne peux pas créer l'épreuve");
            }
        }catch (Exception $e){
            echo 'Exception : ', $e->getMessage(), "<br>";
        }
    }

    public function deleteEpreuve(){
        try{
            if(is_string($this->request->get('oui'))){
                echo 'hello';
            }
        }catch (Exception $e){
            echo 'Exception : ', $e->getMessage(), "<br>";
        }
    }
}