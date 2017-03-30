<?php

namespace ProjectEight\FtpExample\Model;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Framework\Filesystem\Io\Ftp as FtpClient;
use ProjectEight\FtpExample\Model\Exception\FtpConnectionFailed;
use ProjectEight\FtpExample\Model\Exception\FtpDownloadFailed;
use ProjectEight\FtpExample\Model\Exception\FtpUploadFailed;

class Ftp
{
    /**
     * FTP Client
     *
     * @var FtpClient
     */
    private $ftpClient;

    /**
     * Store configuration
     *
     * @var ScopeConfigInterface
     */
    private $scopeConfig;

    /**
     * Ftp constructor
     *
     * @param FtpClient            $ftpClient
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        FtpClient $ftpClient,
        ScopeConfigInterface $scopeConfig
    ) {
        $this->ftpClient   = $ftpClient;
        $this->scopeConfig = $scopeConfig;
    }

    /**
     * Get FTP credentials
     *
     * @return string[]
     */
    protected function _getCredentials()
    {
        return [
            'host'     => $this->_getStoreConfigValue('ftp_credentials/hostname'),
            'username' => $this->_getStoreConfigValue('ftp_credentials/username'),
            'password' => $this->_getStoreConfigValue('ftp_credentials/password'),
        ];
    }

    /**
     * Get store config value
     *
     * @param string $configPath
     *
     * @return string
     */
    protected function _getStoreConfigValue($configPath)
    {
        return $this->scopeConfig->getValue($configPath);
    }

    /**
     * Open FTP connection
     *
     * @return null|true
     */
    protected function _openConnection()
    {
        try {
            $this->ftpClient->open($this->_getCredentials());
        } catch (FtpConnectionFailed $exception) {
            // Log error

            return false;
        }

        return true;
    }

    /**
     * Close FTP connection
     *
     * @return null|true
     */
    protected function _closeConnection()
    {
        try {
            $this->ftpClient->close();
        } catch (FtpConnectionFailed $exception) {
            // Log error

            return false;
        }

        return true;
    }

    /**
     * Download file from FTP
     *
     * @return bool|string
     */
    public function downloadFile()
    {
        try {
            $this->_openConnection();

            $file = $this->ftpClient->read('file_to_download.txt');
        } catch (FtpDownloadFailed $exception) {
            // Log error

            return false;
        }

        $this->_closeConnection();

        return $file;
    }

    /**
     * Upload file to FTP
     *
     * @return bool
     */
    public function uploadFile()
    {
        try {
            $this->_openConnection();

            $result = $this->ftpClient->write('uploaded_filename.csv', 'file_to_upload.csv');
        } catch (FtpUploadFailed $exception) {
            // Log error

            return false;
        }

        $this->_closeConnection();

        return $result;
    }
}
