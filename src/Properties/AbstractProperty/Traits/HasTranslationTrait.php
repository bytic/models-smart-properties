<?php

namespace ByTIC\Models\SmartProperties\Properties\AbstractProperty\Traits;

trait HasTranslationTrait
{

    protected $label = null;

    protected $label_short = null;


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
     * @param string $slug
     * @return string
     */
    public function translate($slug = '', $params = [])
    {
        $slug = empty($slug) ? $slug : '.' . $slug;
        return $this->getManager()->translate($this->getLabelSlug() . '.' . $this->getName() . $slug, $params);
    }

    /**
     * @return string
     */
    protected function generateLabel()
    {
        return $this->translate();
    }

    /**
     * @return string
     */
    protected function generateLabelShort()
    {
        return $this->translate('short');
    }
}