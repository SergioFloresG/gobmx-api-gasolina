<?php
namespace App\Repositories;

use App\Models\CatalogPostalCodes as PostalCodesModel;
use Illuminate\Support\Facades\DB;

class PostalCodesRepository
{

    /**
     * @var PostalCodesModel
     */
    private $model;

    public function __construct(PostalCodesModel $model)
    {
        $this->model = $model;
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    public function obtainStates()
    {
        return $this->queryState()->get();
    }

    /**
     * @param integer $state_key
     *
     * @return object|null (state_key, state_name)
     */
    public function getState($state_key)
    {
        return $this->queryState()->where('state_key', $state_key)->first();
    }

    /**
     * @param integer $state_key
     *
     * @return \Illuminate\Support\Collection
     */
    public function obtainTownshipOfState($state_key)
    {
        return $this->queryTown($state_key)->get();
    }

    /**
     * @param integer $state_key
     * @param integer $town_key
     *
     * @return object|null (town_key, town_name)
     */
    public function getTownship($state_key, $town_key)
    {
        return $this->queryTown($state_key)->where('town_key', $town_key)->first();
    }

    /**
     * @param integer $state_key
     * @param integer $township_key
     *
     * @return \Illuminate\Support\Collection
     */
    public function obtainPostalCodesOfTownship($state_key, $township_key)
    {
        return PostalCodesModel::query()->toBase()
            ->from(DB::raw($this->model->getTable() . ' FORCE INDEX (index_statetownkey)'))
            ->select(['cp'])
            ->where('state_key', $state_key)
            ->where('town_key', $township_key)
            ->groupBy(['cp'])
            ->pluck('cp');
    }


    /**
     * @return \Illuminate\Database\Query\Builder
     */
    private function queryState()
    {
        return PostalCodesModel::query()->toBase()
            ->from(DB::raw($this->model->getTable() . ' FORCE INDEX (index_statekey)'))
            ->select(['state_key', 'state_name'])
            ->groupBy(['state_key', 'state_name']);
    }

    /**
     * @param $state_key
     *
     * @return \Illuminate\Database\Query\Builder
     */
    private function queryTown($state_key)
    {
        return PostalCodesModel::query()->toBase()
            ->from(DB::raw($this->model->getTable() . ' FORCE INDEX (index_statetownkey)'))
            ->select(['town_key', 'town_name'])
            ->where('state_key', $state_key)
            ->groupBy(['town_key', 'town_name']);
    }
}