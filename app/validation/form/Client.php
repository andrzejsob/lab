<?php
namespace lab\validation\form;

class Client extends Entity
{
    public function addValidators()
    {
        $this->validation->addSingleFieldValidation(
            new specificator\NoEmptyValue,
            'name',
            'Nazwa nie może być pusta'
        );
        $this->validation->addSingleFieldValidation(new specificator\ZipCodeFormat)
            ->forField('zipCode')
            ->withMessage('Kod musi mieć format: 12-345');
    }
}
