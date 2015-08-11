<?php

namespace Backend\Modules\{{ moduleNameSafe }}\Engine;

use Backend\Core\Engine\Model as BackendModel;
use Backend\Core\Engine\Language;
{% if tags %}
use Backend\Modules\Tags\Engine\Model as TagsModel;
{% endif %}
{% if searchable %}
use Backend\Modules\Search\Engine\Model as SearchModel;
{% endif %}

/**
 * Backend {{ moduleName }} model
 */
class Model
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
    public static function create(array $item, $tags)
{% else %}
    public static function create(array $item)
{% endif %}
    {
        // insert into the database
        $id = BackendModel::get('database')->insert('{{ moduleName|lower }}', $item);
{% if tags %}

        // insert tags
        TagsModel::saveTags($id, $tags, '{{ moduleName|lower }}');
{% endif %}
{% if searchable %}

        // make searchable
        SearchModel::saveIndex(
            '{{ moduleName|lower }}',
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
        $item = (array) BackendModel::get('database')->getRecord(
            'SELECT i.*{% if meta %}, m.url
{% else %}

{% endif %}
             FROM {{ moduleName|lower }} i
{% if meta %}
             INNER JOIN meta AS m on m.id = i.meta_id
{% endif %}
             WHERE i.id = :id',
            array('id' => (int) $id)
        );
{% if tags %}

        // get tags
        $item['tags'] = TagsModel::getTags('{{ moduleName|lower }}', $id);
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
    public static function update(array $item, $tags)
{% else %}
    public static function update(array $item)
{% endif %}
    {
        if (!isset($item['id'])) {
            return false;
        }

        // insert into the database
        $result = BackendModel::get('database')->update('{{ moduleName|lower }}', $item, 'id = ?', array((int) $item['id']));
{% if tags %}

        // insert tags
        TagsModel::saveTags($item['id'], $tags, '{{ moduleName|lower }}');
{% endif %}
{% if searchable %}

        // make searchable
        SearchModel::saveIndex(
            '{{ moduleName|lower }}',
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
{% if tags %}

        // remove tags
        TagsModel::saveTags($id, array(), '{{ moduleName|lower }}');
{% endif %}
{% if searchable %}

        // delete search index
        SearchModel::removeIndex('{{ moduleName|lower }}', $id);
{% endif %}
{% if meta %}

        // remove meta
        self::deleteMeta($id);
{% endif %}

        return BackendModel::get('database')->delete('{{ moduleName|lower }}', 'id = :id', array('id' => (int) $id));
    }
{% if meta %}

    /**
     * Delete an item's meta info
     *
     * @param int $id The id of the item that we want to delete
     */
    public static function deleteMeta($id)
    {
        // get the item details
        $item = self::get($id);

        // delete remaining meta records
        BackendModel::get('database')->delete('meta', 'id = :metaid', array('metaid' => (int) $item['meta_id']));
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
        $query = 'SELECT 1
                  FROM {{ moduleName|lower }} i
                  INNER JOIN meta AS m ON m.id = i.meta_id
                  WHERE m.url = ?';

        $params = array($url);

        if ($id !== null) {
            $query .= ' AND i.id != ?';
            $params[] = $id;
        }

        $query .= ' LIMIT 1';

        $exists = (bool) BackendModel::get('database')->getVar($query, $params);

        // already exists: append or increment a number after the url
        if ($exists === true) {
            return self::getURL(BackendModel::addNumber($url));
        }

        // return
        return $url;
    }
{% endif %}

    /**
     * Get all items
     *
     * @return array
     */
    public static function getAll()
    {
        return (array) BackendModel::get('database')->getRecords(
            'SELECT *
             FROM {{ moduleName|lower }}
             ORDER BY title'
        );
    }
}
