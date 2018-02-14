<?php
/**
 * Created by PhpStorm.
 * User: Josh Vogel
 * Date: 11/1/2017
 * Time: 2:35 PM
 */

namespace App\Exceptions;


use Illuminate\Support\MessageBag;
use Throwable;

abstract class BaseException extends \Exception
{
    protected $_errors;

    public function __construct($errors = null, $message = "", $code = 0, Throwable $previous = null)
    {
        $this->_set_errors($errors);
        parent::__construct($message, $code, $previous);
    }

    protected function _set_errors($errors){
        if(is_string($errors)) {
            $errors = array(
                'error' => $errors
            );
        }
        if(is_array($errors)){
            $errors = new MessageBag($errors);
        }
        $this->_errors = $errors;
    }

    public function get_errors(){
        return $this->_errors;
    }


}