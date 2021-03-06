<?php

namespace Victoire\Widget\SitemapBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Victoire\Bundle\CoreBundle\Entity\View;
use Victoire\Bundle\WidgetBundle\Entity\Widget;

/**
 * WidgetSitemap.
 *
 * @ORM\Table("vic_widget_sitemap")
 * @ORM\Entity
 */
class WidgetSitemap extends Widget
{
    /**
     * @ORM\ManyToOne(targetEntity="\Victoire\Bundle\PageBundle\Entity\BasePage", inversedBy="children", cascade={"persist"})
     * @ORM\JoinColumn(name="root_page", referencedColumnName="id", onDelete="CASCADE")
     */
    protected $rootPage;

    /**
     * @ORM\OneToMany(targetEntity="\Victoire\Bundle\PageBundle\Entity\BasePage", mappedBy="rootPage")
     * @ORM\OrderBy({"lft" = "ASC"})
     */
    protected $children;

    /**
     * To String function
     * Used in render choices type (Especially in VictoireWidgetRenderBundle)
     * //TODO Check the generated value and make it more consistent.
     *
     * @return string
     */
    public function __toString()
    {
        return 'Sitemap #'.$this->id;
    }

    /**
     * Set rootPage.
     *
     * @param string $rootPage
     */
    public function setRootpage($rootPage)
    {
        $this->rootPage = $rootPage;

        return $this;
    }

    /**
     * Get rootPage.
     *
     * @return string
     */
    public function getRootpage()
    {
        return $this->rootPage;
    }

    /**
     * Set children.
     *
     * @param string $children
     *
     * @return Page
     */
    public function setChildren($children)
    {
        $this->children = $children;
        foreach ($children as $child) {
            $child->setParent($this);
        }

        return $this;
    }

    /**
     * Get children.
     *
     * @return string
     */
    public function getChildren()
    {
        return $this->children;
    }

    /**
     * Add child.
     *
     * @param child $child
     */
    public function addChild(View $child)
    {
        $this->children[] = $child;
    }

    /**
     * Remove child.
     *
     * @param child $child
     */
    public function removeChild(View $child)
    {
        $this->children->remove($child);
    }
}
