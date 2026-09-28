<?php declare(strict_types=1);
namespace ItemCopy;

use ItemCopy\Form\CopyForm;
use Laminas\EventManager\Event;
use Laminas\EventManager\SharedEventManagerInterface;
use Omeka\Module\AbstractModule;

/**
 * The ItemCopy plugin.
 */
class Module extends AbstractModule
{
    public function attachListeners(SharedEventManagerInterface $sharedEventManager): void
    {
        $sharedEventManager->attach(
            'Omeka\Controller\Admin\Item',
            'view.browse.after',
            [$this, 'addItemCopyJs']
        );
    }

    public function addItemCopyJs(Event $event): void
    {
        $view = $event->getTarget();
        $form = new CopyForm();
        $form->prepare();

        $config = [
            'action' => $view->url('item-copy/default', ['id' => '__ITEM_ID__']),
            'csrf' => $form->get('csrf')->getValue(),
            'copyLabel' => $view->translate('Copy item'),
            'confirmMessage' => $view->translate('Copy this item?'),
        ];

        $view->headScript()
            ->appendScript('window.ItemCopy = ' . json_encode($config, JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) . ';')
            ->appendFile(
                $view->assetUrl('item-copy.js', 'ItemCopy'),
                'text/javascript',
                ['defer' => 'defer']
            );
    }
}
