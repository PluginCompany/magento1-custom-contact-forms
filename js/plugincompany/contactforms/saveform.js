/**
 * Copyright (c) 2014-2026 Plugin Company
 *
 * This file is part of Custom Contact Forms, released under the MIT License.
 * See the LICENSE file in the project root.
 */
function prepareFormSave() {
    //add contact form data to form
    var iframe = jQuery('#form_builder_iframe').get(0);
    var jsons = iframe.contentWindow.app.builder.collection;
    var content = jQuery('#form_builder_iframe').contents();
    var html = content.find('#render').val();
    jQuery('#contact_form_html').remove();
    jQuery('#contact_form_json').remove();
    jQuery('#edit_form').prepend(jQuery('<textarea id="contact_form_html" name="form[contact_form_html]" style="display:none;"></textarea>').val(html));
    jQuery('#edit_form').prepend(jQuery('<textarea id="contact_form_json" name="form[contact_form_json]" style="display:none"></textarea>').val(JSON.stringify(jsons)));

    //add dependent fields to form
    var djson = dfields.get('list');
    jQuery('#dfields_json').remove();
    jQuery('#edit_form').prepend(jQuery('<textarea id="dfields_json" name="form[dependent_fields]" style="display:none"></textarea>').val(JSON.stringify(djson)));
}

function resizeFormbuilder(height){
    if(!height){
        height = jQuery(jQuery('#form_builder_iframe').get(0).contentWindow.document.body).height();
    }
    jQuery('#form_builder_iframe').height(height + 100)
}

function resizeDfields(height){
    if(!height){
        height = jQuery(jQuery('#dfields_iframe').get(0).contentWindow.document.body).height() + 200;
    }
    jQuery('#dfields_iframe').height(height)
}




var dfields;
var dfieldsLoaded = false;
var builderLoaded = false;

function initDfields(){
    dfieldsLoaded = true;
    _initDfields();
}

function _initDfields(){
    if(dfieldsLoaded == true && builderLoaded == true){
        var dfieldsFrame = jQuery('#dfields_iframe').get(0);
        dfields = dfieldsFrame.contentWindow.dfields;
        updateDfields();
    }
}

function updateDfields(){
    var iframe = jQuery('#form_builder_iframe').get(0);
    var jsons = iframe.contentWindow.app.builder.collection;
    dfields.setFormData(jsons,false);
}

function initCEditor(emID, mode)
{
    var cEditor = CodeMirror.fromTextArea(document.getElementById("form_" + emID), {
        lineNumbers: true,
        styleActiveLine: true,
        lineWrapping: true,
        matchBrackets: true,
        mode: mode
    });

    //on change set value to original textfield
    cEditor.on('change', function (cm) {
        jQuery('#form_' + emID).val(cm.getValue());
    });

}

jQuery(document).ready(function() {

    jQuery('#form_tabs_dependent_fields').click(function(){
        updateDfields();
        resizeDfields(false);
    });

    jQuery('#form_tabs_form_builder').click(function(){
        resizeFormbuilder(false);
    });


    jQuery('#form_builder_iframe').load(function(){
        builderLoaded = true;
        _initDfields();
    });


    initCEditor('arbitrary_js', 'javascript');
    initCEditor('pageload_js', 'javascript');
    initCEditor('beforesubmit_js', 'javascript');
    initCEditor('custom_css', 'css');

    jQuery('.CodeMirror').each(function(i, el){
        el.CodeMirror.refresh();
    });
    setTimeout(function(){
        jQuery('.CodeMirror').each(function(i, el){
            el.CodeMirror.refresh();
        });
    },2000);

    jQuery('.tab-item-link').click(function(){
        jQuery('.CodeMirror').each(function(i, el){
            el.CodeMirror.refresh();
        });
    })
})