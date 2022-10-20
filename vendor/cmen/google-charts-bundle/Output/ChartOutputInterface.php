<?php

namespace CMEN\GoogleChartsBundle\Output;

use CMEN\GoogleChartsBundle\Exception\GoogleChartsException;
use CMEN\GoogleChartsBundle\GoogleCharts\Chart;

/**
 * @author Christophe Meneses
 */
interface ChartOutputInterface
{
    /**
     * Returns a string to draw the beginning of the chart (Declaration, data and options).
     *
     * @return string
     *
     * @throws GoogleChartsException
     */
    public function startChart(Chart $chart);

    /**
     * Returns a string to draw the end of the chart (Events and drawing).
     *
     * @return string
     */
    public function endChart(Chart $chart);

    /**
     * Returns a string to draw the beginning of one or more charts.
     *
     * @param Chart|Chart[]        $charts     Chart instance or array of Chart instance
     * @param string|string[]|null $elementsID HTML element ID or array of HTML elements IDs. Can be null
     *
     * @return string
     *
     * @throws GoogleChartsException
     */
    public function startCharts($charts, $elementsID = null);

    /**
     * Returns a string to draw the end of one or more charts.
     *
     * @param Chart|Chart[] $charts Chart instance or array of Chart instance
     *
     * @return string
     *
     * @throws GoogleChartsException
     */
    public function endCharts($charts);

    /**
     * Returns a string to draw one or more complete charts.
     *
     * @param Chart|Chart[]        $charts     Chart instance or array of Chart instance
     * @param string|string[]|null $elementsID HTML element ID or array of HTML elements IDs. Can be null
     *
     * @return string
     *
     * @throws GoogleChartsException
     */
    public function fullCharts($charts, $elementsID = null);

    /**
     * Returns a string to load Google libraries.
     *
     * @param string[] $packages List of packages to load
     *
     * @return string
     */
    public function loadLibraries(array $packages);

    /**
     * Returns a string for the beginning of the callback.
     *
     * @param string $name Name of callback
     *
     * @return string
     */
    public function startCallback($name);

    /**
     * Returns a string for the end of the callback.
     *
     * @return string
     */
    public function endCallback();

    /**
     * Sets the language used by Google for charts.
     *
     * @param string $language
     *
     * @return $this
     */
    public function setLanguage($language);
}
