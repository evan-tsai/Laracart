<?php


namespace EvanTsai\Laracart\Modules;


abstract class BaseModule
{
    protected $model;

    public function __construct()
    {
        $modelClass = $this->getModelClass();

        $this->model = new $modelClass;
    }

    public function for($id)
    {
        $model = $this->query()->find($id);

        if (!$model) {
            throw new \ErrorException('Model not found');
        }

        $this->model = $model;

        return $this;
    }

    public function query()
    {
        $query = call_user_func($this->getModelClass() . '::query');

        return $query;
    }

    public function getModel() {
        return $this->model;
    }

    abstract protected function getModelClass();
}
