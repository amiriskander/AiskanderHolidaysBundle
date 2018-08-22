<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 3/16/18
 * Time: 6:11 PM
 */

namespace Aiskander\HolidaysBundle\Provider;

interface HolidayProviderInterface
{
    /**
     * @param string $country
     * @param int $year
     * @param array $options
     * @return array
     */
    public function getCountryYearHolidays(string $country, int $year, array $options = []) : array;
}
