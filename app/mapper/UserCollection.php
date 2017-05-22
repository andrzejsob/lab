<?php
namespace lab\mapper;

class UserCollection extends Collection
                      // implements \database\domain\VenueCollection
{
    public function targetClass()
    {
        return 'lab\domain\User';
    }
}
