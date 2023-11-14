<?php

require '../vendor/autoload.php';

use PhpSpellcheck\Spellchecker\Aspell;

// if you made the default aspell installation on you local machine
$aspell = Aspell::create();


//$misspellings = $aspell->check('helloe wordl', ['en_US'], ['from_example']);

//foreach ($misspellings as $misspelling) {
    //echo $misspelling->getWord(); // 'mispell'
  //  $misspelling->getLineNumber(); // '1'
    //$misspelling->getOffset(); // '0'
    //echo $misspelling->getSuggestions()[0]; // ['misspell', ...]
    //echo "\r\n";
    //$misspelling->getContext(); // ['from_example']
//}
