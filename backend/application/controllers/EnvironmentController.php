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

class EnvironmentController extends Zend_Rest_Controller
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
        $data['results'] = Application_Model_EnvironmentPeer::getAllEnvironments();
        $this->getResponse()->setBody(json_encode($data));
        $this->getResponse()->setHttpResponseCode(200);
    }

    public function getAction()
    {
        $id = $this->_getParam('id');

        if ($this->isEnvironmentIdValid($id)) {
            $data = $this->getEmptyResult();
            $data['results'] = Application_Model_EnvironmentPeer::getEnvironment($id);
            $this->getResponse()->setBody(json_encode($data));
            $this->getResponse()->setHttpResponseCode(200);
        }
        else {
            throw new Exception('Illegal Environment Id.');
        }
    }

    public function headAction()
    {
    }

    public function postAction()
    {
        try {
            $this->createEnvironment(
                $this->_getParam('id'), 
                $this->_getParam('name'), 
                $this->_getParam('domainname'), 
                $this->_getParam('urls')
            );
        } catch (Exception $e) {
            $status = $e instanceof InvalidArgumentException ? 409 : 422;
            $data = array('error' => $e->getMessage());
            $this->getResponse()->setHttpResponseCode($status);
            $this->getResponse()->setBody(json_encode($data));
            return;
        }

        # Return newly created entity by forwarding to GET method
        $this->_forward('get', null, null, array('id', $this->_getParam('id')));
    }

    public function putAction()
    {
        $id = $this->_getParam('id');

        if ($self->isEnvironmentIdValid($id)) {
            $environment = Application_Model_EnvironmentPeer::getEnvironmentFromJsonFile('php://input');
            $content = $environment->content;
            $envConfig = $this->getInvokeArg('bootstrap')->getOption('environment');
            if (is_array($envConfig) && array_key_exists('addUsernameFromEnv', $envConfig)) {
                if ($envConfig['addUsernameFromEnv'] != '' && getenv($envConfig['addUsernameFromEnv']) != '') {
                    if ($environment->by != getenv($envConfig['addUsernameFromEnv'])) {
                        $environment->by .= ' (' . getenv($envConfig['addUsernameFromEnv']) . ')';
                    }
                }
            }
            $environment->update();

            $data = $this->getEmptyResult();
            $environment = Application_Model_EnvironmentPeer::getEnvironment($id);
            $environment->content = $content;
            $data['results'] = $environment;
            $this->getResponse()->setBody(json_encode($data));
            $this->getResponse()->setHttpResponseCode(200);
        } 
        else {
            throw new Exception('Illegal Environment Id.');
        }
    }

    public function deleteAction()
    {
    }

    private function isEnvironmentIdValid($id) {
        $regex = $this->getInvokeArg('bootstrap')->getOption('paramregex');
        return preg_match($regex['envid'], $id);
    }

    private function createEnvironment($id, $name, $domainname, $urls) 
    {
        if ($id && $name && $domainname && $urls && $this->isEnvironmentIdValid($id)) {
            $filename = Application_Model_EnvironmentPeer::generateFilenameForEnvId($id);
            if (file_exists($filename)) {
                throw new InvalidArgumentException('Environment with id "' . $id . '" already exists.');
            }

            $env = new Application_Model_Environment();
            $env->id = $id;
            $env->name = $name;
            $env->domainname = $domainname;
            $env->urls = $urls;
            $env->create();
        }
        else {
            throw new BadMethodCallException('Missing or invalid parameters.');
        }
    }
}