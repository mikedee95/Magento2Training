<?php
namespace Dtn\Giftwrap\Block\Adminhtml\Giftwrap\Edit\Tab;

/**
 * Cms page edit form main tab
 */
class Giftwrap extends \Magento\Backend\Block\Widget\Form\Generic implements \Magento\Backend\Block\Widget\Tab\TabInterface
{
    /**
     * @var \Magento\Store\Model\System\Store
     */
    protected $_systemStore;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Data\FormFactory $formFactory
     * @param \Magento\Store\Model\System\Store $systemStore
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Data\FormFactory $formFactory,
        \Magento\Store\Model\System\Store $systemStore,
        array $data = []
    ) {
        $this->_systemStore = $systemStore;
        parent::__construct($context, $registry, $formFactory, $data);
    }

    /**
     * Prepare form
     *
     * @return $this
     */
    protected function _prepareForm()
    {
        /* @var $model \Magento\Cms\Model\Page */
        $model = $this->_coreRegistry->registry('giftwrap');

        /*
         * Checking if user have permissions to save information
         */
        if ($this->_isAllowedAction('Excellence_Giftwrap::save')) {
            $isElementDisabled = false;
        } else {
            $isElementDisabled = true;
        }

        /** @var \Magento\Framework\Data\Form $form */
        $form = $this->_formFactory->create();

        $form->setHtmlIdPrefix('giftwrap_main_');

        $fieldset = $form->addFieldset('base_fieldset', ['legend' => __('Gift Wrap Information')]);

        if ($model->getId()) {
            $fieldset->addField('giftwrap_id', 'hidden', ['name' => 'giftwrap_id']);
        }

        $fieldset->addField(
            'title',
            'text',
            [
                'name' => 'title',
                'label' => __('Gift Wrap Title'),
                'title' => __('Gift Wrap Title'),
                'required' => true,
                'disabled' => $isElementDisabled
            ]
        );

        $fieldset->addField(
            'store',
            'multiselect',
            [
                'label' => __('Store Scope'),
                'title' => __('Store Scope'),
                'name' => 'store',
                'class' => 'required-entry',
                'required' => true,
                'values' => $this->_systemStore->getStoreValuesForForm(false, false)
            ]
        );

        $fieldset->addField(
            'image',
            'image',
            [
                'name' => 'image',
                'label' => __('Image'),
                'title' => __('Image'),
                'required'  => true,
                'disabled' => $isElementDisabled
            ]
        );

        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $currencysymbol = $objectManager->get('Magento\Directory\Model\Currency');
        $currencySymbol = "<label class='admin__addon-prefix currency-symbol'>
                                <span>".$currencysymbol->getCurrencySymbol()."</span>
                            </label>
                            <script>
                            require([
                                'jquery'
                              ], function (jQuery) {
                               jQuery(document).on('focus', '#giftwrap_main_price', function(){
                                jQuery('.field-price .currency-symbol').addClass('currency-symbol-focus');
                               });
                               jQuery(document).on('blur', '#giftwrap_main_price', function(){
                                jQuery('.field-price .currency-symbol').removeClass('currency-symbol-focus');
                               });
                            });
                            </script>
                            ";

        $comment = "<font size=2 color='#666666'>&uarr;&nbsp;".__("Price for Gift Wrap which will be applied when per gift wrap is selected in config")."</font></p>";

        $fieldset->addField(
            'price',
            'text',
            [
                'name' => 'price',
                'label' => __('Additional Price'),
                'title' => __('Additional Price'),
                'required' => true,
                'disabled' => $isElementDisabled,
                'before_element_html' => $currencySymbol,
                'after_element_html' => $comment
            ]
        );

        $fieldset->addField(
            'is_active',
            'select',
            [
                'name' => 'is_active',
                'label' => __('Status'),
                'title' => __('Status'),
                'class' => 'required-entry',
                'required' => true,
                'disabled' => $isElementDisabled,
                'values' => [
                                0 => __('Disabled'),
                                1 => __('Enabled')
                            ]
            ]
        );

        $this->_eventManager->dispatch('adminhtml_giftwrap_edit_tab_main_prepare_form', ['form' => $form]);

        $form->setValues($model->getData());
        $this->setForm($form);

        return parent::_prepareForm();
    }

    /**
     * Prepare label for tab
     *
     * @return string
     */
    public function getTabLabel()
    {
        return __('Gift Wrap Information');
    }

    /**
     * Prepare title for tab
     *
     * @return string
     */
    public function getTabTitle()
    {
        return __('Gift Wrap Information');
    }

    /**
     * {@inheritdoc}
     */
    public function canShowTab()
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function isHidden()
    {
        return false;
    }

    /**
     * Check permission for passed action
     *
     * @param string $resourceId
     * @return bool
     */
    protected function _isAllowedAction($resourceId)
    {
        return $this->_authorization->isAllowed($resourceId);
    }
}
