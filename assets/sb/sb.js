require('codemirror/lib/codemirror.css') // codemirror
require('tui-editor/dist/tui-editor.css'); // editor ui
require('tui-editor/dist/tui-editor-contents.css'); // editor content
require('highlight.js/styles/github.css'); // code block highlight

/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */
require('../sb/css/bootstrap.css');
require('../sb/css/metisMenu.css');
require('../sb/css/sb-admin-2.css');
require('../sb/css/morris.css');
require('../sb/css/font-awesome.css');
require('../sb/js/bootstrap.js');
require('../sb/js/metisMenu.js');
require('../sb/js/morris.js');
require('../sb/js/sb-admin-2.js');
require( '../sb/js/jquery-2.1.4.js' );

var Editor = require('tui-editor');
var editor = new Editor({
    el: document.querySelector('#article_contents'),
    initialEditType: 'markdown',
    previewStyle: 'vertical',
    height: '300px'
});



