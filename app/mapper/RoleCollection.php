<?php
namespace lab\mapper;

class RoleCollection extends Collection
                      // implements \database\domain\VenueCollection
{
    public function targetClass()
    {
        return 'lab\domain\Role';
    }
}
