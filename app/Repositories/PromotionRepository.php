<?php

namespace App\Repositories;


use App\PromotionMaster;
use BadMethodCallException, Auth;

class PromotionRepository implements RepositoryInterface
{   

    /**
     * get all resources in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function all()
    { 
        return PromotionMaster::orderBy('promo_name')->get();
    }

    /**
     * find specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function find($id)
    {   
        return PromotionMaster::find($id);
    }

    /**
     * create a resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function create($data)
    {
        return PromotionMaster::create($data);
    }


    /**
     * update a specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function update($id, array $data)
    {   
        return PromotionMaster::find($id)->update($data);
    }


    /**
     * delete the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {

        return PromotionMaster::destroy($id);
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


    /**
     * 
     *
     * @return \Illuminate\Http\Response
    */
    public function search($name)
    {
        return PromotionMaster::where('promo_name','LIKE', "%$name%")                        
                        ->orderBy('promo_name')
                        ->pluck('promo_name', 'promo_id');
    }

}
