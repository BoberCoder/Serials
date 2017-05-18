<?php

namespace Serials\Controller;

use Serials\Components\Paginator;
use Serials\Repositories\EpisodeRepository;
use Serials\Repositories\SerialRepository;

class SerialController
{
    private $repository;

    private $ep_repository;

    private $loader;

    private $twig;

    public function __construct($connection)
    {
        $this->repository = new SerialRepository($connection);
        $this->ep_repository = new EpisodeRepository($connection);
        $this->loader = new \Twig_Loader_Filesystem('src/Views/');
        $this->twig = new \Twig_Environment($this->loader, array('cache' => false));
    }

    public function actionList($page)
    {
        $all = $this->repository->countRecords();
        $all = $all[0]['count'];
        $limit = 5;
        $linkLimit = 3;

        $paginator = new Paginator($all,$limit,$linkLimit,$page);
        $pagination = $paginator->getLinks();
        if ($page==1)
        {
            $skip = 0;
        }
        else
        {
            $skip = ($page*$limit)-$limit;
        }

        $serialData = $this->repository->findAll($skip,$limit);

        return $this->twig->display('list.html.twig', ['serials' => $serialData,'pagination' => $pagination]);
    }

    public function actionShow($title)
    {
        $title = str_replace('_',' ',$title);
        $serialData = $this->repository->findBy($title);
        $episodeData = $this->ep_repository->findAll($serialData['id']);


        return $this->twig->display('show.html.twig', ['serial' => $serialData,'episodes' => $episodeData]);
    }

    public function actionNew()
    {
        if (isset($_POST['submit']))
        {
            if(is_uploaded_file($_FILES["poster"]["tmp_name"]))
            {
                move_uploaded_file($_FILES["poster"]["tmp_name"], $path = "uploads/posters/".$_FILES["poster"]["name"]);

                $this->repository->insert(
                    [
                        'title' => $_POST['title'],
                        'description' => $_POST['description'],
                        'poster' => $path,
                    ]
                );
            }
            else
            {
                echo("Ошибка загрузки файла");
            }
            return header("Location: /");
        }

        return $this->twig->display('new.html.twig');
    }

    public function actionDelete($title)
    {
        $title = str_replace('_',' ',$title);
        $this->repository->delete(['title' => $title]);

        return header("Location: /");
    }

    public function actionEdit($title)
    {
        if (isset($_POST['submit']))
        {
            $this->repository->update(
                [
                    'title' => $_POST['title'],
                    'description' => $_POST['description'],
                    'id' => $_POST['serial_id'],
                    'poster' => $_POST['existposter']
                ]
            );

            if(is_uploaded_file($_FILES["poster"]["tmp_name"]))
            {
                $_FILES["poster"]["name"] = uniqid();
                move_uploaded_file($_FILES["poster"]["tmp_name"], $path = "uploads/posters/".$_FILES["poster"]["name"]);
                $this->repository->update(
                    [
                        'title' => $_POST['title'],
                        'description' => $_POST['description'],
                        'id' => $_POST['serial_id'],
                        'poster' => $path,
                    ]
                );
                unlink($_POST['existposter']);
            }

            return header("Location: /");
        }

        $title = str_replace('_',' ',$title);
        $serialData = $this->repository->findBy($title);

        return $this->twig->display('edit.html.twig',
            [
                'title' => $serialData['title'],
                'description' => $serialData['description'],
                'poster' => $serialData['poster'],
                'id' => $serialData['id']
            ]
        );
    }
}
