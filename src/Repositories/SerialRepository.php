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
        $serials = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $serials;
    }

    public function findAll()
    {
        $statement = $this->connector->query('SELECT * FROM serial');

        return $this->fetchSerialsData($statement);
    }
    public function findBy($title)
    {
        $statement = $this->connector->prepare('
              SELECT *
              FROM serial 
              WHERE serial.title = :title 
              ');
        $statement->bindValue(':title', (string) $title);
        $statement->execute();
        $serialData = $this->fetchSerialsData($statement);

        return $serialData[0];
    }

    public function insert($serialData)
    {
        $statement = $this->connector->prepare('INSERT INTO serial (title, description, poster) VALUES (:title, :description, :poster)');
        $statement->bindValue(':title', $serialData['title']);
        $statement->bindValue(':description', $serialData['description']);
        $statement->bindValue(':poster', $serialData['poster']);

        return $statement->execute();
    }


    public function update($serialData)
    {
        $statement = $this->connector->prepare('UPDATE serial SET title = :title, description = :description, poster = :poster WHERE id = :id');
        $statement->bindValue(':title', $serialData['title']);
        $statement->bindValue(':description', $serialData['description']);
        $statement->bindValue(':poster', $serialData['poster']);
        $statement->bindValue(':id', $serialData['id']);

        return $statement->execute();
    }
    public function delete($serialData)
    {
        $file = $this->findBy($serialData["title"]);
        unlink($file["poster"]);

        $statement = $this->connector->prepare('DELETE FROM serial WHERE  title = :title');
        $statement->bindvalue(':title', $serialData['title'], \PDO::PARAM_STR);

        return $statement->execute();
    }
}
