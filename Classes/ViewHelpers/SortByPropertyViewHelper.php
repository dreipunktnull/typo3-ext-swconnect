<?php

namespace DPN\SwConnect\ViewHelpers;

use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

class SortByPropertyViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    public function initializeArguments()
    {
        $this->registerArgument('subject', 'array', 'Subject to sort', false);
        $this->registerArgument('property', 'string', 'Property to sort by', false);
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        $subject = $renderChildrenClosure();
        $property = $arguments['property'];

        if (empty($subject)) {
            return;
        }

        if (current($subject) === null) {
            return;
        }

        uasort($subject, function ($a, $b) use ($property) {
            return strcmp($a->get{ucfirst($property)}, $b->get{ucfirst($property)});
        });

        return $subject;
    }
}
