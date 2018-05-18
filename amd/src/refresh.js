define(['jquery', 'core/ajax', 'core/templates', 'core/notification'], function($, ajax, templates, notification) { 
    return {
        
        /**
         * Refresh the middle of the page!
         *
         * @method refresh
         */
        refresh: function() {
        console.log("HELLO WORLD");
            // Add a click handler to the button.
            $('[data-region="index-page"] #refresh').on('click', function() {
                console.log("CLICKED BUTTON");
                // console.log("WINDOW EDITOR IS ", window.editor);
                // console.log("EDITOR IS ", editor);
                
                // First - reload the data for the page.
                // console.log("editor text ", editor.getValue());
                var _editor = window.editor;
                var _language = window.lang;
                console.log("THE EDITOR IS ", _editor);
                console.log("the _language is: ", _language);
                console.log("Code value is ", _editor.getValue());
                var promises = ajax.call([{
                    methodname: 'mod_coding_compile',
                    args:{ 
                        code: _editor.getValue(),
                        language: _language
                    }
                }]);
                promises[0].done(function(data) {

                    console.log("THE DATA IS ", data);
                    data.language = _language;
                    // We have the data - lets re-render the template with it.
                    templates.render('mod_coding/coding', data).done(function(html, js) {
                        $('[data-region="index-page"]').replaceWith(html);
                        // And execute any JS that was in the template.
                        templates.runTemplateJS(js);
                    }).fail(notification.exception);
                }).fail(notification.exception);
            });
        },
// asdasdsa
    };
});