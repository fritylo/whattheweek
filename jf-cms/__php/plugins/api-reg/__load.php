<?php

class JustFieldRegisterPlaceholder {
   function __get($name)
   {
      return new JustFieldRegisterPlaceholder();
   }
   function __set($name, $value)
   {
      return $value;
   }
   function __call($name, $arguments)
   {
      return null;
   }
}
class JustFieldRegister {
   private stdClass $reg;
   function __construct() {
      $this->reg = new stdClass();
   }

   function __get($name)
   {
      if (property_exists($this->reg, $name))
         return $this->reg->{$name};
      else
         return new JustFieldRegisterPlaceholder();
   }
   function __set($name, $value)
   {
      return $this->reg->{$name} = $value;
   }
   function __call($name, $arguments)
   {
      if (get_class($this->reg->{$name}) != 'JustFieldRegisterPlaceholder')
         return call_user_func($this->reg->{$name}, $arguments);
      else
         return null;
   }
}

$reg = new JustFieldRegister();
$reg->path_to_jf_php_folder = '';