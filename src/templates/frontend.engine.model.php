<?php
/**
 * Frontend {{ moduleName }} model
 */
class Frontend{{ moduleName|capitalize }}Model
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
        /** @var SpoonDatabase $db */
        $db = FrontendModel::get('database');

        $item = $db->getRecords(
            'SELECT i.*,
            m.url AS url,
            m.title AS meta_title,
            m.title_overwrite AS meta_title_overwrite,
            m.description AS meta_description,
            m.description_overwrite AS meta_description_overwrite,
            m.keywords AS meta_keywords,
            m.keywords_overwrite AS meta_keywords_overwrite
            FROM {{ moduleName }} i
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
        /** @var SpoonDatabase $db */
        $db = FrontendModel::get('database');

        $item = $db->getRecords(
            'SELECT i.*,
            m.url AS url,
            m.title AS meta_title,
            m.title_overwrite AS meta_title_overwrite,
            m.description AS meta_description,
            m.description_overwrite AS meta_description_overwrite,
            m.keywords AS meta_keywords,
            m.keywords_overwrite AS meta_keywords_overwrite
            FROM {{ moduleName }} i
            INNER JOIN meta m ON m.id = i.meta_id
            WHERE m.url = ?',
            array($url)
        );

        return $item;
    }
}
