<?php
namespace ProjectEight\QueryingTheRestApiExample\Command;

use GuzzleHttp\Client;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class GetAdminToken extends Command
{
    /**
     * Guzzle HTTP Client
     *
     * @var \GuzzleHttp\Client
     */
    protected $guzzleHttpClient;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this->setName("projecteight:examples:querying-the-rest-api:get-admin-token");
        $this->setDescription("Demonstrates how to query the REST API in Magento 2 to get an admin token, to be used in future requests.");

        $this->initClient();

        parent::configure();
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        /*
         * First we need to get our admin token.
         * See http://devdocs.magento.com/guides/v2.1/get-started/order-tutorial/order-admin-token.html
         */
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

        $adminToken = (string)$response->getBody();

        $output->writeln($adminToken);
    }

    /**
     * Initialise client
     *
     * @return Client
     */
    public function initClient()
    {
        $this->guzzleHttpClient = new \GuzzleHttp\Client([
            // Base URI is used with relative requests
            'base_uri' => 'http://magento2-sample-modules.localhost.com/index.php/rest/default/V1/',
            // You can set any number of default request options.
            'timeout'  => 2.0,
        ]);

        return $this->guzzleHttpClient;
    }
}
