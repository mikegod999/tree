<?php

namespace src\models\repository;

use PDO;
use src\models\entities\TreeNode;

class TreeNodeRepository
{
    private PDO $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getListIterable(): iterable
    {
        $stmt = $this->db->query("SELECT id, title, parent_id FROM tree_node ORDER BY id");

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            yield new TreeNode(
                (int)$row['id'],
                (int)$row['parent_id'],
                $row['title'] ?? ''
            );
        }
    }

    public function create(string $title = '', ?int $parentId = 0): TreeNode
    {
        $stmt = $this->db->prepare("INSERT INTO tree_node (title, parent_id) VALUES (:title, :parent_id)");
        $stmt->execute([
            'title' => $title,
            'parent_id' => $parentId,
        ]);

        $id = (int)$this->db->lastInsertId();

        return new TreeNode($id, $parentId, $title);
    }

    public function deleteRecursive(int $id): void
    {
        $childIdList = $this->getNodeListByParent($id);
        $allIdList = array_merge($childIdList, [$id]);

        if(!$allIdList){
            return;
        }

        $placeholders = implode(',', array_fill(0, count($allIdList), '?'));
        $stmt = $this->db->prepare("DELETE FROM tree_node WHERE id IN ($placeholders)");
        $stmt->execute($allIdList);
    }

    private function getNodeListByParent(int $parentId): array
    {
        $stmt = $this->db->prepare(
            "WITH RECURSIVE tree AS (
                SELECT id, parent_id FROM tree_node WHERE parent_id = :parent_id
                UNION ALL
                SELECT tn.id, tn.parent_id FROM tree_node tn
                JOIN tree t ON tn.parent_id = t.id
            ) SELECT id FROM tree"
        );

        $stmt->execute(['parent_id' => $parentId]);

        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}
