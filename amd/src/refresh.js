define(['jquery', 'core/ajax', 'core/templates', 'core/notification'], function($, ajax, templates, notification) { 
    return {
        
        /**
         * Refresh the page
         *
         * @method refresh
         */
        refresh: function() {
            $('[data-region="index-page"] #refresh').on('click', function() {
                var _editor = window.editor;
                var _language = window.lang;
                var promises = ajax.call([{
                    methodname: 'mod_coding_compile',
                    args:{ 
                        code: _editor.getValue(),
                        language: _language
                    }
                }]);
                promises[0].done(function(data) {

                    data.language = _language;
                    templates.render('mod_coding/coding', data).done(function(html, js) {
                        $('[data-region="index-page"]').replaceWith(html);
                        templates.runTemplateJS(js);
                    }).fail(notification.exception);
                }).fail(notification.exception);
            });
        },
    };
});