<?php

if (!function_exists('addParameterToUrl')) {
    /**
     * Agrega parámetros a una URL.
     *
     * @param string $url
     * @param array $newParams
     * @return string
     */
    function addParameterToUrl($url, $newParams = [])
    {
        // Parsear la URL en sus componentes
        $parsedUrl = parse_url($url);

        // Extraer los parámetros existentes (si los hay)
        $existingParams = [];
        if (isset($parsedUrl['query'])) {
            parse_str($parsedUrl['query'], $existingParams);
        }

        // Fusionar los parámetros existentes con los nuevos
        $updatedParams = array_merge($existingParams, $newParams);

        // Reconstruir la URL con los parámetros actualizados
        $updatedQuery = http_build_query($updatedParams);
        $newUrl = $parsedUrl['scheme'] . '://' . $parsedUrl['host'] .
            (isset($parsedUrl['path']) ? $parsedUrl['path'] : '') .
            '?' . $updatedQuery;

        return $newUrl;
    }
}
