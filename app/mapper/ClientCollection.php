<?php
namespace lab\mapper;

class ClientCollection extends Collection
                      // implements \database\domain\VenueCollection
{
    public function targetClass()
    {
        return 'lab\domain\Client';
    }
}
