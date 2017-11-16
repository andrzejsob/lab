<?php
namespace lab\domain;

class UserAccount
{
    public function generateRandomPassword(int $nrOfCharacters = 8)
    {
        $charArray = array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j',
                            'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't',
                            'u', 'w', 'x', 'y', 'z', 'A', 'B', 'C', 'D', 'E',
                            'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O',
                            'P', 'Q', 'R', 'S', 'T', 'U', 'W', 'X', 'Y', 'Z',
                            '1', '2', '3', '4', '5', '6', '7', '8', '9', '0',
                            '!', '$', '_'
                      );
        $maxRange = count($charArray) - 1;
        $password = '';

        for ($i = 0; $i < $nrOfCharacters; $i++) {
            $password .= $charArray[mt_rand(0, $maxRange)];
        }

        return $password;
    }
}
