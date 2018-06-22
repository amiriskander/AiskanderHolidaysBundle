<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 3/16/18
 * Time: 6:31 PM
 */

namespace Aiskander\HolidaysBundle\Provider;

class OfficeHolidaysHolidayProvider implements HolidayProviderInterface
{
    /**
     * @param string $country
     * @param int $year
     * @param array $options
     * @return array
     */
    public function getCountryYearHolidays(string $country, int $year, array $options = []): array
    {
        $country = strtolower($country);
        $url='https://www.officeholidays.com/countries/'.$country.'/index.php?year='.$year;

        // Use curl to get the page
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
        $html = curl_exec($ch);
        curl_close($ch);

        $dom = new \DOMDocument();
        @$dom->loadHTML($html);
        $holidays = array();
        $items = $dom->getElementsByTagName('tr');

        for ($i=0; $i < $items->length; $i++) {
            $holiday = [];
            $cssClass = $items->item($i)->getAttribute('class');
            if (strpos($cssClass, 'holiday') !== false) {
                $holiday['date'] = $items->item($i)->getElementsByTagName('td')->item(1)
                    ->getElementsByTagName('time')->item(0)->getAttribute('datetime');
                $name = $items->item($i)->getElementsByTagName('td')->item(2)->textContent;
                $holiday['name'] = trim($name);
                $holiday['type'] = $cssClass;
                $holidays[] = $holiday;
            }
        }

        return $holidays;
    }
}
