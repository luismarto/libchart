<?php namespace Libchart\Label;

/**
 * Class EurCurrencyFormatter
 *
 * Class
 *
 * @package Libchart\Label
 */
class EurCurrencyFormatter extends NumberFormatted implements LabelInterface
{
    public function generateLabel($value)
    {
        return parent::generateLabel($value) . ' €';
    }
}
