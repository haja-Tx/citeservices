<?php

namespace CMEN\GoogleChartsBundle\GoogleCharts\Charts;

use CMEN\GoogleChartsBundle\GoogleCharts\Chart;
use CMEN\GoogleChartsBundle\GoogleCharts\EventType;
use CMEN\GoogleChartsBundle\GoogleCharts\Options\LineChart\LineChartOptions;

/**
 * @author Christophe Meneses
 */
class LineChart extends Chart
{
    /**
     * @var LineChartOptions
     */
    protected $options;

    public function __construct()
    {
        parent::__construct();

        $this->options = new LineChartOptions();
    }

    public function getType()
    {
        return 'LineChart';
    }

    public function getPackage()
    {
        return 'corechart';
    }

    public function getAvailableEventTypes()
    {
        return [
            EventType::ANIMATION_FINISH,
            EventType::CLICK,
            EventType::ERROR,
            EventType::ON_MOUSE_OUT,
            EventType::ON_MOUSE_OVER,
            EventType::READY,
            EventType::SELECT,
        ];
    }

    /**
     * @return LineChartOptions
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @param LineChartOptions $options
     *
     * @return LineChart
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }
}
