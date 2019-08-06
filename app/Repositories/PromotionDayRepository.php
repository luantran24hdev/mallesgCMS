<?php

namespace App\Repositories;


use App\PromotionDay;
use BadMethodCallException, Auth;

class PromotionDayRepository implements RepositoryInterface
{   

    /**
     * get all resources in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function all()
    { 
        return PromotionDay::all();
    }

    /**
     * find specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function find($id)
    {   
        return PromotionDay::find($id);
    }

    /**
     * create a resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function create($data)
    {
        try {
            return PromotionDay::create($data);
        } catch (QueryException $e) {
            throw new \Exception($e->getMessage(), 500, $e);
        }
    }


    /**
     * update a specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function update($id, array $data)
    {   
        try {
            return PromotionDay::find($id)->update($data);
        } catch (QueryException $e) {
            throw new \InvalidArgumentException('Cannot update promotion!', 500, $e);
        }
    }


    /**
     * delete the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {

        return PromotionDay::destroy($id);
    }

    /**
     * delete the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function delete($id)
    {   
        return $this->destroy($id);
    }


}
