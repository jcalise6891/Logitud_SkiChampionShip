<?php

namespace App\Controller;

use App\Entity\Epreuve;
use App\Model\BDD;
use App\Model\CSVModel;
use App\Model\EpreuveModel;
use App\Utility\EntityAbstract;
use Exception;
use League\Csv\CannotInsertRecord;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\File;
use Twig\Environment;

class EpreuveController extends AbstractMainController
{
    private Environment $twig;

    /**
     * EpreuveController constructor.
     */
    public function __construct()
    {
        $this->twig = parent::getTwig();
    }

    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @return Response
     */
    public function retrieveEpreuveList($request, $attributes, $container)
    {
        $connexion = new EpreuveModel($container['PDO']);
        $result = $connexion->retrieveEpreuveList();
        return new Response(
            $container['twig']
                ->render(
                    'epreuve/showEpreuveList.html.twig',
                    ['epreuveList' => $result, 'theme' => $container['theme']]
                ),
            200
        );
    }

    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @return Response
     */
    public function showSingleEpreuve($request, $attributes, $container)
    {
        $result = (new EpreuveModel($container['PDO']))->retrieveSingleEpreuve($attributes['id']);
        $partList = (new BDD($container['PDO']))
            ->getListFromSpecificOption(
                'personne',
                'epreuve',
                intval($attributes['id'])
            );
        $dateTime = date_create_from_format('Y-m-d H:i:s', $result['date']);
        $stringTime = $dateTime->format('Y-m-dTH:i');
        $letterArray = array('U', 'C');
        $epreuveDate = str_replace($letterArray, '', $stringTime);
        return new Response(
            $container['twig']
                ->render(
                    'epreuve/showSingleEpreuve.html.twig',
                    [
                        'epreuve' => $result,
                        'personneList' => $partList,
                        'epreuveDate' => $epreuveDate,
                        'theme' => $container['theme']
                    ]
                ),
            200
        );
    }


    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @return Response
     */
    public function showAddEpreuve($request, $attributes, $container)
    {
        return new Response(
            $container['twig']
                ->render(
                    'epreuve/addEpreuve.html.twig',
                    ['theme' => $container['theme']]
                ),
            200
        );
    }

    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @return Response
     * @throws Exception
     */
    public function addEpreuve($request, $attributes, $container)
    {
        if (is_string($request->get('submit'))) {
            try {
                $newEpreuve = new Epreuve(
                    $request->get('epreuveNom'),
                    EntityAbstract::strToDateTime($request->get('epreuveDate'))
                );
            } catch (Exception $e) {
                return new Response(
                    $container['twig']->render(
                        'epreuve/addEpreuve.html.twig',
                        [
                            'status' => true,
                            'theme' => $container['theme'],
                            'errorMessage' => "L'épreuve ne peut être créer à une date antérieur à la date actuelle",
                            'urlToRedirect' => '/Logitud_SkiChampionShip/addEpreuve'
                        ]
                    ),
                    Response::HTTP_METHOD_NOT_ALLOWED
                );
            }
            $connexion = new BDD($container['PDO']);
            if (!$connexion->addToBDD($newEpreuve)) {
                return new Response(
                    $container['twig']
                        ->render(
                            'epreuve/addEpreuve.html.twig',
                            [
                                'entity' => $newEpreuve,
                                'status' => true,
                                'theme' => $container['theme'],
                                'errorMessage' => 'Il existe déjà une épreuve avec ce nom',
                                'urlToRedirect' => '/Logitud_SkiChampionShip/addEpreuve'
                            ]
                        ),
                    Response::HTTP_METHOD_NOT_ALLOWED
                );
            }
        }
        return new RedirectResponse(
            '../../Logitud_SkiChampionShip/epreuveList',
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    /**
     * @param $request
     * @param $attributes
     * @return Response
     * @throws Exception
     */
    public function deleteEpreuve($request, $attributes, $container)
    {
        $epreuveToDelete = $attributes['id'];
        $controllerArray = EntityAbstract::splitAtUpperCase($attributes['_controller']);
        $entity = strtolower(end($controllerArray));

        $connexion = new BDD($container['PDO']);
        if ($connexion->deleteFromBDD($epreuveToDelete, $entity)) {
            return new RedirectResponse(
                '/Logitud_SkiChampionShip/epreuveList',
                Response::HTTP_TEMPORARY_REDIRECT
            );
        } else {
            throw new Exception('Un problème est survenue pendant la suppression');
        }
    }

    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @throws Exception
     * @return Response | RedirectResponse | void
     */
    public function updateEpreuve($request, $attributes, $container)
    {
        $connexion = new EpreuveModel($container['PDO']);
        try {
            $newEpreuve = new Epreuve(
                $request->request->get('epreuveNom'),
                EntityAbstract::strToDateTime($request->get('epreuveDate'))
            );
            $newEpreuve->setID($attributes['id']);
            $connexion->insertIntoBDDNewEpreuve($newEpreuve);
        } catch (Exception $e) {
            return new Response(
                $container['twig']->render(
                    'epreuve/showSingleEpreuve.html.twig',
                    [
                        'urlToRedirect' => "/Logitud_SkiChampionShip/showEpreuve/" . $attributes['id'],
                        'currentEpreuve' => $attributes['id'],
                        'status' => true,
                        'theme' => $container['theme'],
                        'errorMessage' => $e->getMessage()
                    ]
                ),
                Response::HTTP_METHOD_NOT_ALLOWED
            );
        }
        return new RedirectResponse(
            '/Logitud_SkiChampionShip/showEpreuve/' . $attributes['id'],
            Response::HTTP_TEMPORARY_REDIRECT
        );
    }

    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @return Response
     * @throws CannotInsertRecord
     * @throws \League\Csv\Exception
     */
    public function downloadCSV($request, $attributes, $container){
        $m_CSV = new CSVModel($container['PDO']);
        return new Response($m_CSV->createCSV($attributes['id']),200);
    }

    /**
     * @param $request
     * @param $attributes
     * @param $container
     * @return Response
     */
    public function uploadCSV($request, $attributes, $container){
        $m_CSV = new CSVModel($container['PDO']);
        $file = $request->files->get('upload');
        try{
            if($file->getClientOriginalExtension() == "csv" && $file->isValid()){
                $destPath = "./UploadedFile";
                $fileNewName = substr(
                    md5($file->getClientOriginalName()),
                    0,
                    8
                    ).'.'.$file->getClientOriginalExtension();
                $uploadFile = ['path' => $destPath, 'name' => $fileNewName];
                $result =$file->move($uploadFile['path'],$uploadFile['name']);


                return new Response("OK", Response::HTTP_OK);
            }
            throw new Exception("Le fichier doit être un .csv");

        }catch (Exception $e){
            return new response(
                $container['twig']
                    ->render(
                        'epreuve/showSingleEpreuve.html.twig',
                        [
                            'theme'         =>  $container['theme'],
                            'urlToRedirect' =>  "/Logitud_SkiChampionShip/showEpreuve/".$attributes['id'],
                            'currentEpreuve'=>  $attributes['id'],
                            'errorMessage'  =>  $e->getMessage(),
                            'status'        =>  true
                        ]

                    ),Response::HTTP_UNSUPPORTED_MEDIA_TYPE
            );
        }


    }
}
