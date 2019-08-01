<?php

namespace App\Repositories;


use App\MallMaster;
use BadMethodCallException, Auth;

class MallRepository implements RepositoryInterface
{   

    /**
     * get all resources in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function all()
    { 
        return MallMaster::orderBy('mall_name')->get();
    }

    /**
     * find specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function find($id)
    {   
        return MallMaster::find($id);
    }

    /**
     * create a resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function create($data)
    {
        return MallMaster::create($data);
    }


    /**
     * update a specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function update($id, array $data)
    {   
        return MallMaster::find($id)->update($data);
    }


    /**
     * delete the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function destroy($id)
    {

        return MallMaster::destroy($id);
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
        return MallMaster::where('mall_name','LIKE', "%$name%")                        
                        ->orderBy('mall_name')
                        ->pluck('mall_name', 'mall_id');
    }

}
