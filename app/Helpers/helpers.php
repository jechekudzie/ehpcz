<?php

if (!function_exists('formatZimbabweanId')) {
    function formatZimbabweanId($idNumber)
    {
        // Remove unwanted characters
        $cleanedId = preg_replace('/[^a-zA-Z0-9]/', '', $idNumber);

        // Ensure uppercase and check length (adjust as per requirements)
        if (strlen($cleanedId) < 5 || strlen($cleanedId) > 15) {
            throw new \InvalidArgumentException('Invalid Zimbabwean ID format.');
        }

        return strtoupper($cleanedId);
    }
}
