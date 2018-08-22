<?php
/**
 * Created by PhpStorm.
 * User: amir
 * Date: 3/17/18
 * Time: 3:06 PM
 */

namespace Aiskander\HolidaysBundle\Controller;

use Aiskander\HolidaysBundle\Entity\Holiday;
use Aiskander\HolidaysBundle\Enum\HolidayProviderEnum;
use Aiskander\HolidaysBundle\Factory\HolidayProviderFactory;
use Aiskander\HolidaysBundle\Provider\EgyptianHolidayProvider;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class HolidayController
 * @package Aiskander\HolidaysBundle\Controller
 */
class HolidayController extends Controller
{
    /**
     * @var HolidayProviderFactory
     */
    protected $holidayProviderFactory;

    protected $holidayProvider;

    /**
     * HolidayController constructor.
     * @param HolidayProviderFactory $holidayProviderFactory
     */
    public function __construct(HolidayProviderFactory $holidayProviderFactory, EgyptianHolidayProvider $holidayProvider)
    {
        $this->holidayProviderFactory = $holidayProviderFactory;
        $this->holidayProvider = $holidayProvider;
    }

    /**
     * @Route("/", name="holiday_index")
     */
    public function indexAction(Request $request)
    {
        $this->holidayProvider->getCountryYearHolidays('egy');
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

            $holidayForms[] = $this->createForm('Aiskander\HolidaysBundle\Form\HolidayType', $holidayObject)->createView();
            // $holidayObjects[] = $holidayObject;
            // $holidayObjects->add($holidayObject);
        }

        $bulkHolidayImportForm = $this->createForm('Aiskander\HolidaysBundle\Form\BulkHolidayType')->createView();
        // $form->handleRequest($request);

        return $this->render('@AiskanderHolidays/holiday/import.html.twig', [
            'forms' => $holidayForms,
            'bulk_form' => $bulkHolidayImportForm,
        ]);
    }

    /**
     * @Route("/new", name="holiday_new")
     */
    public function newAction(Request $request)
    {
        $holiday = new Holiday();
        $form = $this->createForm('Aiskander\HolidaysBundle\Form\HolidayType', $holiday);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // @TODO
        }

        return $this->render('@AiskanderHolidays/holiday/new.html.twig', array(
            'holiday' => $holiday,
            'form' => $form->createView(),
        ));
    }
}