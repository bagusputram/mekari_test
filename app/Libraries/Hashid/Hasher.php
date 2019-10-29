<?php

namespace App\Libraries\Hashid;

use Hashids\Hashids;

class Hasher
{
    public function encode($value)
    {
      return app(Hashids::class)->encode($value);
    }

    public function decode($value)
    {
      if( $value == null )
        return NULL;
      $data = app(Hashids::class)->decode($value);

      if (is_int($value)) {
        return $value;
      }
      elseif (count($data) > 1) {
        return $data;
      }

      if( is_array($data) && count($data) == 1 ) {
        return $data[0];
      } 
      return NULL;
    }
}
