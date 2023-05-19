<?php
namespace MyApp\Models;

use Phalcon\Mvc\Model;
use Phalcon\Messages\Message;
use Phalcon\Validation;
use Phalcon\Validation\Validator\Uniqueness;
use Phalcon\Validation\Validator\InclusionIn;

class tb_pasien extends Model
{
    public function validation()
    {
        $validator = new Validation();
        
        // Validate the validator
        return $this->validate($validator);
    }
}