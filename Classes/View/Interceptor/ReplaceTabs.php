<?php
namespace X4e\X4ebase\View\Interceptor;

use \TYPO3Fluid\Fluid\Core\Parser\SyntaxTree\NodeInterface;
use \TYPO3Fluid\Fluid\Core\Parser\ParsingState;
use \TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

class ReplaceTabs implements \TYPO3\CMS\Fluid\Core\Parser\InterceptorInterface
{

    /**
     * @var bool
     */
    protected $interceptorEnabled = true;

    /**
     * @var ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param ObjectManagerInterface $objectManager
     * @return void
     */
    public function injectObjectManager(ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param NodeInterface $node
     * @param int $interceptorPosition One of the INTERCEPT_* constants for the current interception point
     * @param ParsingState $parsingState the current parsing state. Not needed in this interceptor.
     * @return \TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\NodeInterface
     */
    public function process(NodeInterface $node, $interceptorPosition, ParsingState $parsingState)
    {
        $nodeText = $node->getText();
        $replacedNode = $this->objectManager->get('TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\TextNode', str_replace(chr(9), chr(8204), $nodeText));
        return $replacedNode;
    }

    /**
     * @return array Array of INTERCEPT_* constants
     */
    public function getInterceptionPoints()
    {
        return [
            self::INTERCEPT_TEXT
        ];
    }
}
