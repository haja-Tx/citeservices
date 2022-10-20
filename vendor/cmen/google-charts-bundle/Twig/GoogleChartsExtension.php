<?php

namespace CMEN\GoogleChartsBundle\Twig;

use CMEN\GoogleChartsBundle\Exception\GoogleChartsException;
use CMEN\GoogleChartsBundle\GoogleCharts\Chart;
use CMEN\GoogleChartsBundle\Output\ChartOutputInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

/**
 * @author Christophe Meneses
 */
class GoogleChartsExtension extends AbstractExtension
{
    /** @var ChartOutputInterface */
    private $chartOutput;

    public function __construct(ChartOutputInterface $chartOutput)
    {
        $this->chartOutput = $chartOutput;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('gc_draw', [$this, 'gcDraw'], ['is_safe' => ['html']]),
            new TwigFunction('gc_start', [$this, 'gcStart'], ['is_safe' => ['html']]),
            new TwigFunction('gc_end', [$this, 'gcEnd'], ['is_safe' => ['html']]),
            new TwigFunction('gc_event', [$this, 'gcEvent'], ['is_safe' => ['html']]),
            new TwigFunction('gc_language', [$this, 'gcLanguage']),
        ];
    }

    /**
     * Returns the Javascript for the beginning of one or more charts.
     *
     * @param Chart|Chart[]        $charts     Chart instance or array of Chart instance
     * @param string|string[]|null $elementsID HTML element ID or array of HTML elements IDs. Can be null
     *
     * @return string
     *
     * @throws GoogleChartsException
     */
    public function gcStart($charts, $elementsID = null)
    {
        return $this->chartOutput->startCharts($charts, $elementsID);
    }

    /**
     * Returns the Javascript for the end of one or more charts.
     *
     * @param Chart|Chart[] $charts Chart instance or array of Chart instance
     *
     * @return string
     *
     * @throws GoogleChartsException
     */
    public function gcEnd($charts)
    {
        return $this->chartOutput->endCharts($charts);
    }

    /**
     * Returns the full Javascript to draw one or more charts.
     *
     * @param Chart|Chart[]        $charts     Chart instance or array of Chart instance
     * @param string|string[]|null $elementsID HTML element ID or array of HTML elements IDs. Can be null
     *
     * @return string
     *
     * @throws GoogleChartsException
     */
    public function gcDraw($charts, $elementsID = null)
    {
        return $this->chartOutput->fullCharts($charts, $elementsID);
    }

    /**
     * Add an event to a chart.
     *
     * @param Chart  $chart        A Chart instance
     * @param string $type         Type of event
     * @param string $functionName Name of Javascript function
     *
     * @return void
     */
    public function gcEvent(Chart $chart, $type, $functionName)
    {
        $chart->getEvents()->addListener($type, $functionName);
    }

    /**
     * Set the locale. Must be called before drawing charts.
     *
     * @see https://developers.google.com/chart/interactive/docs/basic_load_libs#loadwithlocale
     *
     * @param string $language Locale, for example : "fr"
     *
     * @return void
     */
    public function gcLanguage($language)
    {
        $this->chartOutput->setLanguage($language);
    }
}
