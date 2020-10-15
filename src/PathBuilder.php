<?php

namespace JDI\Helper;

class PathBuilder
{
    /**
     * Concatenate a path with a custom separator
     *
     * @param string $separator
     * @param string[] $pathComponents
     *
     * @return string
     */
    public static function custom($separator, array $pathComponents)
    {
        // remove all empty strings and nulls so we have clean data, has to be done so i can look at the first and last bit of actual data to look for trailing separators.
        $pathComponents = array_values(array_filter($pathComponents, function ($item) {
            return $item !== null && $item !== "";
        }));

        $arrayLength = sizeof($pathComponents);

        for ($i = 0; $i < $arrayLength; $i++) {
            $part = $pathComponents[$i];

            if (is_numeric($part)) {
                $part = (string)$part;
            }

            // check if any but the first has a leading separator
            if ($i != 0) {
                $firstChar = $part[0];

                if ($firstChar == $separator) {
                    $part = substr($part, 1, strlen($part) - 1);
                }
            }

            // check if any but the last has a trailing separator
            if ($i != $arrayLength - 1) {
                $lastChar = $part[strlen($part) - 1];

                if ($lastChar == $separator) {
                    $part = substr($part, 0, strlen($part) - 1);
                }
            }

            $pathComponents[$i] = $part;
        }



        return join($separator ,$pathComponents);
    }

    /**
     * Concatenate any number of path sections and correctly
     * handle directory separators
     *
     * @param array $parts
     *
     * @return string
     */
    public static function system(...$parts)
    {
        return static::custom(DIRECTORY_SEPARATOR, $parts);
    }

    /**
     * Concatenate a path with windows style path separators
     *
     * @param array $parts
     *
     * @return string
     */
    public static function windows(...$parts)
    {
        return static::custom('\\', $parts);
    }

    /**
     * Concatenate a path with unix style path separators
     *
     * @param array $parts
     *
     * @return string
     */
    public static function unix(...$parts)
    {
        return static::custom('/', $parts);
    }

    /**
     * Concatenate a path with unix style path separators
     *
     * @param array $parts
     *
     * @return string
     */
    public static function url(...$parts)
    {
        return static::custom('/', $parts);
    }
}
