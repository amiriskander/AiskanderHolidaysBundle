<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 3/17/18
 * Time: 3:06 PM
 */

namespace Aiskander\CalendarHolidaysBundle\Controller;

use Aiskander\CalendarHolidaysBundle\Entity\Holiday;
use Aiskander\CalendarHolidaysBundle\Enum\HolidayProviderEnum;
use Aiskander\CalendarHolidaysBundle\Factory\HolidayProviderFactory;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HolidayController
 * @package Aiskander\CalendarHolidaysBundle\Controller
 */
class HolidayController extends Controller
{
    /**
     * @var HolidayProviderFactory
     */
    protected $holidayProviderFactory;

    /**
     * HolidayController constructor.
     * @param HolidayProviderFactory $holidayProviderFactory
     */
    public function __construct(HolidayProviderFactory $holidayProviderFactory)
    {
        $this->holidayProviderFactory = $holidayProviderFactory;
    }

    /**
     * @Route("/", name="holiday_index")
     */
    public function indexAction(Request $request)
    {
        $holidayProvider = $this->holidayProviderFactory->create('calculated');
        $holidayProvider->getCountryYearHolidays('egy');
    }

    /**
     * @Route("/import", name="holiday_import")
     */
    public function importAction(Request $request)
    {
        $holidays = $this->holidayProviderFactory->create(HolidayProviderEnum::OFFICE_HOLIDAYS)
            ->getCountryYearHolidays('egypt', 2018);

        // $holidayObjects = new ArrayCollection();
        $holidayForms = [];
        foreach ($holidays as $holiday) {
            $holidayObject = new Holiday();
            $holidayObject
                ->setName($holiday['name'])
                ->setDate(new \DateTime($holiday['date']))
                ->setProvider(HolidayProviderEnum::OFFICE_HOLIDAYS)
                ->setType($holiday['type']);

            $holidayForms[] = $this->createForm('Aiskander\CalendarHolidaysBundle\Form\HolidayType', $holidayObject)->createView();
            // $holidayObjects[] = $holidayObject;
            // $holidayObjects->add($holidayObject);
        }

        $bulkHolidayImportForm = $this->createForm('Aiskander\CalendarHolidaysBundle\Form\BulkHolidayType')->createView();
        // $form->handleRequest($request);

        return $this->render('@AiskanderHolidays/holiday/import.html.twig', [
            'forms'     => $holidayForms,
            'bulk_form' => $bulkHolidayImportForm,
        ]);
    }

    /**
     * @Route("/new", name="holiday_new")
     */
    public function newAction(Request $request)
    {
        $holiday = new Holiday();
        $form = $this->createForm('Aiskander\CalendarHolidaysBundle\Form\HolidayType', $holiday);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            // @TODO
        }
        return $this->render('@AiskanderCalendarHolidays/holiday/new.html.twig', array(
            'holiday' => $holiday,
            'form' => $form->createView(),
        ));
    }
}
