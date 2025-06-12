<?php
namespace src\models\blogic\helper;

class TreeRenderer
{
    public function renderTree(array $nodes): string
    {
        $html = '';

        foreach ($nodes as $node) {
            $rootNode = 0;
            if ($node->getParentId() === 0) {
                $rootNode = 1;
            }
            $html .= '<div class="section p-2 ms-3 mt-2 border-start" id="node-' . $node->getId() . '">';
            $html .= '<div class="block-content d-flex align-items-center gap-2">';
            $html .= '<span>' . $node->getTitle() . '</span>';
            $html .= '<button class="removeElement btn btn-sm btn-danger btn-icon" data-node-id="' . $node->getId() . '" data-root="'.$rootNode.'">-</button>';
            $html .= '<button class="addElement btn btn-sm btn-success btn-icon" data-node-id="' . $node->getId() . '">+</button>';
            $html .= '</div>';
            // add children nodes
            if (!empty($node->getChildList())) {
                $html .= $this->renderTree($node->getChildList());
            }

            $html .= '</div>';
        }

        return $html;
    }
}