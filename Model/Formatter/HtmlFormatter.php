<?php
namespace Model\Formatter;

/**
 * Description of HtmlFormatter
 *
 * @author Anastasiia
 */
abstract class HtmlFormatter {
    protected function wrapElementToHtml($element, $item) {
        return "<" . $element . ">" . $item . "</" . $element . ">";
    }    
}
