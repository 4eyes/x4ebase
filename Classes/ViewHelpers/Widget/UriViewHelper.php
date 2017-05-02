<?php
namespace X4e\X4ebase\ViewHelpers\Widget;

/*
 * This script is backported from the TYPO3 Flow package "TYPO3.Fluid".   *
 *                                                                        *
 * It is free software; you can redistribute it and/or modify it under    *
 * the terms of the GNU Lesser General Public License, either version 3   *
 *  of the License, or (at your option) any later version.                *
 *                                                                        *
 *                                                                        *
 * This script is distributed in the hope that it will be useful, but     *
 * WITHOUT ANY WARRANTY; without even the implied warranty of MERCHAN-    *
 * TABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU Lesser       *
 * General Public License for more details.                               *
 *                                                                        *
 * You should have received a copy of the GNU Lesser General Public       *
 * License along with the script.                                         *
 * If not, see http://www.gnu.org/licenses/lgpl.html                      *
 *                                                                        *
 * The TYPO3 project - inspiring people to share!                         *
 *                                                                        */
/**
 * A view helper for creating URIs to extbase actions within widgets.
 *
 * = Examples =
 *
 * <code title="URI to the show-action of the current controller">
 * <f:widget.uri action="show" />
 * </code>
 * <output>
 * index.php?id=123&tx_myextension_plugin[widgetIdentifier][action]=show&tx_myextension_plugin[widgetIdentifier][controller]=Standard&cHash=xyz
 * (depending on the current page, widget and your TS configuration)
 * </output>
 *
 */
class UriViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Widget\UriViewHelper
{

    /**
     * Initializes the view helper before invoking the render method.
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerArgument('absolute', 'boolean', 'If set, the URI of the rendered link is absolute', false, false);
    }

    /**
     * Get the URI for an AJAX Request.
     *
     * @return string
     */
    protected function getAjaxUri()
    {
        $action = $this->arguments['action'];
        $arguments = $this->arguments['arguments'];
        if ($action === null) {
            $action = $this->controllerContext->getRequest()->getControllerActionName();
        }
        $arguments['fluid-widget-id'] = $this->controllerContext->getRequest()->getWidgetContext()->getAjaxWidgetIdentifier();
        $arguments['action'] = $action;

        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uri = $uriBuilder
                ->reset()
                ->setTargetPageUid($GLOBALS['TSFE']->id)
                ->setTargetPageType(7076)
                ->setNoCache(false)
                ->setUseCacheHash(false)
                ->setSection('')
                ->setLinkAccessRestrictedPages(true)
                ->setArguments($arguments)
                ->setCreateAbsoluteUri((boolean)$this->arguments['absolute'])
                ->setAddQueryString(false)
                ->setArgumentsToBeExcludedFromQueryString([])
                ->build();
        return $uri;
    }
}
