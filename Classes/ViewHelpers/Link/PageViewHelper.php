<?php
namespace X4e\X4ebase\ViewHelpers\Link;

class PageViewHelper extends \TYPO3\CMS\Fluid\ViewHelpers\Link\PageViewHelper
{

    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * Arguments initialization
     *
     * @return void
     */
    public function initializeArguments()
    {
        $this->registerUniversalTagAttributes();
        $this->registerTagAttribute('target', 'string', 'Target of link', false);
        $this->registerTagAttribute('rel', 'string', 'Specifies the relationship between the current document and the linked document', false);
    }

    /**
     * @param int|NULL $pageUid target page. See TypoLink destination
     * @param array $additionalParams query parameters to be attached to the resulting URI
     * @param int $pageType type of the target page. See typolink.parameter
     * @param bool $noCache set this to disable caching for the target page. You should not need this.
     * @param bool $noCacheHash set this to supress the cHash query parameter created by TypoLink. You should not need this.
     * @param string $section the anchor to be added to the URI
     * @param bool $linkAccessRestrictedPages If set, links pointing to access restricted pages will still link to the page even though the page cannot be accessed.
     * @param bool $absolute If set, the URI of the rendered link is absolute
     * @param bool $addQueryString If set, the current query parameters will be kept in the URI
     * @param array $argumentsToBeExcludedFromQueryString arguments to be removed from the URI. Only active if $addQueryString = TRUE
     * @param string $uriScheme
     * @return string
     */
    public function render($pageUid = null, array $additionalParams = [], $pageType = 0, $noCache = false, $noCacheHash = false, $section = '', $linkAccessRestrictedPages = false, $absolute = false, $addQueryString = false, array $argumentsToBeExcludedFromQueryString = [], $uriScheme = null)
    {
        \X4e\X4ebase\Utility\BackendUtility::initTSFE($pageUid);

        $uriBuilder = $this->controllerContext->getUriBuilder();
        $uri = $uriBuilder->reset()->setTargetPageUid($pageUid)->setTargetPageType($pageType)->setNoCache($noCache)->setUseCacheHash(!$noCacheHash)->setSection($section)->setLinkAccessRestrictedPages($linkAccessRestrictedPages)->setArguments($additionalParams)->setCreateAbsoluteUri($absolute)->setAddQueryString($addQueryString)->setArgumentsToBeExcludedFromQueryString($argumentsToBeExcludedFromQueryString)->setAbsoluteUriScheme($uriScheme);
        $uri = $uriBuilder->buildFrontendUri();
        $this->tag->addAttribute('href', $uri);
        $this->tag->setContent($this->renderChildren());
        return $this->tag->render();
    }
}
