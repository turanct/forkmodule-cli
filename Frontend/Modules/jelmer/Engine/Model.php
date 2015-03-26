<?php

namespace Frontend\Modules\Jelmer\Engine;

use Frontend\Core\Engine\Model as FrontendModel;

/**
 * Frontend Jelmer model
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
        /** @var \SpoonDatabase $db */
        $db = FrontendModel::get('database');

        $item = $db->getRecord(
            'SELECT i.*,
            m.url AS url,
            m.title AS meta_title,
            m.title_overwrite AS meta_title_overwrite,
            m.description AS meta_description,
            m.description_overwrite AS meta_description_overwrite,
            m.keywords AS meta_keywords,
            m.keywords_overwrite AS meta_keywords_overwrite
            FROM jelmer i
            INNER JOIN meta m ON m.id = i.meta_id
            WHERE i.id = ?',
            array((int) $id)
        );

        return $item;
    }

    /**
     * Get one item by URL
     *
     * @param string $url The item's url
     *
     * @return array The item
     */
    public static function getByURL($url)
    {
        /** @var \SpoonDatabase $db */
        $db = FrontendModel::get('database');

        $item = $db->getRecord(
            'SELECT i.*,
            m.url AS url,
            m.title AS meta_title,
            m.title_overwrite AS meta_title_overwrite,
            m.description AS meta_description,
            m.description_overwrite AS meta_description_overwrite,
            m.keywords AS meta_keywords,
            m.keywords_overwrite AS meta_keywords_overwrite
            FROM jelmer i
            INNER JOIN meta m ON m.id = i.meta_id
            WHERE m.url = ?',
            array($url)
        );

        return $item;
    }

    /**
     * Get all items
     *
     * @return array All items
     */
    public static function getAll()
    {
        /** @var \SpoonDatabase $db */
        $db = FrontendModel::get('database');

        $items = (array) $db->getRecords(
            'SELECT i.*, m.url
            FROM jelmer AS i
            INNER JOIN meta AS m ON m.id = i.meta_id
            ORDER BY i.title'
        );

        return $items;
    }

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
        /** @var \SpoonDatabase $db */
        $db = FrontendModel::get('database');

        $items = (array) $db->getRecords(
            'SELECT i.id, i.title, i.description as text, m.url
            FROM jelmer i
            INNER JOIN meta m ON m.id = i.meta_id
            WHERE i.id IN (' . implode(',', $ids) . ')'
        );

        $returnItems = array();
        foreach ($items as $item) {
            $returnItems[$item['id']] = $item;
        }

        return $returnItems;
    }
}
