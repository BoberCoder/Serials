<?php

namespace Serials\Controller;

use Serials\Repositories\EpisodeRepository;

class EpisodeController
{
    private $repository;

    private $loader;

    private $twig;

    public function __construct($connection)
    {
        $this->repository = new EpisodeRepository($connection);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/');
        $this->twig = new \Twig_Environment($this->loader, array('cache' => false));
    }

//    public function actionList()
//    {
//        $serialData = $this->repository->findAll();
//
//        return $this->twig->display('list.html.twig', ['serials' => $serialData]);
//    }
//
//    public function actionShow($title)
//    {
//        $title = str_replace('_',' ',$title);
//        $serialData = $this->repository->findBy($title);
//
//        return $this->twig->display('show.html.twig', ['serial' => $serialData]);
//    }

    public function actionNew()
    {
        $this->repository->insert(
            [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'date' => date('Y-m-d H:i:s'),
                'serial_id' => 1
            ]
        );
    }

//    public function actionDelete($title)
//    {
//        $title = str_replace('_',' ',$title);
//        $this->repository->delete(['title' => $title]);
//
//        return header("Location: /");
//    }

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
