<?php

namespace App\Repositories;


use App\MerchantMaster;
use BadMethodCallException, Auth;

class MerchantRepository implements RepositoryInterface
{   


    /**
     * get all resources in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function all()
    { 
        return MerchantMaster::all();
    }

    /**
     * find specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function find($id)
    {   
        return MerchantMaster::find($id);
    }

    /**
     * create a resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function create($data)
    {
        return MerchantMaster::create($data);
    }


    /**
     * update a specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function update($id, array $data)
    {   
        return MerchantMaster::find($id)->update($data);
    }


    /**
     * delete the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {

        return MerchantMaster::destroy($id);
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
