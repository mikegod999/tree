<?php
namespace src\models\blogic\helper;

class TreeRenderer
{
    public function renderTree(array $nodes): string
    {
        $html = '';

        foreach ($nodes as $node) {
            $parentNode = $node->getParentId() ?? 0;

            $hideToggleBtn = empty($node->getChildList()) ? 'hidden' : '';

            $html .= '<div class="section p-2 ms-3 mt-2 border-start" id="node-' . $node->getId() . '">';
            $html .= '<div class="block-content d-flex align-items-center gap-2">';
            $html .= '<button class="toggleChildren btn btn-sm btn-light btn-icon" id="toggle-btn-' . $node->getId() . '" data-node-id="' . $node->getId() . '" ' . $hideToggleBtn . '>
                        <i class="bi-caret-down-fill"></i> 
                      </button>';

            $html .= '<span id="node-title-' . $node->getId() . '" class="node-title" data-node-id="' . $node->getId() . '">' . $node->getTitle() . '</span>';
            $html .= '<button class="removeElement btn btn-sm btn-danger btn-icon" data-node-id="' . $node->getId() . '" data-parent-id="' . $parentNode . '">-</button>';
            $html .= '<button class="addElement btn btn-sm btn-success btn-icon" data-node-id="' . $node->getId() . '" data-parent-id="' . $parentNode . '">+</button>';
            $html .= '</div>';

            // add children nodes
            $html .= '<div class="child-nodes ms-3 mt-2" id="children-block-' . $node->getId() . '">';
            if (!empty($node->getChildList())) {
                $html .= $this->renderTree($node->getChildList());
            }
            $html .= '</div>';
            $html .= '</div>';
        }

        return $html;
    }
}