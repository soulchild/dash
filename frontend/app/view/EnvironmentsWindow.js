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
Ext.define("Dash.view.EnvironmentsWindow", {
    extend: 'Ext.window.Window',
    alias: 'widget.environmentswindow',
    requires: [
        'Ext.form.Panel', 
        'Dash.view.EnvironmentsToolbar'
    ],
    id: 'EnvironmentsWindow',
    title: 'Environments',
    width: 800,
    height: 600,
    layout: 'fit',
    items: [
        {
            xtype: 'panel',
            border: false,
            padding: 10,
            layout: 'fit',
            items: [
                {
                    xtype: 'environmentgrid'
                }
            ]
        },
    ],
    dockedItems: [
        {
            xtype: 'toolbar',
            flex: 1,
            dock: 'bottom',
            ui: 'footer',
            layout: {
                type: 'hbox'
            },
            items: [
                {
                    xtype: 'button',
                    id: 'CreateEnvironmentsWindow',
                    text: 'Neues Environment erstellen',
                    handler: function(button, event) {
                        button.fireEvent('createEnvironmentsWindow', this);
                    }
                },
            ]
        }
    ]
});