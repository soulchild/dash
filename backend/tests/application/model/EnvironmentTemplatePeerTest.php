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
class Application_Model_EnvironmentTemplateTest extends PHPUnit_Framework_TestCase
{
    private static function templateJSON()
    {
        return <<<EOT
[
    {
        "name": "Development Environment",
        "params": {
            "env" : "development",
            "foo" : "bar"
        }
    },
    {
        "name": "Staging Environment",
        "params": {
            "env" : "staging",
            "foo" : "bar"
        }
    },
    {
        "name": "Production Environment",
        "params": {
            "env" : "production",
        }
    }
]
EOT;
    }

    public function testGetAllTemplates()
    {
        $templates = Application_Model_EnvironmentTemplatePeer::getAllTemplates();

        $this->assertEquals($templates[0]->name, "Development Environment");
        $this->assertEquals($templates[0]->params->env, "development");
        $this->assertEquals($templates[0]->params->foo, "bar");

        $this->assertEquals($templates[1]->name, "Staging Environment");
        $this->assertEquals($templates[1]->params->env, "staging");
        $this->assertEquals($templates[1]->params->foo, "bar");

        $this->assertEquals($templates[2]->name, "Production Environment");
        $this->assertEquals($templates[2]->params->env, "production");
    }

}