<?php

namespace AcitJazz\Starterkit\Http\Resources\Frontend;

use AcitJazz\Starterkit\Http\Resources\BaseResource;

class UserResource extends BaseResource
{
   /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */
   public function toArray($request)
   {
      return [
         'id' => $this->id,
         'name' => $this->name,
         'email' => $this->email,
         'slug' => $this->slug,
      ];
   }

}
