<?php
/*
 * Copyright 2013 pingworks - Alexander Birk und Christoph Lukas
 * 
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 * 
 *     http://www.apache.org/licenses/LICENSE-2.0
 * 
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */

class Application_Model_EnvironmentTemplatePeer
{
    private function getFilename()
    {
        return Zend_Registry::get("datadir") . '/templates/templates.json';
    }

    public static function getAllTemplates()
    {
        $filename = self::getFilename();

        if (!file_exists($filename) || !is_readable($filename))
            throw new InvalidArgumentException("Environment template file '$filename' missing or unreadable!");
        $contents = file_get_contents($filename);       
        $json = json_decode($contents);
        if (!is_array($json))
            throw new InvalidArgumentException('Expected JSON array.');


        $templates = array();
        foreach ($json as $template) {
            $t = Application_Model_EnvironmentTemplate::newWithObject($template);
            array_push($templates, $t);
        }

        return $templates;
    }
}