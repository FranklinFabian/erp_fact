<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Breadcrumb
{
    private $breadcrumbs = array();
    private $tags = array();

    function __construct()
    {
        $this->tags['open'] = "<ol class='breadcrumb float-sm-right'>";
        $this->tags['close'] = "</ol>";
        $this->tags['itemOpen'] = "<li class='breadcrumb-item'>";
        $this->tags['itemClose'] = "</li>";
    }

    function add($title, $href)
    {
        if (!$title OR !$href) return;
        $this->breadcrumbs[] = array('title' => $title, 'href' => $href);
    }

    function openTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['open'];
        } else {
            $this->tags['open'] = $tags;
        }
    }

    function closeTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['close'];
        } else {
            $this->tags['close'] = $tags;
        }
    }

    function itemOpenTag($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['itemOpen'];
        } else {
            $this->tags['itemOpen'] = $tags;
        }
    }

    function itemCloseTage($tags = "")
    {
        if (empty($tags)) {
            return $this->tags['itemClose'];
        } else {
            $this->tags['itemClose'] = $tags;
        }
    }

    function render()
    {

        if (!empty($this->tags['open'])) {
            $output = $this->tags['open'];
        } else {
            $output = '<ol class="breadcrumb float-sm-right">';
        }

        $count = count($this->breadcrumbs) - 1;
        foreach ($this->breadcrumbs as $index => $breadcrumb) {

            if ($index == $count) {
                $output .= '<li class="breadcrumb-item active">';
                $output .= $breadcrumb['title'];
                $output .= '</li>';
            } else {
                $output .= ($this->tags['itemOpen']) ? $this->tags['itemOpen'] : '<li>';
                $output .= '<a href="' . $breadcrumb['href'] . '">';
                $output .= $breadcrumb['title'];
                $output .= '</a>';
                $output .= '</li>';
            }

        }

        if (!empty($this->tags['open'])) {
            $output .= $this->tags['close'];
        } else {
            $output .= "</ol>";
        }

        return $output;
    }

    function getTitle()
    {
        $output = '';

        foreach ($this->breadcrumbs as $index => $breadcrumb) {

            $output = $breadcrumb['title'];

        }

        $output .= '';

        return $output;
    }
}
