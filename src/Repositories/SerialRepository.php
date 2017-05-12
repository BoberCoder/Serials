<?php

namespace Serials\Repositories;

class SerialRepository
{
    private $connector;

    public function __construct($connection)
    {
        $this->connector = $connection;
    }

    public function fetchSerialsData($statement)
    {
        while ($serial = $statement->fetch()) {
            $serials[] = [
                'id' => $serial['id'],
                'title' => $serial['title'],
                'description' => $serial['description'],
                'poster' => $serial['poster'],
            ];
        }

        return $serials;
    }

    public function findAll()
    {
        $statement = $this->connector->query('SELECT * FROM serial');

        return $this->fetchSerialsData($statement);
    }
    public function findBy($title)
    {
        $statement = $this->connector->prepare('SELECT * FROM serial WHERE title = :title LIMIT 1');
        $statement->bindValue(':title', (string) $title);
        $statement->execute();
        $universityData = $this->fetchSerialsData($statement);

        return $universityData[0];
    }

    public function insert($serialData)
    {
        $statement = $this->connector->prepare('INSERT INTO serial (title, description, poster) VALUES (:title, :description, :poster)');
        $statement->bindValue(':title', $serialData['title']);
        $statement->bindValue(':description', $serialData['description']);
        $statement->bindValue(':poster', $serialData['poster']);

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
//    public function delete($universityData)
//    {
//        $statement = $this->connector->prepare('DELETE FROM university WHERE  id = :id');
//        $statement->bindvalue(':id', $universityData['id'], \PDO::PARAM_INT);
//
//        return $statement->execute();
//    }
}
