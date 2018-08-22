<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 3/16/18
 * Time: 6:15 PM
 */

namespace Aiskander\CalendarHolidaysBundle\Provider;

class WikipediaHolidayProvider implements HolidayProviderInterface
{
    /**
     * @param string $country
     * @param int $year
     * @param array $options
     * @return array
     */
    public function getCountryYearHolidays(string $country, int $year, array $options = []): array
    {
        // TODO: Implement getYearHolidays() method.
    }
}
