<?php

namespace pxgamer\Common\Scalars;

/**
 * Class Arrays
 * @package pxgamer\Common\Scalars
 */
class Arrays
{
    /**
     * @param array $array
     * @param string $delimiter
     * @param bool $base_val
     * @return array|bool
     */
    public static function to_tree($array, $delimiter = '_', $base_val = false)
    {
        if (!is_array($array)) {
            return false;
        }
        $splitRE = '/' . preg_quote($delimiter, '/') . '/';
        $returnArr = array();
        foreach ($array as $key => $val) {
            // Get parent parts and the current leaf
            $parts = preg_split($splitRE, $key, -1, PREG_SPLIT_NO_EMPTY);
            $leafPart = array_pop($parts);

            // Build parent structure
            // Might be slow for really deep and large structures
            $parentArr = &$returnArr;
            foreach ($parts as $part) {
                if (!isset($parentArr[$part])) {
                    $parentArr[$part] = array();
                } elseif (!is_array($parentArr[$part])) {
                    if ($base_val) {
                        $parentArr[$part] = array('__base_val' => $parentArr[$part]);
                    } else {
                        $parentArr[$part] = array();
                    }
                }
                $parentArr = &$parentArr[$part];
            }

            // Add the final part to the structure
            if (empty($parentArr[$leafPart])) {
                $parentArr[$leafPart] = $val;
            } elseif ($base_val && is_array($parentArr[$leafPart])) {
                $parentArr[$leafPart]['__base_val'] = $val;
            }
        }
        return $returnArr;
    }

    /**
     * @param array $a
     * @param array $b
     * @return array
     */
    public static function array_key_intersect(&$a, &$b)
    {
        $aReturn = array();

        foreach ($a as $mKey => $mValue) {
            if (array_key_exists($mKey, $b)) {
                if (is_array($mValue)) {
                    $aRecursiveDiff = array_key_intersect($mValue, $b[$mKey]);
                    if (count($aRecursiveDiff)) {
                        $aReturn[$mKey] = $aRecursiveDiff;
                    }
                } else {
                    if ($mValue != $b[$mKey]) {
                        $aReturn[$mKey] = $mValue;
                    }
                }
            } else {
                $aReturn[$mKey] = $mValue;
            }
        }
        return $aReturn;
    }
}