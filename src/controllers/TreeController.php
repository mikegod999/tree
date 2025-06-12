<?php

namespace src\controllers;

use Exception;
use InvalidArgumentException;
use RuntimeException;
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
            $parentId = (int)filter_var($data['id'], FILTER_VALIDATE_INT);
            $node = $this->manager->createNode($parentId);
            $treeRenderer = new TreeRenderer();

            $htmlTree = $treeRenderer->renderTree([$node]);

            return ['status' => 'success', 'data' => $htmlTree];
        } catch (Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function delete(array $data): array
    {
        try {
            $id = (int)filter_var($data['id'], FILTER_VALIDATE_INT);
            if (!$id) {
                throw new InvalidArgumentException("ID is required for deletion.");
            }

            $this->manager->deleteNode($id);

            return ['status' => 'success'];
        } catch (Exception|InvalidArgumentException $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }

    public function edit(array $data): array
    {
        try {
            $id = (int)filter_var($data['id'], FILTER_VALIDATE_INT);
            if (!$id) {
                throw new \InvalidArgumentException('ID is required');
            }

            $title = strip_tags(filter_var(trim($data['nodeTitle'] ?? ''), FILTER_SANITIZE_FULL_SPECIAL_CHARS));
            if (!$title) {
                throw new \InvalidArgumentException('Title is required');
            }

            $node = $this->manager->findById($id);
            if (!$node) {
                throw new \RuntimeException('Node not found');
            }

            $updatedNode = $node->withTitle($title);
            $this->manager->editNode($updatedNode);

            return ['status' => 'success', 'title' => $title];
        } catch (InvalidArgumentException|RuntimeException|Exception $e) {
            return ['status' => 'error', 'message' => $e->getMessage()];
        }
    }
}
