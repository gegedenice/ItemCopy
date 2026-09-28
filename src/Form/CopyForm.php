<?php declare(strict_types=1);

namespace ItemCopy\Form;

use Laminas\Form\Element\Csrf;
use Laminas\Form\Form;

class CopyForm extends Form
{
    public function __construct()
    {
        parent::__construct('item-copy');

        $this->add([
            'name' => 'csrf',
            'type' => Csrf::class,
        ]);
    }
}
