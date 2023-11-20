<?php

namespace App\Services;

class GenericService implements IGenericService {

    function __construct(protected $model) { }

    function all() {
        return $this->model::all();
    }

    function getById($id) {
        return $this->model::find($id);
    }

    function create($newitem) {
        return $this->model::create($newitem);
    }

    function createAll(Array $newitemArray) {
        return $this->model::insert($newitemArray);
    }

    function update($updatedItem) {
        return $this->model::find($updatedItem->id)->update((array) $updatedItem);
    }

    function delete($oldItem) {
        return $this->model::find($oldItem->id)->delete();
    }
}
