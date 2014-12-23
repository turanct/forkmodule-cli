CREATE TABLE IF NOT EXISTS `{{ moduleName|lower }}` (
    `id` int(11) NOT NULL AUTO_INCREMENT,
{% if meta %}
    `title` varchar(255) NOT NULL,
    `meta_id` int(11) NOT NULL,
{% endif %}
    PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;
