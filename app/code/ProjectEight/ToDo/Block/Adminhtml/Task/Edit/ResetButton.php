<?php
namespace ProjectEight\ToDo\Block\Adminhtml\Task\Edit;
use Magento\Framework\View\Element\UiComponent\Control\ButtonProviderInterface;
class ResetButton extends GenericButton implements ButtonProviderInterface
{     
    public function getButtonData()
    {
        
        return [
            'label' => __('Reset'),
            'class' => 'reset',
            'on_click' => 'location.reload();',
            'sort_order' => 30
        ];
    }
}
