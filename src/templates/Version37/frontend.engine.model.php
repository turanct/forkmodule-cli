<?php

namespace Frontend\Modules\{{ moduleNameSafe }}\Engine;

use Frontend\Core\Engine\Model as FrontendModel;

/**
 * Frontend {{ moduleName }} model
 */
class Model
{
    /**
     * Get one item by id
     *
     * @param int $id The item id
     *
     * @return array The item
     */
    public static function get($id)
    {
        return FrontendModel::get('database')->getRecord(
{% if meta %}
            'SELECT i.*,
             m.url AS url,
             m.title AS meta_title,
             m.title_overwrite AS meta_title_overwrite,
             m.description AS meta_description,
             m.description_overwrite AS meta_description_overwrite,
             m.keywords AS meta_keywords,
             m.keywords_overwrite AS meta_keywords_overwrite
{% else %}
            'SELECT i.*
{% endif %}
             FROM {{ moduleName|lower }} i
{% if meta %}
             INNER JOIN meta m ON m.id = i.meta_id
{% endif %}
             WHERE i.id = ?',
            array((int) $id)
        );
    }
{% if meta %}

    /**
     * Get one item by URL
     *
     * @param string $url The item's url
     *
     * @return array The item
     */
    public static function getByURL($url)
    {
        return FrontendModel::get('database')->getRecord(
            'SELECT i.*,
             m.url AS url,
             m.title AS meta_title,
             m.title_overwrite AS meta_title_overwrite,
             m.description AS meta_description,
             m.description_overwrite AS meta_description_overwrite,
             m.keywords AS meta_keywords,
             m.keywords_overwrite AS meta_keywords_overwrite
             FROM {{ moduleName|lower }} i
             INNER JOIN meta m ON m.id = i.meta_id
             WHERE m.url = ?',
            array($url)
        );
    }
{% endif %}

    /**
     * Get all items
     *
     * @return array All items
     */
    public static function getAll()
    {
        return (array) FrontendModel::get('database')->getRecords(
{% if meta %}
            'SELECT i.*, m.url
             FROM {{ moduleName|lower }} AS i
             INNER JOIN meta AS m ON m.id = i.meta_id
             ORDER BY i.title'
{% else %}
            'SELECT i.*
             FROM {{ moduleName|lower }} AS i
             ORDER BY i.id'
{% endif %}
        );
    }
{% if searchable %}

    /**
     * Parse the search results for this module
     *
     * Note: a module's search function should always:
     *      - accept an array of entry id's
     *      - return only the entries that are allowed to be displayed, with their array's index being the entry's id
     *
     * @param array $ids The ids of the found results.
     *
     * @return array An array of search results
     */
    public static function search(array $ids)
    {
        $items = (array) FrontendModel::get('database')->getRecords(
            'SELECT i.id, i.title, i.description as text, m.url
             FROM {{ moduleName|lower }} i
             INNER JOIN meta m ON m.id = i.meta_id
             WHERE i.id IN (' . implode(',', $ids) . ')',
            array(),
            'id'
        );

        $detailUrl = FrontendNavigation::getURLForBlock('{{ moduleName }}', 'Detail');
        foreach ($items as &$item) {
            $item['full_url'] = $detailUrl . '/' . $item['url'];
        }

        return $items;
    }
{% endif %}
}
