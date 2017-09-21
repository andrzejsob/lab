<?php
namespace lab\mapper;

class OrderCollection extends Collection
                      // implements \database\domain\VenueCollection
{
    public function targetClass()
    {
        return 'lab\domain\Order';
    }
}
