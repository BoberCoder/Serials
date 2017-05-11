<?php

namespace Serials\Controller;

use Serials\Repositories\SerialRepository;

class SerialController
{
    private $repository;

    private $loader;

    private $twig;

    public function __construct($connection)
    {
        $this->repository = new SerialRepository($connection);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/');
        $this->twig = new \Twig_Environment($this->loader, array('cache' => false));
    }

    public function actionList()
    {
        $serialData = $this->repository->findAll();

        return $this->twig->display('list.html.twig', ['serials' => $serialData]);
    }

//    public function actionNew()
//    {
//        if (isset($_POST['submit'])) {
//            $this->repository->insert(
//                [
//                    'name' => $_POST['name'],
//                    'town' => $_POST['town'],
//                    'site' => $_POST['site'],
//                ]
//            );
//
//            return $this->actionList();
//        }
//
//        return $this->twig->display('university_new.html.twig');
//    }
//
//    public function actionRemove($id)
//    {
//        $this->repository->delete(['id' => $id]);
//
//        return $this->actionList();
//    }
//
//    public function actionEdit($id)
//    {
//        if (isset($_POST['submit'])) {
//            $this->repository->update(
//                [
//                    'name' => $_POST['name'],
//                    'town' => $_POST['town'],
//                    'site' => $_POST['site'],
//                    'id' => (int) $id,
//
//                ]
//            );
//
//            return $this->actionList();
//        }
//
//        $universityData = $this->repository->findBy($id);
//
//        return $this->twig->display('university_new.html.twig',
//            [
//                'name' => $universityData['name'],
//                'town' => $universityData['town'],
//                'site' => $universityData['site'],
//            ]
//        );
//    }
}
