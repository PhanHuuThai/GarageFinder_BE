<?php

namespace App\Repositories;

interface BaseRepositoryInterface
{
    public function getAll();

    public function find($id);

    public function create($attributes = []);

    public function update($id, $attributes = []);

    public function delete($id);

    public function beginTransaction();

    public function commit();

    public function rollBack();
}