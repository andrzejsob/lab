<?php
namespace lab\mapper;

class InternalOrderCollection extends Collection
                      // implements \database\domain\VenueCollection
{
    public function targetClass()
    {
        return 'lab\domain\InternalOrder';
    }
}
