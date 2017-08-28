<?php
namespace lab\mapper;

class PermissionCollection extends Collection
                      // implements \database\domain\VenueCollection
{
    public function targetClass()
    {
        return 'lab\domain\Permission';
    }
}
