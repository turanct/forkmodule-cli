<?php
/**
 * Backend {{ moduleName }} model
 */
class Backend{{ moduleName|capitalize }}Model
{
    /**
     * Create an item
     *
     * @param array $item The item that we want to create
     * @param mixed $tags The tags for this item
     *
     * @return int The insert id
     */
    public static function create($item, $tags)
    {
        /** @var SpoonDatabase $db */
        $db = BackendModel::get('database');

        // Insert into the database
        $id = $db->insert('{{ moduleName }}', $item);

        // Insert tags
        BackendTagsModel::saveTags($id, $tags, '{{ moduleName }}');

        return $id;
    }


    /**
     * Get one item by id
     *
     * @param int $id The item id
     *
     * @return array The item
     */
    public static function get($id)
    {
        /** @var SpoonDatabase $db */
        $db = BackendModel::get('database');

        $item = $db->getRecord(
            'SELECT i.*
            FROM {{ moduleName }} i
            WHERE i.id = :id',
            array('id' => (int) $id)
        );

        // Get tags
        $item['tags'] = BackendTagsModel::getTags('{{ moduleName }}', $id);

        return $item;
    }


    /**
     * Update an item
     *
     * @param array $item The item that we want to update
     * @param mixed $tags The tags for this item
     *
     * @return int The number of affected rows
     */
    public static function update($item, $tags)
    {
        /** @var SpoonDatabase $db */
        $db = BackendModel::get('database');

        if (!isset($item['id'])) {
            return false;
        }

        // Insert into the database
        $result = $db->update('{{ moduleName }}', $item, 'id = ?', array((int) $item['id']));

        // Insert tags
        BackendTagsModel::saveTags($id, $tags, '{{ moduleName }}');

        return $result;
    }


    /**
     * Delete an item
     *
     * @param int $id The id of the item that we want to delete
     *
     * @return int The number of affected rows
     */
    public static function delete($id)
    {
        /** @var SpoonDatabase $db */
        $db = BackendModel::get('database');

        // Remove tags
        BackendTagsModel::saveTags($id, array(), '{{ moduleName }}');

        // Remove meta
        self::deleteMeta($id);

        return $db->delete('{{ moduleName }}', 'id = :id', array('id' => (int) $id));
    }


    /**
     * Delete an item's meta info
     *
     * @param int $id The id of the item that we want to delete
     *
     * @return void
     */
    public static function deleteMeta($id)
    {
        /** @var SpoonDatabase $db */
        $db = BackendModel::get('database');

        // Get the item details
        $item = self::get($id);

        // Delete remaining files
        $db->delete('meta', 'id = :metaid', array('metaid' => (int) $item['meta_id']));
    }


    /**
     * Create a unique url for an item
     *
     * @param string $url The proposed url of the item
     * @param string $id  The id of the item
     *
     * @return string
     */
    public static function getURL($url, $id)
    {
        /** @var SpoonDatabase $db */
        $db = BackendModel::get('database');

        $q = 'SELECT 1
              FROM {{ moduleName }} i
              INNER JOIN meta AS m ON m.id = i.meta_id
              WHERE m.url = ?';

        $params = array($url);

        if ($id !== null) {
            $q .= ' AND r.id != ?';
            $params[] = $id;
        }

        $q .= ' LIMIT 1';

        $exists = (bool) $db->getVar($q, $params);

        // Already exists
        if ($exists === true) {
            $new = BackendModel::addNumber($url);

            return self::getURL($new);
        }

        // Return
        return $url;
    }
}
