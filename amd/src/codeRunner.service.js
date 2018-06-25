define(['jquery', 'core/ajax', 'core/templates', 'core/notification'], function($, ajax, templates, notification) { 
    return {
        
        /**
         * Run the tests
         *
         * @method runTests
         */
        runTests: function(input, output) {
            $('[data-region="index-page"] #run-button').on('click', function() {
                console.log("input is ", input);
                var _editor = window.editor;
                var _language = window.lang;
                var promises = ajax.call([{
                    methodname: 'mod_coding_compile',
                    args: { 
                        code: _editor.getValue(),
                        language: _language,
                        input: input
                    }
                }]);
                promises[0].done(function(data) {
                    console.log("data is ", data);
                    data.compile_result = data.compile_result;
                    data.language = _language;
                    data.input = input;
                    data.output = output;
                    data.done = true;
                    templates.render('mod_coding/coding', data).done(function(html, js) {
                        console.log("js is ", js);
                        $('[data-region="index-page"]').replaceWith(html);
                        templates.runTemplateJS(js);
                    }).fail(notification.exception);
                }).fail(notification.exception);
            });
        },
    };
});