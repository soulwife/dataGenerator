<?php
namespace Model\Formatter;

/**
 * General abstract class for html formating
 *
 * @author Anastasiia
 */
abstract class HtmlFormatter {
    /**
     * 
     * @param string $element
     * @param string $item
     * @return string
     */
    protected function wrapElementToHtml($element, $item) {
        return "<" . $element . ">" . $item . "</" . $element . ">";
    }    
}
