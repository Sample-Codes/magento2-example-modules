<?php
namespace ProjectEight\QueryingTheRestApiExample\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;

abstract class AbstractRestApiExample extends Command
{
    /**
     * Guzzle HTTP Client
     *
     * @var \GuzzleHttp\Client
     */
    protected $guzzleHttpClient;

    /**
     * An admin token
     *
     * @var string
     */
    protected $adminToken;

    /**
     * A customer token
     *
     * @var string
     */
    protected $customerToken;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->initHttpClient();

        parent::configure();
    }

    /**
     * Initialise client
     *
     * @return Client
     */
    public function initHttpClient()
    {
        $this->guzzleHttpClient = new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://www.magento2-example-modules.dev/index.php/rest/default/V1/',
            // You can set any number of default request options.
//            'timeout'  => 2.0,
        ]);

        return $this->guzzleHttpClient;
    }

    /**
     * Generate a new admin token. The token is valid for four hours.
     *
     * @link http://devdocs.magento.com/guides/v2.1/get-started/order-tutorial/order-admin-token.html
     *
     * @return void
     */
    protected function getAdminToken()
    {
        $data['json']       = [
            'username' => 'admin',
            'password' => 'password123',
        ];
        $headers['headers'] = [
            "Content-Type" => "application/json",
        ];
        $options['json']    = $data['json'];
        $options['headers'] = $headers['headers'];
        $response           = $this->guzzleHttpClient->request('POST', 'integration/admin/token', $options);

        $this->adminToken = (string)$response->getBody();
    }

}
