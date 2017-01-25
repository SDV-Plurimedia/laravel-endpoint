<?php

namespace Fab\Larapi\Contracts\Repositories;

use Illuminate\Database\Eloquent\Model;

interface EloquentRepository
{
    /**
     * Returns a paginator instance.
     *
     * @param  int $max Max items to return by page.
     *
     * @return [type]      [description]
     */
    public function paginate($max);
    /**
     * Returns a model by id.
     *
     * @param  int|string $id The id of the model to find.
     *
     * @return Model|null
     */
    public function find($id);
    /**
     * Create a new model.
     *
     * @param  array  $data The data needed for creation.
     *
     * @return Model       The created model.
     */
    public function create(array $data);
    /**
     * Update a model.
     *
     * @param  Model $model The model to update.
     * @param  array  $data          The data to update.
     *
     * @return Model                The updated model.
     */
    public function update($model, array $data);
    /**
     * Delete a model instance.
     *
     * @param  Dummyy $dummyInstance The model instance to delete.
     *
     * @return void
     */
    public function delete($model);
}
