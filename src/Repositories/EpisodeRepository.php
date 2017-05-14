<?php

namespace Serials\Repositories;

class EpisodeRepository
{
    private $connector;

    public function __construct($connection)
    {
        $this->connector = $connection;
    }

    public function fetchEpisodesData($statement)
    {
        $episodes = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $episodes;
    }

    public function findAll($serial_id)
    {
        $statement = $this->connector->prepare('SELECT * FROM episode WHERE serial_id = :serial_id');
        $statement->bindValue(':serial_id', $serial_id);
        $statement->execute();

        return $this->fetchEpisodesData($statement);
    }


    public function insert($episodeData)
    {
        $statement = $this->connector->prepare('INSERT INTO episode (title, description, date, serial_id) VALUES (:title, :description, :date, :serial_id)');
        $statement->bindValue(':title', $episodeData['title']);
        $statement->bindValue(':description', $episodeData['description']);
        $statement->bindValue(':date', $episodeData['date']);
        $statement->bindValue(':serial_id', $episodeData['serial_id']);

        return $statement->execute();
    }


//    public function update($universityData)
//    {
//        $statement = $this->connector->prepare('UPDATE university SET name = :name, town = :town, site = :site WHERE id = :id');
//        $statement->bindValue(':name', $universityData['name']);
//        $statement->bindValue(':town', $universityData['town']);
//        $statement->bindValue(':site', $universityData['site']);
//        $statement->bindValue(':id', $universityData['id']);
//
//        return $statement->execute();
//    }
//    public function delete($serialData)
//    {
//        $file = $this->findBy($serialData["title"]);
//        unlink($file["poster"]);
//
//        $statement = $this->connector->prepare('DELETE FROM serial WHERE  title = :title');
//        $statement->bindvalue(':title', $serialData['title'], \PDO::PARAM_STR);
//
//        return $statement->execute();
//    }
}
