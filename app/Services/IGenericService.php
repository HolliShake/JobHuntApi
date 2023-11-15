<?php

namespace App\Services;

interface IGenericService {
    function all();
    function getById($id);
    function create($newItem);
    function createAll(Array $newItemArray);
    function update($updatedItem);
    function delete($oldItem);
}

