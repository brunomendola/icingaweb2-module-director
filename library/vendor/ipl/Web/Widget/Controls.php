<?php

namespace dipl\Web\Widget;

use dipl\Html\BaseHtmlElement;
use dipl\Html\Html;
use dipl\Html\HtmlDocument;

class Controls extends BaseHtmlElement
{
    protected $tag = 'div';

    protected $contentSeparator = "\n";

    protected $defaultAttributes = ['class' => 'controls'];

    /** @var Tabs */
    private $tabs;

    /** @var ActionBar */
    private $actions;

    /** @var string */
    private $title;

    /** @var string */
    private $subTitle;

    /** @var BaseHtmlElement */
    private $titleElement;

    /**
     * @param $title
     * @param null $subTitle
     * @return $this
     * @throws \Icinga\Exception\IcingaException
     */
    public function addTitle($title, $subTitle = null)
    {
        $this->title = $title;
        if ($subTitle !== null) {
            $this->subTitle = $subTitle;
        }

        return $this->setTitleElement($this->renderTitleElement());
    }

    /**
     * @param BaseHtmlElement $element
     * @return $this
     * @throws \Icinga\Exception\IcingaException
     */
    public function setTitleElement(BaseHtmlElement $element)
    {
        if ($this->titleElement !== null) {
            $this->remove($this->titleElement);
        }

        $this->titleElement = $element;
        $this->prepend($element);

        return $this;
    }

    public function getTitleElement()
    {
        return $this->titleElement;
    }

    /**
     * @return Tabs
     */
    public function getTabs()
    {
        if ($this->tabs === null) {
            $this->tabs = new Tabs();
        }

        return $this->tabs;
    }

    /**
     * @param Tabs $tabs
     * @return $this
     */
    public function setTabs(Tabs $tabs)
    {
        $this->tabs = $tabs;
        return $this;
    }

    /**
     * @param Tabs $tabs
     * @return $this
     * @throws \Icinga\Exception\ProgrammingError
     */
    public function prependTabs(Tabs $tabs)
    {
        if ($this->tabs === null) {
            $this->tabs = $tabs;
        } else {
            $current = $this->tabs->getTabs();
            $this->tabs = $tabs;
            foreach ($current as $name => $tab) {
                $this->tabs->add($name, $tab);
            }
        }

        return $this;
    }

    /**
     * @return ActionBar
     * @throws \Icinga\Exception\IcingaException
     */
    public function getActionBar()
    {
        if ($this->actions === null) {
            $this->setActionBar(new ActionBar());
        }

        return $this->actions;
    }

    /**
     * @param HtmlDocument $actionBar
     * @return $this
     * @throws \Icinga\Exception\IcingaException
     */
    public function setActionBar(HtmlDocument $actionBar)
    {
        if ($this->actions !== null) {
            $this->remove($this->actions);
        }

        $this->actions = $actionBar;
        $this->add($actionBar);

        return $this;
    }

    /**
     * @return BaseHtmlElement
     * @throws \Icinga\Exception\IcingaException
     */
    protected function renderTitleElement()
    {
        $h1 = Html::tag('h1', null, $this->title);
        if ($this->subTitle) {
            $h1->setSeparator(' ')->add(
                Html::tag('small', null, $this->subTitle)
            );
        }

        return $h1;
    }

    /**
     * @return string
     * @throws \Icinga\Exception\IcingaException
     */
    public function renderContent()
    {
        if (null !== $this->tabs) {
            $this->prepend($this->tabs);
        }

        return parent::renderContent();
    }
}
