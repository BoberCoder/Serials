<?php

namespace Serials\Repositories;

interface RepositoryInterface
{
    public function findAll();

    public function insert($universityData);

    public function update($universityData);

    public function delete($universityData);

    public function findBy($id);
}
