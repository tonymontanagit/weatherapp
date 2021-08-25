<?php

namespace App\Repositories;

use App\Models\City;

class CityRepository
{
    /**
     * @var City
     */
    protected $city;

    /**
     * CityRepository constructor.
     *
     * @param City $city
     */
    public function __construct(City $city)
    {
        $this->city = $city;
    }

    /**
     * Get all citys.
     *
     * @return City $city
     */
    public function getAll()
    {
        return $this->city
            ->get();
    }

    /**
     * Get city by id
     *
     * @param $id
     * @return mixed
     */
    public function getById($id)
    {
        return $this->city
            ->where('id', $id)
            ->get();
    }


    /**
     * Save City
     *
     * @param $data
     * @return City
     */
    public function save($data)
    {
        $city = new $this->city;

        $city->title = $data['title'];
        $city->description = $data['description'];

        $city->save();

        return $city->fresh();
    }

    /**
     * Update city
     *
     * @param $data
     * @return city
     */
    public function update($data, $id)
    {
        
        $city = $this->city->find($id);

        $city->title = $data['title'];
        $city->description = $data['description'];

        $city->update();

        return $city;
    }

    /**
     * Update city
     *
     * @param $data
     * @return city
     */
    public function delete($id)
    {
        
        $city = $this->city->find($id);
        $city->delete();

        return $city;
    }

}