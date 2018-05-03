<?php

namespace DPN\SwConnect\Command;

use DPN\SwConnect\Domain\Model\Article;
use DPN\SwConnect\Service\ProductService;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Object\ObjectManager;
use TYPO3\CMS\Extbase\Object\ObjectManagerInterface;

class ArticleImportCommand extends Command
{
    /**
     * @var ProductService
     */
    protected $productService;

    protected function configure()
    {
        $this->addArgument('shop', InputArgument::REQUIRED, 'The shop id (foreign)');
        $this->addArgument('limit', InputArgument::OPTIONAL, 'How many articles should be fetched with one cycle', 10);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $io->text(sprintf('Importing articles from remote shop with ID %s', $input->getArgument('shop')));

        /** @var ObjectManagerInterface $objectManager */
        $objectManager = GeneralUtility::makeInstance(ObjectManager::class);

        /** @var ProductService $productService */
        $this->productService = $objectManager->get(ProductService::class);

        $limit = (int)$input->getArgument('limit');
        $offset = 0;

        $totalAmountArticles = $this->productService->count();

        $io->progressStart($totalAmountArticles);
        while ($offset < ($totalAmountArticles + $limit)) {
            $articles = $this->productService->findAll([
                'limit' => $limit,
                'start' => $offset
            ]);

            $this->importArticleHeaders($io, $articles);

            $offset = $limit + $offset;
        }

        $io->progressFinish();
    }

    /**
     * @param SymfonyStyle $io
     * @param Article[] $articles
     */
    public function importArticleHeaders(SymfonyStyle $io, array $articles = [])
    {
        $db = GeneralUtility::makeInstance(ConnectionPool::class)->getConnectionForTable('tx_dpnswconnect_article');

        foreach ($articles as $article) {
            $existingRows = $db->select(['uid', 'shopware_id'], 'tx_dpnswconnect_article', ['shopware_id' => $article->getId()])->fetchAll();

            /** @var Article $enrichedArticle */
            $enrichedArticle = $this->productService->findOne($article->getId());

            if (count($existingRows) > 0) {
                $current = current($existingRows);

                $db->update('tx_dpnswconnect_article', [
                    'shopware_id' => $article->getId(),
                    'name' => $article->getName(),
                    'article_number' => $enrichedArticle->getMainDetail() !== null ? $enrichedArticle->getMainDetail()->getNumber() : '',
                ], ['uid' => $current['uid']]);
            } else {
                $articleNumber = '';
                if ($enrichedArticle !== null && $enrichedArticle->getMainDetail() !== null) {
                    $articleNumber = $enrichedArticle->getMainDetail()->getNumber();
                }
                $db->insert('tx_dpnswconnect_article', [
                    'shopware_id' => $article->getId(),
                    'name' => $article->getName(),
                    'article_number' => $articleNumber,
                ]);
            }

            $io->progressAdvance(1);
        }
    }
}
