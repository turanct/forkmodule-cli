<?php

namespace Backend\Modules\Jelmer\Engine;

use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Engine\Language as BL;
use Backend\Modules\Tags\Engine\Model as BackendTagsModel;
use Backend\Modules\Search\Engine\Model as BackendSearchModel;

/**
 * Backend Jelmer model
 */
class Model
{
    /**
     * Create an item
     *
     * @param array $item The item that we want to create
     * @param mixed $tags The tags for this item
     *
     * @return int The insert id
     */
    public static function create(array $item, $tags)
    {
        /** @var \SpoonDatabase $db */
        $db = BackendModel::get('database');

        // Insert into the database
        $id = $db->insert('jelmer', $item);

        // Insert tags
        BackendTagsModel::saveTags($id, $tags, 'jelmer');

        // Make searchable
        BackendSearchModel::saveIndex(
            'jelmer',
            $id,
            array(
                'title' => $item['title'],
                'text' => $item['description'],
            )
        );

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
        /** @var \SpoonDatabase $db */
        $db = BackendModel::get('database');

        $item = (array) $db->getRecord(
            'SELECT i.*, m.url
             FROM jelmer i
             INNER JOIN meta AS m on m.id = i.meta_id
             WHERE i.id = :id',
            array('id' => (int) $id)
        );

        // Get tags
        $item['tags'] = BackendTagsModel::getTags('jelmer', $id);

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
    public static function update(array $item, $tags)
    {
        /** @var \SpoonDatabase $db */
        $db = BackendModel::get('database');

        if (!isset($item['id'])) {
            return false;
        }

        // Insert into the database
        $result = $db->update('jelmer', $item, 'id = ?', array((int) $item['id']));

        // Insert tags
        BackendTagsModel::saveTags($item['id'], $tags, 'jelmer');

        // Make searchable
        BackendSearchModel::saveIndex(
            'jelmer',
            $item['id'],
            array(
                'title' => $item['title'],
                'text' => $item['description'],
            )
        );

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
        /** @var \SpoonDatabase $db */
        $db = BackendModel::get('database');

        // Remove tags
        BackendTagsModel::saveTags($id, array(), 'jelmer');

        // Delete search index
        BackendSearchModel::removeIndex('jelmer', $id);

        // Remove meta
        self::deleteMeta($id);

        return $db->delete('jelmer', 'id = :id', array('id' => (int) $id));
    }

    /**
     * Delete an item's meta info
     *
     * @param int $id The id of the item that we want to delete
     */
    public static function deleteMeta($id)
    {
        /** @var \SpoonDatabase $db */
        $db = BackendModel::get('database');

        // Get the item details
        $item = self::get($id);

        // Delete remaining meta records
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
    public static function getURL($url, $id = null)
    {
        /** @var \SpoonDatabase $db */
        $db = BackendModel::get('database');

        $q = 'SELECT 1
              FROM jelmer i
              INNER JOIN meta AS m ON m.id = i.meta_id
              WHERE m.url = ?';

        $params = array($url);

        if ($id !== null) {
            $q .= ' AND i.id != ?';
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

    /**
     * Get all items
     *
     * @return array
     */
    public static function getAll()
    {
        return (array) BackendModel::get('database')->getRecords(
            'SELECT *
             FROM jelmer
             ORDER BY title'
        );
    }
}
