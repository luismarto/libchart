<?php namespace Libchart\Element;

use Libchart\Color\ColorHex;
use Noodlehaus\Config;

/**
 * Class Text
 * @package Libchart\Element
 */
class Text
{
    public $HORIZONTAL_LEFT_ALIGN = 1;
    public $HORIZONTAL_CENTER_ALIGN = 2;
    public $HORIZONTAL_RIGHT_ALIGN = 4;
    public $VERTICAL_TOP_ALIGN = 8;
    public $VERTICAL_CENTER_ALIGN = 16;
    public $VERTICAL_BOTTOM_ALIGN = 32;

    /**
     * @var Config
     */
    private $config;

    /**
     * @var string
     */
    private $fontsDirectory;

    /**
     * @var string
     */
    private $font;

    /**
     * @var int
     */
    private $angle;

    /**
     * @var resource
     */
    private $img;

    /**
     * @var ColorHex
     */
    private $color;

    /**
     * Creates a new text drawing helper.
     */
    public function __construct($img, $config)
    {
        $this->img = $img;
        $this->config = $config;

        $this->fontsDirectory = $this->config->get(
            'fonts.path',
            dirname(__FILE__)
            . DIRECTORY_SEPARATOR. '..'
            . DIRECTORY_SEPARATOR . '..'
            . DIRECTORY_SEPARATOR . 'fonts' . DIRECTORY_SEPARATOR
        );

        $this->font = $this->fontsDirectory
            . $this->config->get('fonts.text', 'SourceSansPro-Light.otf');

        $this->angle = $this->config->get('label.angle', 0);
        // @todo: make this configurable
        $this->color = new ColorHex('#555555');
    }

    /**
     * Print text.
     *
     * @param integer $px text coordinate (x)
     * @param integer $py text coordinate (y)
     * @param \Libchart\Color\Color $color text color
     * @param string $text text value
     * @param string $fontFileName font file name
     * @param int $align text alignment
     * @param int $fontSize
     */
    public function draw($px, $py, $color, $text, $fontFileName, $align = 0, $fontSize = 12)
    {
        if (!($align & $this->HORIZONTAL_CENTER_ALIGN) && !($align & $this->HORIZONTAL_RIGHT_ALIGN)) {
            $align |= $this->HORIZONTAL_LEFT_ALIGN;
        }

        if (!($align & $this->VERTICAL_CENTER_ALIGN) && !($align & $this->VERTICAL_BOTTOM_ALIGN)) {
            $align |= $this->VERTICAL_TOP_ALIGN;
        }

        $lineSpacing = 1;

        list ($llx, $lly, $lrx, $lry, $urx, $ury, $ulx, $uly)= imageftbbox(
            $fontSize,
            0,
            $fontFileName,
            $text,
            array("linespacing" => $lineSpacing)
        );

        $textWidth = $lrx - $llx;
        $textHeight = $lry - $ury;

        $angle = 0;

        if ($align & $this->HORIZONTAL_CENTER_ALIGN) {
            $px -= $textWidth / 2;
        }

        if ($align & $this->HORIZONTAL_RIGHT_ALIGN) {
            $px -= $textWidth;
        }

        if ($align & $this->VERTICAL_CENTER_ALIGN) {
            $py += $textHeight / 2;
        }

        if ($align & $this->VERTICAL_TOP_ALIGN) {
            $py += $textHeight;
        }

        imagettftext($this->img, $fontSize, $angle, $px, $py, $color->getColor($this->img), $fontFileName, $text);
    }

    /**
     * Print text centered horizontally on the image.
     *
     * @param integer $py text coordinate (y)
     * @param \Libchart\Color\Color $color text color
     * @param string $text text value
     * @param string $fontFileName font file name
     * @param int $fontSize
     */
    public function printCentered($py, $color, $text, $fontFileName, $fontSize)
    {
        $this->draw(
            imagesx($this->img) / 2,
            $py,
            $color,
            $text,
            $fontFileName,
            $this->HORIZONTAL_CENTER_ALIGN | $this->VERTICAL_CENTER_ALIGN,
            $fontSize
        );
    }

    /**
     * Print text in diagonal.
     *
     * @param int $px text coordinate (x)
     * @param int $py text coordinate (y)
     * @param \Libchart\Color\Color $color text color
     * @param string $text value
     */
    public function printDiagonal($px, $py, $color, $text)
    {
        $fontSize = $this->config->get('label.size', 11);
        $fontFileName = $this->font;

        $py = $py + $this->config->get('label.margin-top', 15);
        imagettftext($this->img, $fontSize, $this->angle, $px, $py, $color->getColor($this->img), $fontFileName, $text);
    }

    /**
     * Sets a new font to be used for the text
     * @param string $fontName
     * @return $this
     */
    public function setFont($fontName)
    {
        if (strpos($fontName, DIRECTORY_SEPARATOR) === false) {
            $this->font = $this->fontsDirectory . $fontName;
        } else {
            $this->font = $fontName;
        }

        return $this;
    }

    /**
     * Returns the font used for the chart texts
     * @return string
     */
    public function getFont()
    {
        return $this->font;
    }

    /**
     * Allows you to change the point's label angle on runtime
     * @param int $angle
     * @return $this
     */
    public function setAngle($angle)
    {
        $this->angle = $angle;

        return $this;
    }

    /**
     * Defines the color
     * @param string $hexColor
     * @return $this
     */
    public function setColorHex($hexColor)
    {
        $this->color = new ColorHex($hexColor);

        return $this;
    }

    /**
     * Returns the text color
     * @return ColorHex
     */
    public function getColor()
    {
        return $this->color;
    }
}
