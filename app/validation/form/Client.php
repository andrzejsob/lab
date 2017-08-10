<?php
namespace lab\validation\form;

use lab\validation\Facade as ValidationFacade;
use lab\validation\specification as specificator;
use lab\controller\Request as Request;
use lab\domain\DomainObject as DomainObject;

class Client
{

    public static function handleRequest(
        Request $request,
        DomainObject $client
    ) {
        if($request->getProperty('submit')) {
            $client->setProperties($request);
            $validation = self::addValidators();

            $validation->validate($client);
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
            ->forField('zipCode')
            ->withMessage('Kod musi mieć format: 12-345');

        return $validation;
    }
}
