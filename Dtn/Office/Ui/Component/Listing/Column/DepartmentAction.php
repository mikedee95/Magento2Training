<?php

namespace Dtn\Office\Ui\Component\Listing\Column;

use Magento\Framework\Escaper;
use Magento\Framework\UrlInterface;
use Magento\Framework\View\Element\UiComponent\ContextInterface;
use Magento\Framework\View\Element\UiComponentFactory;
use Magento\Ui\Component\Listing\Columns\Column;

class DepartmentAction extends Column
{
    const URL_PATH_EDIT = 'dtn/department/edit';
    const URL_PATH_DELETE = 'dtn/department/delete';

    protected $urlBuilder;

    /**
     * DepartmentAction constructor.
     * @param ContextInterface $context
     * @param UiComponentFactory $uiComponentFactory
     * @param UrlInterface $urlBuilder
     * @param array $components
     * @param array $data
     */

    public function __construct(ContextInterface $context, UiComponentFactory $uiComponentFactory, UrlInterface $urlBuilder, Escaper $escaper, array $components = [], $data = [])
    {
        $this->urlBuilder = $urlBuilder;
        parent::__construct($context, $uiComponentFactory, $components, $data);
    }

    /**
     * Prepare data source to render
     * @param array $dataSource
     * @return array
     */
    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {
                if (isset($item['entity_id'])) {
                    $item[$this->getData('name')] = [
                        'edit' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_EDIT,
                                ['entity_id' => $item['entity_id']
                                ]),
                            'label' => __('edit')
                        ],
                        'delete' => [
                            'href' => $this->urlBuilder->getUrl(
                                static::URL_PATH_DELETE,
                                [
                                    'entity_id' => $item['entity_id']
                                ]),
                                    'label' => __('delete'),
                                    'confirm' => [
                                        'title' => __('Delete department'),
                                        'message' => __('All records of this department will be deleted, are you sure you want to do this?')
                                    ]
                        ]
                    ];
                }
            }
        }
        return $dataSource;
    }
}
