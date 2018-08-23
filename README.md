# Holidays Bundle

This bundle still under active development and not ready to be used yet.

## Installation

### Install Using Composer

```
composer require aiskander/calendar-holidays-bundle
```

### Add Bundle Instance

- Symfony 2.8 ~ 3.x

In `/app/AppKernel.php`, add the below line to the bundles array
```
new \Aiskander\CalendarHolidaysBundle\AiskanderCalendarHolidaysBundle();
```

- Symfony 4.x

In `/config/bundles.php`, add the below line to the bundles array.
```
\Aiskander\CalendarHolidaysBundle\AiskanderCalendarHolidaysBundle::class => ['all' => true],
```

### Import Bundle Routes

Add the below configuration to your Symfony `routing.yaml` file

```
aiskander_calendar_holidays:
    resource: "@AiskanderCalendarHolidaysBundle/Resources/config/routing.yml"
```