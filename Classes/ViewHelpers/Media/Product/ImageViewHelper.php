<?php

namespace DPN\SwConnect\ViewHelpers\Media\Product;

use DPN\SwConnect\Media\ShopwareImageHelper;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

class ImageViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    /**
     * @var bool
     */
    protected  $escapeOutput = false;

    protected $escapeChildren = false;

    public function initializeArguments()
    {
        parent::initializeArguments();

        $this->registerArgument('image', 'object', 'The Image object to render');
    }

    /**
     * @param array $arguments
     * @param \Closure $renderChildrenClosure
     * @param RenderingContextInterface $renderingContext
     * @return mixed
     */
    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $image = $renderChildrenClosure();

        $file = ShopwareImageHelper::transformImageToFile($image);
        $file->_getMetaData();

        return $file;
    }
}
