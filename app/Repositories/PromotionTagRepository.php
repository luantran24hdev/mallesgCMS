<?php

namespace App\Repositories;


use App\PromotionTag;
use App\TagMaster;
use BadMethodCallException, Auth;

class PromotionTagRepository implements RepositoryInterface
{   

    /**
     * get all resources in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function all()
    { 
        return PromotionTag::orderBy('tag_name')->get();
    }

    /**
     * find specified resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function find($id)
    {   
        return PromotionTag::find($id);
    }

    /**
     * create a resource in storage.
     *
     * @return \Illuminate\Http\Response
    */
    public function create($data)
    {
        try {
            return PromotionTag::create($data);
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
            return PromotionTag::find($id)->update($data);
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

        return PromotionTag::destroy($id);
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
        return TagMaster::where('tag_name','LIKE', "%$name%")                        
                        ->orderBy('tag_name')
                        ->pluck('tag_name', 'tag_id');
    }

}
