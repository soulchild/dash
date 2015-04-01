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
Ext.define("Dash.view.CreateEnvironmentWindow", {
    extend: 'Ext.window.Window',
    alias: 'widget.createenvironmentwindow',
    requires: ['Ext.form.Panel'],

    id: 'CreateEnvironmentWindow',
    title: 'Environment erstellen',
    width: 600,
    items: [
        {
            xtype: 'form',
            border: false,
            padding: 10,
            defaults: {
                width: 550,
                labelWidth: 150
            },
            items: [
                {
                    xtype: 'combobox',
                    id: 'EnvironmentCombo',
                    name: 'environment',
                    fieldLabel: 'Vorlage',
                    store: 'EnvironmentTemplates',
                    queryMode: 'local',
                    displayField: 'name',
                    valueField: 'name',
                    border: false,
                    forceSelection: true,
                    allowBlank: false,
                    validator: function(value) {
                        var record = this.getStore().findRecord('name', value);
                        return !!record;
                    },
                },
            ],
            bbar: ['->', {
                xtype: 'button',
                id: 'Cancel',
                text: 'Abbrechen',
                handler: function(button, event) {
                    button.findParentByType('window').destroy();
                }
            }, {
                xtype: 'button',
                id: 'CreateEnvironment',
                text: 'Erstellen',
                handler: function(button, event) {
                    var form = button.findParentByType('form');
                    if (form.isValid()) {
                        button.fireEvent('createEnvironment', window.bundle, form.getValues());
                    }
                }
            }]
        }
    ]
});
