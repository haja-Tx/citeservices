<?php

/**
 * @author Julien Mercier-Rojas <julien@jeckel-lab.fr>
 * Created at : 13/12/2019
 */

declare(strict_types=1);

namespace JeckelLab\AdvancedTypes\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;

/**
 * Class DurationExtension
 * @package App\Twig
 */
class DurationExtension extends AbstractExtension
{
    /** @var int */
    protected $dayDuration = 86400; // 60*60*24 ==> 1 day

    /**
     * DurationExtension constructor.
     * @param int|null $dayDuration
     */
    public function __construct($dayDuration = null)
    {
        if (null !== $dayDuration & is_numeric($dayDuration)) {
            $this->dayDuration = (int) $dayDuration;
        }
    }

    /**
     * @return TwigFilter[]
     */
    public function getFilters(): iterable
    {
        return [
            new TwigFilter('duration', [$this, 'formatDuration'])
        ];
    }

    /**
     * @param int $duration
     * @return string
     */
    public function formatDuration(int $duration): string
    {
        if ($duration === 0) {
            return '0';
        }

        $minutes = floor($duration / 60) % 60;
        $hours = floor(($duration % $this->dayDuration) / 3600) ;
        $days = floor($duration / $this->dayDuration);

        switch (true) {
            case $days > 0:
                return sprintf('%dd %d:%02d', $days, $hours, $minutes);
            case ($hours > 0 || $minutes > 0):
                return sprintf('%d:%02d', $hours, $minutes);
            default:
                return '<1mn';
        }
    }
}
