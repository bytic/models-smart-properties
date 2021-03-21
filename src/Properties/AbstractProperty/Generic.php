<?php

namespace ByTIC\Models\SmartProperties\Properties\AbstractProperty;

use ByTIC\Models\SmartProperties\Workflow\State;
use Symfony\Component\Workflow\Definition;
use Symfony\Component\Workflow\Event\AnnounceEvent;
use Symfony\Component\Workflow\Marking;
use Symfony\Component\Workflow\Transition;
use Symfony\Component\Workflow\Workflow;

/**
 * Class Generic
 * @package ByTIC\Models\SmartProperties\Properties\AbstractProperty
 */
abstract class Generic extends State
{
    use Traits\HasItemTrait;
    use Traits\HasManagerTrait;
    use Traits\HasNameTrait;

    protected $label = null;

    protected $label_short = null;


    /**
     * @var null|string
     */
    protected $field;

    /**
     * @param $name
     * @return null
     */
    public function __get($name)
    {
        $method = 'get' . ucfirst($name);
        if (method_exists($this, $method)) {
            return $this->$method();
        }

        return null;
    }

    /**
     * @param bool $short
     * @return string
     */
    public function getLabelHTML($short = false)
    {
        return '<span class="' . $this->getLabelClasses() . '" rel="tooltip" title="' . $this->getLabel() . '"  
        style="' . $this->getColorCSS() . '">
            ' . $this->getIconHTML() . '
            ' . $this->getLabel($short) . '
        </span>';
    }

    /**
     * get the label class name
     *
     * @return string
     */
    public function getLabelClasses(): string
    {
        return 'badge badge-' . $this->getColorClass() . ' label label-' . $this->getColorClass();
    }

    /**
     * Get the color class
     *
     * @return string
     */
    public function getColorClass()
    {
        return 'default';
    }

    /**
     * Get Property label
     *
     * @param bool $short short flag
     *
     * @return null
     */
    public function getLabel($short = false)
    {
        if (!$this->label) {
            $this->label = $this->generateLabel();
            if ($this->hasShortLabel()) {
                $this->label_short = $this->generateLabelShort();
            }
        }

        return $short ? $this->label_short : $this->label;
    }

    /**
     * @return string
     */
    protected function generateLabel()
    {
        return $this->getManager()->translate($this->getLabelSlug() . '.' . $this->getName());
    }

    /**
     * @return string
     */
    abstract protected function getLabelSlug();

    /**
     * @return boolean
     */
    protected function hasShortLabel()
    {
        return true;
    }

    /**
     * @return string
     */
    protected function generateLabelShort()
    {
        return $this->getManager()->translate($this->getLabelSlug() . '.' . $this->getName() . '.short');
    }

    /**
     * @return string
     */
    public function getColorCSS()
    {
        $css = [];
        if ($this->getBGColor()) {
            $css[] = 'background-color: ' . $this->getBGColor();
        }
        if ($this->getFGColor()) {
            $css[] = 'color: ' . $this->getFGColor();
        }

        return implode(';', $css);
    }

    /**
     * @return bool|string
     */
    public function getBGColor()
    {
        return false;
    }

    /**
     * @return bool|string
     */
    public function getFGColor()
    {
        return false;
    }

    /**
     * @return string
     */
    public function getIconHTML(): string
    {
        $icon = $this->getIcon();
        if (strpos($icon, 'glyphicon') !== false) {
            return '<span class="glyphicon glyphicon-white ' . $icon . '"></span> ';
        }
        if (strpos($icon, 'fas') === 0 || strpos($icon, 'far') === 0) {
            return '<i class="' . $icon . '"></i>';
        }
        if (strpos($icon, 'fa') === 0) {
            return '<i class="fas ' . $icon . '"></i>';
        }

        return '';
    }

    /**
     * @return bool|string
     */
    public function getIcon()
    {
        return false;
    }

    /**
     * @return bool|mixed
     */
    public function update()
    {
        $item = $this->getItem();
        if (!is_object($item)) {
            return false;
        }
        $this->preValueChange();
        /** @noinspection PhpUndefinedFieldInspection */
        $item->{$this->getField()} = $this->getName();
        $this->preUpdate();
        $return = $item->saveRecord();
        $this->postUpdate();

        $marking = new Marking();
        $initialTransition = new Transition('generic_transition', [], []);
        $workflow = new Workflow(new Definition([], []));
        $event = new AnnounceEvent($item, $marking, $initialTransition, $workflow, []);

        event($event);
        return $return;
    }

    public function preValueChange()
    {
    }

    /**
     * @return null|string
     */
    public function getField()
    {
        return $this->field;
    }

    /**
     * @param null|string $field
     */
    public function setField($field)
    {
        $this->field = $field;
    }

    public function preUpdate()
    {
    }

    public function postUpdate()
    {
    }

    /**
     * @return string
     */
    public function getMessageType()
    {
        return 'info';
    }

}
