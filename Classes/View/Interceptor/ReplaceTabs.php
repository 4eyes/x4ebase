<?php
namespace X4e\X4ebase\View\Interceptor;

class ReplaceTabs implements \TYPO3\CMS\Fluid\Core\Parser\InterceptorInterface
{

    /**
     * @var bool
     */
    protected $interceptorEnabled = true;

    /**
     * @var Tx_Extbase_Object_ObjectManagerInterface
     */
    protected $objectManager;

    /**
     * @param \TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager
     * @return void
     */
    public function injectObjectManager(\TYPO3\CMS\Extbase\Object\ObjectManagerInterface $objectManager)
    {
        $this->objectManager = $objectManager;
    }

    /**
     * @param \TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\NodeInterface $node
     * @param int $interceptorPosition One of the INTERCEPT_* constants for the current interception point
     * @param \TYPO3\CMS\Fluid\Core\Parser\ParsingState $parsingState the current parsing state. Not needed in this interceptor.
     * @return \TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\NodeInterface
     */
    public function process(\TYPO3\CMS\Fluid\Core\Parser\SyntaxTree\NodeInterface $node, $interceptorPosition, \TYPO3\CMS\Fluid\Core\Parser\ParsingState $parsingState)
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
