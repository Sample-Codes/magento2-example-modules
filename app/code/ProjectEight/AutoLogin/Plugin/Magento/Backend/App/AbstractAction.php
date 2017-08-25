<?php

namespace ProjectEight\AutoLogin\Plugin\Magento\Backend\App;

class AbstractAction extends \Magento\Backend\App\Action\Plugin\Authentication
{
    /**
     * Magento Framework Data Form FormKey
     *
     * @var \Magento\Framework\Data\Form\FormKey $formKey
     */
    protected $formKey;

    /**
     * AbstractAction constructor.
     *
     * @param \Magento\Backend\Model\Auth                          $auth
     * @param \Magento\Backend\Model\UrlInterface                  $url
     * @param \Magento\Framework\App\ResponseInterface             $response
     * @param \Magento\Framework\App\ActionFlag                    $actionFlag
     * @param \Magento\Framework\Message\ManagerInterface          $messageManager
     * @param \Magento\Backend\Model\UrlInterface                  $backendUrl
     * @param \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory
     * @param \Magento\Backend\App\BackendAppList                  $backendAppList
     * @param \Magento\Framework\Data\Form\FormKey\Validator       $formKeyValidator
     * @param \Magento\Framework\Data\Form\FormKey                 $formKey
     */
    public function __construct(
        \Magento\Backend\Model\Auth $auth, \Magento\Backend\Model\UrlInterface $url,
        \Magento\Framework\App\ResponseInterface $response, \Magento\Framework\App\ActionFlag $actionFlag,
        \Magento\Framework\Message\ManagerInterface $messageManager, \Magento\Backend\Model\UrlInterface $backendUrl,
        \Magento\Framework\Controller\Result\RedirectFactory $resultRedirectFactory,
        \Magento\Backend\App\BackendAppList $backendAppList,
        \Magento\Framework\Data\Form\FormKey\Validator $formKeyValidator,
        \Magento\Framework\Data\Form\FormKey $formKey

    ) {
        $this->formKey = $formKey;

        parent::__construct($auth, $url, $response, $actionFlag, $messageManager, $backendUrl, $resultRedirectFactory,
            $backendAppList, $formKeyValidator);
    }

    /**
     * Check if the user is logged in and if not, perform login
     *
     * @param \Magento\Backend\App\AbstractAction     $subject
     * @param \Magento\Framework\App\RequestInterface $request
     *
     * @return void
     *
     * @SuppressWarnings(PHPMD.UnusedFormalParameter)
     */
    public function beforeDispatch(
        \Magento\Backend\App\AbstractAction $subject,
        \Magento\Framework\App\RequestInterface $request
    ) {
        if ($request->getRouteName() == "adminhtml"
            && $request->getModuleName() == "admin"
            && $request->getControllerModule() == "Magento_Backend"
        ) {

            if ($this->_auth->getUser()) {
                $this->_auth->getUser()->reload();
            }
            if (!$this->_auth->isLoggedIn()) {
                $loginPost['form_key'] = $this->formKey->getFormKey();
                $loginPost['login']    = ['username' => 'admin', 'password' => 'password123'];
                $request->setPostValue($loginPost);
                $this->_processNotLoggedInUser($request);
                $this->_auth->getAuthStorage()->refreshAcl();
            }
        }
    }
}
