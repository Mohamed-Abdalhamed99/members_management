<?php
namespace App\Traits;

trait StoreFile
{

    /**
     * store files
     *
     * @param $file
     * @return string
     */
    public function storeFile($file , $folder) :string
    {

        if($file){
            $filename= date('YmdHi').$file->getClientOriginalExtension();
            $file-> move(public_path($folder), $filename);
        }
        return $filename;
    }
}
