<?php
namespace DPN\SwConnect\ViewHelpers\Price;

use DPN\SwConnect\Domain\Model\Price;
use TYPO3\CMS\Fluid\Core\ViewHelper\AbstractViewHelper;
use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\Traits\CompileWithContentArgumentAndRenderStatic;

class CheapestViewHelper extends AbstractViewHelper
{
    use CompileWithContentArgumentAndRenderStatic;

    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('prices', 'array', 'Array of prices');
    }

    public static function renderStatic(array $arguments, \Closure $renderChildrenClosure, RenderingContextInterface $renderingContext)
    {
        /** @var Price[] $prices */
        $prices = $renderChildrenClosure();

        // Hotfix: Filter prices by hardcoded B2C customer group
        // TODO: Make this configurable
        $filteredPrices = array_filter($prices, function($price) {
            /** @var Price $price */
            return 'EK' === $price->getCustomerGroupKey();
        });

        usort($filteredPrices, function ($a, $b) {
            /** @var Price $a */
            /** @var Price $b */
            return $a->getPrice() > $b->getPrice();
        });

        return $prices[0];
    }
}
