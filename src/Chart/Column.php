<?php namespace Libchart\Chart;

use Libchart\Element\BasicPadding;

/**
 * Class Column
 * @package Libchart\Chart
 */
class Column extends AbstractChartBar
{
    /**
     * Ratio of empty space beside the bars.
     */
    private $emptyToFullRatio;

    /**
     * Creates a new vertical bar chart (Column)
     *
     * @param array $args arguments to define the properties for this chart
     */
    public function __construct(array $args)
    {
        parent::__construct('bar');
        $this->emptyToFullRatio = 1 / 5;

        $this->init($args, $this->hasSeveralSerie);
        $this->setGraphPadding(new BasicPadding(5, 30, 50, 50));
    }

    /**
     * Print the horizontal and vertical axis.
     */
    protected function printAxis()
    {
        $minValue = $this->axis->getLowerBoundary();
        $maxValue = $this->axis->getUpperBoundary();
        $stepValue = $this->axis->getTics();

        // Get the graph area
        $graphArea = $this->graphArea;
        $axisColor0 = $this->palette->axisColor[0];
        /**
         * Deal with the Vertical Axis
         */
        $this->gd->line($graphArea->x1 - 1, $graphArea->y1, $graphArea->x1 - 1, $graphArea->y2, $axisColor0);

        for ($value = $minValue; $value <= $maxValue; $value += $stepValue) {
            $y = $graphArea->y2
                - ($value - $minValue)
                * ($graphArea->y2 - $graphArea->y1)
                / ($this->axis->displayDelta);

            // For each marker, create the "guiding line"
            $this->gd->line($graphArea->x1, $y, $graphArea->x2, $y, $this->palette->backgroundColor);

            // Now print the label for the y axis
            $this->text->draw(
                $graphArea->x1 - 10,
                $y,
                $this->text->getColor(),
                $this->axisLabelGenerator->generateLabel($value),
                $this->text->getFont(),
                $this->text->HORIZONTAL_RIGHT_ALIGN | $this->text->VERTICAL_CENTER_ALIGN
            );
        }

        // Get first serie of a list
        $pointList = $this->getFirstSerieOfList();

        /**
         * Deal with the Horizontal Axis
         */
        $pointCount = count($pointList);
        reset($pointList);
        $columnWidth = ($graphArea->x2 - $graphArea->x1) / $pointCount;
        $horizOriginY = $graphArea->y2 + $minValue * ($graphArea->y2 - $graphArea->y1) / ($this->axis->displayDelta);

        $this->gd->line($graphArea->x1 -1, $horizOriginY, $graphArea->x2, $horizOriginY, $axisColor0);

        for ($i = 0; $i <= $pointCount; $i++) {
            $x = $graphArea->x1 + $i * $columnWidth;

            // Draw the bar separator marker
            $this->gd->line($x, $horizOriginY, $x, $horizOriginY + 5, $axisColor0);

            if ($i < $pointCount) {
                $point = current($pointList);
                next($pointList);

                $label = $point->getX();

                $this->text->printDiagonal(
                    $x + $columnWidth * 1 / 3,
                    $graphArea->y2 + 10,
                    $this->text->getColor(),
                    $label
                );
            }
        }
    }

    /**
     * Print the bars.
     */
    protected function printBar()
    {
        // Get the data as a list of series for consistency
        $serieList = $this->getDataAsSerieList();

        // Get the graph area
        $graphArea = $this->graphArea;

        // Start from the first color for the first serie
        $barColorSet = $this->palette->barColorSet;
        $barColorSet->reset();

        $minValue = $this->axis->getLowerBoundary();
        $maxValue = $this->axis->getUpperBoundary();
        $stepValue = $this->axis->getTics();

        $horizOriginY = $graphArea->y2 + $minValue * ($graphArea->y2 - $graphArea->y1) / ($this->axis->displayDelta);

        $serieCount = count($serieList);
        for ($j = 0; $j < $serieCount; $j++) {
            $serie = $serieList[$j];
            $pointList = $serie->getPointList();
            $pointCount = count($pointList);
            reset($pointList);

            // Select the next color for the next serie
            $bColor = '';
            if (!$this->config->get('useMultipleColor')) {
                $bColor = $barColorSet->currentColor();
                $barColorSet->next();
            }

            $columnWidth = ($graphArea->x2 - $graphArea->x1) / $pointCount;
            for ($i = 0; $i < $pointCount; $i++) {
                $x = $graphArea->x1 + $i * $columnWidth;

                /**
                 * @var \Libchart\Data\Point $point
                 */
                $point = current($pointList);
                next($pointList);

                $value = $point->getY();

                $ymin = $graphArea->y2
                    - ($value - $minValue)
                    * ($graphArea->y2 - $graphArea->y1)
                    / ($this->axis->displayDelta);

                // Bar dimensions
                $xWithMargin = $x + $columnWidth * $this->emptyToFullRatio;
                $columnWidthWithMargin = $columnWidth * (1 - $this->emptyToFullRatio * 2);
                $barWidth = $columnWidthWithMargin / $serieCount;
                $barOffset = $barWidth * $j;
                $x1 = $xWithMargin + $barOffset;
                $x2 = $xWithMargin + $barWidth + $barOffset - 1;

                // Select the next color for the next item in the serie

                // Check if the point has a specific color. If so, this overrides anything else
                if (!is_null($point->getColor())) {
                    $color = $point->getColor();
                } elseif ($this->config->get('useMultipleColor')) {
                    $color = $barColorSet->currentColor();
                    $barColorSet->next();
                } else {
                    $color = $bColor;
                }

                // Draw the vertical bar
                // Prevents drawing a small box when y = 0
                if ($value != 0) {
                    $this->gd->rectangle(
                        $x1 + 1,
                        $ymin + ($value > 0 ? 1 : 0),
                        $x2 - 4,
                        $horizOriginY + ($value >= 0 ? -1 : 2),
                        $color
                    );
                }

                // Draw caption text on bar
                if ($this->config->get('showPointCaption')) {
                    $this->text->draw(
                        $x1 + $barWidth / 2,
                        ($value >= 0 ? $ymin - 5 : $ymin + 15),
                        $this->text->getColor(),
                        $this->barLabelGenerator->generateLabel($value),
                        $this->text->getFont(),
                        $this->text->HORIZONTAL_CENTER_ALIGN | $this->text->VERTICAL_BOTTOM_ALIGN
                    );
                }
            }
        }
    }
}
