<?php
namespace lab\validation\form;

use lab\validation\Facade as ValidationFacade;
use lab\validation\specification as specificator;
use lab\controller\Request as Request;

class Client
{

    public static function handleRequest(Request $request)
    {
        if($request->getProperty('submit')) {
            $validation = self::addValidators();
            $validation->validate($request);
            return $validation;
        }

        return new ValidationFacade();
    }

    public static function addValidators()
    {
        $validation = new ValidationFacade();
        $validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'name',
            'Nazwa nie może być pusta'
        );
        $validation->addSingleFieldValidation(new specificator\ZipCodeFormat)
            ->forField('zip_code')
            ->withMessage('Kod musi mieć format: 12-345');

        return $validation;
    }
}
