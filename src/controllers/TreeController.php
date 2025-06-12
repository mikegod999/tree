<?php

namespace src\controllers;

use Exception;
use src\models\blogic\helper\TreeRenderer;
use src\models\blogic\TreeManager;

class TreeController
{
    private TreeManager $manager;

    public function __construct(TreeManager $manager)
    {
        $this->manager = $manager;
    }

    public function index()
    {
        $data = $this->manager->getTree();
        require __DIR__ . '/../view/tree_view.php';
    }

    public function create(array $data): array
    {
        try {
            $parentId = isset($data['id']) ? (int)$data['id'] : null;
            $node = $this->manager->createNode($parentId);
            $treeRenderer = new TreeRenderer();

            $htmlTree = $treeRenderer->renderTree([$node]);
            return ['status' => 'success', 'data' => $htmlTree];
        } catch (Exception $e){
            return ['status' => 'error'];
        }

    }

    public function delete(array $data): array
    {
        try {
            $id = isset($data['id']) ? (int)$data['id'] : null;
            if (!$id) {
                throw new \InvalidArgumentException("ID is required for deletion.");
            }

            $this->manager->deleteNode($id);

            return ['status' => 'success'];
        } catch (Exception $e){
            return ['status' => 'error'];
        }
    }
}
