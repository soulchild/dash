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

class EnvironmentTemplateController extends Zend_Rest_Controller
{
    public function init()
    {
        $this->_helper->viewRenderer->setNoRender(true);
    }

    private function getEmptyResult()
    {
        return array(
            'success' => true,
            'results' => array()
        );
    }

    public function indexAction()
    {
        $data = $this->getEmptyResult();
        $data['results'] = Application_Model_EnvironmentTemplatePeer::getAllTemplates();
        $this->getResponse()->setBody(json_encode($data));
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function getAction()
    {
    }

    public function headAction()
    {
    }

    public function postAction()
    {
    }

    public function putAction()
    {
    }

    public function deleteAction()
    {
    }
}