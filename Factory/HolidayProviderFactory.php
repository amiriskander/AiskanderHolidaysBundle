<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 3/16/18
 * Time: 6:20 PM
 */

namespace Aiskander\CalendarHolidaysBundle\Factory;

use Symfony\Component\Config\Definition\Exception\Exception;

/**
 * Class HolidayProviderFactory
 * @package Aiskander\CalendarHolidaysBundle\Provider
 */
class HolidayProviderFactory
{
    /**
     * @return mixed
     */
    public function create()
    {
        $args = func_get_args();
        if (empty($args)) {
            throw new Exception("Missing arguments to create the provider.");
        }
        $holidayProvider = array_shift($args);
        $namespace = 'Aiskander\\CalendarHolidaysBundle\\Provider\\';
        $targetClass = $namespace.ucfirst($holidayProvider).'HolidayProvider';
        if (class_exists($targetClass)) {
            return new $targetClass(...$args); // using the unpack operator
        } else {
            throw new Exception("The holiday provider '$holidayProvider' is not recognized");
        }
    }
}
