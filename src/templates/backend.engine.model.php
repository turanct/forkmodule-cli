<?php
/**
 * Backend {{ moduleName }} model
 */
class Backend{{ moduleNameSafe }}Model
{
    /**
     * Create an item
     *
     * @param array $item The item that we want to create
{% if tags %}
     * @param mixed $tags The tags for this item
{% endif %}
     *
     * @return int The insert id
     */
{% if tags %}
    public static function create($item, $tags)
{% else %}
    public static function create($item)
{% endif %}
    {
        /** @var SpoonDatabase $db */
        $db = BackendModel::get('database');

        // Insert into the database
        $id = $db->insert('{{ moduleName }}', $item);
{% if tags %}

        // Insert tags
        BackendTagsModel::saveTags($id, $tags, '{{ moduleName }}');
{% endif %}
{% if searchable %}

        // Make searchable
        BackendSearchModel::saveIndex(
            '{{ moduleName }}',
            $id,
            array(
                'title' => $item['title'],
                'text' => $item['description'],
            )
        );
{% endif %}

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

        $item = (array) $db->getRecord(
            'SELECT i.*
             FROM {{ moduleName }} i
             WHERE i.id = :id',
            array('id' => (int) $id)
        );
{% if tags %}

        // Get tags
        $item['tags'] = BackendTagsModel::getTags('{{ moduleName }}', $id);
{% endif %}

        return $item;
    }

    /**
     * Update an item
     *
     * @param array $item The item that we want to update
{% if tags %}
     * @param mixed $tags The tags for this item
{% endif %}
     *
     * @return int The number of affected rows
     */
{% if tags %}
    public static function update($item, $tags)
{% else %}
    public static function update($item)
{% endif %}
    {
        /** @var SpoonDatabase $db */
        $db = BackendModel::get('database');

        if (!isset($item['id'])) {
            return false;
        }

        // Insert into the database
        $result = $db->update('{{ moduleName }}', $item, 'id = ?', array((int) $item['id']));
{% if tags %}

        // Insert tags
        BackendTagsModel::saveTags($item['id'], $tags, '{{ moduleName }}');
{% endif %}
{% if searchable %}

        // Make searchable
        BackendSearchModel::saveIndex(
            '{{ moduleName }}',
            $item['id'],
            array(
                'title' => $item['title'],
                'text' => $item['description'],
            )
        );
{% endif %}

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
{% if tags %}

        // Remove tags
        BackendTagsModel::saveTags($id, array(), '{{ moduleName }}');
{% endif %}
{% if searchable %}

        // Delete search index
        BackendSearchModel::removeIndex('{{ moduleName }}', $id);
{% endif %}
{% if meta %}

        // Remove meta
        self::deleteMeta($id);
{% endif %}

        return $db->delete('{{ moduleName }}', 'id = :id', array('id' => (int) $id));
    }
{% if meta %}

    /**
     * Delete an item's meta info
     *
     * @param int $id The id of the item that we want to delete
     */
    public static function deleteMeta($id)
    {
        /** @var SpoonDatabase $db */
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
        /** @var SpoonDatabase $db */
        $db = BackendModel::get('database');

        $q = 'SELECT 1
              FROM {{ moduleName }} i
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
{% endif %}
{% for action in backendActions %}
{% if action.name == 'index' %}

    /**
     * Get all items
     *
     * @return array
     */
    public static function getAll()
    {
        return (array) BackendModel::get('database')->getRecords(
            'SELECT *
             FROM {{ moduleName }}
             ORDER BY title'
        );
    }
{% endif %}
{% endfor %}
}
