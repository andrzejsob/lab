<?php
namespace lab\mapper;

class MethodCollection extends Collection
                      // implements \database\domain\VenueCollection
{
    public function targetClass()
    {
        return 'lab\domain\Method';
    }
}
