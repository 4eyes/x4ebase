<?php
namespace X4e\X4ebase\ViewHelpers\Format;

/**
 * This file is part of the TYPO3 CMS project.
 *
 * It is free software; you can redistribute it and/or modify it under
 * the terms of the GNU General Public License, either version 2
 * of the License, or any later version.
 *
 * For the full copyright and license information, please read the
 * LICENSE.txt file that was distributed with this source code.
 *
 * The TYPO3 project - inspiring people to share!
 */

/**
 * Encodes the given string according to http://www.faqs.org/rfcs/rfc3986.html
 * (applying PHPs rawurlencode() function)
 * @see http://www.php.net/manual/function.rawurlencode.php
 *
 * @author Christoph Dörfel <christoph@4eyes.ch>
 */
class UrlencodeViewHelper extends \TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper
{

    /**
     * Disable the escaping interceptor because otherwise the child nodes would be escaped before this view helper
     * can decode the text's entities.
     *
     * @var bool
     */
    protected $escapingInterceptorEnabled = false;

    /**
     * Escapes special characters using PHPs urlencode() function.
     *
     * @param bool $insertSpaces
     * @param null $value
     * @return mixed|null
     * @see http://www.php.net/manual/function.rawurlencode.php
     */
    public function render($insertSpaces = true, $value = null)
    {
        if ($value === null) {
            $value = $this->renderChildren();
        }
        if (!is_string($value)) {
            return $value;
        }
        $encodedString = rawurlencode($value);
        return str_replace('%20', ' ', $encodedString);
    }
}
