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

    public function actionList($serial_id)
    {
        $episodeData = $this->repository->findAll($serial_id);

        return $this->twig->display('ep_list.html.twig', ['episodes' => $episodeData]);
    }

    public function actionNew($serial_id)
    {
        $this->repository->insert(
            [
                'title' => $_POST['title'],
                'description' => $_POST['description'],
                'date' => date('Y-m-d H:i:s'),
                'serial_id' => $serial_id,
            ]
        );
    }

    public function actionDelete($id)
    {
        $this->repository->delete(['id' => $id]);

    }

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
