<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 3/28/18
 * Time: 11:52 PM
 */

namespace Aiskander\HolidaysBundle\Provider;

use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Config\Exception\FileLocatorFileNotFoundException;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\Yaml\Exception\ParseException;
use Symfony\Component\Yaml\Yaml;

class EgyptianHolidayProvider
{
    public function __construct()
    {

    }

    public function getCountryYearHolidays(string $country, int $year = null)
    {
        $year = ($year) ?? (int) date('Y');

        try {
            $fileLocator = new FileLocator([__DIR__.'/../Resources/config/holiday_providers']);
            $yamlFiles = $fileLocator->locate($country.'.yml', null, false);
            $holidays = Yaml::parseFile($yamlFiles[0]);

            if (isset($holidays['fixed']) && !empty($holidays['fixed'])) {
                foreach ($holidays['fixed'] as $k => $holiday) {
                    switch ($holiday['calendar']) {
                        case 'gregorian':
                            $date = $holiday['date'].' '.$year;
                            $holidays['fixed'][$k]['timestamp'] = strtotime($date);
                            $holidays['fixed'][$k]['date_formatted'] = date('Y-m-d', strtotime($date));
                            break;
                        case 'coptic':
                            break;
                        case 'hijri':
                            $date = \GeniusTS\HijriDate\Hijri::convertToHijri(date('Y-m-d'));
                            $hijriYear = $date->year;

                            dump($date->format('l d F o')); die;
                            break;
                        default:
                            break;
                    }
                }
            }
            dump($holidays); die;
        } catch (ParseException $exception) {
            // @TODO
        } catch (FileLocatorFileNotFoundException $exception) {
            // @TODO
        } catch (Exception $exception) {
            // @TODO
        }
    }

    private function getOrthodoxEaster($year)
    {
        $a = $year % 4;
        $b = $year % 7;
        $c = $year % 19;
        $d = (19 * $c + 15) % 30;
        $e = (2 * $a + 4 * $b - $d + 34) % 7;
        $month = floor(($d + $e + 114) / 31);
        $day = (($d + $e + 114) % 31) + 1;
        $de = mktime(0, 0, 0, $month, $day + 13, $year);

        return $de;
    }
}
