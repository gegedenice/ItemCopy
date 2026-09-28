<?php declare(strict_types=1);

namespace ItemCopy\Controller;

use ItemCopy\Form\CopyForm;
use Laminas\Mvc\Controller\AbstractActionController;
use Omeka\Api\Manager as ApiManager;
use Omeka\Api\Representation\ItemRepresentation;

class IndexController extends AbstractActionController
{
    /** @var ApiManager */
    protected $api;

    public function __construct(ApiManager $api)
    {
        $this->api = $api;
    }

    public function copyAction()
    {
        if (!$this->getRequest()->isPost()) {
            return $this->redirect()->toRoute('admin/default', [
                'controller' => 'item',
                'action' => 'browse',
            ]);
        }

        $form = new CopyForm();
        $form->setData($this->params()->fromPost());
        if (!$form->isValid()) {
            $this->messenger()->addError('The form has expired. Please try again.');
            return $this->redirect()->toRoute('admin/default', [
                'controller' => 'item',
                'action' => 'browse',
            ]);
        }

        $id = (int) $this->params()->fromRoute('id');

        try {
            /** @var ItemRepresentation $item */
            $item = $this->api->read('items', $id)->getContent();
            $data = $this->copyData($item);
            /** @var ItemRepresentation $copy */
            $copy = $this->api->create('items', $data)->getContent();
        } catch (\Exception $e) {
            $this->messenger()->addError('The item could not be copied.');
            return $this->redirect()->toRoute('admin/default', [
                'controller' => 'item',
                'action' => 'browse',
            ]);
        }

        $this->messenger()->addSuccess('Item successfully copied.');
        return $this->redirect()->toRoute('admin/id', [
            'controller' => 'item',
            'action' => 'edit',
            'id' => $copy->id(),
        ]);
    }

    private function copyData(ItemRepresentation $item): array
    {
        $data = $item->jsonSerialize();

        // These fields belong to the source item or are generated on creation.
        foreach (['@context', '@id', '@type', 'o:id', 'o:owner', 'o:created', 'o:modified', 'o:media'] as $key) {
            unset($data[$key]);
        }

        return $data;
    }
}
