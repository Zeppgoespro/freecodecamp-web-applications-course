<?php

# PHP OOP

/*

class Person {
  public $full_name = false;
  public $given_name = false;
  public $family_name = false;
  public $room = false;

  function get_name() {
    if ($this->full_name !== false) return $this->full_name;
    if ($this->family_name !== false && $this->given_name !== false) {
      return $this->given_name . ' ' . $this->family_name;
    }
  }
}

$zepp = new Person();
$zepp->full_name = 'Dima Boronox';
$zepp->room = '135';

$cat = new Person();
$cat->family_name = 'Boronox';
$cat->given_name = 'Koko';
$cat->room = 'box';

echo $zepp->get_name() . '<br/>';
echo $cat->get_name() . '<br/>';

*/

/*

class Hello {
  protected $lang;

  function __construct($lang) {
    $this->lang = $lang;
  }

  function greet() {
    if ($this->lang == 'fr') return 'Bonjour';
    if ($this->lang == 'es') return 'Hola';
    return 'Hello';
  }
}

class Social extends Hello {
  function bye() {
    if ($this->lang == 'fr') return 'Au revoir';
    if ($this->lang == 'es') return 'Adios';
    return 'Goodbye';
  }
}

$hi = new Hello('fr');
echo $hi->greet();

echo '<br/>';

$farewell = new Social('es');
echo $farewell->bye() . '<br/>';
echo $farewell->greet() . '<br/>';

*/

?>