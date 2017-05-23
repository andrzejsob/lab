<?php
namespace lab\mapper;

class ContactPersonCollection extends Collection
                      // implements \database\domain\VenueCollection
{
    public function targetClass()
    {
        return 'lab\domain\ContactPerson';
    }
}
