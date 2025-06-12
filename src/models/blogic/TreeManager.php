<?php

namespace src\models\blogic;

use src\models\blogic\helper\TreeRenderer;
use src\models\dto\TreeNodeDTO;
use src\models\repository\TreeNodeRepository;

class TreeManager
{
    private TreeNodeRepository $repository;

    public function __construct(TreeNodeRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createNode(int $parentId = 0): TreeNodeDTO
    {
        $node = $this->repository->create('node', $parentId);

        return new TreeNodeDTO($node->getId(), $node->getParentId(), $node->getTitle());
    }

    public function deleteNode(int $id): void
    {
        $this->repository->deleteRecursive($id);
    }

    public function getTree(): string
    {
        $nodes = $this->repository->getListIterable();

        // parents list array
        $map = [];
        foreach ($nodes as $node) {
            $map[$node->getParentId()][] = $node;
        }

        //build tree
        $tree = $this->buildTree($map, 0);

        // render tree
        return (new TreeRenderer())->renderTree($tree);
    }

    private function buildTree(array &$map, int $parentId): array
    {
        $branch = [];

        if (!isset($map[$parentId])) {
            return $branch;
        }

        foreach ($map[$parentId] as $node) {
            $nodeData = new TreeNodeDTO($node->getId(), $node->getParentId(), $node->getTitle());
            $childrenList = $this->buildTree($map, $node->getId());
            if($childrenList){
                foreach ($childrenList as $child) {
                    $nodeData->addChild($child);
                }
            }

            $branch[] = $nodeData;
        }

        return $branch;
    }
}