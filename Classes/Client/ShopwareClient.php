<?php

namespace DPN\SwConnect\Client;

use TYPO3\CMS\Core\Log\LogManager;
use TYPO3\CMS\Core\Utility\GeneralUtility;

class ShopwareClient
{
    const METHOD_GET = 'GET';
    const METHOD_PUT = 'PUT';
    const METHOD_POST = 'POST';
    const METHOD_DELETE = 'DELETE';

    /**
     * @var array
     */
    protected $validMethods = [
        self::METHOD_GET,
        self::METHOD_PUT,
        self::METHOD_POST,
        self::METHOD_DELETE,
    ];

    /**
     * @var string
     */
    protected $apiUrl;

    /**
     * @var resource
     */
    protected $cURL;

    /**
     * @var \TYPO3\CMS\Core\Log\Logger
     */
    protected $logger;

    /**
     * ShopwareClient constructor.
     * @param string $apiUrl
     * @param string $username
     * @param string $apiKey
     */
    public function __construct($apiUrl, $username, $apiKey)
    {
        $this->apiUrl = rtrim($apiUrl, '/') . '/';
        //Initializes the cURL instance
        $this->cURL = curl_init();
        curl_setopt($this->cURL, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->cURL, CURLOPT_FOLLOWLOCATION, false);
        curl_setopt($this->cURL, CURLOPT_USERAGENT, 'Shopware ApiClient');
        curl_setopt($this->cURL, CURLOPT_HTTPAUTH, CURLAUTH_DIGEST);
        curl_setopt($this->cURL, CURLOPT_USERPWD, $username . ':' . $apiKey);
        curl_setopt(
            $this->cURL,
            CURLOPT_HTTPHEADER,
            ['Content-Type: application/json; charset=utf-8']
        );

        $this->logger = GeneralUtility::makeInstance(LogManager::class)->getLogger(__CLASS__);
    }

    /**
     * @param string $url
     * @param string $method
     * @param array $data
     * @param array $params
     * @return mixed|void
     * @throws \Exception
     */
    public function call($url, $method = self::METHOD_GET, $data = [], $params = [])
    {
        if (!in_array($method, $this->validMethods)) {
            throw new \Exception('Invalid HTTP-Method: ' . $method);
        }
        $queryString = '';
        if (!empty($params)) {
            $queryString = http_build_query($params);
        }
        $url = rtrim($url, '?') . '?';
        $url = $this->apiUrl . $url . $queryString;
        $dataString = json_encode($data);
        curl_setopt($this->cURL, CURLOPT_URL, $url);
        curl_setopt($this->cURL, CURLOPT_CUSTOMREQUEST, $method);
        curl_setopt($this->cURL, CURLOPT_POSTFIELDS, $dataString);
        $result = curl_exec($this->cURL);
        $httpCode = curl_getinfo($this->cURL, CURLINFO_HTTP_CODE);

        $this->logger->debug($result, [
            'url' => $url,
            'method' => $method,
            'statusCode' => $httpCode,
        ]);

        return $this->prepareResponse($result, $httpCode);
    }

    /**
     * @param string $url
     * @param array $params
     * @return mixed|void
     */
    public function get($url, $params = [])
    {
        $this->logger->info('[EXT:sw:_connect] API GET call', [
            'url' => $url,
        ]);

        return $this->call($url, self::METHOD_GET, [], $params);
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $params
     * @return mixed|void
     */
    public function post($url, $data = [], $params = [])
    {
        return $this->call($url, self::METHOD_POST, $data, $params);
    }

    /**
     * @param string $url
     * @param array $data
     * @param array $params
     * @return mixed|void
     */
    public function put($url, $data = [], $params = [])
    {
        return $this->call($url, self::METHOD_PUT, $data, $params);
    }

    /**
     * @param string $url
     * @param array $params
     * @return mixed|void
     */
    public function delete($url, $params = [])
    {
        return $this->call($url, self::METHOD_DELETE, [], $params);
    }

    protected function prepareResponse($result, $httpCode)
    {
        if (null === $decodedResult = json_decode($result, true)) {
            $jsonErrors = [
                JSON_ERROR_NONE => 'No error occurred',
                JSON_ERROR_DEPTH => 'The maximum stack depth has been reached',
                JSON_ERROR_CTRL_CHAR => 'Control character issue, maybe wrong encoded',
                JSON_ERROR_SYNTAX => 'Syntaxerror',
            ];

            return [
                'result' => $result,
            ];
        }

        if (!isset($decodedResult['success'])) {
            return [
                'result' => $result,
            ];
        }

        if (!$decodedResult['success']) {
            return [
                'result' => $result,
            ];
        }

        return $decodedResult;
    }
}
