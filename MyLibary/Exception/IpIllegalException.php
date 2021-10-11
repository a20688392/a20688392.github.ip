<?php
/**IpIllegalException.php */
namespace MyLibary\Exception;
use InvalidArgumentException;
class IpIllegalException extends InvalidArgumentException   
{
    /**
     * IpIllegalException constructor
     */
     
    public function __construct()
    {
        parent::__construct('Invalid IP!');
    }
}
